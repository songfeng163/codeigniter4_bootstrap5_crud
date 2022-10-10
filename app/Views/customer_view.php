<div class="offset-lg-1" id="layoutSidenav_content">
	<div class="container col-md-12 col-sm-12 col-lg-9">
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
					<th>ID1</th>
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
						<input type="text" class="form-control" name="cust_father_name" id="cust_father_name" placeholder="Father Name">
					</div>
					<div class="col-md-6">
						<label>Mother</label>
						<input type="text" class="form-control" name="cust_mother_name" id="cust_mother_name" placeholder="Mother Name">
					</div>
					<div class="col-md-6">
						<label>NID No</label>
						<input type="text" class="form-control" name="cust_nid_no" id="cust_nid_no" placeholder="NID No">
					</div>
					<div class="col-md-6">
						<label>Address</label>
						<input type="text" class="form-control" name="cust_pr_address" id="cust_pr_address" placeholder="Present Address">
					</div>
					<div class="col-md-6">
						<label>Mobile</label>
						<input type="text" class="form-control" name="cust_mobile" id="cust_mobile" placeholder="Mobile No">
					</div>
					<div class="col-md-6">
						<label>Email</label>
						<input type="text" class="form-control" name="cust_email" id="cust_email" placeholder="Email">
					</div>
					<div class="col-md-6">
						<label>Credit Limit</label>
						<input type="text" class="form-control" name="cust_credit_limit" id="cust_credit_limit" placeholder="Credit Limit">
					</div>
					<div class="col-md-6">
						<label>Group</label>
						<input type="text" id="cust_group_id_input">
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
		<input type="hidden" id="cust_group_id_hidden"></div>
			</div>
		</div>
	</div>
	</div>
</form>
<!-- End for Modal Add Product-->

