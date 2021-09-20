<?php

namespace App\Models\Sistem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingCourier extends Model
{
    use HasFactory;
    protected $table = "setting_courier";
    protected $fillable = [
        "name",
        "rate",
        "state_id",
        "city_id",
        "status",
        "min_rate",
        "distance",
        "min_distance"
    ];
}
