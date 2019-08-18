<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace' => 'Api'],function(){
    Route::get('governorates','MainController@governorates');
    Route::get('cities','MainController@cities');
    Route::get('configs','MainController@configs');
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
    Route::post('reset','Authcontroller@resetPassword');
    Route::post('new-password', 'AuthController@newPassword');

    Route::group(['middleware' => 'auth:api'],function(){
        Route::get('posts','MainController@posts');
        Route::get('post','MainController@post');
        Route::post('favorite','MainController@toggleFavorite');
        Route::get('list-favorites','MainController@listFavorites');
        Route::post('donation-request-create','MainController@donationRequestCreate');
        Route::get('donation-request-list','MainController@listDonationRequests');
        Route::get('donation-request','MainController@donationRequest');
        Route::post('register-token', 'AuthController@registerToken');
        Route::post('remove-token', 'AuthController@removeToken');
        Route::post('update-notification-setting', 'MainController@updateNotificationSettings');
        Route::get('notifications-count', 'MainController@countUnReadNotification');
        Route::post('update-profile','AuthController@updateProfile');
        Route::get('list-notifications', 'MainController@listNotification');
        Route::post('contact-us','MainController@contactUs');
    });
});