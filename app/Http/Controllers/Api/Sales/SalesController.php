<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesDetail;
use App\Models\Sales\SalesEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function history(Request $request)
    {
        $data = Sale::where('member_id',auth()->user()->id)->get();
        return response()->json([
            'success'=>true,
            'data'=>$data,
        ], 200);
    }

    public function update_payment(Request $request)
    {
        $number = $request->number;
        Sale::where('number',$number)->where('payment_status','unpaid')->update([
            'payment_method' => $request->payment_method,
            'payment_link'  => $request->payment_link,
            'payment_token' => $request->payment_token
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Update',
        ], 200);
    }
    public function store(Request $request)
    {
        $customer_id = $request->customer ? $request->customer : auth()->user()->id ;

        $validator = Validator::make($request->all(), [
            'store_id'      => 'required',
            'grand_total'   => 'required',
            'type_sales' => 'required',
            'payment_method' => 'required',
            'products' => 'required|json'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }

        if ($request->type_sales==3) {
            $code = Sale::generateCode(3);
        }else if ($request->type_sales==2) {
            $code = Sale::generateCode(2);
        }else{
            $code = Sale::generateCode(1);
        }

        $request->merge([
            'number' => $code,
            'date' => date('Y-m-d'),
            'member_id' => $customer_id,
            'customer_name' => auth()->user()->fullname,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone,
            'status' => 1
        ]);
        $yeePoint = false;
        if($request->poin_dikurangkan!=0){
            $yeePoint = true;
            $request->merge(['point_total' => $request->poin_dikurangkan]);
        }

        try
        {
            DB::beginTransaction();
                $sale = Sale::create($request->all());
                $saleId = $sale->id;
                if($yeePoint){
                    $uId = auth()->user()->id;
                    $user = User::find($uId)->first();
                    $user->update([
                        'poin' => $user->point - $request->poin_dikurangkan
                    ]);
                }
                $productcss = $request->products;
                if($productcss && $request->type_sales == 1){
                    $produkArray = json_decode($productcss, true);
                    $macamProduk = count($produkArray);
                    for ($i=0; $i < $macamProduk; $i++) {
                        $product_id = $produkArray[$i]["product_id"];
                        $price = $produkArray[$i]['price'];
                        $price_promo = $produkArray[$i]["price_promo"];
                        $price_variant = $produkArray[$i]["price_variant"];
                        $qty = $produkArray[$i]['qty'];
                        $notes = $produkArray[$i]["notes"];


                        $detail = new \App\Models\Sales\SalesDetail;
                        $detail->sale_id = $saleId;
                        $detail->store_id = $sale->store_id;
                        $detail->product_id = $product_id;
                        $detail->price_promo = $price_promo;
                        $detail->price_variant = $price_variant;
                        $detail->qty = $qty;
                        $detail->price = $price;
                        $detail->subtotal = (($price-$price_promo) + $price_variant) * $qty;
                        $detail->notes = $notes;
                        $detail->save();
                    }
                }else if ($productcss && $request->type_sales == 2){
                    $produkArray = json_decode($productcss, true);
                    $macamProduk = count($produkArray);
                    for ($i=0; $i < $macamProduk; $i++) {
                        $product_id = $produkArray[$i]["product_id"];
                        $price = $produkArray[$i]['price'];
                        $price_promo = $produkArray[$i]["price_promo"];
                        $price_variant = $produkArray[$i]["price_variant"];
                        $qty = $produkArray[$i]['qty'];
                        $notes = $produkArray[$i]["notes"];

                        $detail = new \App\Models\Sales\SalesDetail;
                        $detail->sale_id = $saleId;
                        $detail->store_id = $sale->store_id;
                        $detail->product_id = $product_id;
                        $detail->price_promo = $price_promo;
                        $detail->price_variant = $price_variant;
                        $detail->qty = $qty;
                        $detail->price = $price;
                        $detail->type = 1;
                        $detail->subtotal = (($price-$price_promo) + $price_variant) * $qty;
                        $detail->notes = $notes;
                        $detail->save();
                    }
                }else if ($productcss && $request->type_sales == 3){
                    $produkArray = json_decode($productcss, true);
                    $macamProduk = count($produkArray);
                    for ($i=0; $i < $macamProduk; $i++) {
                        SalesEvent::create([
                            "sale_id" => $saleId,
                            "member_id" => auth()->user()->id,
                            "event_id" => $produkArray[$i]["event_id"],
                            "qty" => $produkArray[$i]["qty"],
                            "remainder" => $produkArray[$i]["qty"],
                            "status" => 1
                        ]);
                    }
                }

            DB::commit();
            // $this->_generatePaymentToken($sale);
            return response()->json([
                'success'=>true,
                'message'=>'Silahkan Lakukan Proses Pembayaran',
                'data' => Sale::find($sale->id)
            ], 200);
        }catch (\PDOException $e) {
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Gagal melakukan transaksi',
                'error' => $e
            ], 400);
        }
    }

    public function _generatePaymentToken($order)
    {
        $this->initPaymentGateway();

		$customerDetails = [
			'first_name' => $order->customer_name,
			'last_name' => $order->customer_name,
			'email' => $order->customer_email,
			'phone' => $order->customer_phone,
		];

		$params = [
			'enable_payments' => \App\Models\Sales\Payment::PAYMENT_CHANNELS,
			'transaction_details' => [
				'order_id' => $order->number,
				'gross_amount' => $order->grand_total,
			],
			'customer_details' => $customerDetails,
			'expiry' => [
				'start_time' => date('Y-m-d H:i:s T'),
				'unit' => \App\Models\Sales\Payment::EXPIRY_UNIT,
				'duration' => \App\Models\Sales\Payment::EXPIRY_DURATION,
			],
		];

		$snap = \Midtrans\Snap::createTransaction($params);
		
		if ($snap->token) {
			$order->payment_token = $snap->token;
			$order->payment_link = $snap->redirect_url;
			$order->save();
		}
    }
}
