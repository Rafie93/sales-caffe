<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores\StoreTable;
use Image;
use Illuminate\Support\Facades\Storage;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->IN_STORE()) {
            $seats = StoreTable::orderBy('id','desc')
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }
        return view('seat.index',compact('seats'));
    }


    public function create(Request $request)
    {
       return view('seat.create');
    }
     public function edit(Request $request,$id)
    {
       $data = StoreTable::find($id); 
       return view('seat.edit',compact('data'));
    }

    public function store(Request $request)
    {
        $store_id = auth()->user()->store_id;
        $this->validate($request,[
            'table_number' => 'required',
            'minimum_shopping'=>'numeric',
            'file' => 'required'
        ]);
        $request->merge([
            'store_id' => $store_id
        ]);
        $seats = StoreTable::create($request->all());
        if ($request->hasFile('file')) {
            $image      = $request->file('file');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(400, 250, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream(); 
            Storage::disk('local')->put('public/images/seat/'.$seats->id.'/'.$fileName, $img, 'public');
            $seats->image = $fileName;
            $seats->save();
       }
        return redirect()->route('seat')->with('message','Table / Seat Berhasil dibuat');
    }
     public function update(Request $request,$id)
    {
        $this->validate($request,[
            'table_number' => 'required',
            'minimum_shopping'=>'numeric',
        ]);
        $seats = StoreTable::find($id);
        $seats->update($request->all());
        if ($request->hasFile('file')) {
            $image      = $request->file('file');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(400, 250, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream(); 
            Storage::disk('local')->put('public/images/seat/'.$id.'/'.$fileName, $img, 'public');
            $seats->image = $fileName;
            $seats->save();
       }
        return redirect()->route('seat')->with('message','Table / Seat Berhasil dibuat');
    }

    public function delete($id)
    {
        $seat=StoreTable::find($id);
        $seat->delete();
        return redirect()->route('seat')->with('message','Berhasil dihapus');
    }
}
