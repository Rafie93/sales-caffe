<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesBundle extends Model
{
    use HasFactory;
    protected $table = "sales_product_subscription";
    protected $fillable = ["sale_id","bundle_id","product_id","qty","remainder","status","member_id","price"];


    public function bundle()
    {
        return $this->belongsTo("App\Models\Products\ProductBundle","bundle_id");
    }
}
