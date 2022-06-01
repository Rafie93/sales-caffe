<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesDetail;
use App\Models\Sales\SalesEvent;
use App\Models\Sales\SalesBundle;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Sales\SaleItem;
use App\Http\Resources\Sales\SaleList;
use App\Models\Stores\StoreTable;
use App\Models\Carts\Cart;
use App\Models\User;
use App\Models\Products\Product;
use App\Models\Shopp\StoreVoucher;


class SalesController extends Controller
{
    public function history(Request $request)
    {
        $data = Sale::orderBy('id','desc')
                    ->whereIn('status',[0,1,2,3])
                    ->where('member_id',auth()->user()->id)->get();
        return new SaleList($data);
    }

    public function ready_to_pick(Request $request)
    {
        $data = Sale::orderBy('id','desc')
                    ->where('status',3)
                    ->where('member_id',auth()->user()->id)->get();
        return new SaleList($data);
    }

    public function history_complete(Request $request)
    {
        $data = Sale::orderBy('id','desc')
                    ->whereIn('type_sales',[1,2])
                    ->whereIn('status',[4,5,6])
                    ->where('member_id',auth()->user()->id)->get();
        return new SaleList($data);
    }

    public function history_event(Request $request)
    {
        $data = Sale::orderBy('id','desc')
                        ->where('type_sales',3)
                        ->where('member_id',auth()->user()->id)->get();
        return new SaleList($data);

    }

    public function detail(Request $request)
    {
        $saleId = $request->id;
        $sales = Sale::where('id',$saleId)->first();

        if ($sales) {
            return response()->json([
                'success'=>true,
                'data'=>new SaleItem($sales)
            ], 200);
        }else{
            $sales = Sale::where('number',$saleId)->first();
            if ($sales) {
                return response()->json([
                    'success'=>true,
                    'data'=>new SaleItem($sales)
                ], 200);
            }else{
                return response()->json([
                    'success'=>false,
                    'data'=>null
                ], 200);
            }
        }       
    }

    
    public function detail_event(Request $request)
    {
        $saleId = $request->id;
        $sales = Sale::where('id',$saleId)->first();
        $detail = SalesEvent::where('sale_id',$saleId)->get();
        
        if ($sales) {
            return response()->json([
                'success'=>true,
                'data'=>new SaleItem($sales)
            ], 200);
        }else{
            return response()->json([
                'success'=>false,
                'data'=>null
            ], 200);
        }
    }

    public function update_status_to_accept(Request $request)
    {
        $number = $request->number;
        $cashback = false;
        $sale = Sale::where('number',$number)->whereIn('status',[2,3])->first();
        if ($sale) {
            $sale->status = 4;
            $sale->save();
            $detail = SalesDetail::where('sale_id',$sale->id)->get();
            foreach ($detail as $key => $row) {
                $product_id = $row->product_id;
                $product = Product::where('id',$product_id)->first();
                if ($product) {
                    $point_cashback = $product->point_cashback;
                    if ($point_cashback > 0) {
                        $poinNow = auth()->user()->point;
                        $poinFuture = $poinNow + $point_cashback;
                        User::find(auth()->user()->id)->update([
                            'poin' => $poinFuture
                        ]);
                        $cashback = true;
                    }
                }
            }

            if ($sale->voucher_type=="Cashback") {
               $cashback = true;
               $nilai_cashback = $sale->discount_total;
               $poinNow = auth()->user()->point;
               $poinFuture = $poinNow + $nilai_cashback;
                User::find(auth()->user()->id)->update([
                    'poin' => $poinFuture
                ]);
            }

            return response()->json([
                'success'=>true,
                'cashback' => $cashback,
                'data'=>new SaleItem($sale)
            ], 200);
        }else{
            return response()->json([
                'success'=>false,
                'message' => "Sale not found",
            ], 400);
        }

    }

