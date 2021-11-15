@extends('app.app')
@section('content')
  <div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Work Time</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <form method="POST" action="{{Route('worktime.store')}}">
                {{ csrf_field() }}
            <div class="card flex-fill">
                <div >
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Day</td>
                                <td>Open Time</td>
                                <td>Close Time</td>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if ($works->count() > 0)
                                @foreach ($works as $row)
                                    <tr>
                                         <td>
                                            {!! Form::text('day[]', $row->day, ['class'=>'form-control','readonly']) !!}
                                        </td>
                                        <td>
                                            {!! Form::time('open_time[]', $row->open_time, ['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::time('close_time[]', $row->close_time, ['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                             <tr>
                                <td> {!! Form::text('day[]', 'Minggu', ['class'=>'form-control','readonly']) !!}</td>
                                <td> {!! Form::time('open_time[]', '09:00', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::time('close_time[]', '23:00', ['class'=>'form-control']) !!}</td>  
                             </tr>
                             <tr>
                                <td> {!! Form::text('day[]', 'Senin', ['class'=>'form-control','readonly']) !!}</td>
                                <td> {!! Form::time('open_time[]', '09:00', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::time('close_time[]', '23:00', ['class'=>'form-control']) !!}</td>  
                             </tr>
                             <tr>
                                <td> {!! Form::text('day[]', 'Selasa', ['class'=>'form-control','readonly']) !!}</td>
                                <td> {!! Form::time('open_time[]', '09:00', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::time('close_time[]', '23:00', ['class'=>'form-control']) !!}</td>  
                             </tr>
                             <tr>
                                <td> {!! Form::text('day[]', 'Rabu', ['class'=>'form-control','readonly']) !!}</td>
                                <td> {!! Form::time('open_time[]', '09:00', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::time('close_time[]', '23:00', ['class'=>'form-control']) !!}</td>  
                             </tr>
                             <tr>
                                <td> {!! Form::text('day[]', 'Kamis', ['class'=>'form-control','readonly']) !!}</td>
                                <td> {!! Form::time('open_time[]', '09:00', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::time('close_time[]', '23:00', ['class'=>'form-control']) !!}</td>  
                             </tr>
                             <tr>
                                <td> {!! Form::text('day[]', 'Jumat', ['class'=>'form-control','readonly']) !!}</td>
                                <td> {!! Form::time('open_time[]', '09:00', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::time('close_time[]', '23:00', ['class'=>'form-control']) !!}</td>  
                             </tr>
                             <tr>
                                <td> {!! Form::text('day[]', 'Sabtu', ['class'=>'form-control','readonly']) !!}</td>
                                <td> {!! Form::time('open_time[]', '09:00', ['class'=>'form-control']) !!}</td>
                                <td>{!! Form::time('close_time[]', '23:00', ['class'=>'form-control']) !!}</td>  
                             </tr>
                           
                           
                            @endif
                            <tr>
                                <br/>
                                <td colspan="4"><button type="submit" class="btn btn-lg btn-info mg">UPDATE</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <br>
            </div>
            </form>
        </div>
       
    </div>

</div>  
@endsection