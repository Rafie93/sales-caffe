<?php

namespace App\Http\Controllers\Api\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carts\Cart;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::where('status',1)
                    ->where('user_id',auth()->user()->id)
                    ->get();

        $output = array();
        foreach ($cart as $row) {
            $output[] = array(
                'id' => intval($row->id),
                'product_id' => intval($row->product_id),
                'store_id' => intval($row->store_id),
                'store_name' => $row->stores->name,
                'product_name' => $row->products->name,
                'product_price' => intval($row->products->price_sales),
                'price_item' => intval($row->price_item),
                'price_promo' => intval($row->price_promo),
                'price_variant'=> intval($row->price_variant),
                'qty'=> intval($row->qty),
                'subtotal' => intval($row->subtotal),
                'notes' => $row->notes,
                'cover' => $row->products->cover(),
                'product_variant' => json_decode($row->product_variant)
            );
        }
        return response()->json([
            'success'=>true,
            'data'=>$output,
        ], 200);

    }
    public function detail(Request $request,$id)
    {
        $row = Cart::where('id',$id)
                    ->where('user_id',auth()->user()->id)
                    ->first();

        $output = null;
        if ($row) {
            $output = array(
                'id' => $row->id,
                'product_id' => $row->id,
                'product_name' => $row->products->name,
                'product_price' => intval($row->products->price_sales),
                'price_item' => intval($row->price_item),
                'price_promo' => intval($row->price_promo),
                'price_variant'=> intval($row->price_variant),
                'qty'=> intval($row->qty),
                'subtotal' => intval($row->subtotal),
                'notes' => $row->notes,
                'product_variant' => json_decode($row->product_variant)
            );
        }
        return response()->json([
            'success'=>true,
            'data'=>$output,
        ], 200);

    }

    public function store(Request $request)
    {
        $customer_id = $request->customer ? $request->customer : auth()->user()->id ;
        $validator = Validator::make($request->all(), [
            'storeid'      => 'required',
            'productid'   => 'required',
            'priceitem' => 'required',
            'pricepromo' => 'required',
            'pricevariant' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $cartOtherStore = Cart::where('status',1)
                        ->where('user_id',auth()->user()->id)
                        ->where('store_id','!=',$request->storeid)
                        ->get();

        if ($cartOtherStore->count() > 0) {
            return response()->json([
                'success'=>false,
                'message'=>'Oppss ! You can only add product from one store'
            ], 400);
        }

        $products =  Product::find($request->productid);
        if (!$products) {
            $arrayName[] = array(
                'attribute' => 'productid',
                'message' => 'Produk tidak ditemukan'
             );
            return response()->json(array("errors"=>$arrayName), 422);
        }
        try
        {
           DB::beginTransaction();
           $cart = Cart::where("store_id",$request->storeid)
                                ->where("product_id",$request->productid)
                                ->where('user_id',$customer_id)
                                ->where('price_item',$request->priceitem)
                                ->where('product_variant',$request->productvariant)
                                ->where('status','1')
                                ->first();
           if ($cart) {
               $cart->update([
                    'qty' => $cart->qty + $request->qty,
                    'notes' => $request->notes
               ]);
           }else{               
                $cart= Cart::create([
                        'store_id' => $request->storeid,
                        'product_id' => $request->productid,
                        'user_id' => $customer_id,
                        'price' => $products->price_sales,
                        'price_item' => $request->priceitem,
                        'price_promo' => $request->pricepromo,
                        'price_variant' => $request->pricevariant,
                        'product_variant' => $request->productvariant,
                        'notes' => $request->notes,
                        'qty' => $request->qty,
                        'subtotal' => intval($request->priceitem) * intval($request->qty),
                        'status' => 1
                    ]);
            }
            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'Produk sudah ditambahkan ke keranjang',
                'data' => Cart::find($cart->id)
            ], 200);
        }catch (\PDOException $e) {
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Gagal memasukkan kekeranjang',
                'error' => $e
            ], 400);
        }

    }
    
    public function update(Request $request,$id)
    {
        $customer_id = $request->customer ? $request->customer : auth()->user()->id ;
        $validator = Validator::make($request->all(), [
            'storeid'      => 'required',
            'productid'   => 'required',
            'priceitem' => 'required',
            'pricepromo' => 'required',
            'pricevariant' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }

        $products =  Product::find($request->productid);
        if (!$products) {
            $arrayName[] = array(
                'attribute' => 'productid',
                'message' => 'Produk tidak ditemukan'
             );
            return response()->json(array("errors"=>$arrayName), 422);
        }
        try
        {
           DB::beginTransaction();
            $cart = Cart::find($id);
            $cart->update([
                    'store_id' => $request->storeid,
                    'product_id' => $request->productid,
                    'user_id' => $customer_id,
                    'price' => $products->price_sales,
                    'price_item' => $request->priceitem,
                    'price_promo' => $request->pricepromo,
                    'price_variant' => $request->pricevariant,
                    'product_variant' => $request->productvariant,
                    'notes' => $request->notes,
                    'qty' => $request->qty,
                    'subtotal' => intval($request->priceitem) * intval($request->qty),
                    'status' => 1
                ]);
            
            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'Produk sudah diperbaharui ke keranjang',
                'data' => Cart::find($cart->id)
            ], 200);
        }catch (\PDOException $e) {
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Gagal memasukkan kekeranjang',
                'error' => $e
            ], 400);
        }
    }

    public function delete(Request $request,$id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Produk sudah dihapus dari daftar keranjang',
        ], 200);
    }

    public function delete_all(Request $request)
    {
        $cart = Cart::where('status',1)
                    ->where('user_id',auth()->user()->id)
                    ->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Semua Produk sudah dihapus dari daftar keranjang',
        ], 200);
    }
}
