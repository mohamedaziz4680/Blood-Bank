<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'date_of_birth', 'last_day_of_donation', 'city_id', 'phone_number', 'password', 'pin_code');

    public function donationRquests()
    {
        return $this->hasMany('App\Models\DonationRequest');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function bloodtypes()
    {
        return $this->belongsToMany('App\Models\BloodType');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

    public function governorates()
    {
        return $this->belongsToMany('App\Models\Governorate');
    }

    protected $hidden = [
        'password',
        'api_token'
    ];

}