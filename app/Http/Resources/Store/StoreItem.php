<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreItem extends JsonResource
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
            'id'      => $this->resource->id,
            'code' => $this->resource->code,
            'email' => $this->resource->email,
            'name' => $this->resource->name,
            'state_id' => strval($this->resource->state_id),
            'state_name' => $this->resource->state->name,
            'city_id' => strval($this->resource->city_id),
            'city_name' => strval($this->resource->city->name),
            'district_id' => strval($this->resource->district_id),
            'address' => $this->resource->address,
            'latitude' => doubleval($this->resource->latitude),
            'phone' => $this->resource->phone,
            'longitude' => doubleval($this->resource->longitude),
            'logo' => $this->resource->logo()
        ];
    }
}
