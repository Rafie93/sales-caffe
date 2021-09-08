@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('voucher')}}">Data Voucher</a></li>
                        <li class="active">Tambah Voucher</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('voucher.store')}}" method="POST" enctype="multipart/form-data">
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
                                        placeholder="" name="code" required value="{{old('code')}}">
                                        @error('code')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                      <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Voucer *</label>
                                        <input type="text" class="form-control"
                                        placeholder="" name="name" required value="{{old('name')}}">
                                        @error('name')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('start_date') has-error @enderror">
                                        <label class="form-label">Tanggal Mulai*</label>
                                        <input type="date" class="form-control" data-date="" data-date-format="DD-MM-YYYY" 
                                        placeholder="" name="start_date" required value="{{old('start_date') ? old('start_date') : date('Y-m-d')}}">
                                        @error('start_date')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('expired_at') has-error @enderror">
                                        <label class="form-label">Tanggal Berakhir*</label>
                                        <input type="date" class="form-control" data-date="" data-date-format="DD-MM-YYYY" 
                                        placeholder="" name="expired_at" required value="{{old('expired_at') ? old('expired_at') : date('Y-m-d')}}">
                                        @error('expired_at')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('amount_type') has-error @enderror">
                                        <label class="form-label">Tipe Promo</label>
                                        <select name="amount_type" id="amount_type" class="form-control" required>
                                            <option value="nominal">Nominal</option>
                                            <option value="percentage">Percentage</option>
                                            <option value="percentage">Reservasi</option>
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
                                        placeholder="" name="amount" required value="{{old('amount')}}">
                                        @error('amount')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('minimum_shopp') has-error @enderror">
                                        <label class="form-label">Minimal Belanja (Rp) </label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="minimum_shopp" required value="{{old('minimum_shopp') ? old('minimum_shopp') : 0}}">
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
                                        <textarea name="description" id="editor" class="form-control">{{old('description')}}</textarea>
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