<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Stores\Store;
class StoresController extends Controller
{
    
    public function index()
    {
        $stores = Store::all();
        return view('stores.index', compact('stores'));
    }
    
    public function create()
    {
       return view('stores.create');
    }
     public function edit($id)
    {
        $data = Store::find($id);
       return view('stores.edit',compact('data'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:2',
            'address'    => 'required',
            'phone'=>'required',
        ]);
        $store = Store::create($request->all());
        if ($request->hasFile('file')) {
            $request->file('file')->move(public_path('images/stores'),$request->file('file')->getClientOriginalName());
            $store->logo= $request->file('file')->getClientOriginalName();
            $store->save();
       }
        return redirect()->route('stores')->with('message','Toko Baru Berhasil ditambahkan');
    }
    public function update(Request $request,$id)
    {
          $this->validate($request,[
            'name' => 'required|min:2',
            'address'    => 'required',
            'phone'=>'required',
        ]);
        $store = Store::find($id);
        $store->update($request->all());
        if ($request->hasFile('file')) {
            $request->file('file')->move(public_path('images/stores'),$request->file('file')->getClientOriginalName());
            $store->update(['logo'=>$request->file('file')->getClientOriginalName()]);
       }
        return redirect()->route('stores')->with('message','Toko Baru Berhasil diperbaharui');
    }
}
