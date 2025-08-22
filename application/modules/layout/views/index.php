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
				<div class="flash-data" data-flashdata='<?= is_string($this->session->flashdata('message')) ? $this->session->flashdata('message') : json_encode($this->session->flashdata('message')) ?>'></div>
			<?php endif; ?>

			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">
							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="table-layout">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>No</th>
											<th>Images</th>
											<th>Model Name</th>
											<th>Action</th>

									</thead>
									<tbody>
										<?php
										$no = 1;
										foreach ($model as $mod) : ?>
											<tr>
												<td class="text-center text-bold align-middle"><?= $no++ ?></td>
												<td class="text-center align-middle">
													<img width="80px" src="<?= base_url($mod['gambar']) ?>">
												</td>
												<td class="text-center align-middle"><?= $mod['model_name'] ?></td>
												<td class="text-center align-middle">
													<?php if ($mod['nama_layout']) : ?>
														<a type="button" class="btn btn-danger btn-sm"
															data-bs-toggle="modal"
															data-bs-target="#modalUpload"
															onclick="formUpload('<?= $mod['model_name'] ?>')">
															<i class="icofont-upload-alt"></i> Upload Ulang
														</a>

														<a type="button" target="__blank" class="btn btn-success btn-sm" href="<?= base_url($mod['nama_layout'])  ?>"><i class="icofont-eye-open"></i> Lihat File</a>
													<?php else : ?>
														<a type="button" class="btn btn-primary btn-sm"
															data-bs-toggle="modal"
															data-bs-target="#modalUpload"
															onclick="formUpload('<?= $mod['model_name'] ?>')">
															<i class="icofont-upload-alt"></i> Upload
														</a>

													<?php endif ?>
												</td>
											</tr>
										<?php endforeach ?>

									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal -->
	<form action="<?php echo site_url('layout/uploadLayout') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<div id="modalUpload" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width: 50px; height: 50px">
						<h5 class=" modal-title text-dark text-bold" id="modal_kaizen_title" style="font-weight: bold;">Upload New Layout</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetFormUploadLayout()"></button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<div class="row g-3">
								<div class="col-md-12">
									<label for="date" class="form-label">Nama Model</label>
									<input type="text" class="form-control" name="nama_model" placeholder="NAMA MODEL" required readonly>
								</div>
								<div class="col-md-12">
									<label for="artikel" class="form-label">FILE LAYOUT (PDF)</label>
									<input type="file" class="form-control" name="file" placeholder="FILE LAYOUT" required>
								</div>


							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Upload</button>
					</div>
				</div>
			</div>
		</div>
	</form>





	<script>
		function formUpload(nama_model) {
			$('input[name="nama_model"]').val(nama_model)
		}

		function resetFormUploadLayout() {
			$('input[name="nama_model"]').val("");
			$('input[name="file"]').val("");
		}
	</script>