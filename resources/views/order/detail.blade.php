@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li ><a href="{{Route('order')}}">Order</a></li>
                        <li class="active">View {{$sales->number}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" id="datamember-tab" data-toggle="tab" href="#datamember" role="tab" aria-controls="datamember" aria-selected="true" aria-expanded="true">Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hubungan-tab" data-toggle="tab" href="#hubungan" role="tab" aria-controls="hubungan" aria-selected="false" aria-expanded="false">Data Produk</a>
                        </li>
                        
                       
                       
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active in" id="datamember">
                             <table class="table">
                                 <tbody>
                                     <tr>
                                         <td>Number</td>
                                         <td>:</td>
                                         <td style="text-align: left">{{$sales->number}}</td>
                                     </tr>
                                     <tr>
                                        <td>Store</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$sales->stores->name}}</td>
                                    </tr>
                                     <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$sales->date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Service</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$sales->service}}</td>
                                    </tr>
                                     <tr>
                                        <td>Payment Method</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$sales->payment_method}}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Status</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$sales->payment_status}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Order</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{statusOrder($sales->status)}}</td>
                                    </tr>
                                    @if ($sales->service == 'delivery')
                                        <tr>
                                            <td>Tujuan</td>
                                            <td>:</td>
                                            <td style="text-align: left">{{$sales->address.", ".$sales->destination->name.", ".$sales->destination->province." ".$sales->destination->postal_code}}</td>
                                        </tr>
                                        <tr>
                                            <td>Pickup Date</td>
                                            <td>:</td>
                                            <td style="text-align: left">{{$sales->pickup_date." ".$sales->pickup_time}}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Method</td>
                                            <td>:</td>
                                            <td style="text-align: left">{{$sales->shipping_method}}</td>
                                        </tr>
                                        <tr>
                                            <td>No Resi</td>
                                            <td>:</td>
                                            <td style="text-align: left">{{$sales->resi_no}}</td>
                                        </tr>
                                    @elseif ($sales->service == 'take_away')
                                        <tr>
                                            <td>Tanggal Dan Jam Pengambilan</td>
                                            <td>:</td>
                                            <td style="text-align: left">{{$sales->pickup_date." ".$sales->pickup_time}}</td>
                                        </tr>
                                    @elseif ($sales->service == 'reservation')
                                   
                                    <tr>
                                        <td>Tanggal Reservasi</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$sales->seat_reservation_date." ".$sales->seat_reservation_start."s/d".$sales->seat_reservation_end}}</td>
                                    </tr>
                                    <tr>
                                        <td>Seat / Meja</td>
                                        <td>:</td>
                                        <td style="text-align: left">{{$sales->seat}}</td>
                                    </tr>
                                        
                                    @endif
                                   
                                 </tbody>
                             </table>                                     
                        </div>
                        <div class="tab-pane" id="hubungan">
                            <div class="table-responsive ">
                                <table class="table table-bordered" id="listOrder">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product</th>
                                        <th>Harga</th>
                                        <th>Harga Variant</th>
                                        <th>Harga Promo</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Catatan</th>
                                    </tr>
                                    </thead>
                                    <tbody  id="tbody">
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($sales->detail as $key=>$row)
                                            <tr>
                                                <td align="center">{{$no++}}</td>
                                                <td>{{$row->products->name}}</td>
                                                <td align="right">{{number_format($row->price)}}</td>
                                                <td align="right">{{number_format($row->price_variant)}}</td>
                                                <td align="right">{{number_format($row->price_promo)}}</td>
                                                <td align="center">{{$row->qty}}</td>
                                                <td align="right">{{number_format($row->subtotal)}}</td>
                                                <td>{{$row->notes}}</td>
                                               
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