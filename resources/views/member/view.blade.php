@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li ><a href="{{Route('member')}}">Data Member</a></li>
                        <li class="active">View Member {{$user->fullname}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" id="datamember-tab" data-toggle="tab" href="#datamember" role="tab" aria-controls="datamember" aria-selected="true" aria-expanded="true">Data Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hubungan-tab" data-toggle="tab" href="#hubungan" role="tab" aria-controls="hubungan" aria-selected="false" aria-expanded="false">History Transaksi</a>
                        </li>
                        
                       
                       
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active in" id="datamember">
                             <table class="table">
                                 <tbody>
                                     <tr>
                                         <td>Nama</td>
                                         <td>:</td>
                                         <td style="text-align: left">{{$user->fullname}}</td>
                                     </tr>
                                     <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$user->birthday}}</td>
                                    </tr>
                                     <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$user->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$user->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td>Level</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$user->level}}</td>
                                    </tr>
                                    <tr>
                                        <td>Poin</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$user->poin}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$user->IS_STATUS()}}</td>
                                    </tr>
                                 </tbody>
                             </table>                                     
                        </div>
                        <div class="tab-pane" id="hubungan">
                            <div class="table-responsive order-list-item">
                                <table class="table" id="listOrder">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Menu Product</th>
                                        <th>Grand Total</th>
                                        <th>Service</th>
                                        <th>Payment Status</th>
                                        <th>Status Order</th>

                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody  id="tbody">
                                        @foreach ($user->sales as $key=>$row)
                                            <tr>
                                                <td>{{$row->number}}</td>
                                                <td>{{$row->created_at->format('d-m-Y H:i:s')}}</td>
                                                <td>{{$row->detail->count()}}</td>
                                                <td align="right">{{number_format($row->grand_total)}}</td>
                                                <td>{{$row->service}}</td>
                                                <td>{!! $row->payment_status !!}</td>
                                                <td>{{$row->is_status()}}</td>
                                                <td>
                                                    <a href="#" class="btn btn-info viewData"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>                
                                                </td>
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

</div>
@endsection