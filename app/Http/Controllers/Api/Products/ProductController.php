<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Products\ProductList as ListResource;
use App\Http\Resources\Products\ProductItem;
use App\Models\Sales\SalesDetail;

class ProductController extends Controller
{

    public function popular(Request $request)
    {
        $sales = SalesDetail::select(DB::raw('product_id, sum(qty) as total_qty'))
                            ->groupBy('product_id')
                            ->orderBy('total_qty','desc')
                            ->take(10)->get()->toArray();

        $products = Product::whereIn('id',array_column($sales,'product_id'))
                        ->whereIn('product_type',[1,2])
                        ->where('status',1)
                        ->paginate(10);

        return new ListResource($products);
    }

    public function promo(Request $request)
    {
        $products = Product::orderBy('price_sales','asc')
                        ->whereIn('product_type',[1,2])
                        ->where('status',1)
                        ->paginate(4);

        return new ListResource($products);
    }

    public function index(Request $request,$storeId)
    {
        $products = Product::orderBy('id','desc')
                        ->where('product_type',1)
                        ->where('status',1)
                        ->where('store_id',$storeId)
                        ->paginate(20);

        return new ListResource($products);
    }
    
     public function detail(Request $request,$id)
    {
        $product = Product::where('id',$id)->first();
        return response()->json([
         'data' =>  new ProductItem($product)
        ],200);
    }
}