<!-- Modal Delete Product-->
<form action="" method="post">
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header bg-warning">
					<h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
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
<input type="hidden" name="cust_id" id="cust_id">

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
			if($('#cust_id').val().length == 0) {
				clear_field();
				$('#btnEdit').hide();
				$('#btnSubmit').show();
			} else {
				$('#btnEdit').show();
				$('#btnSubmit').hide();
			}
		});
		//----------------------------------------------------------------------
		$('#cust_group_id_input').autocomplete({
			serviceUrl: '<?php echo site_url("customer/get_customer_group"); ?>',
			onSelect:function (suggestion) {
				// alert('You selected: ' + suggestion.value +', ' + suggestion.data);
				$('#cust_group_id_hidden').val(suggestion.data);
			}
		});
		//----------------------------------------------------------------------
		function fetch_data() {
			var request = $.ajax({
				url: '<?php echo site_url("customer/fetch_data"); ?>',
				dataType: 'json',
			});

			request.done(function(response) {
				if (response.length > 0) {
					for(var i in response) {
						dataTable.fnAddData([
							response[i].cust_id,
							response[i].cust_name,
							response[i].cust_pr_address,
							response[i].cust_mobile,
							response[i].cust_note,
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response[i].cust_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].cust_id + '"><i class="fa fa-trash"></i>Delete</a>'
						], false);
					}
					dataTable.fnDraw(true);
				} else {

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
				"cust_father_name":$('#cust_father_name').val(),
				"cust_mother_name":$('#cust_mother_name').val(),
				"cust_nid_no":$('#cust_nid_no').val(),
				"cust_pr_address":$('#cust_pr_address').val(),
				"cust_mobile":$('#cust_mobile').val(),
				"cust_email":$('#cust_email').val(),
				"cust_credit_limit":$('#cust_credit_limit').val(),
				"cust_group_id":$('#cust_group_id_hidden').val(),
				"cust_note":$('#cust_note').val()};

			var request = $.ajax({
				url: '<?php echo site_url("customer/save"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Saved Successfully");
					//Show new records in the data table
					dataTable.fnAddData([response.cust_id,
						$('#cust_name').val(),
						$('#cust_pr_address').val(),
						$('#cust_mobile').val(),
						$('#cust_note').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.cust_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.cust_id + '"><i class="fa fa-trash"></i>Delete</a>'
					]);
					clear_field();
					$('#addModal').modal('hide');
					$('#msgModal').modal('show');
				} else {
					var txt_error = "";
					if (Object.keys(response.valid).length > 0) {
						var arr_msg = Object.values(response.valid);
						for(var i in arr_msg) {
							txt_error = txt_error + arr_msg[i];
						}
					}
					$('#msgAddValidation > p').html(txt_error);
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
			$('#cust_id').val(id);

			var jsonStr = [];
			jsonStr = {"cust_id": id};
			var request = $.ajax({
				url: '<?php echo site_url("customer/fetchById"); ?>',
				type: 'POST',
				dataType: 'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});
			request.done(function(response) {
				if (response.cust_id.length > 0) {
					$('#cust_id').val(response.cust_id);
					$('#cust_name').val(response.cust_name),
						$('#cust_father_name').val(response.cust_father_name),
						$('#cust_mother_name').val(response.cust_mother_name),
						$('#cust_nid_no').val(response.cust_nid_no),
						$('#cust_pr_address').val(response.cust_pr_address),
						$('#cust_mobile').val(response.cust_mobile),
						$('#cust_email').val(response.cust_email),
						$('#cust_credit_limit').val(response.cust_credit_limit),
						$('#cust_group_id_input').val(response.cg_name),
						$('#cust_group_id_hidden').val(response.cust_group_id),
						$('#cust_note').val(response.cust_note),
						$('#addModal').modal('show');
				} else {

				}
			});
		});
		//-----------------------------------------------------------------
		$('#btnEdit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"cust_id":$('#cust_id').val(),
				"cust_name":$('#cust_name').val(),
				"cust_father_name":$('#cust_father_name').val(),
				"cust_mother_name":$('#cust_mother_name').val(),
				"cust_nid_no":$('#cust_nid_no').val(),
				"cust_pr_address":$('#cust_pr_address').val(),
				"cust_mobile":$('#cust_mobile').val(),
				"cust_email":$('#cust_email').val(),
				"cust_credit_limit":$('#cust_credit_limit').val(),
				"cust_group_id":$('#cust_group_id_hidden').val(),
				"cust_note":$('#cust_note').val()};
			var request = $.ajax({
				url: '<?php echo site_url("customer/edit"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Updated Successfully");
					//Show new records in the data table
					dataTable.fnUpdate([response.cust_id,
						$('#cust_name').val(),
						$('#cust_pr_address').val(),
						$('#cust_mobile').val(),
						$('#cust_note').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.cust_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.cust_id + '"><i class="fa fa-trash"></i>Delete</a>'
					], update_position);
					clear_field();
					$('#addModal').modal('hide');
					$('#msgModal').modal('show');
				} else {
					var txt_error = "";
					if (Object.keys(response.valid).length > 0) {
						var arr_msg = Object.values(response.valid);
						for(var i in arr_msg) {
							txt_error = txt_error + arr_msg[i];
						}
					}
					$('#msgAddValidation > p').html(txt_error);
				}
			});
		});
		//----------------------------------------------------------------------
	    $('#show_data').on('click','.btn-delete',function() {
			// get data from button delete
			const id = $(this).data('id');
			// Set data to Form Edit
			$('#cust_id').val(id);
			// Call Modal Edit
			$('#deleteModal').modal('show');
		});

		//----------------------------------------------------------------------
		$('#btnDelete').button().click(function() {
			var jsonStr = [];
			jsonStr = {"cust_id":$('#cust_id').val()};
			var request = $.ajax({
				url: '<?php echo site_url("customer/delete"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});
			request.done(function(response) {
				$('#deleteModal').modal('hide');
				if(response.valid == 'deleted'){
					$('[data-id="' + $('#cust_id').val() + '"]').parents('tr').fadeOut('slow', function() {
						cur_tr = this;
						dataTable.fnDeleteRow(cur_tr);
					});
					$('#cust_id').val('');
					$('#msgDialog > p').html('Successfully ' + response.valid);
					$('#msgModal').modal('show');
				} else {
					$('#cust_id').val('');
					$('#msgDialog > p').html(response.valid + ' to delete');
					$('#deleteModal').modal('hide');
					$('#msgModal').modal('show');
				}
			});

			request.fail(function(response) {
				$('#msgDialog > p').html('Cannot be deleted');
				$('#deleteModal').modal('hide');
				$('#msgModal').modal('show');
			});
		});
		//----------------------------------------------------------------------
	});
</script>
