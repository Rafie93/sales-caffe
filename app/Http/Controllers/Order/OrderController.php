<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Sale;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('order.index');
    }
     public function history(Request $request)
    {
        $sales = Sale::orderBy('id','desc')->where('store_id',auth()->user()->store_id)->paginate(20);
        return view('order.history',compact('sales'));
    }
}
