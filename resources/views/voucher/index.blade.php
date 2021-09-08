@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Data Voucher</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <form method="get" action="{{ url()->current() }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <div class="row">
                                            <div class="form-group col-lg-8" style="float: left">
                                                <a href="{{Route('voucher.create')}}" class="btn btn-lg btn-info"> <i class="ace-icon fa fa-plus bigger-110"></i>
                                                    Add New Data</a>
                                            </div>

                                            <div class="form-group col-lg-4" style="float: right">

                                                <div class="input-group">
                                                    <input type="text" class="form-control gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari" value="" autocomplete="off">
                                                    <div class="input-group-btn">
                                                        <button type="submit" class="btn btn-default no-border btn-sm gp-search">
                                                        <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>

                </div>
                <div class="table-responsive order-list-item">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode / Nama Voucher</th>
                                <th>Type</th>
                                <th>Nominal</th>
                                <th>Expired</th>
                                <th>Status</th>
                                <th>Digunakan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                        @foreach ($vouchers as $key=> $row)
                            <tr>
                                <td>{{$vouchers->firstItem() + $key }}</td>
                                <td><strong> {{$row->code}} </strong><br> {{$row->name}}  </td>
                                <td>{{$row->amount_type}}</td>
                                <td align="right">{{$row->amount}}</td>
                                <td align="center">{{$row->expired_at}}</td>
                                <td align="center">{{$row->is_status()}}</td>
                                <td align="center">
                                    {{$row->sales->count()}}
                                </td>
                                <td>
                                    <a href="{{Route('voucher.edit',$row->id)}}" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                     <a href="#" class="btn btn-danger delete"  r-name="{{ $row->name}}" r-id="{{ $row->id }}">
                                        <i class="glyphicon glyphicon-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                     {{$vouchers->appends(request()->except('page'))->links()}}
                </div>
                
                <br>
            </div>
        </div>
       
    </div>

</div>
@endsection
@section('script')
<script>
        $().ready( function () {
            $(".delete").click(function() {
                var id = $(this).attr('r-id');
                var name = $(this).attr('r-name');
                swal({
                    title: 'Ingin Menghapus?',
                    text: "Yakin ingin menghapus data voucher  : "+name+" ini ?" ,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                         window.location =  "/voucher/"+id+"/delete";
                    }, 2000);
                });
            });
        } );

    </script>
@endsection