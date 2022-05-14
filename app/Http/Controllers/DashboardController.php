<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $role = auth()->user()->role;
        if ($role==12) {
            return view('dashboard.admin');
        }else if ($role==16) {
            return view('dashboard.kurir');
        }
        return view('dashboard.admin');
    }

    public function getSalesHarian()
    {
        $data = Sale::select(DB::raw('distinct(date) date'),
                        DB::raw('count(id) jumlah'))
                        ->groupBy('date')
                        ->whereYear('date',date('Y'))
                        ->where(function ($query) {
                            if (auth()->user()->IN_STORE()) {
                                $query->where('store_id','=', auth()->user()->store_id);
                            }
                        })
                        ->get();
        $output = array();
        foreach ($data as $key => $row) {
            $output[]=array(
                'date'=>$row->date,
                'jumlah'=>$row->jumlah
            );
        }
        return response()->json($output);
    }   
    public function getSalesBulanan()
    {
        $data = Sale::select(DB::raw('count(id) as `data`'),
                    DB::raw('YEAR(date) year, MONTH(date) month'))
                    ->groupby('year','month')
                    ->whereYear('date',date('Y'))
                    ->where(function ($query) {
                        if (auth()->user()->IN_STORE()) {
                            $query->where('store_id','=', auth()->user()->store_id);
                        }
                    })
                    ->get();
        $output = array();
        foreach ($data as $key => $row) {
            $output[]=array(
            'date'=>$row->month,
            'jumlah'=>$row->data
            );
        }
        return response()->json($output);
    }

    public function getPenjualanProductYearly()
    {

        $label = Sale::orderBy('day','desc')
                                ->limit(10)
                                ->select(DB::raw('DATE(date) day'))
                                        ->groupBy('day')
                                        ->whereYear('date', date('Y'))
                                        ->where(function ($query) {
                                            if (auth()->user()->IN_STORE()) {
                                                $query->where('store_id','=', auth()->user()->store_id);
                                            }
                                        })
                                        ->get();
        $dataset = array();
        $productCategory = SalesDetail::select(DB::raw('product_id'))
                                    ->groupBy('product_id')
                                    ->whereYear('created_at', date('Y'))
                                    ->where(function ($query) {
                                        if (auth()->user()->IN_STORE()) {
                                            $query->where('store_id','=', auth()->user()->store_id);
                                        }
                                    })
                                    ->get();

        foreach ($productCategory as $crim) {
            $data=array();
            foreach ($label as $date) {
                $detail = SalesDetail::orderBy('day','asc')
                                        ->select(DB::raw('sum(qty) AS data'),
                                        DB::raw('product_id'),DB::raw('DATE(created_at) day'))
                                        ->groupBy('product_id','day')
                                        ->where('product_id',$crim->product_id)
                                        ->whereYear('created_at', date('Y'))
                                        ->whereDate('created_at',$date->day)
                                        ->where(function ($query) {
                                            if (auth()->user()->IN_STORE()) {
                                                $query->where('store_id','=', auth()->user()->store_id);
                                            }
                                        })
                                        ->get();

                if ($detail->count()>0) {
                    foreach ($detail as $d) {
                        $data[] = $d->data;
                    }
                }else{
                    $data[] = 0;
                }
              
               
            }
            $dataset[] = array(
                'label' => $crim->products->name,
                'data' => $data,
                'backgroundColor' => 'transparent',
                'borderColor'=> $this->rand_color(),
                'borderWidth' => 3,
                'pointStyle' => 'circle',
                'pointRadius'=> 5,
                'pointBorderColor' => 'transparent',
                'pointBackgroundColor' => $this->rand_color(),
            );
        }

        $outLabel = array();
        foreach ($label as $lab) {
            $outLabel[] = $lab->day;
        }
       

        $output = array(
            'title' => "Penjualan Harian",
            'type' => "line",
            'labels' => $outLabel,
            'datasets' => $dataset
        );

        return response()->json(array(
            "data" => $output
        ));
    }

    public function getPenjualanProductMonthly()
    {

        $label = Sale::orderBy('day','desc')
                                ->limit(10)
                                ->select(DB::raw('Month(date) day'))
                                ->groupBy('day')
                                ->whereYear('date', date('Y'))
                                ->where(function ($query) {
                                    if (auth()->user()->IN_STORE()) {
                                        $query->where('store_id','=', auth()->user()->store_id);
                                    }
                                })
                                ->get();
        $dataset = array();
        $productCategory = SalesDetail::select(DB::raw('product_id'))
                                    ->groupBy('product_id')
                                    ->whereYear('created_at', date('Y'))
                                    ->where(function ($query) {
                                        if (auth()->user()->IN_STORE()) {
                                            $query->where('store_id','=', auth()->user()->store_id);
                                        }
                                    })
                                    ->get();

        foreach ($productCategory as $crim) {
            $data=array();
            foreach ($label as $date) {
                $detail = SalesDetail::orderBy('day','asc')
                                        ->select(DB::raw('sum(qty) AS data'),
                                        DB::raw('product_id'),DB::raw('Month(created_at) day'))
                                        ->groupBy('product_id','day')
                                        ->where('product_id',$crim->product_id)
                                        ->whereYear('created_at', date('Y'))
                                        ->whereMonth('created_at',$date->day)
                                        ->where(function ($query) {
                                            if (auth()->user()->IN_STORE()) {
                                                $query->where('store_id','=', auth()->user()->store_id);
                                            }
                                        })
                                        ->get();

                if ($detail->count()>0) {
                    foreach ($detail as $d) {
                        $data[] = $d->data;
                    }
                }else{
                    $data[] = 0;
                }
              
               
            }
            $dataset[] = array(
                'label' => $crim->products->name,
                'data' => $data,
                'backgroundColor' => 'transparent',
                'borderColor'=> $this->rand_color(),
                'borderWidth' => 3,
                'pointStyle' => 'circle',
                'pointRadius'=> 5,
                'pointBorderColor' => 'transparent',
                'pointBackgroundColor' => $this->rand_color(),
            );
        }

        $outLabel = array();
        foreach ($label as $lab) {
            $outLabel[] = $lab->day;
        }
       

        $output = array(
            'title' => "Penjualan Harian",
            'type' => "line",
            'labels' => $outLabel,
            'datasets' => $dataset
        );

        return response()->json(array(
            "data" => $output
        ));
    }

    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
