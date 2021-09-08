<?php

namespace App\Models\Regions;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function districts()
    {
        return $this->hasManyThrough(District::class, City::class);
    }
}
