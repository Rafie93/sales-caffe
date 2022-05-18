@extends('app.app')
@section('content')
     <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Subscription Events </h1>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Subscription</a></li>
                                    <li class="active">Events</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                             <div class="card-header">
                                <form method="get" action="{{ url()->current() }}">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group col-lg-8" style="float: left">
                                                            <a href="{{Route('event.list')}}" class="btn btn-lg btn-info"> 
                                                               Daftar Events</a>
                                                            <a href="{{Route('event.create')}}" class="btn btn-lg btn-primary"> 
                                                               Add Events</a>
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
                            <div class="card alert">
                                <div class="order-list-item">
                                    <table class="table" id="listOrder">
                                        <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Nama Event</th>
                                            <th>Event Date</th>
                                            <th>Grand Total</th>
                                            <th>Status</th>
                                            <th>Ticket</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="tbody">
                                            <tr>
                                                <td colspan="7">Loading data .....</td>    
                                                <td></td>     
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
							</div>
						</div><!-- /# column -->
					</div><!-- /# row -->
                </div><!-- /# main content -->
            </div><!-- /# container-fluid -->
@endsection
@section('script')
    <script>
        $(document).ready(function(){
             getDataSales()
            setInterval(function(){
                getDataSales()
            }, 30000)
        });

        function getDataSales(){
            $.ajax({
                url: "{{ route('event.getDataSalesEvent') }}",
                method: "GET",
                success: function(data) {
                    console.log(data);
                    var htmls = [];
                    $.each(data, function(index, value) {
                    if(value) {
                        var s = value.status;
                        var status_payment = value.status_payment;
                        var product_date = value.product_date;
                        var is_tiket = value.is_ticket;

                        var tiket = "";
                        if(status_payment=="paid"){
                            status_payment = '<span  class="btn btn-rounded btn-success">PAID</span>';
                        }else{
                            status_payment = '<span  class="btn btn-rounded btn-warning">UNPAID</span>';
                        }
                        if(is_tiket=="E-Ticket Terbit"){
                            tiket = '<span  class="btn btn-rounded btn-success">E-Ticket Terbit</span>';
                        }else{
                            tiket = '<span  class="btn btn-rounded btn-danger">E-Ticket Belum Terbit</span>';
                        }
                        htmls.push('<tr>\
                        <td>'+ value.customer +'</td>\
                        <td>'+ value.number +'</td>\
                        <td>'+ value.date +'</td>\
                        <td style="text-align:center">'+ value.menu_product +'</td>\
                        <td>'+ product_date +'</td>\
                        <td align="right"><strong>Rp. '+ value.grand_total +'</strong></td>\
                        <td>'+ status_payment +'</td>\
                        <td>'+ tiket +'</td>\
                        <td>\
                            <a style="width:100px" href="/event/tiket/'+value.sales_event_id+'" class="btn btn-info" data-id="'+value.sales_event_id+'"><i class="glyphicon glyphicon-eye-open"></i> E-Ticket</a>\
                        </td>\
                        </tr>');
                      }
                     lastIndex = index;
                    });
                    $('#tbody').html(htmls);
                    $("#submitUser").removeClass('desabled');                    
                }
            });
        }
    </script>
@endsection
