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


	<script src="<?= base_url('assets/login/') ?>/js/main.js"></script>
	<script src="<?= base_url('assets/login/') ?>js/jquery.min.js"></script>



	<div id="base" data-id="<?= site_url(); ?>"></div>

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

		.bg-gradient-primary {
			background: linear-gradient(to right, #0d6efd, #0d6dfdbb) !important;
			color: white;
		}
	}
</style>

<body>
	<section class="ftco-section bg-fullscreen">
		<div class="container">
			<?php if ($this->session->flashdata('message')): ?>
				<div class="flash-data" data-flashdata='<?= is_string($this->session->flashdata('message')) ? $this->session->flashdata('message') : json_encode($this->session->flashdata('message')) ?>'></div>
			<?php endif; ?>
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<!-- <h2 class="heading-section">LOGIN CELL</h2> -->
					<h1 class="text-center" style="font-size: 1.8em; font-weight: 400;">TIER SEWING DASHBOARD</h1>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image:url(assets/login/images/login-bg.jpg);">
						</div>
						<div class="login-wrap p-4 p-md-5">
							<div class="d-flex">
								<div class="w-100 bg">
									<h3 class="mb-4">Sign In to Your Account</h3>
								</div>
							</div>
							<form action="<?= site_url('Auth/loginOperator') ?>" method="POST" class="signin-form">
								<div class="form-group mb-3">
									<label class="label" for="building">BUILDING</label>
									<select id="building" name="building" class="form-control" aria-label="Default select example" required>
										<option value="">---Silahkan Pilih Building---</option>
										<?php foreach ($factory as $data) {
										?>
											<option value="<?= $data->gedung ?>"><?= $data->gedung; ?></option>
										<?php
										} ?>
										<!-- <option value="all">PWJ</option> -->
									</select>
								</div>
								<div class="form-group input-cell mb-3">
									<label class="label" for="password">CELL</label>

									<select id="cell" name="cell" class="form-control" aria-label="Default select example" name="cell">
										<option value="">---Silahkan Pilih Cell---</option>
										<!-- Otomatis tampil -->
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="form-control bg-gradient-primary">LOGIN</button>
								</div>
								<div class="col-md-12  text-center">
									<a href="<?= base_url('pengguna') ?>" class="nav-link active" style="color: #0eacf5ff;">
										<i class="nav-icon bi bi-circle-fill"></i>
										<p class="text-center">LOGIN ADMIN</p>
									</a>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<script src="<?= base_url('assets/login/') ?>js/popper.js"></script>
	<script src="<?= base_url('assets/login/') ?>js/bootstrap.min.js"></script>
	<!-- Sweet Alert -->
	<script src="<?= base_url('assets/plugin/'); ?>/js/sweetalert2@11.js"></script>
	<!-- Customize JS -->
	<script src="<?= base_url('assets/'); ?>js/myjs.js"></script>
	<script>
		var base = $('#base').data('id')

		$('#building').change(function(event) {
			var id = $(this).val()
			if (id != '') {
				if (id == 'all') {
					$('.input-cell').hide();
					$('#cell').prop('required', false);
				} else {
					$('.input-cell').show()

					$.ajax({
							url: base + 'home/mssGetCellSewing/' + id,
							type: 'get',
							dataType: 'json',
						})
						.done(function(data) {
							console.log(data)
							// Cek apakah data ada isinya
							if (data.length > 0) {
								$('#cell').attr('disabled', false);
								var items = "<option value=''>--- PILIH ---</option>";
								// items += "<option value='semua'>SEMUA</option>";
								// Loop semua data dari API/AJAX
								for (var i = 0; i < data.length; i++) {
									// lewati LINE_CD = "A953"
									if (data[i].LINE_CD != "A953") {
										items += "<option value='" + data[i].LINE_CD + "'>" + data[i].LINE_NM + "</option>";
									}
								}
								// Masukkan seluruh opsi ke dalam dropdown
								$("#cell").html(items);
							} else {
								Swal.fire(
									'Cell Tidak Tersedia',
									'Factory Yang Anda Pilih Tidak Memiliki Cell Aktif.. ',
									'error'
								)
							}
						})
						.fail(function() {
							alert("error");
						});
				}

			} else {

				$('#cell').attr('disabled', true);
			}

		});
	</script>

</body>

</html>
