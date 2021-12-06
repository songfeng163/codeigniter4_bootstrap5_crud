<div class="offset-lg-1" id="layoutSidenav_content">
	<div class="container col-md-12 col-sm-12 col-lg-9 ">
		<div class="pt-5"> </div>
		<div class="pt-5 float-left">
			<h3>Vendor List</h3>
		</div>

		<div class="pt-5"> </div>
		<div class="float-right">
			<button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addModal"> Add New Group</button>
		</div>
		<div class="py-md-5"> </div>
		<table id="tblvendor" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Organization</th>
					<th>Address</th>
					<th>Mobile</th>
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
					<h5 class="modal-title">Add/Edit Vendor</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="ven_name" id="ven_name" placeholder="Vendor Name">
					</div>
					<div class="form-group">
						<label>Organization</label>
						<input type="text" class="form-control" name="ven_org" id="ven_org" placeholder="Organization">
					</div>
					<div class="form-group">
						<label>Address</label>
						<input type="text" class="form-control" name="ven_addr" id="ven_addr" placeholder="Address">
					</div>
					<div class="form-group">
						<label>Mobile</label>
						<input type="text" class="form-control" name="ven_mobile" id="ven_mobile" placeholder="Mobile">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="ven_email" id="ven_email" placeholder="Email">
					</div>
					<div class="form-group">
						<label>Note</label>
						<input type="text" class="form-control" name="ven_note" id="ven_note" placeholder="Note">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="Exit" id="exit" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i>Exit</button></td>
				<button type="button" name="btnSubmit" id="btnSubmit" class="btn btn-primary"><i class="fa fa-fw fa-plus-square"></i>Save</button></td>
			<button type="button" name="btn" id="btnEdit" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i>Update</button></td>

		<!-- To Show Validation Message to the User -->
		<div id="msgAddValidation"><p></p></div>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- End for Modal Add Product-->

<!-- Modal Delete Product-->
<form action="" method="post">
	<div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header bg-warning">
					<h5 class="modal-title" id="deleteModalLabel">Warning</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					<p>Are you to sure delete?</p>
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
<input type="hidden" name="ven_id" id="ven_id">

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
			if($('#ven_id').val().length == 0) {
				clear_field();
				$('#btnEdit').hide();
				$('#btnSubmit').show();
			} else {
				$('#btnEdit').show();
				$('#btnSubmit').hide();
			}
		});
		//----------------------------------------------------------------------
		function fetch_data() {
			var request = $.ajax({
				url: '<?php echo site_url("vendor/fetch_data"); ?>',
				dataType: 'json',
			});
			request.done(function(response) {
				if (response.length > 0) {
					for(var i in response) {
						dataTable.fnAddData([
							response[i].ven_id,
							response[i].ven_name,
							response[i].ven_org,
							response[i].ven_addr,
							response[i].ven_mobile,
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response[i].ven_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].ven_id + '"><i class="fa fa-trash"></i>Delete</a>'
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
				dataTable = $('#tblvendor').dataTable({
					"bJQueryUI": false,
					"bLengthChange": true,
					"bAutoWidth": false,
					"aoColumns":[
						{sClass:"left", "sWidth":"80px"},
						{sClass:"left", "sWidth":"200px"},
						{sClass:"left"},
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

			jsonStr = {"ven_name":$('#ven_name').val(),
					   "ven_org":$('#ven_org').val(),
					   "ven_addr":$('#ven_addr').val(),
					   "ven_mobile":$('#ven_mobile').val(),
					   "ven_email":$('#ven_email').val(),
					   "ven_note":$('#ven_note').val()};

			var request = $.ajax({
				url: '<?php echo site_url("vendor/save"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Saved Successfully");
					//Show new records in the data table
					dataTable.fnAddData([response.ven_id,
						$('#ven_name').val(),
						$('#ven_org').val(),
						$('#ven_addr').val(),
						$('#ven_mobile').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.ven_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.ven_id + '"><i class="fa fa-trash"></i>Delete</a>'
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
			$('#ven_id').val(id);

			var jsonStr = [];
			jsonStr = {"ven_id": id};
			var request = $.ajax({
				url: '<?php echo site_url("vendor/fetchById"); ?>',
				type: 'POST',
				dataType: 'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if (response.ven_id.length > 0) {
					$('#ven_id').val(response.ven_id);
					$('#ven_name').val(response.ven_name),
					$('#ven_org').val(response.ven_org),
					$('#ven_addr').val(response.ven_addr),
					$('#ven_mobile').val(response.ven_mobile),
					$('#ven_email').val(response.ven_email),
					$('#ven_note').val(response.ven_note),
					$('#addModal').modal('show');
				} else {

				}
			});
		});
		//-----------------------------------------------------------------
		$('#btnEdit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"ven_id":$('#ven_id').val(),
					   "ven_name":$('#ven_name').val(),
					   "ven_org":$('#ven_org').val(),
					   "ven_addr":$('#ven_addr').val(),
					   "ven_mobile":$('#ven_mobile').val(),
					   "ven_email":$('#ven_email').val(),
					   "ven_note":$('#ven_note').val()};

			var request = $.ajax({
				url: '<?php echo site_url("vendor/edit"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Updated Successfully");
					//Show new records in the data table
					dataTable.fnUpdate([response.ven_id,
						$('#ven_name').val(),
						$('#ven_org').val(),
						$('#ven_addr').val(),
						$('#ven_mobile').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.ven_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.ven_id + '"><i class="fa fa-trash"></i>Delete</a>'
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
	    $('#show_data').on('click','.btn-delete',function(){
			// get data from button delete
			const id = $(this).data('id');
			// Set data to Form Edit
			$('#ven_id').val(id);
			// Call Modal Edit
			$('#deleteModal').modal('show');
		});

		//----------------------------------------------------------------------
		$('#btnDelete').button().click(function() {
			var jsonStr = [];
			jsonStr = {"ven_id":$('#ven_id').val()};
			var request = $.ajax({
				url: '<?php echo site_url("vendor/delete"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				$('#deleteModal').modal('hide');
				if(response.valid == 'deleted'){
					$('[data-id="' + $('#ven_id').val() + '"]').parents('tr').fadeOut('slow', function() {
						cur_tr = this;
						dataTable.fnDeleteRow(cur_tr);
					});
					$('#ven_id').val('');
					$('#msgDialog > p').html('Successfully ' + response.valid);
					$('#msgModal').modal('show');
				} else {
					$('#ven_id').val('');
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
