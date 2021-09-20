<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Products\ProductMerchantItem as ListResource;

class ProductMerchantController extends Controller
{
    public function index(Request $request)
    {
        $products =
              Product::where('type','2')
                 ->where('product_type',1)
                 ->where('status',1)
                 ->where('is_ready',1)
                 ->select('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery')
                 ->groupBy('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery')
                 ->paginate(20);
         
        $productStores =
              Product::where('type','1')
                 ->where('product_type',1)
                 ->where('status',1)
                 ->where('is_ready',1)
                 ->select('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery','store_id','cover')
                 ->groupBy('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery','store_id','cover')
                 ->paginate(20);

        $output = [];
        foreach ($products as $key => $row) {
            $available = [];
            $available_display = "";
            foreach ($row->storeAvailables($row->code) as $key => $store) {
               $available[] = array(
                    'store_id' => $store->store_id,
                    'store_name'=> $store->name
               );
               $available_display .= $store->name.' /n';
            }
            $output[] = array(
                'name' => $row->name,
                'code' => $row->code,
                'description' => $row->description,
                'category_id' => $row->category_id,
                'price_sales' => $row->price_sales,
                'point_cashback' => $row->point_cashback,
                'time_duration' => $row->time_duration,
                'long_delivery' => $row->long_delivery,
                'weight' => $row->weight,
                'cover' => $row->coverProductMerchant($row->code),
                'available_display' => $available_display,
                'available' => $available,
               
            );
        }

        foreach ($productStores as $key => $row) {
            $available = [];
            $available[] = array(
                    'store_id' => $row->store_id,
                    'store_name'=> $row->stores->name
            );
            $available_display = $row->stores->name;
            $output[] = array(
                'name' => $row->name,
                'code' => $row->code,
                'description' => $row->description,
                'category_id' => $row->category_id,
                'price_sales' => $row->price_sales,
                'point_cashback' => $row->point_cashback,
                'time_duration' => $row->time_duration,
                'long_delivery' => $row->long_delivery,
                'weight' => $row->weight,
                'cover' => $row->cover(),
                'available_display' => $available_display,
                'available' => $available,
               
            );
        }
        return response()->json(['success'=>true,'data'=>$output]);
    }
}
