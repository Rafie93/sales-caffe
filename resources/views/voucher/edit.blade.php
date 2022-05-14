@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('voucher')}}">Data Voucher</a></li>
                        <li class="active">Edit Voucher</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('voucher.update',$data->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
                    
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('code') has-error @enderror">
                                        <label class="form-label">Kode Voucer *</label>
                                        <input type="text" class="form-control"
                                        placeholder="" name="code" required value="{{old('code') ? old('code') : $data->code}}">
                                        @error('code')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                      <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Voucher</label>
                                        <input type="text" class="form-control"
                                        placeholder="" name="name" required value="{{old('name') ? old('name') : $data->name}}">
                                        @error('name')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('start_date') has-error @enderror">
                                        <label class="form-label">Tanggal Mulai*</label>
                                        <input type="date" class="form-control" 
                                        placeholder="" name="start_date" required value="{{old('start_date') ? old('start_date') : $data->start_date}}">
                                        @error('start_date')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('expired_at') has-error @enderror">
                                        <label class="form-label">Tanggal Berakhir*</label>
                                        <input type="date" class="form-control" 
                                        placeholder="" name="expired_at" required value="{{old('expired_at') ? old('expired_at') : $data->expired_at}}">
                                        @error('expired_at')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('amount_type') has-error @enderror">
                                        <label class="form-label">Tipe Promo</label>
                                        <select name="amount_type" id="amount_type" class="form-control" required>
                                            <option value="nominal" {{$data->amount_type=="nominal" ? 'selected' : ''}}>Nominal</option>
                                            <option value="percentage" {{$data->amount_type=="percentage" ? 'selected' : ''}}>Percentage</option>
                                            <option value="reservation" {{$data->amount_type=="reservation" ? 'selected' : ''}}>Reservasi</option>
                                        </select>
                                        @error('amount_type')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                     <div class="form-group @error('amount') has-error @enderror">
                                        <label class="form-label">Nilai *</label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="amount" required value="{{old('amount') ? old('amount') : $data->amount}}">
                                        @error('amount')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('minimum_shopp') has-error @enderror">
                                        <label class="form-label">Minimal Belanja (Rp) </label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="minimum_shopp" required value="{{old('minimum_shopp') ? old('minimum_shopp') : $data->minimum_shopp}}">
                                        @error('minimum_shopp')
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
         <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('description') has-error @enderror">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" id="editor" class="form-control">{{old('description') ? old('description') : $data->description}}</textarea>
                                        @error('description')
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
                <button type="submit" class="btn btn-lg btn-info mg">SIMPAN</button>
                <br/>
            </div>
        </div>

        </form>
    </div>

</div>
@endsection
@section('script')
<script>
  CKEDITOR.replace('editor', {
        height  : '490px',
        filebrowserUploadUrl: "{{route('product.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection