<div id="layoutSidenav_content">
	<div class="container col-md-12 col-sm-12 col-lg-5 ">
		<div class="pt-5"> </div>
		<div class="pt-5 float-left">
			<h3>Product Unit</h3>
		</div>

		<div class="pt-5"> </div>
		<div class="float-right">
			<button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addModal"> Add New Unit</button>
		</div>
		<div class="py-md-5"> </div>
		<table id="tblcustgroup" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Unit</th>
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
					<h5 class="modal-title">Add/Edit Group</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Unit Name</label>
						<input type="text" class="form-control" name="unit_name" id="unit_name" placeholder="Unit Name">
					</div>
					<div class="form-group">
						<label>Note</label>
						<input type="text" class="form-control" name="unit_note" id="unit_note" placeholder="Note">
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
<input type="hidden" name="unit_id" id="unit_id">

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
			if($('#unit_id').val().length == 0) {
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
				url: '<?php echo site_url("product_unit/fetch_data"); ?>',
				dataType: 'json',
			});
			request.done(function(response) {
				if (response.length > 0) {
					for(var i in response) {
						dataTable.fnAddData([
							response[i].unit_id,
							response[i].unit_name,
							response[i].unit_note,
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response[i].unit_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].unit_id + '"><i class="fa fa-trash"></i>Delete</a>'
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
				dataTable = $('#tblcustgroup').dataTable({
					"bJQueryUI": false,
					"bLengthChange": true,
					"bAutoWidth": false,
					"aoColumns":[
						{sClass:"left", "sWidth":"100px"},
						{sClass:"left", "sWidth":"200px"},
						{sClass:"left"},
						{sClass:"center"}]
				});
			}
			fetch_data();
		}
		//-----------------------------------------------------------------
		$('#btnSubmit').button().click(function() {
			var jsonStr = [];

			jsonStr = {"unit_name":$('#unit_name').val(),
					   "unit_note":$('#unit_note').val()};

			var request = $.ajax({
				url: '<?php echo site_url("product_unit/save"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Saved Successfully");
					//Show new records in the data table
					dataTable.fnAddData([response.unit_id,
						$('#unit_name').val(),
						$('#unit_note').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.unit_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.unit_id + '"><i class="fa fa-trash"></i>Delete</a>'
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
			$('#unit_id').val(id);

			var jsonStr = [];
			jsonStr = {"unit_id": id};
			var request = $.ajax({
				url: '<?php echo site_url("product_unit/fetchById"); ?>',
				type: 'POST',
				dataType: 'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if (response.unit_id.length > 0) {
					$('#unit_id').val(response.unit_id);
					$('#unit_name').val(response.unit_name),
					$('#unit_note').val(response.unit_note),
					$('#addModal').modal('show');
				} else {

				}
			});
		});
		//-----------------------------------------------------------------
		$('#btnEdit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"unit_id":$('#unit_id').val(),
					   "unit_name":$('#unit_name').val(),
					   "unit_note":$('#unit_note').val()};
			var request = $.ajax({
				url: '<?php echo site_url("product_unit/edit"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Updated Successfully");
					//Show new records in the data table
					dataTable.fnUpdate([response.unit_id,
						$('#unit_name').val(),
						$('#unit_note').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.unit_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.unit_id + '"><i class="fa fa-trash"></i>Delete</a>'
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
			$('#unit_id').val(id);
			// Call Modal Edit
			$('#deleteModal').modal('show');
		});

		//----------------------------------------------------------------------
		$('#btnDelete').button().click(function() {
			var jsonStr = [];
			jsonStr = {"unit_id":$('#unit_id').val()};
			var request = $.ajax({
				url: '<?php echo site_url("product_unit/delete"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				$('#deleteModal').modal('hide');
				if(response.valid == 'deleted'){
					$('[data-id="' + $('#unit_id').val() + '"]').parents('tr').fadeOut('slow', function() {
						cur_tr = this;
						dataTable.fnDeleteRow(cur_tr);
					});
					$('#unit_id').val('');
					$('#msgDialog > p').html('Successfully ' + response.valid);
					$('#msgModal').modal('show');
				} else {
					$('#unit_id').val('');
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
