@inject('regionQuery', 'App\Models\Regions\RegionQuery')
@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('product.special')}}">Data Produk Special</a></li>
                        <li class="active">Tambah Produk Special</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('product.special.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
                    
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('city_id') has-error @enderror">
                                        <label class="form-label">Kota*</label>
                                         <select id="city_id" name="city_id" class="form-control select2" required>
                                            <option value="">--Pilih Kota--</option>
                                            @foreach ($regionQuery->getCities("") as $st)
                                             <option value="{{$st->id}}">{{$st->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('khas') has-error @enderror">
                                         @error('khas')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                        <table class="table table-bordered" id="myTable">
                                            <thead>
                                                <tr>
                                                    <td></td>
                                                    <td>Nama Produk</td>
                                                    <td>Deskripsi</td>
                                                    <td>Harga Jual</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product as $row)
                                                    <tr>
                                                        <td><input type="checkbox" name="khas[]" value="{{$row->id}}"></td>
                                                        <td>{{$row->name}}</td>
                                                        <td>{{$row->category->name}}<br/>{!!$row->description !!}</td>
                                                        <td>{{number_format($row->price_sales)}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
@section('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" />
@endsection
@section('script')
	<script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection