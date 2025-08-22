<style>
	a {
		text-decoration: none !important;
	}
</style>

<main class="app-main">
	<!--begin::App Content Header-->
	<div class="app-content-header">
		<!--begin::Container-->
		<div class="container-fluid">
			<!--begin::Row-->
			<div class="row">
				<div class="col-sm-12">
					<h3 class="mb-0 text-lg-center text-uppercase"><?= $title ?></h3>
				</div>

			</div>
			<!--end::Row-->
		</div>
		<!--end::Container-->
	</div>

	<div class="app-content">
		<!--begin::Container-->
		<div class="container-fluid">

			<?php if ($this->session->flashdata('message')): ?>
				<div class="flash-data"
					data-flashdata='<?= htmlspecialchars(json_encode($this->session->flashdata("message")), ENT_QUOTES, "UTF-8") ?>'></div>
			<?php endif; ?>
			<div class="row mb-3">
				<div class="d-flex justify-content-between w-100">
					<!-- Tombol Kembali -->
					<button type="button" class="btn btn-success btn-sm">
						<a href="<?= base_url('sixs') ?>" class="text-white text-decoration-none">
							<i class="icofont-arrow-first"></i> kembali
						</a>
					</button>

					<!-- Tombol Download Format -->
					<button type="button" class="btn btn-primary btn-sm">
						<a href="<?= base_url('excelfile/master/'); ?>safety.xlsx" class="text-white text-decoration-none">
							<i class="icofont-download"></i> Download Format
						</a>
					</button>
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<form method="POST" action="<?= site_url('Safety/upload_safety'); ?>" enctype="multipart/form-data">
							<div class="card-body">
								<!-- Isian disini -->
								<div class="row">
									<div class="col-md-6">
										<input type="file" name="file" class="form-control" placeholder="pilih file xls / xlsx" accept=".xlsx, .xls" />

									</div>
									<div class="col-md-6">
										<button type="submit" class="btn btn-dark"> <i class="icofont-download"></i> Import File</button>
									</div>
								</div>
								<div class="card-footer mt-2">
									<p class="text-red "><span class="text-bold">NB.</span>
									<ul>
										<li>Silahkan Upload File Sesuai dengan Format Excel yang telah kami sediakan, format dapat di download pada menu download format yang telah kami sediakan.</li>

									</ul>
									</p>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>