    public function getReviewProduct(Request $request)
    {
        $sales = Sale::select('sales_details.*')
                    ->leftJoin('sales_details','sales_details.sale_id','sales.id')
                    ->where('sales.type_sales',1)
                    ->where('sales.member_id',auth()->user()->id)
                    ->where('sales.status',4)
                    ->whereNull('sales_details.rating')
                    ->get();

        $salesComplete = Sale::select('sales_details.*')
                    ->leftJoin('sales_details','sales_details.sale_id','sales.id')
                    ->where('sales.type_sales',1)
                    ->where('sales.member_id',auth()->user()->id)
                    ->where('sales.status',4)
                    ->whereNotNull('sales_details.rating')
                    ->get();

        $output = array();
        foreach ($sales as $key => $item) {
            $product = Product::where('id',$item->product_id)->first();
            $output[] = array(
                'id' => intval($item->id),
                'product_id' => intval($item->product_id),
                'product_name' => $product->name,
                'product_image' => $product->cover(),
                'rating' => 0,
                'ulasan' => null,
                'status' => 'Waiting Review'
            );
        }
        
        foreach ($salesComplete as $key => $item) {
            $product = Product::where('id',$item->product_id)->first();
            $output[] = array(
                'id' => intval($item->id),
                'product_id' => intval($item->product_id),
                'product_name' => $product->name,
                'product_image' => $product->cover(),
                'rating' => intval($item->rating),
                'ulasan' => $item->ulasan,
                'status' => 'Reviewed'
            );
        }

        return response()->json([
            'success'=>true,
            'data'=>$output
        ], 200);
    }
    public function getReviewProductComplete(Request $request)
    {
        $sales = Sale::select('sales_details.*')
                    ->leftJoin('sales_details','sales_details.sale_id','sales.id')
                    ->where('sales.type_sales',1)
                    ->where('sales.member_id',auth()->user()->id)
                    ->where('sales.status',4)
                    ->whereNotNull('sales_details.rating')
                    ->get();

        $output = array();
        foreach ($sales as $key => $item) {
            $product = Product::where('id',$item->product_id)->first();
            $output[] = array(
                'id' => intval($item->id),
                'product_id' => intval($item->product_id),
                'product_name' => $product->name,
                'product_image' => $product->cover(),
                'rating' => intval($item->rating),
                'ulasan' => $item->ulasan,
            );
        }

        return response()->json([
            'success'=>true,
            'data'=>$output
        ], 200);
    }

    public function addReviewProduct(Request $request,$id)
    {
        $rating = $request->rating;
        $ulasan = $request->ulasan;
        $sale = SalesDetail::where('id',$id)->first();
        if ($sale) {
            $sale->rating = $rating;
            $sale->ulasan = $ulasan;
            $sale->save();
            return response()->json([
                'success'=>true,
                'message'=>"Review berhasil ditambahkan"
            ], 200);
        }else{
            return response()->json([
                'success'=>false,
                'message' => "Product Review not found",
            ], 400);
        }
    }

