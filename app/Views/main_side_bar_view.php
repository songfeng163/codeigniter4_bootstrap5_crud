<!DOCTYPE html>
    <div class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="<?php echo site_url('/login/load_dash_board') ?>">Light POS</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
						<li><a class="dropdown-item" href="<?php echo site_url('/login/logout') ?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="<?php echo site_url('/login/load_dash_board') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRegistration" aria-expanded="false" aria-controls="collapseRegistration">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Registration
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseRegistration" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Customer</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer_group') ?>">Customer Group</a>
                                    <a class="nav-link" href="<?php echo site_url('/product') ?>">Product</a>
                                    <a class="nav-link" href="<?php echo site_url('/product_cat') ?>">Product Category</a>
                                    <a class="nav-link" href="<?php echo site_url('/vendor') ?>">Vendor</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTran" aria-expanded="false" aria-controls="collapseTran">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Transaction
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseTran" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Sales</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Purhchase</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Money Receipt</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Vendor Payment</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Report
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseReport" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Cash Balance Report</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Customer Ledger</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Vendor Ledger</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Sales Report</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Purhchse Report</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Stock Report</a>
                                    <a class="nav-link" href="<?php echo site_url('/customer') ?>">Expense Report</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
						<?php echo session()->get('email'); ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
