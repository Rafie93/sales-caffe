<?php

namespace App\Models\Information;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = ["title","store_id","description","slide"];

    public function slide()
    {
        return $this->slide==null ? 'Tidak Ada Image' : asset('/storage/images/slider/'.$this->id.'/'.$this->slide);
    }

}
