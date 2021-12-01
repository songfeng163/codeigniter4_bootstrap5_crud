<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<?php echo view('include_css'); ?>
		<style type="text/css" media="all">
			#layoutSidenav_content {
				margin-left: 177px;
			}
		</style>
	</head>
    <!-- <body class="bg&#45;primary bg&#45;gradient"> -->
    <body class="">
		<?php echo view('main_side_bar'); ?>
		<div id="layoutSidenav_content">
			<main>
					<div class="container-fluid col-md-12 col-sm-12 col-lg-11 ">
						<div class="pt-5"> </div>
						<div class="pt-5"> </div>
                        <ol class="breadcrumb bg-light text-muted">
							<li> <i class="fas fa-tachometer-alt"></i> Dashboard </li>
						</ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
									<div class="card-body  bg-primary text-white">
										<i class="fa fa-shopping-cart fa-2x"></i>
										Today's Sales
									</div>
									<div class="card-footer bg-light d-flex align-items-center justify-content-between">
                                        <a class="small text-blue stretched-link" href="#">View Details </a>
                                        <div class="small"><i class="fas fa-angle-right"></i></div>
									</div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
									<div class="card-body bg-secondary text-white">
                                        <i class="fa fa-truck fa-2x"></i>
										Today's Purchase
									</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-blue stretched-link" href="#">View Details</a>
                                        <div class="small"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
									<div class="card-body bg-success text-white">
										<i class="fa fa-money-bill-alt fa-2x" aria-hidden="true"></i>
										Cash Balance
									</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-blue stretched-link" href="#">View Details</a>
                                        <div class="small"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-4">
									<div class="card-body bg-secondary text-white ">
										<i class="fa fa-university fa-2x" aria-hidden="true"></i>
										Bank Balance
									</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-blue stretched-link" href="#">View Details</a>
                                        <div class="small "><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>$170,750</td>
                                        </tr>
                                        <tr>
                                            <td>Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>San Francisco</td>
                                            <td>66</td>
                                            <td>2009/01/12</td>
                                            <td>$86,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4 col-lg-8 col-md-8 col-sm-8">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Light POS 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
		</div> <!-- Layout Side nav Content -->


	<!-- Include Additional JS Files-->
	<?php echo view('include_js') ?>

	<script src="<?php echo base_url('assets/demo/Chart.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/demo/chart-area-demo.js'); ?>"></script>
	<script src="<?php echo base_url('assets/demo/chart-bar-demo.js'); ?>"></script>
	<script src="<?php echo base_url('assets/demo/chart-pie-demo.js'); ?>"></script>

	<script src="<?php echo base_url('js/datatables-simple-demo.js'); ?>"></script>
	<script src="<?php echo base_url('js/simple-datatables.js'); ?>"></script>

	<script src="<?php echo base_url('js/.js'); ?>"></script>

<script>
$(document).ready(function() {

});
</script>
</body>
</html>
