<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesDetail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::orderBy('id','desc')->where('store_id',auth()->user()->store_id)->paginate(20);
        return view('order.index');
    }
    public function detail(Request $request,$id)
    {
        $sales = Sale::find($id);
        return view('order.detail',compact('sales'));
    }
     public function history(Request $request)
    {
        $sales = Sale::orderBy('id','desc')->where('store_id',auth()->user()->store_id)->paginate(20);
        return view('order.history',compact('sales'));
    }

    public function bundle(Request $request)
    {
        $sales = Sale::orderBy('id','desc')->where('store_id',auth()->user()->store_id)->paginate(20);
        return view('order.bundle');
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'id' => 'required',
            'status'    => 'required',
        ]);

        $status = $request->status;
        Sale::find($request->id)->update([
            'status' => $status,
            'resi_no' => $request->resi_no
        ]);

        $sale = Sale::where('id',$request->id)->first();
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
            "status"=> statusOrder($sale->status),
            "payment_status" => $sale->payment_status,
            "payment_method" => $sale->payment_method
        ];
        $updates = ['orders/store-'.$sale->store_id.'/'.$sale->firebase_id => $postData];
        $firebase->getReference()->update($updates);


        return redirect()->route('order')->with('message','Status Pesanan di Perbaharui');
    }

    public function getDataSales()
    {
       $sale =  Sale::orderBy('id','asc')
                    ->where('payment_status','paid')
                    ->where('type_sales',1)
                    ->whereIn('status',[2,3])
                    ->where('store_id',auth()->user()->store_id)
                    ->get();
       $output = array();
       foreach ($sale as $key => $row) {
           $output[] = array(
                'id' => $row->id,
                'number' => $row->number,
                'customer' => $row->customer_name,
                'date' => $row->date,
                'menu_product' => $row->detail->count(),
                'grand_total' => number_format($row->grand_total),
                'service' => $row->service,
                'resi_no' => $row->resi_no,
                'status' => intval($row->status),
                'status_order' => statusOrder($row->status),
                'status_payment' => $row->payment_status,
                'detail' => $row->detail
           );
       }
       return response()->json($output);
    }

    public function getDataSalesBundle()
    {
       $sale =  Sale::orderBy('id','asc')
                    ->where('payment_status','paid')
                    ->where('type_sales',2)
                    ->whereIn('status',[2,3])
                    ->where('store_id',auth()->user()->store_id)
                    ->get();
       $output = array();
       foreach ($sale as $key => $row) {
           $output[] = array(
                'id' => $row->id,
                'number' => $row->number,
                'customer' => $row->member->fullname,
                'date' => $row->date,
                'menu_product' => $row->detail->count(),
                'grand_total' => number_format($row->grand_total),
                'service' => $row->service,
                'resi_no' => $row->resi_no,
                'status' => intval($row->status),
                'status_order' => statusOrder($row->status),
                'status_payment' => $row->payment_status,
                'detail' => $row->detail
           );
       }
       return response()->json($output);
    }
}
