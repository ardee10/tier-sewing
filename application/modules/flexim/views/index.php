<main class="app-main">
	<!--begin::App Content Header-->
	<div class="app-content-header">
		<!--begin::Container-->
		<div class="container-fluid">
			<!--begin::Row-->
			<div class="row">
				<div class="col-sm-12">
					<h3 class="mb-0 text-lg-center text-uppercase"><?= $title; ?></h3>
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

			<!-- Button Add Edit -->
			<div class="row mb-3">
				<div class="d-flex justify-content-start">
					<button type="button" class="btn btn-primary btn-md" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modalFlex">
						<i class="icofont-plus-circle"></i> Tambah Video
					</button>&nbsp;


				</div>
			</div>

			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">
							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="table-flexim">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>No</th>
											<th>Model</th>
											<th>Video</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										foreach ($flexim as $var) {
											$path = 'assets/fleximData/' . $var->nama_file;
											if (file_exists($path) && $var->nama_file != null) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $var->model ?></td>
													<td>
														<video width="320" height="240" controls>
															<source src="<?= base_url('assets/fleximData/') . $var->nama_file ?>" type="video/webM">
														</video>
													</td>
													<td class="align-middle">
														<a href="<?= site_url('flexim/hapus_data/') . $var->id_data ?>" class="btn btn-warning tombol-hapus"><i class="icofont-trash text-white"></i> Delete</a>
													</td>
												</tr>
										<?php
											endif;
										}
										?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal Insert / Update -->

	<form id="formFlex" action="<?= base_url('flexim/uploadVideo'); ?>" method="POST" enctype="multipart/form-data">
		<div class="modal fade" id="modalFlex" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark" id="staticBackdropLabel"><i class="icofont-video-alt"></i> Tambah Video</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-12">
							<label for="model" class="form-label">Pilih Model</label>
							<select class="form-select" aria-label="Default select example" name="model" id="model">
								<?php foreach ($model as $var) : ?>
									<option value="<?= $var->nama_model ?>"><?= $var->nama_model ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div class="mb-12 mt-2">
							<label for="model" class="form-label">Pilih File</label>
							<div class="input-group mb-3">
								<input type="file" class="form-control" name="file" accept=".webm" />
								<label class="input-group-text" for="inputGroupFile02">Upload</label>
							</div>
						</div>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="icofont-ui-close"></i> Close</button>
						<button type="submit" class="btn btn-primary"><i class="icofont-save"></i> Save</button>

					</div>
				</div>
			</div>
		</div>

	</form>


	<script>
		var base = $('#base').data('id');
		$(document).ready(function() {
			// Tombol Tambah
			$('#btnTambah').on('click', function() {
				$('#modal_flex_title').text('Tambah Data Video Flexim');
				$('#formFlex')[0].reset();
				$('#formFlex').attr('action', base + 'Flexim/uploadVideo');
			});

		});
	</script>