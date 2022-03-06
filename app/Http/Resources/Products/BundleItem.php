<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Products\Product;
class BundleItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $bundle = json_decode($this->resource->products->bundle_product);
        $bdl=array();
        foreach ($bundle as $key => $value) {
            $p = Product::where('id',$value->id)->first();
            $image ="";
            if ($p) {
               $image = $p->cover();
            }
            $bdl[] = array(
                'id' => strval($value->id),
                'name' => $value->name,
                'qty' => strval($value->qty),
                'image' => $image
            );
        }
        return  [
            'id'      => intval($this->resource->id),
            'name' => $this->resource->name,
            'store_id' => intval($this->resource->store_id),
            'store_name' => $this->resource->stores->name,
            'product_id' => intval($this->resource->product_id),
            'product_name' => $this->resource->products->name,
            'price'  => intval($this->resource->price),
            'quantity'  => intval($this->resource->quantity),
            'description' => $this->resource->description,
            'expired' => strval($this->resource->expired),
            'day' => $this->resource->day,
            'point_cashback' => intval($this->resource->products->point_cashback),
            'cover' => $this->resource->products->cover(),
            'bundle' => $bdl

        ];
    }
}
