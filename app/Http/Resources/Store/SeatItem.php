<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class SeatItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {       
          return  [
            'id'      => intval($this->resource->id),
            'store_id' => intval($this->resource->store_id),
            'store_name' => $this->resource->store->name,
            'table_number' => strval($this->resource->table_number),
            'description' => $this->resource->description,
            'sequence' => intval($this->resource->sequence),
            'minimum_shopping' =>intval($this->resource->minimum_shopping),
            'maximum' => intval($this->resource->maximum),
            'is_ready' => intval($this->resource->is_ready),
            'image'  => $this->resource->image()
        ];
    }
}
