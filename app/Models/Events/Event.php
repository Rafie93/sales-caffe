<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        "store_id",
        "name",
        "date",
        "date_end",
        "term_condition",
        "description",
        "price",
        "point_cashback",
        "image",
        "category",
        "kouta",
        "online_link",
        "min_purchased",
        "max_purchased"
    ];
    public function image()
    {
        return $this->image==null ? 'Tidak Ada Image' : asset('images/event/'.$this->image);
    }
      public function stores()
    {
        return $this->belongsTo('App\Models\Stores\Store','store_id');
    }

}
