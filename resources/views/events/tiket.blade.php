@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('event.running')}}">Subscription</a></li>
                        <li>Events</li>
                        <li class="active">E-Tiket</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                
                <div class="table-responsive mg">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Number</th>
                                <th>Nama Event</th>
                                <th>Tanggal Event</th>
                                <th>Nama Partisipan</th>
                                <th>Phone Partisipan</th>
                                <th>Status</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if ($tiket->isEmpty())
                                <tr>
                                    <td style="text-align: left" colspan="8" class="text-center">Event Belum di jadikan e-tiket oleh partisipan</td>
                                </tr>
                            @else 
                                @php
                                $no=1;
                            @endphp
                            @foreach ($tiket as $item)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$events->sales->number}}</td>
                                    <td>{{$item->events->name}}</td>
                                    <td>{{$item->events->date." ".$item->events->date_end}}</td>
                                    <td>{{$item->participant_name}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->isStatus()}}</td>
                                    {{-- <td></td> --}}
                                </tr>
                                
                            @endforeach
                            @endif
                           
                        </tbody>
                    </table>
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
                    text: "Yakin ingin menghapus event  : "+name+" ini ?" ,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                         window.location =  "/event/"+id+"/delete";
                    }, 2000);
                });
            });
        } );

    </script>
@endsection