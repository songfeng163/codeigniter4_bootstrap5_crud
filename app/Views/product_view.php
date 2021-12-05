<div id="layoutSidenav_content">
	<div class="container col-md-12 col-sm-12 col-lg-12 offset-lg-2 ">
		<div class="pt-5"> </div>
		<div class="pt-5 float-left">
			<h3>Product Lists</h3>
		</div>
		<div class="pt-5"> </div>
		<div class="float-right">
			<button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addModal"> Add New Product Record </button>
		</div>
		<div class="py-md-5"> </div>
		<table id="tblproduct" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Product Name</th>
					<th>Price</th>
					<th>Category</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="show_data">

			</tbody>
		</table>
	</div> <!-- end container -->
</div> <!-- Layout Side nav Content -->

<!-- Modal for Message -->
<div class="modal fade" id="msgModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Warning!</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
			</div>
			<div class="modal-body">
				<div id="msgDialog"><p></p></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add Product -->
<form action="" method="post">
	<div class="modal fade" id="addModal" tabindex="1" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add/Edit Product</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Product Name</label>
						<input type="text" class="form-control" name="prod_name" id="prod_name" placeholder="Product Name">
					</div>
					<div class="form-group">
						<label>Price</label>
						<input type="text" class="form-control" name="prod_price" id="prod_price" placeholder="Product Price">
					</div>
					<div class="form-group">
						<label>Category</label>
						<input type="text" id="prod_pc_id_input">
					</div>
					<div class="form-group">
						<label>Note</label>
						<input type="text" class="form-control" name="prod_note" id="prod_note" placeholder="Note">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="Exit" id="exit" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i>Exit</button></td>
					<button type="button" name="btnSubmit" id="btnSubmit" class="btn btn-primary"><i class="fa fa-fw fa-plus-square"></i>Save</button></td>
					<button type="button" name="btn" id="btnEdit" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i>Update</button></td>
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
					<h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Are you sure want to delete this product?</h4>
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
<input type="hidden" name="prod_id" id="prod_id">
<input type="hidden" id="prod_pc_id_hidden"></div>

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
			if($('#prod_id').val().length == 0) {
				clear_field();
				$('#btnEdit').hide();
				$('#btnSubmit').show();
			} else {
				$('#btnEdit').show();
				$('#btnSubmit').hide();
			}
		});
		//----------------------------------------------------------------------
		function display_data() {
			if(typeof dataTable == 'undefined') {
				dataTable = $('#tblproduct').dataTable({
					"bJQueryUI": false,
					"bLengthChange": true,
					"bAutoWidth": false,
					"aoColumns":[
						{sClass:"left"},
						{sClass:"left", "sWidth":"370px"},
						{sClass:"right"},
						{sClass:"right"},
						{sClass:"center"}]
				});
			}
			fetch_data();
		}
		//----------------------------------------------------------------------
		function fetch_data() {
			var request = $.ajax({
				url: '<?php echo site_url("product/fetch_data"); ?>',
				dataType: 'json',
			});
			request.done(function(response) {
				if (response.length > 0) {
					for(var i in response) {
						dataTable.fnAddData([
							response[i].prod_id,
							response[i].prod_name,
							response[i].prod_price,
							response[i].pc_name,
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response[i].prod_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].prod_id + '"><i class="fa fa-trash"></i>Delete</a>'
						], false);
					}
					dataTable.fnDraw(true);
				} else {

				}
			});
		}
		//----------------------------------------------------------------------
		$('#prod_pc_id_input').autocomplete({
			serviceUrl: '<?php echo site_url("product/get_category"); ?>',
			onSelect:function (suggestion) {
				// alert('You selected: ' + suggestion.value +', ' + suggestion.data);
				$('#prod_pc_id_hidden').val(suggestion.data);
			}
		});
		//-----------------------------------------------------------------
		$('#btnSubmit').button().click(function() {
			var jsonStr = [];

			jsonStr = {"prod_name":$('#prod_name').val(),
				"prod_price":$('#prod_price').val(),
				"prod_pc_id":$('#prod_pc_id_hidden').val(),
				"prod_note":$('#prod_note').val()};

			var request = $.ajax({
				url: '<?php echo site_url("product/save"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Saved Successfully");
					//Show new records in the data table
					dataTable.fnAddData([response.prod_id,
						$('#prod_name').val(),
						$('#prod_price').val(),
						$('#prod_pc_id_input').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.prod_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.prod_id + '"><i class="fa fa-trash"></i>Delete</a>'
					]);
					clear_field();
					$('#msgModal').modal('show');
					$('#addModal').modal('hide');
				} else {
					$('#msgAddValidation > p').html(response.valid);
				}
			});
		});

		//----------------------------------------------------------------------
	    $('#show_data').on('click','.btn-edit',function() {
			// get data from button edit
			const id = $(this).data('id');
			update_position = dataTable.fnGetPosition($(this).parents('tr')[0]);
			// Set data to Form Edit
			$('#prod_id').val(id);

			var jsonStr = [];
			jsonStr = {"prod_id": id};

			var request = $.ajax({
				url: '<?php echo site_url("product/fetchById"); ?>',
				type: 'POST',
				dataType: 'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if (response.prod_id.length > 0) {
					$('#prod_id').val(response.prod_id);
					$('#prod_name').val(response.prod_name),
					$('#prod_price').val(response.prod_price),
					$('#prod_pc_id_input').val(response.pc_name),
					$('#prod_pc_id_hidden').val(response.prod_pc_id),
					$('#prod_note').val(response.prod_note),
					$('#addModal').modal('show');
				} else {

				}
			});
		});
		//-----------------------------------------------------------------
		$('#btnEdit').button().click(function() {
			var jsonStr = [];

			jsonStr = {"prod_id":$('#prod_id').val(),
				"prod_name":$('#prod_name').val(),
				"prod_price":$('#prod_price').val(),
				"prod_pc_id":$('#prod_pc_id_hidden').val(),
				"prod_note":$('#prod_note').val()};

			var request = $.ajax({
				url: '<?php echo site_url("product/edit"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});

			request.done(function(response) {
				if(response.valid == "Success") {
					$('#msgDialog > p').html("Data Updated Successfully");
					//Show new records in the data table
					dataTable.fnUpdate([response.prod_id,
						$('#prod_name').val(),
						$('#prod_price').val(),
						$('#prod_pc_id_input').val(),
						'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.prod_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response.prod_id + '"><i class="fa fa-trash"></i>Delete</a>'
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
			// get data from button edit
			const id = $(this).data('id');
			// Set data to Form Edit
			$('#prod_id').val(id);
			// Call Modal Edit
			$('#deleteModal').modal('show');
		});

		//----------------------------------------------------------------------
		$('#btnDelete').button().click(function() {
			var jsonStr = [];
			jsonStr = {"prod_id":$('#prod_id').val()};
			var request = $.ajax({
				url: '<?php echo site_url("product/delete"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
			});
			request.done(function(response) {
				$('#deleteModal').modal('hide');
				if(response.valid == 'deleted'){
					$('[data-id="' + $('#prod_id').val() + '"]').parents('tr').fadeOut('slow', function() {
						cur_tr = this;
						dataTable.fnDeleteRow(cur_tr);
					});
					$('#prod_id').val('');
					$('#msgDialog > p').html('Successfully ' + response.valid);
					$('#msgModal').modal('show');
				} else {
					$('#prod_id').val('');
					$('#msgDialog > p').html(response.valid + ' to delete');
					$('#deleteModal').modal('hide');
					$('#msgModal').modal('show');
				}
			});

			request.fail(function(response) {
				$('#msgDialog > p').html('Cannot delete');
				$('#deleteModal').modal('hide');
				$('#msgModal').modal('show');
			});

		});
		//----------------------------------------------------------------------
	});
</script>
