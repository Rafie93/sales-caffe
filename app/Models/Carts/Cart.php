<?php

namespace App\Models\Carts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "carts";
    protected $fillable = ["user_id","store_id","product_id","price","price_item","price_promo","price_variant","qty","subtotal","product_variant","notes","status"];

    public function products()
    {
        return $this->belongsTo("App\Models\Products\Product","product_id");
    }

    public function stores()
    {
        return $this->belongsTo('App\Models\Stores\Store','store_id');
    }

    public function variant()
    {
        if ($this->product_variant != "" && $this->product_variant != "[]") {
            
        }
    }
   
}
