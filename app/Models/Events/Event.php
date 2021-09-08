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
        "category"
    ];
     public function image()
    {
        return $this->image==null ? 'Tidak Ada Image' : asset('/storage/images/event/'.$this->id.'/'.$this->image);
    }

}
