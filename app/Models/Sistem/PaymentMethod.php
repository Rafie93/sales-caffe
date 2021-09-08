<?php

namespace App\Models\Sistem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = "payment_methods";
    protected $fillable = [
        "code",
        "name",
        "type",
        "fee",
        "status",
        "charged"
    ];
}
