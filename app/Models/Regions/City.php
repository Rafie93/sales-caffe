<?php

namespace App\Models\Regions;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'citys';
    protected $fillable = ['id','province_id','name'];
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function destinationCities()
    {
        return $this->belongsToMany(City::class, 'rates', 'orig_city_id', 'dest_city_id')->where('rates.customer_id', 0);
    }

    public function destinationDistricts()
    {
        return $this->belongsToMany(District::class, 'rates', 'orig_city_id', 'dest_district_id')->where('rates.customer_id', 0);
    }

    public function rates()
    {
        return $this->hasMany('App\Models\Rates\Rate', 'dest_city_id');
    }

    public function retailRates()
    {
        return $this->hasMany(Rate::class, 'dest_city_id')->where('customer_id', 0);
    }
}
