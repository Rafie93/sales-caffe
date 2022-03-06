<?php

namespace App\Http\Resources\Sales;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Sales\SaleDetail;

class SaleItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $det = array();
        $item_string = "";
        foreach ($this->resource->detail as $row) {
            $det[] = array(
                'sale_id' => strval($row->sale_id),
                'product_id' => strval($row->product_id),
                'product_name' => strval($row->products->name),
                'qty' => strval($row->qty),
                'price' => strval($row->price),
                'price_promo' => strval($row->price_promo),
                'price_variant' => strval($row->price_variant),
                'subtotal' => strval($row->subtotal),
                'notes'=> strval($row->notes)
            );
            $item_string .= $row->qty."x ".$row->products->name."\n";
        }
        if ($this->resource->type_sales==3) {
            foreach ($this->resource->events as $row) {
                $det[] = array(
                    'sale_id' => strval($row->sale_id),
                    'product_id' => strval($row->event->id),
                    'product_name' => $row->event->name,
                    'qty' => strval($row->qty),
                    'price' => strval($row->event->price),
                    'price_promo' => "0",
                    'price_variant' => "0",
                    'subtotal' => strval($row->event->price * $row->qty),
                    'notes'=> ""
                );
                $item_string .= $row->qty."x ".$row->event->name."\n";
            }
        }
        if ($this->resource->type_sales==2) {
            foreach ($this->resource->bundles as $row) {
                $det[] = array(
                    'sale_id' => strval($row->sale_id),
                    'product_id' => strval($row->bundle->id),
                    'product_name' => $row->bundle->name,
                    'qty' => strval($row->qty),
                    'price' => strval($row->price),
                    'price_promo' => "0",
                    'price_variant' => "0",
                    'subtotal' => strval($row->price * $row->qty),
                    'notes'=> ""
                );
                $item_string .= $row->qty."x ".$row->bundle->name."\n";
            }
        }
        return  [
            'id'      => intval($this->resource->id),
            'firebase_id'      => strval($this->resource->firebase_id),
            'type_sales' => strval($this->resource->type_sales),
            'store_id'     => strval($this->resource->store_id),
            'store_name'     => strval($this->resource->stores->name),
            'number'     => strval($this->resource->number),
            'date' =>  strval($this->resource->date),
            'member_id'      => strval($this->resource->member_id),
            'sub_total'      => strval($this->resource->sub_total),
            'variant_total' => strval($this->resource->variant_total),
            'shipping_total'     => strval($this->resource->shipping_total),
            'tax_total'     => strval($this->resource->tax_total),
            'fee_total' =>  strval($this->resource->fee_total),
            'discount_total'      => strval($this->resource->discount_total),
            'admin_total'      => strval($this->resource->admin_total),
            'point_total' => strval($this->resource->point_total),
            'grand_total'     => strval($this->resource->grand_total),
            'modal_total'     => strval($this->resource->modal_total),
            'payment_method' =>  strval($this->resource->payment_method),
            'payment_status'      => strval($this->resource->payment_status),
            'payment_no' =>  strval($this->resource->payment_no),
            'payment_link' =>  strval($this->resource->payment_link),
            'payment_expired'      => strval($this->resource->payment_expired),
            'service'      => strval($this->resource->service),
            'shipping_method' => strval($this->resource->shipping_method),
            'origin_id'     => strval($this->resource->origin_id),
            'customer_name'     => strval($this->resource->customer_name),
            'customer_phone' =>  strval($this->resource->customer_phone),
            'destination_city' => strval($this->resource->destination_city),
            'destination' =>  strval($this->resource->destination->name),
            'address'     => strval($this->resource->address),
            'postal_code'     => strval($this->resource->postal_code),
            'pickup_date' =>  strval($this->resource->pickup_date),
            'pickup_time' =>  strval($this->resource->pickup_time),
            'customer_phone' =>  strval($this->resource->customer_phone),
            'seat_reservation_date' => strval($this->resource->seat_reservation_date),
            'seat_reservation_start'     => strval($this->resource->seat_reservation_start),
            'seat_reservation_end'     => strval($this->resource->seat_reservation_end),
            'seat' =>  strval($this->resource->seat),
            'status' => strval($this->resource->status),
            'notes' => strval($this->resource->notes),
            'created_at' => strval($this->resource->created_at->format('D, d M Y')),
            'total_item' => intval($this->resource->detail->count()),
            'item_string'=>$item_string,
            'detail' => $det
        ];
    }
}
