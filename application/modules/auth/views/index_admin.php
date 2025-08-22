<!doctype html>
<html lang="en">

<head>
	<title><?= SITENAME ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- favicon -->
	<link rel="icon" type="image/x-icon" href="<?= base_url('assets') ?>/img/3.jpeg">
	<link rel="stylesheet" href="<?= base_url('assets/login/') ?>css/style.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/mycss.css">
	<!-- CSS SweetAlert -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/sweetalert2.min.css">


</head>

<style>
	.bg-fullscreen {
		background-image: url('assets/login/images/background-images.jpg');
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		background-attachment: fixed;
		width: 100%;
		min-height: 100vh;
		/* Full height of viewport */

	}

	.bg-gradient-primary {
		background: linear-gradient(to right, #0d6efd, #0d6dfdbb) !important;
		color: white;
	}


	/* assets/css/sweetalert.css */
	/* .swal2-popup {
		font-size: 1.6rem !important;
	} */
</style>

<body>
	<section class="ftco-section bg-fullscreen">
		<div class="container">


			<?php if ($this->session->flashdata('message')): ?>
				<div class="flash-data" data-flashdata='<?= is_string($this->session->flashdata('message')) ? $this->session->flashdata('message') : json_encode($this->session->flashdata('message')) ?>'></div>
			<?php endif; ?>


			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h1 class="text-center" style="font-size: 1.8em; font-weight: 350;">TIER SEWING DASHBOARD</h1>
					<span class=""></span>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(assets/login/images/login-bg.jpg);">
						</div>
						<div class="login-wrap p-4 p-md-5">
							<!-- LOGIN AND LOGOUT -->

							<div class="d-flex">
								<div class="w-100 bg">
									<h3 class="mb-4">Sign In to Your Account</h3>
								</div>
							</div>
							<form action="<?= base_url('Auth/process_login') ?>" method="POST" class="signin-form" id="loginAdmin">
								<div class="form-group mb-3">
									<label class="label" for="name">Username</label>
									<input type="text" name="username" class="form-control" placeholder="Username" autocomplete="username" required>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="password">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Password" autocomplete="current-password" required>
								</div>
								<div class="form-group">
									<button type="submit" class="form-control bg-gradient-primary">LOGIN</button>
								</div>
								<div class="col-md-12  text-center">
									<a href="<?= base_url('users') ?>" class="nav-link active" style="color: #0eacf5ff;">
										<i class=" nav-icon bi bi-circle-fill"></i>
										<p class="text-center">LOGIN OPERATOR</p>
									</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="<?= base_url('assets/login/'); ?>js/popper.js"></script>
	<script src="<?= base_url('assets/login/'); ?>js/bootstrap.min.js"></script>
	<script src="<?= base_url('assets/login/'); ?>js/jquery.min.js"></script>
	<script src="<?= base_url('assets/login/'); ?>/js/main.js"></script>
	<!-- Sweet Alert -->
	<script src="<?= base_url('assets/plugin/'); ?>/js/sweetalert2@11.js"></script>
	<!-- Customize JS -->
	<script src="<?= base_url('assets/'); ?>js/myjs.js"></script>

</body>

</html>
