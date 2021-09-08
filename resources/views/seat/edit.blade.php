@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('seat')}}">Data Table or Seat</a></li>
                        <li class="active">Edit Table or Seat</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('seat.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}   
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                    <div class="form-group @error('table_number') has-error @enderror">
                                        <label class="form-label">Table Number or Seat*</label>
									    <input type="text" class="form-control @error('table_number') has-error @enderror"
                                         placeholder="" name="table_number" required value="{{old('table_number') ? old('table_number') : $data->table_number}}">
                                         @error('table_number')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>  
                                    <div class="form-group @error('maximum') has-error @enderror">
                                        <label class="form-label">Maximum Table / Seat*</label>
									    <input type="number" class="form-control @error('maximum') has-error @enderror"
                                         placeholder="" name="maximum" required value="{{old('maximum') ? old('maximum') : $data->maximum}}">
                                         @error('maximum')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>  
                                      <div class="form-group @error('minimum_shopping') has-error @enderror">
                                        <label class="form-label">Minimum Shopping*</label>
									    <input type="number" class="form-control @error('minimum_shopping') has-error @enderror"
                                         placeholder="" name="minimum_shopping" required value="{{old('minimum_shopping') ? old('minimum_shopping') : $data->minimum_shopping}}">
                                         @error('minimum_shopping')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 
                                    <div class="form-group @error('description') has-error @enderror">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id="editor" class="description">{{old('description') ? old('description') : $data->description}}</textarea>
                                         @error('description')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>   
                                    <div class="form-group @error('file') has-error @enderror">
                                        <label class="form-label">Image</label>
									    <input type="file" class="form-control @error('file') has-error @enderror"
                                         placeholder="" name="file" value="{{old('file')}}">
                                         @error('file')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>  
                                      
                                   
								</div>
                                <button type="submit" class="btn btn-lg btn-info mg">UPDATE</button>
                            
							</div>
                              
						</div>
					</div>
                </form>
            </div>
        </div>
      
    </div>

</div>
@endsection
@section('script')
<script>
  CKEDITOR.replace('editor', {
        height  : '200px',
        filebrowserUploadUrl: "{{route('slider.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection