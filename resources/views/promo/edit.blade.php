@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('product.promo')}}">Data Produk Promo</a></li>
                        <li class="active">Edit Produk Promo</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('promo.update',$data->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
                    
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                      <div class="form-group @error('product_id') has-error @enderror">
                                        <label class="form-label">Pilih Produk*</label>
                                         <select name="product_id" id="product_id" class="form-control select2" required>
                                             @foreach ($product as $item)
                                                @if ($item->id == $data->product_id)
                                                    <option value="{{$item->id}}" selected>{{$item->name}}</option>      
                                                @else 
                                                   <option value="{{$item->id}}">{{$item->name}}</option>                                              
                                                @endif
                                             @endforeach
                                        </select>
                                        @error('product_id')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('start_date') has-error @enderror">
                                        <label class="form-label">Tanggal Mulai*</label>
                                        <input type="date" class="form-control tanggal" data-date="" data-date-format="DD-MM-YYYY" 
                                        placeholder="" name="start_date" required value="{{old('start_date') ? old('start_date') : $data->start_date}}">
                                        @error('start_date')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('end_date') has-error @enderror">
                                        <label class="form-label">Tanggal Berakhir*</label>
                                        <input type="date" class="form-control tanggal" data-date="" data-date-format="DD-MM-YYYY" 
                                        placeholder="" name="end_date" required value="{{old('end_date') ? old('end_date') : $data->end_date}}">
                                        @error('end_date')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('type') has-error @enderror">
                                        <label class="form-label">Tipe Promo</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="nominal" {{$data->type=='nominal' ? 'selected' : '' }}>Nominal</option>
                                            <option value="percentage" {{$data->type=='nominal' ? 'selected' : '' }}>Percentage</option>
                                        </select>
                                        @error('type')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                     <div class="form-group @error('amount') has-error @enderror">
                                        <label class="form-label">Amount *</label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="amount" required value="{{old('amount') ? old('amount') : $data->amount}}">
                                        @error('amount')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>                            
                            </div>
                            
                        </div>
                    </div>
            </div>
        </div>
    
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <br/>
                <button type="submit" class="btn btn-lg btn-info mg">UPDATE</button>
                <br/>
            </div>
        </div>

        </form>
    </div>

</div>
@endsection