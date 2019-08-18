<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model 
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('name', 'age', 'blood_bags', 'hospital_name', 'latitude', 'longatitude', 'city_id', 'phone_number', 'comments','blood_type_id');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function bloodtype()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

    public function notification()
    {
        return $this->hasOne('App\Models\Notification');
    }

}