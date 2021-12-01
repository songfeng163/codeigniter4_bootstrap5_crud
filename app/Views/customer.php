<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<?php echo view('include_css'); ?>
		<style type="text/css" media="all">
			#layoutSidenav_content {
				margin-left: 170px;
			}
		</style>
	</head>

	<body class="bg-white">

		<?php echo view('main_side_bar'); ?>

		<div id="layoutSidenav_content">
			<div class="container col-md-9 col-sm-9 col-lg-10">
				<div class="pt-5"> </div>
				<div class="pt-5 float-left">
					<h3>Customer List</h3>
				</div>

				<div class="pt-5"> </div>
				<div class="float-right">
					<button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addModal"> Add New Customer</button>
				</div>
				<div class="py-md-5"> </div>
				<table id="tbl_customer" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Mobile</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="show_data">

					</tbody>
				</table>
			</div> <!-- end container -->
		</div> <!-- Layout Side nav Content -->

	<!-- Modal for Message -->
	<div class="modal fade" id="msgModal" tabindex="1" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Message</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
				</div>
				<div class="modal-body">
					<div id="msgDialog"><p></p></div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal Message -->

	<!-- Modal Add Product -->
	<form action="" method="post">
		<div class="modal fade" id="addModal" tabindex="1" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add/Edit Customer</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
					</div>
					<div class="modal-body row g-3">
						<div class="col-md-6">
							<label>Name</label>
							<input type="text" class="form-control" name="cust_name" id="cust_name" placeholder="Customer Name">
						</div>
						<div class="col-md-6">
							<label>Father</label>
							<input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father Name">
						</div>
						<div class="col-md-6">
							<label>Mother</label>
							<input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother Name">
						</div>
						<div class="col-md-6">
							<label>NID No</label>
							<input type="text" class="form-control" name="nid_no" id="nid_no" placeholder="NID No">
						</div>
						<div class="col-md-6">
							<label>Address</label>
							<input type="text" class="form-control" name="present_address" id="present_address" placeholder="Present Address">
						</div>
						<div class="col-md-6">
							<label>Mobile</label>
							<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No">
						</div>
						<div class="col-md-6">
							<label>Email</label>
							<input type="text" class="form-control" name="email_add" id="email_add" placeholder="Email">
						</div>
						<div class="col-md-6">
							<label>Credit Limit</label>
							<input type="text" class="form-control" name="credit_limit" id="credit_limit" placeholder="Credit Limit">
						</div>
						<div class="col-md-6">
							<label>Group</label>
							<input type="text" id="cust_group_input">
						</div>
						<div class="col-md-6">
							<label>Note</label>
							<input type="text" class="form-control" name="cust_note" id="cust_note" placeholder="Note">
						</div>
					</div>
					<div class="modal-footer">
					<button type="button" name="Exit" id="exit" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i>Exit</button></td>
					<button type="button" name="btnSubmit" id="btnSubmit" class="btn btn-primary"><i class="fa fa-fw fa-plus-square"></i>Save</button></td>
					<button type="button" name="btn" id="btnEdit" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i>Update</button></td>

					<!-- To Show Validation Message to the User -->
					<div id="msgAddValidation"><p></p></div>
					<input type="hidden" id="cust_group_hidden"></div>
				</div>
			</div>
		</div>
		</div>
	</form>
	<!-- End for Modal Add Product-->

	<!-- Modal Delete Product-->
    <form action="" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <h4>Are you sure to delete?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button id="btnDelete" type="button" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
    </form>
    <!-- End Modal Delete Product-->

	<!-- Field to detect Save/Update State of Add Modal Form  -->
	<!-- Field to Submit ID for Save/Edit/Delete of the Form -->
	<input type="hidden" name="customer_id" id="customer_id">

	<!-- Include Additional JS Files-->
	<?php echo view('include_js') ?>

	<script>

	$(document).ready(function() {

		var dataTable;

		display_data();

		//----------------------------------------------------------------------
		function clear_field() {
			$(':text').val('');
			$('input[type="hidden"]').val('');
			$('#msgAddValidation > p').html('');
		}
		//----------------------------------------------------------------------
		$("#addModal").on("hidden.bs.modal", function(){
			clear_field();
		});
		//----------------------------------------------------------------------
		$('#addModal').on('shown.bs.modal', function (e) {
			if($('#customer_id').val().length == 0) {
				clear_field();
				$('#btnEdit').hide();
				$('#btnSubmit').show();
			} else {
				$('#btnEdit').show();
				$('#btnSubmit').hide();
			}
		});
		//----------------------------------------------------------------------
		$('#cust_group_input').autocomplete({
			serviceUrl: '<?php echo site_url("customer/get_customer_group"); ?>',
			onSelect:function (suggestion) {
				// alert('You selected: ' + suggestion.value +', ' + suggestion.data);
				$('#cust_group_hidden').val(suggestion.data);
			}
		});
		//----------------------------------------------------------------------
		function fetch_data() {
			$.ajax({
				url: '<?php echo site_url("customer/fetch_data"); ?>',
				dataType: 'json',
				success: function(response) {
					if (response.length > 0) {
						for(var i in response) {
							dataTable.fnAddData([
								response[i].id,
								response[i].customer_name,
								response[i].present_address,
								response[i].mobile,
								response[i].note,
								'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response[i].id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].id + '"><i class="fa fa-trash"></i>Delete</a>'
							], false);
						}
						dataTable.fnDraw(true);
					} else {

					}
				}
			});
		}
		//----------------------------------------------------------------------
		function display_data() {
			if(typeof dataTable == 'undefined') {
				dataTable = $('#tbl_customer').dataTable({
					"bJQueryUI": false,
					"bLengthChange": true,
					"bAutoWidth": false,
					"aoColumns":[
						{sClass:"left", "sWidth":"100px"},
						{sClass:"left", "sWidth":"200px"},
						{sClass:"left", "sWidth":"200px"},
						{sClass:"left"},
						{sClass:"left"},
						{sClass:"center"}]
				});
			}
			fetch_data();
		}
		//-----------------------------------------------------------------
		$('#btnSubmit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"cust_name":$('#cust_name').val(),
					   "father_name":$('#father_name').val(),
					   "mother_name":$('#mother_name').val(),
					   "nid_no":$('#nid_no').val(),
					   "present_address":$('#present_address').val(),
					   "mobile_no":$('#mobile_no').val(),
					   "email_add":$('#email_add').val(),
					   "credit_limit":$('#credit_limit').val(),
					   "cust_group_id":$('#cust_group_hidden').val(),
					   "cust_note":$('#cust_note').val()};
			$.ajax({
				url: '<?php echo site_url("customer/save"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},

				success: function(response) {
					if(response.valid == "Success") {
						$('#msgDialog > p').html("Data Saved Successfully");
						//Show new records in the data table
						dataTable.fnAddData([response.customer_id,
							$('#cust_name').val(),
							$('#present_address').val(),
							$('#mobile_no').val(),
							$('#cust_note').val(),
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.customer_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.customer_id + '"><i class="fa fa-trash"></i>Delete</a>'
						]);
						clear_field();
						$('#addModal').modal('hide');
						$('#msgModal').modal('show');
					} else {
						$('#msgAddValidation > p').html(response.valid);
					}
				}
			});
		});
		//----------------------------------------------------------------------
	    $('#show_data').on('click','.btn-edit',function() {
			// get data from button edit

			//To Update the Table Row by Jquery after Edit/Update
			update_position = dataTable.fnGetPosition($(this).parents('tr')[0]);

			// Set data to Form Edit
			const id = $(this).data('id');
			$('#customer_id').val(id);

			var jsonStr = [];
			jsonStr = {"customer_id": id};
			$.ajax({
				url: '<?php echo site_url("customer/fetchById"); ?>',
				type: 'POST',
				dataType: 'json',
				data: {'jsarray': $.toJSON(jsonStr)},
				success: function(response) {
					if (response.id.length > 0) {
						$('#customer_id').val(response.id);
						$('#cust_name').val(response.customer_name),
						$('#father_name').val(response.father_name),
						$('#mother_name').val(response.mother_name),
						$('#nid_no').val(response.national_id_card_no),
						$('#present_address').val(response.present_address),
						$('#mobile_no').val(response.mobile),
						$('#email_add').val(response.email_address),
						$('#credit_limit').val(response.credit_limit),
						$('#cust_group_input').val(response.group_id + '-' + response.group_name),
						$('#cust_group_hidden').val(response.group_id),
						$('#cust_note').val(response.note),
						$('#addModal').modal('show');
					} else {

					}
				}
			});
		});
		//-----------------------------------------------------------------
		$('#btnEdit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"customer_id":$('#customer_id').val(),
					   "cust_name":$('#cust_name').val(),
					   "father_name":$('#father_name').val(),
					   "mother_name":$('#mother_name').val(),
					   "nid_no":$('#nid_no').val(),
					   "present_address":$('#present_address').val(),
					   "mobile_no":$('#mobile_no').val(),
					   "email_add":$('#email_add').val(),
					   "credit_limit":$('#credit_limit').val(),
					   "cust_group_id":$('#cust_group_hidden').val(),
					   "cust_note":$('#cust_note').val()};
			$.ajax({
				url: '<?php echo site_url("customer/edit"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},

				success: function(response) {
					if(response.valid == "Success") {
						$('#msgDialog > p').html("Data Updated Successfully");
						//Show new records in the data table
						dataTable.fnUpdate([response.customer_id,
							$('#cust_name').val(),
							$('#present_address').val(),
							$('#mobile_no').val(),
							$('#cust_note').val(),
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.customer_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.customer_id + '"><i class="fa fa-trash"></i>Delete</a>'
						], update_position);
						clear_field();
						$('#addModal').modal('hide');
						$('#msgModal').modal('show');
					} else {
						$('#msgAddValidation > p').html(response.valid);
					}
				}
			});
		});
		//----------------------------------------------------------------------
	    $('#show_data').on('click','.btn-delete',function() {
			// get data from button delete
			const id = $(this).data('id');
			// Set data to Form Edit
			$('#customer_id').val(id);
			// Call Modal Edit
			$('#deleteModal').modal('show');
		});

		//----------------------------------------------------------------------
		$('#btnDelete').button().click(function() {
			var jsonStr = [];
			jsonStr = {"customer_id":$('#customer_id').val()};
			$.ajax({
				url: '<?php echo site_url("customer/delete"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
				success: function(response) {
					$('#deleteModal').modal('hide');
					if(response.valid == 'deleted'){
						$('[data-id="' + $('#customer_id').val() + '"]').parents('tr').fadeOut('slow', function() {
							cur_tr = this;
							dataTable.fnDeleteRow(cur_tr);
						});
						$('#customer_id').val('');
						$('#msgDialog > p').html('Successfully ' + response.valid);
						$('#msgModal').modal('show');
					} else {
						$('#customer_id').val('');
						$('#msgDialog > p').html(response.valid + ' to delete');
						$('#deleteModal').modal('hide');
						$('#msgModal').modal('show');
					}
				}
			});
		});
		//----------------------------------------------------------------------
	});
	</script>
</body>
</html>
