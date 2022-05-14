<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores\StoreWork;
use App\Models\Stores\Store;

class WorkTimeController extends Controller
{
    public function index(Request $request)
    {
        $works = StoreWork::where('store_id',auth()->user()->store_id)->get();
        return view('worktime.index',compact('works'));
    }
    public function store(Request $request)
    {
        if (auth()->user()->store_id != null) {
            foreach ($request->day as $i => $day) {
                StoreWork::updateOrInsert([
                    'store_id' =>  auth()->user()->store_id,
                    'day' => $day
                ],
                [
                    'store_id'=> auth()->user()->store_id,
                    'day' => $day,
                    'open_time' => $request->open_time[$i],
                    'close_time' => $request->close_time[$i],
                ]);
            }
            return redirect()->route('worktime')->with('message','Jam Kerja diperbaharui');
        }else{
            if (auth()->user()->role==11) {
                $store = Store::where('status',1)->get();
                foreach ($store as $key => $row) {
                    $storeId = $row->id;
                    foreach ($request->day as $i => $day) {
                        StoreWork::updateOrInsert([
                            'store_id' =>  $storeId,
                            'day' => $day
                        ],
                        [
                            'store_id'=> $storeId,
                            'day' => $day,
                            'open_time' => $request->open_time[$i],
                            'close_time' => $request->close_time[$i],
                        ]);
                    }
                }
                return redirect()->route('worktime')->with('message','Seluru Jam Kerja Store diperbaharui');

            }else{
                return redirect()->route('worktime')->with('error','Hak akses tidak diizinkan');

            }
        }
       

    }
}
