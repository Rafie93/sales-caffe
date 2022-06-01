<?php

namespace App\Models\Shopp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVoucher extends Model
{
    use HasFactory;
    protected $table = "store_voucher";
    protected $fillable = [
        "type",
        "store_id",
        "code",
        "name",
        "amount",
        "amount_type",
        "is_higher_amount",
        "higher_amount",
        "maximum_amount",
        "maximum_user",
        "expired_at",
        "status",
        "minimum_shopp",
        "image",
        "description",
        "start_date"
    ];
    public function sales()
    {
        return $this->hasMany('App\Models\Sales\Sale','voucher_code','code');
    }
      public function IS_STATUS()
    {
        if ($this->status==1) {
           return "Aktif";
        }else{
            return "Tidak Aktif";
        }
    }
}
