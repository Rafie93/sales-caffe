@extends('app.app')
@section('content')
  <div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Tax</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <form method="POST" action="{{Route('tax.store')}}">
                {{ csrf_field() }}
            <div class="card flex-fill">
                <div >
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Status</td>
                                <td>Nama Tax</td>
                                <td>Tax Type</td>
                                <td>Nilai</td>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if ($taxs->count() > 0)
                                @foreach ($taxs as $row)
                                    <tr>
                                        <td>
                                              <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status_{{strtolower($row->code)}}[]" 
                                                 @if ($row->status==1)
                                                    checked
                                                @endif 
                                                    value="1">
                                                <span class="form-check-label">
                                                Aktif
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status_{{strtolower($row->code)}}[]" 
                                                @if ($row->status==0)
                                                    checked
                                                @endif value="0">
                                                <span class="form-check-label">
                                                Tidak Aktif
                                                </span>
                                            </label>
                                        </td>
                                         <td>
                                            {!! Form::hidden('code[]', $row->code) !!}
                                            {!! Form::text('name[]', $row->name, ['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'Percentage',
                                            ['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::number('amount[]', $row->amount, ['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                                  <tr>
                                <td align="center">
                                       <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_ppn[]" value="1">
                                            <span class="form-check-label">
                                            Aktif
                                            </span>
                                        </label>
										<label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_ppn[]" checked value="0">
                                            <span class="form-check-label">
                                            Tidak Aktif
                                            </span>
                                        </label>
                                </td>
                                <td>
                                    {!! Form::hidden('code[]', 'PPN') !!}
                                    {!! Form::text('name[]', 'PPN', ['class'=>'form-control']) !!}
                                </td>
                                <td>{!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'Percentage', ['class'=>'form-control']) !!}</td>
                                <td>
                                     {!! Form::number('amount[]', '10', ['class'=>'form-control']) !!}
                                </td>
                                
                            </tr>
                            <tr>
                                <td align="center">
                                       <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_charge[]" value="1">
                                            <span class="form-check-label">
                                            Aktif
                                            </span>
                                        </label>
										<label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_charge[]" checked value="0">
                                            <span class="form-check-label">
                                            Tidak Aktif
                                            </span>
                                        </label>
                                </td>
                                <td>
                                    {!! Form::hidden('code[]', 'CHARGE') !!}
                                    {!! Form::text('name[]', 'Service Charge', ['class'=>'form-control']) !!}
                                </td>
                                <td>
                                    {!! Form::select('type[]', ['percentage' => 'Percentage', 'nominal' => 'Nominal'], 'Percentage',
                                     ['class'=>'form-control']) !!}
                                </td>
                                <td>
                                     {!! Form::number('amount[]', '0', ['class'=>'form-control']) !!}
                                </td>
                              
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