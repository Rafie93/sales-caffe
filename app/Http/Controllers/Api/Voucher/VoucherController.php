<?php

namespace App\Http\Controllers\Api\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shopp\StoreVoucher;
use App\Http\Resources\Voucher\VoucherList as ListResource;
use App\Http\Resources\Voucher\VoucherItem;

use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $vouchers = StoreVoucher::orderBy('expired_at','asc')
                            ->where('expired_at','>',Carbon::now())
                            ->when($request->store_id, function ($query) use ($request) {
                                $query->where('store_id', $request->store_id);
                            })
                            
                            ->get();

        return new ListResource($vouchers);
    }

    public function detail(Request $request,$code)
    {
        $vouchers = StoreVoucher::where('code',$code)->first();
        if ($vouchers) {
            return response()->json([
                'success' => true,
                'message'=>'Voucher ditemukan',
                'data' => new VoucherItem($vouchers)
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message'=>'Voucher tidak ditemukan'],400);
        }
    }
}
