<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Products\VariantItem as ItemVariant;

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
       $variant = [];
       foreach ($this->resource->variants as $vari){
           $variant[] = array(
                'id'      => $vari->id,
                'product_id' => $vari->product_id,
                'product_name' => $vari->product->name,
                'name'      => $vari->name,
                'type'      => $vari->type,
                'type_display'      => $vari->is_type(),
                'options' => json_decode($vari->options)
           );
       }
       return  [
            'id'      => $this->resource->id,
            'name' => $this->resource->name,
            'store_id' => $this->resource->store_id,
            'store_name' => $this->resource->stores->name,
            'product_type' => $this->resource->product_type,
            'code' => $this->resource->code,
            'description' => $this->resource->description,
            'category_id' => $this->resource->category_id,
            'category_name' => $this->resource->category->name,
            'cost_of_goods' => $this->resource->cost_of_goods,
            'price_sales' => $this->resource->price_sales,
            'is_ready' => $this->resource->is_ready,
            'is_ppn' => $this->resource->is_ppn,
            'type' => $this->resource->type,
            'point_cashback' => $this->resource->point_cashback,
            'time_duration' => $this->resource->time_duration,
            'is_stock' => $this->resource->is_stock,
            'long_delivery' => $this->resource->long_delivery,
            'weight' => $this->resource->weight,
            'cover' => $this->resource->cover(),
            'images' => $this->resource->images,
            'sales' => $this->resource->sales->count(),
            'rating'  => $this->resource->sales->count(),
            'variant' => $variant
        ];
    }
}
