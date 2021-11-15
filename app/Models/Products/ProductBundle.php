<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBundle extends Model
{
    use HasFactory;
    protected $table = "product_bundle";
    protected $fillable = ["store_id","name","product_id","price","quantity","description","expired","day"];
}
