<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\City;
use App\Models\Configs;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Token;
use App\Models\DonationRequest;
use App\Models\Notification;
use App\Models\ContactUs;

class MainController extends Controller
{
    //

    public function governorates()
    {
        $governorates = Governorate::all();

        return responseJson(1, 'success', $governorates);
    }

    public function cities(Request $request)
    {
        $cities = City::where(function ($query) use ($request) {
            if ($request->has('governorate_id')) {
                $query->where('governorate_id', $request->governorate_id);
            }
        })->get();

        return responseJson(1, 'success', $cities);
    }

    public function posts(Request $request)
    {
        $posts = Post::where(function ($query) use ($request) {
            if ($request->has('category_id') || $request->has('filter')) {
                $query->where('category_id', $request->category_id);
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->filter.'%')
                    ->orwhere('content', 'like', '%'.$request->filter.'%');
                });
            }
        })->paginate(20);
        return responseJson(1, 'success', $posts);
    }

    public function post(Request $request)
    {
        $post = Post::find($request->post_id);

        return responseJson(1, 'success', $post);
    }

    public function toggleFavorite(Request $request)
    {
        $client = $request->user();
        if ($client) {
            $client->posts()->toggle($request->post_id);
            return responseJson(1, 'success add to favorite');
        } else {
            return responseJson(0, 'failed add to favorite');
        }
    }

    public function listFavorites(Request $request)
    {
        $client = $request->user();

        $favoritePosts = $client->posts()->paginate(20);

        return responseJson(1, 'favorite posts', $favoritePosts);
    }

    public function donationRequestCreate(Request $request, Client $client)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'age' => 'required|numeric',
            'blood_bags' => 'required|numeric',
            'blood_type_id' => 'required',
            'hospital_name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'phone_number' => 'required|digits:11'
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        $donationRequest = $request->user()->donationRquests()->create($request->all());
        $clientsIds = $donationRequest->city->governorate->clients()->wherehas('bloodtypes', function ($query) use ($request) {
            $query->where('blood_types.id', $request->blood_type_id);
        })->pluck('clients.id')->toArray();

        if (count($clientsIds)) {
            $notification = $donationRequest->notification()->create([
                'title' => 'احتاج متبرع لفصيلة',
                'content' => $request->user()->name.'محتاج متبرع لفصيلة',
            ]);

            $notification->clients()->attach($clientsIds, ['is_read' => false]);

            $tokens = Token::whereIn('client_id', $clientsIds)->where('token', '!=', null)->pluck('token')->toArray();
                
            if (count($tokens)) {
                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    'action' => 'new notify',
                    'data' => null,
                    'client' => 'client',
                    'title' => $notification->title,
                    'content' => $notification->content,
                    'donation_request_id' => $donationRequest->id
                ];

                $send = notifyByFireBase($title, $content, $tokens, $data);
            }

            return responseJson(1, 'success', $send);
        } else {
            return responseJson(0, 'failed');
        }
    }

    public function listDonationRequests(Request $request)
    {
        $donationRequests = DonationRequest::where(function ($query) use ($request) {
            if ($request->has('filter')) {
                $query->whereHas('city', function ($query) use ($request) {
                    $query->where('governorate_id', $request->governorate_id);
                });
                $query->where('blood_type_id', $request->blood_type_id);
            }
        })->paginate(20);

        return responseJson(1, 'success', $donationRequests);
    }

    public function donationRequest(Request $request)
    {
        $donationRequest= DonationRequest::find($request->donation_request_id);

        return responseJson(1, 'success', $donationRequest);
    }

    public function updateNotificationSettings(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'governorates' => 'required|array',
            'governorates.*' => 'exists:governorates,id',
            'blood_types' => 'required|array',
            'blood_types.*' => 'exists:blood_types,id',
            'action' => 'required|in:get,set'
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        if ($request->action == 'set') {
            $request->user()->governorates()->sync($request->governorates);
            $request->user()->bloodtypes()->sync($request->blood_types);
        }

        return responseJson(1, 'succes to save setting', [
            'governorates' => $request->user()->governorates()->pluck('governorates.id')->toArray(),
            'bloodtypes' => $request->user()->bloodtypes()->pluck('blood_types.id')->toArray(),
        ]);
    }

    public function countUnReadNotification(Request $request)
    {
        $notifications = $request->user()->notifications()->where('is_read', false)->get();
        $allUnReadNotification= count($notifications);
        if ($allUnReadNotification) {
            return responseJson(1, 'success notification', $allUnReadNotification);
        } else {
            return responseJson(0, 'failed to get notification');
        }
    }

    public function listNotification(Request $request)
    {
        $notifications= Notification::paginate(20);
        return responseJson(1, 'success', $notifications);
    }

    public function configs()
    {
        $configs = Configs::all();
        return responseJson(1, 'success', $configs);
    }

    public function contactUs(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'title' => 'required',
            'message' => 'required'
        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        $contactUs = ContactUs::create($request->all());
        return responseJson(1, 'succes send', $contactUs);
    }
}
