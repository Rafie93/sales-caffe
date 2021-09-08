<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events\Event;
use Image;

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
            $image      = $request->file('cover');
            $img = Image::make($image->getRealPath());
            $img->resize(400, 250, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream(); 
            Storage::disk('local')->put('public/images/event/'.$events->id.'/'.$fileName, $img, 'public');
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
            $image      = $request->file('file');
            $img = Image::make($image->getRealPath());
            $img->resize(400, 250, function ($constraint) {
                $constraint->aspectRatio();                 
            });
            $img->stream(); 
            Storage::disk('local')->put('public/images/event/'.$events->id.'/'.$fileName, $img, 'public');
            $events->image = $fileName;
            $events->save();
        }
        return redirect()->route('event.list')->with('message','Event Baru Berhasil dibuat');
    }

    public function delete($id)
    {
        
    }
}
