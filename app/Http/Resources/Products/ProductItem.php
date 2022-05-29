<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Products\VariantItem as ItemVariant;
use App\Models\Products\ProductPromo;
use App\Models\Sales\SalesDetail;

class ProductItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $variant = array();
       foreach ($this->resource->variants as $vari){
           $variant[] = array(
                'id'      => intval($vari->id),
                'product_id' => intval($vari->product_id),
                'product_name' => $vari->product->name,
                'name'      => $vari->name,
                'type'      => strval($vari->type),
                'type_display'      => $vari->is_type(),
                'options' => json_decode($vari->options)
           );
       }
       $product_pairing = [];
       foreach ($this->resource->pairings as $pair){
           $product_pairing = json_decode($pair->product_pairing);
       }
       $price_promo = 0;
       $productPromo = ProductPromo::where('product_id',$this->resource->id)
                                    ->where('start_date','<=',date('Y-m-d'))
                                    ->where('end_date','>=',date('Y-m-d'))
                                    ->get();
      if ($productPromo->count()>0) {
         $productPromo = $productPromo->first();
         $type = $productPromo->type;
         if ($type=='percentage') {
            $price_sale = $this->resource->price_sales;
            $price_promo = intval(($price_sale * $productPromo->amount)/100);
         }else{
            $price_promo = intval($productPromo->amount);
         }
         $price_promo = $this->resource->price_sales - $price_promo;
      }

       $sales = SalesDetail::where('product_id',$this->resource->id)->sum('qty');

       return  [
            'id'      => intval($this->resource->id),
            'name' => $this->resource->name,
            'store_id' => intval($this->resource->store_id),
            'store_name' => $this->resource->stores->name,
            'product_type' => strval($this->resource->product_type),
            'code' => $this->resource->code,
            'description' => $this->resource->description,
            'category_id' => strval($this->resource->category_id),
            'category_name' => $this->resource->category->name,
            'cost_of_goods' => intval($this->resource->cost_of_goods),
            'price_sales' => intval($this->resource->price_sales),
            'price_promo' => intval($price_promo),
            'is_ready' =>intval($this->resource->is_ready),
            'is_ppn' => intval($this->resource->is_ppn),
            'type' => intval($this->resource->type),
            'point_cashback' => intval($this->resource->point_cashback),
            'time_duration' => strval($this->resource->time_duration),
            'is_stock' => intval($this->resource->is_stock),
            'long_delivery' => intval($this->resource->long_delivery),
            'weight' => doubleval($this->resource->weight),
            'cover' => $this->resource->cover(),
            'images' => $this->resource->images,
            'sales' => intval($sales ? $sales : 0),
            'rating'  => intval($this->resource->sales->count()),
            'variant' => $variant,
            'pairing' => $product_pairing
        ];
    }
}