    public function update_payment(Request $request)
    {
        $number = $request->number;
        $sale = Sale::where('number',$number)->where('payment_status','unpaid')->update([
            'payment_method' => $request->payment_method,
            'payment_link'  => $request->payment_link,
            'payment_token' => $request->payment_token,
            'payment_status' => $request->payment_status
        ]);
        $sale = Sale::where('number',$number)->first();
        if ($sale) {
            $firebase = $this->initFirebase();
            $salesDetail = SalesDetail::where('sale_id',$sale->id)->get();
            $menu_product_name ="";
            foreach ($salesDetail as $detail) {
                $menu_product_name .= $detail->qty." x ".$detail->products->name."\n";
            }
            $postData = [
                "id" =>$sale->id,
                'store_name' => $sale->stores->name,
                "number" =>$sale->number,
                "customer_id" => $sale->member_id,
                "customer_name" => $sale->member->fullname,
                "date" =>  $sale->created_at->format('D, d M Y : H:i:s'),
                "grand_total" => $sale->grand_total,
                "menu_name" => $menu_product_name,
                "service"=> $sale->service,
                "status"=> 'Prepare Order',
                "payment_status" => $sale->payment_status,
                "payment_method" => $sale->payment_method
            ];
            $updates = ['orders/store-'.$sale->store_id.'/'.$sale->firebase_id => $postData];
            $firebase->getReference()->update($updates);

            //
            $title = "Transaction ".$sale->number." (PAID)";
            $body  = $title." ".$sale->member->fullname." Baru Saja Melakukan Pembayaran via ".$sale->payment_method." Sebesar Rp ".number_format($sale->grand_total);
            sendFirebaseToAdminStore($sale->store_id,$title,$body);
            $notifFirebaseData = [
                "title" => $title,
                "body" => $body,
                "from" => $sale->member_id,
                "to" => $sale->store_id,
                "code" => $sale->number,
                "type" => "sales",
                "is_read" => "belum"
            ];
            $firebase->getReference('notification')->push($notifFirebaseData);
            //
        }
       
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
            'products' => 'required|json',
            'number' => 'required||unique:sales'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $request->merge([
            'date' => date('Y-m-d'),
            'member_id' => $customer_id,
            'customer_name' => auth()->user()->fullname,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone,
            'status' => $request->status,
        ]);
        $yeePoint = false;
        if($request->poin_dikurangkan!=0){
            $yeePoint = true;
            $request->merge(['point_total' => $request->poin_dikurangkan]);
        }
        if ($request->voucher_code) {
            $voucher_type = null;
            $vouc = StoreVoucher::where('code',$request->voucher_code)->first();
            if ($vouc) {
               $voucher_type = $vouc->type;
            }
            $request->merge(['voucher_type' => $voucher_type]);

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
                    $menu_product_name = "";
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

                        Cart::where('status',1)
                            ->where('user_id',auth()->user()->id)
                            ->update([
                                'status' => 2
                            ]);

                        $menu_product_name .= $detail->qty." x ".$detail->products->name."\n";
                    }
                    //FIREBASE INSERT
                    $firebase = $this->initFirebase();
                    $poshData = [
                        "id" =>$saleId,
                        "store_name" => $sale->stores->name,
                        "number" =>$sale->number,
                        "customer_id" => $sale->member_id,
                        "customer_name" => $sale->member->fullname,
                        "date" =>  $sale->created_at->format('D, d M Y : H:i:s'),
                        "grand_total" => $sale->grand_total,
                        "menu_name" => $menu_product_name,
                        "service"=> $sale->service,
                        "payment_status" => $sale->payment_status,
                        "status"=> $sale->status == 2 ? 'Prepare Order' : 'Waiting Payment',
                        "payment_method" => $sale->payment_method
                    ];
                    $postRef = $firebase->getReference('orders/store-'.$sale->store_id)->push($poshData);
                    $firebaseIdSales = $postRef->getKey();
                    $sale->firebase_id = $firebaseIdSales;
                    $sale->save();

                }else if ($productcss && $request->type_sales == 2){
                    $produkArray = json_decode($productcss, true);
                    $macamProduk = count($produkArray);
                    for ($i=0; $i < $macamProduk; $i++) {
                        SalesBundle::create([
                            "sale_id" => $saleId,
                            "member_id" => auth()->user()->id,
                            "bundle_id" => $produkArray[$i]["bundle_id"],
                            "price" => $produkArray[$i]["price"],
                            "qty" => $produkArray[$i]["qty"],
                            "remainder" => $produkArray[$i]["qty"],
                            "product_id" => $produkArray[$i]["product_id"],
                            "status" => 1
                        ]);
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

                if ($request->seat!="" || $request->seat!=null) {
                    StoreTable::where('store_id',$sale->store_id)
                                ->where('table_number',$request->seat)
                                ->update([
                                    'is_ready' => 0
                                ]);
                }

            DB::commit();
            $this->_generatePaymentToken($sale);
            return response()->json([
                'success'=>true,
                'message'=>'Silahkan Lakukan Proses Pembayaran',
                'data'=>new SaleItem($sale)
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
