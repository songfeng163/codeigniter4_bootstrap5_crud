<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo view('include_css'); ?>
    <title>Login</title>
  </head>
  <body>
    <body class="bg-primary">
        <div id="layoutAuthentication">
                <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-warning">
                       <?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif;?>
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
									<div class="card-header"><h2>Login</h2></div>
                                    <div class="card-body">
										<form action='<?php echo site_url("SigninController/loginAuth"); ?>' method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" id="email" type="email" value="<?= set_value('email') ?>" class="form-control">
                    </divplaceholder="name@example.com" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
												<button type="submit" class="btn btn-success">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
	<?php echo view('include_js') ?>
  </body>
</html>
