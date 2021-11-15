<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductBundle;
use Carbon\Carbon;
class ProductSubscription extends Controller
{
    public function index(Request $request)
    {
        $products = ProductBundle::orderBy('expired','asc')
                        ->where('expired','>',Carbon::now())
                        ->paginate(20);

        return response()->json($products);
    }
}
