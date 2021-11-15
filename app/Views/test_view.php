<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href='css/bootstrap.min.css'
	</head>
	<body>
	<br/>
	<br/>
	<br/>

	<div id="layoutSidenav_content">
		<div class="container col-md-7 col-sm-7 col-lg-7">
			<h3>Products</h3>
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<button class="nav-link active" id="nav-view-tab" data-bs-toggle="tab" data-bs-target="#view" type="button" role="tab" aria-controls="nav-home" aria-selected="true">View</button>
					<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#entryform" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">New</button>
				</div>
			</nav>
			<div class="tab-content">
				<div id="view" role="tabpanel" class="tab-pane fade show active">
					<button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#addModal">Add New </button>
					<table class="table table-striped table-bordered table-hover">
						<thead class="thead-dark">
							<tr>
								<th>Product Name</th>
								<th>Price</th>
								<th>Category</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($product as $row): ?>
							<tr>
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
				</div> <!-- end view tab -->

				<div id="entryform" class="tab-pane">
					<form action="" method="post">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Product Name</label>
							<input class="col-sm-5" type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name">
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Price</label>
							<input class="col-sm-3" type="text" class="form-control" name="product_price" id="product_price" placeholder="Product Price">
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Category</label>
							<select class="col-sm-3" name="product_category" id="product_category" class="form-control">
								<option value="">-Select-</option>
								<?php foreach($category as $row): ?>
								<option value="<?= $row->category_id; ?>"> <?= $row->category_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<input type="hidden" id="prod_id" name="prod_id"/>
					</form>
				</div> <!-- end entryform tab-->
			</div> <!-- end tab content -->
		</div> <!-- end container -->
	</div> <!-- Layout Side nav Content -->
	<?php echo view('main_side_bar'); ?>

	<!-- Include Additional JS Files-->
	<script src='js/jquery-3.4.1.min.js'?>" </script>
	</body>
</html>
