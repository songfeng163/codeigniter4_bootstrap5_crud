<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
		<link rel="stylesheet" href="css/jquery.dataTables.min.css">
		<style>
			.mt{
				margin-top:5em;
			}
		</style>
	</head>
	<body>
		<div id="layoutSidenav_content" class="mt">
			<div class="container col-md-7 col-sm-7 col-lg-7">
			<h3>Product Lists</h3>
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"> Add New </button>
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
						<?php foreach($product as $row): ?>
							<tr>
								<td> <?= $row->product_id; ?></td>
								<td> <?= $row->product_name; ?></td>
								<td> <?= $row->product_price; ?></td>
								<td> <?= $row->category_name; ?></td>
								<td>
									<a href="#" class="btn btn-info btn-sm btn-edit" data-id="<?= $row->product_id;?>" data-name="<?= $row->product_name;?>"  data-price="<?= $row->product_price;?>" data-category_id="<?= $row->product_category_id;?>">Edit</a>
									<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="<?= $row->product_id;?>">Delete</a>
								</td>
							</tr>
						<?php endforeach; ?>
				</tbody>
			</table>
			</div> <!-- end container -->
		</div> <!-- Layout Side nav Content -->

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
								<select name="product_category" id="product_category" class="form-control">
									<option value="">-Select-</option>
									<?php foreach($category as $row): ?>
									<option value="<?= $row->category_id; ?>"> <?= $row->category_name; ?></option>
									<?php endforeach; ?>
								</select>
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

	<?php echo view('main_side_bar'); ?>

	<!-- Include Additional JS Files-->
	<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script>
		$(document).ready( function () {

			$('#tblproduct').DataTable({
					"bJQueryUI": true,
							"bLengthChange": true,
							"bAutoWidth": false,
			});

		});
	</script>
	</body>
</html>
