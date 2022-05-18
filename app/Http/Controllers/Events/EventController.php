<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events\Event;
use Image;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesEvent;
use App\Models\Events\ETicket;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::orderBy('date_end','desc')
                    ->where('store_id',auth()->user()->store_id)
                    ->paginate(10);
        return view("events.index",compact('events'));
    }
    
    public function running(Request $request)
    {
        $events = Event::where('store_id',auth()->user()->store_id);
        return view("events.running",compact('events'));
    }
    public function tiket(Request $request,$id)
    {
        $events = SalesEvent::where('id',$id)->first();
        $tiket = ETicket::where('sales_event_id',$id)->get();
        return view("events.tiket",compact('events','tiket'));
    }

     public function create(Request $request)
    {
        return view("events.create");
    }
     public function edit(Request $request,$id)
    {
        $data = Event::find($id);
        return view("events.edit",compact('data'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'date' => 'required|date',
            'date_end' => 'required|date',
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|numeric'
        ]);
         if(auth()->user()->role!=11){
            $request->merge(['store_id'=>auth()->user()->store_id]);
        }
      
        $events = Event::create($request->all());
        if ($request->hasFile('cover')) {
            $originName = $request->file('cover')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('cover')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('cover')->move('images/event/',$fileName);
            $events->image = $fileName;
            $events->save();
        }
        return redirect()->route('event.list')->with('message','Event Baru Berhasil dibuat');
    }
     public function update(Request $request,$id)
    {
        $this->validate($request,[
            'date' => 'required|date',
            'date_end' => 'required|date',
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|numeric'
        ]);
      
        $events = Event::find($id);
        $events->update($request->all());
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/event/',$fileName);
            $events->image = $fileName;
            $events->save();
        }
        return redirect()->route('event.list')->with('message','Event Baru Berhasil dibuat');
    }

    public function delete($id)
    {
        
    }

    public function getDataSalesEvent()
    {
       $sale =  Sale::orderBy('id','desc')
                    ->where('payment_status','paid')
                    ->where('type_sales',3)
                    ->whereIn('status',[2,3,4,6])
                    ->where('store_id',auth()->user()->store_id)
                    ->get();
       $output = array();
       foreach ($sale as $key => $row) {
           $event = SalesEvent::where('sale_id',$row->id)->first();
           $tiket = ETicket::where('sales_event_id',$event->id)->get()->count();
           $output[] = array(
                'id' => $row->id,
                'number' => $row->number,
                'customer' => $row->member->fullname,
                'date' => $row->date,
                'sales_event_id' => $event->id,
                'menu_product' => $event->qty." x ".$event->event->name,
                'product_date' => $event->event->date.' '.$event->event->date_end,
                'grand_total' => number_format($row->grand_total),
                'service' => $row->service,
                'resi_no' => $row->resi_no,
                'status' => intval($row->status),
                'status_order' => statusOrder($row->status),
                'status_payment' => $row->payment_status,
                'is_ticket' => $tiket==0 ? 'E-Ticket Belum Terbit' : 'E-Ticket Terbit',
                'detail' => $event
           );
       }
       return response()->json($output);
    }
}
