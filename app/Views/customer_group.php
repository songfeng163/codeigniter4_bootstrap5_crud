<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<?php echo view('include_css'); ?>
	</head>

	<body class="bg-white">

		<?php echo view('main_side_bar'); ?>

		<div id="layoutSidenav_content">
			<div class="container col-md-5 col-sm-5 col-lg-5 ">
				<div class="pt-5"> </div>
				<div class="pt-5 float-left">
					<h3>Customer Group</h3>
				</div>

				<div class="pt-5"> </div>
				<div class="float-right">
					<button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addModal"> Add New Group</button>
				</div>
				<div class="py-md-5"> </div>
				<table id="tblcustgroup" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Group</th>
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
							<label>Group Name</label>
							<input type="text" class="form-control" name="cg_name" id="cg_name" placeholder="Group Name">
						</div>
						<div class="form-group">
							<label>Note</label>
							<input type="text" class="form-control" name="cg_note" id="cg_note" placeholder="Note">
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
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <h4>Are you to delete?</h4>
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
	<input type="hidden" name="cg_id" id="cg_id">

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
			if($('#cg_id').val().length == 0) {
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
				url: '<?php echo site_url("customer_group/fetch_data"); ?>',
				dataType: 'json',
			});
			request.done(function(response) {
				if (response.length > 0) {
					for(var i in response) {
						dataTable.fnAddData([
							response[i].cg_id,
							response[i].cg_name,
							response[i].cg_note,
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response[i].cg_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].cg_id + '"><i class="fa fa-trash"></i>Delete</a>'
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

			jsonStr = {"cg_name":$('#cg_name').val(),
					   "cg_note":$('#cg_note').val()};

			var request = $.ajax({
				url: '<?php echo site_url("customer_group/save"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Saved Successfully");
					//Show new records in the data table
					dataTable.fnAddData([response.cg_id,
						$('#cg_name').val(),
						$('#cg_note').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.cg_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.cg_id + '"><i class="fa fa-trash"></i>Delete</a>'
					]);
					clear_field();
					$('#addModal').modal('hide');
					$('#msgModal').modal('show');
				} else {
					$('#msgAddValidation > p').html(response.valid);
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
			$('#cg_id').val(id);

			var jsonStr = [];
			jsonStr = {"cg_id": id};
			var request = $.ajax({
				url: '<?php echo site_url("customer_group/fetchById"); ?>',
				type: 'POST',
				dataType: 'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if (response.cg_id.length > 0) {
					$('#cg_id').val(response.cg_id);
					$('#cg_name').val(response.cg_name),
					$('#cg_note').val(response.cg_note),
					$('#addModal').modal('show');
				} else {

				}
			});
		});
		//-----------------------------------------------------------------
		$('#btnEdit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"cg_id":$('#cg_id').val(),
					   "cg_name":$('#cg_name').val(),
					   "cg_note":$('#cg_note').val()};
			var request = $.ajax({
				url: '<?php echo site_url("customer_group/edit"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Updated Successfully");
					//Show new records in the data table
					dataTable.fnUpdate([response.cg_id,
						$('#cg_name').val(),
						$('#cg_note').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.cg_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.cg_id + '"><i class="fa fa-trash"></i>Delete</a>'
					], update_position);
					clear_field();
					$('#addModal').modal('hide');
					$('#msgModal').modal('show');
				} else {
					$('#msgAddValidation > p').html(response.valid);
				}
			});
		});
		//----------------------------------------------------------------------
	    $('#show_data').on('click','.btn-delete',function(){
			// get data from button delete
			const id = $(this).data('id');
			// Set data to Form Edit
			$('#cg_id').val(id);
			// Call Modal Edit
			$('#deleteModal').modal('show');
		});

		//----------------------------------------------------------------------
		$('#btnDelete').button().click(function() {
			var jsonStr = [];
			jsonStr = {"cg_id":$('#cg_id').val()};
			var request = $.ajax({
				url: '<?php echo site_url("customer_group/delete"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				$('#deleteModal').modal('hide');
				if(response.valid == 'deleted'){
					$('[data-id="' + $('#cg_id').val() + '"]').parents('tr').fadeOut('slow', function() {
						cur_tr = this;
						dataTable.fnDeleteRow(cur_tr);
					});
					$('#cg_id').val('');
					$('#msgDialog > p').html('Successfully ' + response.valid);
					$('#msgModal').modal('show');
				} else {
					$('#cg_id').val('');
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
</body>
</html>
