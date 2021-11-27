<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<?php echo view('include_css'); ?>
	</head>
	<body>
		<?php echo view('main_side_bar'); ?>
		<div id="layoutSidenav_content">
			<div class="container col-md-7 col-sm-7 col-lg-7 ">
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
	<div class="modal fade" id="msgModal" tabindex="1" aria-hidden="true">
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
							<input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name">
						</div>
						<div class="form-group">
							<label>Price</label>
							<input type="text" class="form-control" name="product_price" id="product_price" placeholder="Product Price">
						</div>
						<div class="form-group">
							<label>Category</label>
							<input type="text" id="category_input">
						</div>
					</div>
					<div class="modal-footer">
					<button type="button" name="Exit" id="exit" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i>Exit</button></td>
					<button type="button" name="btnSubmit" id="btnSubmit" class="btn btn-primary"><i class="fa fa-fw fa-plus-square"></i>Save</button></td>
					<button type="button" name="btn" id="btnEdit" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i>Update</button></td>
					<input type="hidden" id="category_hidden"></div>
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
                <input type="hidden" name="product_id" id="product_id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button id="btnDelete" type="button" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
    </form>
    <!-- End Modal Delete Product-->

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
			if($('#product_id').val().length == 0) {
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
					{sClass:"left", "sWidth":"200px"},
					{sClass:"right"},
					{sClass:"right"},
					{sClass:"center"}]
				});
			}
			fetch_data();
		}
		//----------------------------------------------------------------------
		function fetch_data() {
			$.ajax({
			url: '<?php echo site_url("product/fetch_data"); ?>',
				dataType: 'json',
				success: function(response) {
					if (response.length > 0) {
						for(var i in response) {
							dataTable.fnAddData([
								response[i].product_id,
								response[i].product_name,
								response[i].product_price,
								response[i].category_name,
								'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response[i].product_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].product_id + '"><i class="fa fa-trash"></i>Delete</a>'
								], false);
							}
							dataTable.fnDraw(true);
						} else {

						}
					}
				});
		}
		//----------------------------------------------------------------------
		$('#category_input').autocomplete({
			serviceUrl: '<?php echo site_url("product/get_category"); ?>',
			onSelect:function (suggestion) {
				// alert('You selected: ' + suggestion.value +', ' + suggestion.data);
				$('#category_hidden').val(suggestion.data);
			}
		});
		//-----------------------------------------------------------------
		$('#btnSubmit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"product_name":$('#product_name').val(),
				"product_price":$('#product_price').val(),
				"category_id":$('#category_hidden').val()};
			$.ajax({
			url: '<?php echo site_url("product/save"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},

				success: function(response) {
					if(response.valid == "Success") {
						$('#msgDialog > p').html("Data Saved Successfully");
						//Show new records in the data table
						dataTable.fnAddData([response.pr_id,
							$('#product_name').val(),
							$('#product_price').val(),
							$('#category_input').val(),
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.pr_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + $('#product_id').val() + '"><i class="fa fa-trash"></i>Delete</a>'
							]);
						clear_field();
						$('#addModal').modal('hide');
						$('#msgModal').modal('show');
						// $("#update").button("enable");
						// $("#btnSubmit").button("disable");
						} else {
							// $('#addModal').modal('hide');
							$('#msgAddValidation > p').html(response.valid);
							// $('#msgModal').modal('show');
							// $("#btnSubmit").button("enable");
							}
					}
				});
			});
		//----------------------------------------------------------------------
		    $('#show_data').on('click','.btn-edit',function(){
			// get data from button edit
			const id = $(this).data('id');
			update_position = dataTable.fnGetPosition($(this).parents('tr')[0]);
			// Set data to Form Edit
			$('#product_id').val(id);

			var jsonStr = [];
			jsonStr = {"product_id": id};
			$.ajax({
			url: '<?php echo site_url("product/fetchById"); ?>',
				type: 'POST',
				dataType: 'json',
				data: {'jsarray': $.toJSON(jsonStr)},
				success: function(response) {
					if (response.product_id.length > 0) {
						$('#product_id').val(response.product_id);
						$('#product_name').val(response.product_name),
							$('#product_price').val(response.product_price),
							$('#category_input').val(response.category_id + '-' + response.category_name),
							$('#category_hidden').val(response.category_id),
							$('#addModal').modal('show');
						} else {

							}
					}
				});

				// Call Modal Edit
				// $('#deleteModal').modal('show');
			});
		//-----------------------------------------------------------------
		$('#btnEdit').button().click(function() {
			var jsonStr = [];
			jsonStr = {"product_id":$('#product_id').val(),
				"product_name":$('#product_name').val(),
				"product_price":$('#product_price').val(),
				"category_id":$('#category_hidden').val()};
			$.ajax({
			url: '<?php echo site_url("product/edit"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},

				success: function(response) {
					if(response.valid == "Success") {
						$('#msgDialog > p').html("Data Updated Successfully");
						//Show new records in the data table
						dataTable.fnUpdate([response.pr_id,
							$('#product_name').val(),
							$('#product_price').val(),
							$('#category_input').val(),
							'<a class="btn btn-primary btn-sm btn-edit" href="#" data-id="' + response.pr_id + '"><i class="fa fa-edit"></i>Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + $('#product_id').val() + '"><i class="fa fa-trash"></i>Delete</a>'
							], update_position);
						clear_field();
						$('#addModal').modal('hide');
						$('#msgModal').modal('show');
						// $("#update").button("enable");
						// $("#btnSubmit").button("disable");
						} else {
							// $('#addModal').modal('hide');
							$('#msgAddValidation > p').html(response.valid);
							// $('#msgModal').modal('show');
							// $("#btnSubmit").button("enable");
							}
					}
				});
			});
		//----------------------------------------------------------------------
	    $('#show_data').on('click','.btn-delete',function(){
			// get data from button edit
			const id = $(this).data('id');
			// Set data to Form Edit
			$('#product_id').val(id);
			// Call Modal Edit
			$('#deleteModal').modal('show');
		});

		//----------------------------------------------------------------------
		$('#btnDelete').button().click(function() {
			var jsonStr = [];
			jsonStr = {"product_id":$('#product_id').val()};
			$.ajax({
			url: '<?php echo site_url("product/delete"); ?>',
				type: 'POST',
				dataType:'json',
				data: {'jsarray': $.toJSON(jsonStr)},
				success: function(response) {
					$('#deleteModal').modal('hide');
					if(response.valid == 'deleted'){
						$('[data-id="' + $('#product_id').val() + '"]').parents('tr').fadeOut('slow', function() {
							cur_tr = this;
							dataTable.fnDeleteRow(cur_tr);
							});
							$('#msgDialog > p').html('Successfully ' + response.valid);
							$('#msgModal').modal('show');
						} else {
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
