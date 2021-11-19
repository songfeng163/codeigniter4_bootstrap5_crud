<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
		<link rel="stylesheet" href="css/jquery.dataTables.min.css">
		<link href="css/jquery.flexbox.css" rel="stylesheet">
		<style>
			.mt{
				margin-top:5em;
			}
		</style>
	</head>
	<body>
		<div id="layoutSidenav_content" class="mt">
			<div class="container col-md-7 col-sm-7 col-lg-7">
				<div class="float-left">
					<h3>Product Lists</h3>
				</div>
				<div class="float-right">
					<button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addModal"> Add New Product Record </button>
				</div>
				<table id="tblproduct" class="mt table table-striped table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Product Name</th>
							<th>Price</th>
							<th>Category</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div> <!-- end container -->
		</div> <!-- Layout Side nav Content -->
	<?php echo view('main_side_bar'); ?>
		<!-- Modal Add Product -->
		<form action="" method="post">
			<div class="modal fade" id="addModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
							<button type="button" class="close" data-dismiss="modal" arial-label="close">
								<span aria-hidden="true">&times;</span>
							</button>
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
								<div id="category">
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
				</div>
			</div>
		</form>


	<!-- Include Additional JS Files-->
	<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script type="text/JavaScript" src="js/jquery.flexbox.min.js"> </script>
<script>
$(document).ready( function () {
	var dataTable;

	fetch_data();
	//----------------------------------------------------------------------

	if(typeof dataTable == 'undefined') {
		dataTable = $('#tblproduct').dataTable({
			"bJQueryUI": true,
			"bLengthChange": true,
			"bAutoWidth": false,
		});
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
							'<a class="btn btn-info btn-sm btn-edit" href="#" data-id="' + response[i].product_id + '" data-name="' + response[i].product_name + '" data-price="' + response[i].product_price + '" data-category_id="' + response[i].product_category_id + '">Edit</a> <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="' + response[i].product_id + '">Delete</a>'
							], false);
						}
						dataTable.fnDraw(true);
					} else {

					}
				}
			});

		//to show list for auto complete customer Name Text Box
		$('#category').flexbox('index.php/product/get_category', {selectBehavior: false, watermark: '', paging: true, allowInput: true, autoCompleteFirstMatch: false});
		$('#category_ctr').css('width', '200px');
		$('#category_input').css('width', '200px');
	}
	//----------------------------------------------------------------------
	});
</script>
</body>
</html>
