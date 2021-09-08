@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('products')}}">Data Produk</a></li>
                        <li class="active">Tambah Produk Baru</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('products.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
                    
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('category_id') has-error @enderror">
                                        <label class="form-label">Kategori*</label>
                                        <select name="category_id" class="form-control select2" required>
                                            <option value="">--Pilih kategori--</option>
                                            @foreach ($categorys as $st)
                                                <option value="{{$st->id}}">{{$st->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> 

                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Produk*</label>
                                        <input type="text" class="form-control @error('name') has-error @enderror"
                                        placeholder="" name="name" required value="{{old('name')}}">
                                        @error('name')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('code') has-error @enderror">
                                        <label class="form-label">Code Produk*</label>
                                        <input type="text" class="form-control @error('code') has-error @enderror" placeholder="" name="code" value="{{old('code')}}">
                                        @error('code')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                
                                    <div class="form-group @error('cost_of_goods') has-error @enderror">
                                        <label class="form-label">Harga Modal*</label>
                                        <input type="number" required class="form-control @error('cost_of_goods') has-error @enderror" name="cost_of_goods" value="{{old('cost_of_goods')}}" >
                                        @error('cost_of_goods')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('price_sales') has-error @enderror">
                                        <label class="form-label">Harga Jual *</label>
                                        <input type="number" class="form-control @error('price_sales') has-error @enderror" name="price_sales" value="{{old('price_sales')}}" >
                                        @error('price_sales')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div> 
                                    
                             

                                      <div class="form-group @error('point_cashback') has-error @enderror">
                                        <label class="form-label">Poin For Cashback</label>
                                        <input type="number" class="form-control @error('point_cashback') has-error @enderror"
                                        placeholder="" name="point_cashback" value="{{old('point_cashback') ? old('point_cashback') : 0}}">
                                        @error('point_cashback')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('weight') has-error @enderror">
                                        <label class="form-label">Berat (gram)</label>
                                        <input type="number" step="0.1" class="form-control @error('weight') has-error @enderror"
                                        placeholder="" name="weight" value="{{old('weight') ? old('weight') : 0.1}}">
                                        @error('weight')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                      <div class="form-group @error('time_duration') has-error @enderror">
                                        <label class="form-label">Time Duration (Menit)</label>
                                        <input type="number" class="form-control @error('time_duration') has-error @enderror"
                                        placeholder="" name="time_duration" value="{{old('time_duration') ? old('time_duration') : 0}}">
                                        @error('time_duration')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                     <div class="form-group @error('is_stock') has-error @enderror">
                                            <label class="form-label col-md-4">Menggunakan Stock </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_stock"  value="1">
                                                <span class="form-check-label">
                                                Ya
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_stock" checked value="0">
                                                <span class="form-check-label">
                                                Tidak
                                                </span>
                                    </div>

                                    <div class="form-group @error('long_delivery') has-error @enderror">
                                            <label class="form-label col-md-4">Dukungan Pengirman Lama</label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="long_delivery"  value="1">
                                                <span class="form-check-label">
                                                Ya
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="long_delivery" checked value="0">
                                                <span class="form-check-label">
                                                Tidak
                                                </span>
                                    </div>



                               
                                    <div class="form-group @error('status') has-error @enderror">
                                            <label class="form-label col-md-4">Status </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="status" checked value="1">
                                                <span class="form-check-label">
                                                Aktif
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="status" value="0">
                                                <span class="form-check-label">
                                                Tidak Aktif
                                                </span>
                                    </div>
                                
                                    <div class="form-group @error('is_show_menu') has-error @enderror">
                                        <label class="form-label col-md-4">Tampil ke Menu </label>
                                        <label class="form-check form-check-inline col-md-4">
                                            <input class="form-check-input" type="radio" name="is_show_menu" checked value="1">
                                            <span class="form-check-label">
                                            Ya
                                            </span>
                                        </label>
                                        <label class="form-check form-check-inline col-md-4">
                                            <input class="form-check-input" type="radio" name="is_show_menu" value="0">
                                            <span class="form-check-label">
                                            Tidak
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-group @error('is_ppn') has-error @enderror">
                                            <label class="form-label col-md-4">PPN </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_ppn" value="1">
                                                <span class="form-check-label">
                                                Ya
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_ppn" checked value="0">
                                                <span class="form-check-label">
                                                Tidak
                                                </span>
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
                                        <textarea name="description" id="editor" class="form-control @error('description') has-error @enderror">{{old('description')}}</textarea>
                                        @error('description')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                     <div class="form-group @error('store') has-error @enderror">
                                        <label class="form-label">Store*</label><br>
                                           <select name="store[]" class="form-control" multiple required>
                                             @foreach ($stores as $st)
                                                  <option value="{{$st->id}}">{{$st->name}}</option>
                                             @endforeach
                                        </select>
                                          
                                    </div>

                                    <div class="form-group @error('variant') has-error @enderror">
                                        <label class="form-label">Variant</label>
                                        <select name="variant" id="variant" class="form-control" onchange="variantSelect()">
                                              <option value="0">Tanpa Variant</option>
                                              <option value="1">Pilih Salah Satu</option>
                                              <option value="2">Pilih Banyak</option>
                                        </select>
                                          
                                    </div>
                                    <div id="variantPage">
                                         <table class="table table-borderd" id="tableVariant">
                                             {!! Form::hidden("countvariant", "2", ["id"=>"countvariant"]) !!}
                                            <thead>
                                                <tr>
                                                    <th>Nama Pilihan</th>
                                                    <th>+ Harga</th>
                                                    <th>Urutan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {!! Form::text("name_pilihan[]", "", ["class"=>"form-control","id"=>"name_pilihan1"]) !!}      
                                                    </td>
                                                    <td>
                                                        {!! Form::number("price_pilihan[]", "0", ["class"=>"form-control","id"=>"price_pilihan1"]) !!}      
                                                    </td>
                                                    <td>
                                                        {!! Form::number("urutan[]", "1", ["class"=>"form-control","id"=>"urutan1"]) !!}   
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" onclick="addRow()" >Add Pilihan</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                      <td>
                                                        {!! Form::text("name_pilihan[]", "", ["class"=>"form-control","id"=>"name_pilihan2"]) !!}      
                                                    </td>
                                                    <td>
                                                        {!! Form::number("price_pilihan[]", "0", ["class"=>"form-control","id"=>"price_pilihan2"]) !!}      
                                                    </td>
                                                    <td>
                                                        {!! Form::number("urutan[]", "1", ["class"=>"form-control","id"=>"urutan2"]) !!}   
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group @error('file') has-error @enderror">
                                        <label class="form-label">Cover</label>
                                        <input type="file" name="file" class="form-control @error('file') has-error @enderror">
                                            @error('file')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                     <button type="button" class="btn btn-info" onclick="addImage()" >Add Image</button>
                                     {!! Form::hidden("imagecount", 0, ["id"=>"imagecount"]) !!}
                                     <table class="table" id="tableImage">
                                         <tbody></tbody>
                                     </table>
                                    
                                </div>
                            
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <br/>
                    <button type="submit" class="btn btn-lg btn-info mg">PROSES</button>
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
        height  : '150px',
        filebrowserUploadUrl: "{{route('product.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

     $(function() {
         $("#variantPage").hide();

     })
     function addImage(){
        var count = $("#imagecount").val();
        var newCount = parseInt(count)+1;
        $("#imagecount").val(newCount);

        var markup = "<tr id='rowImage-"+newCount+"'><td><input type='file' name='images[]' class='form-control' required></td>"+
        "<td><button type='button' class='btn btn-danger' onclick='removeImage("+newCount+")' >Hapus</button></td></tr>";
        $("#tableImage tbody").append(markup);
       
     }
      function addRow(){
        var count = $("#countvariant").val();
         var newCount = parseInt(count)+1;
        $("#countvariant").val(newCount);

        var markup = "<tr id='rowVariant-"+newCount+"'><td><input type='text' name='name_pilihan[]' class='form-control' required id='name_pilihan"+newCount+"'></td>"+
        "<td><input type='number' name='price_pilihan[]' class='form-control' required id='price_pilihan"+newCount+"'></td>"+
        "<td><input type='number' name='urutan[]' class='form-control' required id='urutan"+newCount+"'></td>"+
        "<td><button type='button' class='btn btn-danger' onclick='removeRow("+newCount+")' >Hapus</button></td></tr>";
        $("#tableVariant tbody").append(markup);
    }
    function removeRow(no){
        $("#rowVariant-"+no).remove();
    }
      function removeImage(no){
        $("#rowImage-"+no).remove();
    }
     function variantSelect(){
         var variant = $("#variant").val();
         if(variant!=0){
              $("#variantPage").show();
         }else{
              $("#variantPage").hide();
         }
     }
 </script>   
@endsection