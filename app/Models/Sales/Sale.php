<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        "type_sales",
        "number",
        "date",
        "member_id",
        "store_id",
        "variant_total",
        "shipping_total",
        "tax_total",
        "discount_total",
        "admin_total",
        "point_total",
        "grand_total",
        "modal_total",
        "payment_method",
        "payment_channel",
        "service",
        "service_type",
        "shipping_method",
        "delivery_to",
        "pickup_date",
        "pickup_time",
        "seat_reservation_date",
        "seat_reservation_start",
        "seat_reservation_end",
        "seat",
        "voucher_code",
        "status",
        "notes"
    ];
    public function detail()
    {
        return $this->hasMany(SaleDetail::class);
    }
    public function is_status()
    {
        return $this->status;
    }
    public function member()
    {
        return $this->belongsTo('App\Models\User','member_id');
    }
}
