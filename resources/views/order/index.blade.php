@extends('app.app')
@section('content')
     <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>List Ordering</h1>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Ordering</a></li>
                                    <li class="active">List</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                                <div class="order-list-item">
                                    <table class="table" id="listOrder">
                                        <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Menu Product</th>
                                            <th>Grand Total</th>
                                            <th>Service</th>
                                            <th>Status</th>
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
        	//DATABASE REALTIME
			// Get Data Order store
            var storeId = <?php echo Auth()->user()->store_id ?> ;
			firebase.database().ref('orders/store-'+storeId).on('value', function(snapshot) {
                var value = snapshot.val();
                var htmls = [];
                $.each(value, function(index, value){
                if(value) {
                    var status = value.status;
                    if (status=="Wait Payment") {
                        status = '<span  class="btn btn-rounded btn-warning">Wait Payment</span>';
                    }else if (status=="Prepare Order") {
                        status = '<span  class="btn btn-rounded btn-info">Prepare Order	</span>';
                    }else{
                        status = '<span  class="btn btn-rounded btn-default">'+value.status+'</span>';
                    }
                htmls.push('<tr>\
                <td>'+ value.customer_name +'</td>\
                <td>'+ value.number +'</td>\
                <td>'+ value.date +'</td>\
                <td>'+ value.menu_name +'</td>\
                <td align="right"><strong>Rp. '+ value.grand_total +'</strong></td>\
                <td>'+ value.service +'</td>\
                <td>'+ status +'</td>\
                <td>\
                    <a data-toggle="modal" data-target="#view-modal" class="btn btn-info viewData" data-id="'+index+'"><i class="glyphicon glyphicon-eye-open"></i> View</a>\
                    <a data-toggle="modal" data-target="#update-modal" class="btn btn-primary updateData" data-id="'+index+'"><i class="glyphicon glyphicon-edit"></i> Update</a>\
                </td>\
                </tr>');
                }    	
                lastIndex = index;
                });
                $('#tbody').html(htmls);
                $("#submitUser").removeClass('desabled');
			});
			
			
			// Add Data
			$('#submitUser').on('click', function(){
                var values = $("#addUser").serializeArray();
                var first_name = values[0].value;
                var last_name = values[1].value;
                var userID = lastIndex+1;
                
                firebase.database().ref('users/' + userID).set({
                first_name: first_name,
                last_name: last_name,
                });
                
                // Reassign lastID value
                lastIndex = userID;
                $("#addUser input").val("");
			});
			
			// Update Data
			var updateID = 0;
			$('body').on('click', '.updateData', function() {
                updateID = $(this).attr('data-id');
                firebase.database().ref('users/' + updateID).on('value', function(snapshot) {
                    var values = snapshot.val();
                    var updateData = '<div class="form-group">\
                    <label for="first_name" class="col-md-12 col-form-label">First Name</label>\
                    <div class="col-md-12">\
                    <input id="first_name" type="text" class="form-control" name="first_name" value="'+values.first_name+'" required autofocus>\
                    </div>\
                    </div>\
                    <div class="form-group">\
                    <label for="last_name" class="col-md-12 col-form-label">Last Name</label>\
                    <div class="col-md-12">\
                    <input id="last_name" type="text" class="form-control" name="last_name" value="'+values.last_name+'" required autofocus>\
                    </div>\
                    </div>';
                    
                    $('#updateBody').html(updateData);
                });
			});
			
			$('.updateUserRecord').on('click', function() {
                var values = $(".users-update-record-model").serializeArray();
                var postData = {
                    first_name : values[0].value,
                    last_name : values[1].value,
                };
                
                var updates = {};
                updates['/users/' + updateID] = postData;
                
                firebase.database().ref().update(updates);
                
                $("#update-modal").modal('hide');
			});
			
			
			// Remove Data
			$("body").on('click', '.removeData', function() {
                var id = $(this).attr('data-id');
                $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
            });
                
            $('.deleteMatchRecord').on('click', function(){
                var values = $(".users-remove-record-model").serializeArray();
                var id = values[0].value;
                firebase.database().ref('users/' + id).remove();
                $('body').find('.users-remove-record-model').find( "input" ).remove();
                $("#remove-modal").modal('hide');
            });
            $('.remove-data-from-delete-form').click(function() {
                $('body').find('.users-remove-record-model').find( "input" ).remove();
			});
		//
    </script>
@endsection
