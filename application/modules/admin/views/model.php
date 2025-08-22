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


			<!-- Button Add Import and Download -->
			<div class="row mb-3">
				<div class="d-flex justify-content-end">
					<button type="button" class="btn btn-primary btn-sm" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modal_model">
						<i class="icofont-plus-circle"></i> Tambah Data
					</button>&nbsp;
					<button type="button" class="btn btn-success btn-sm"><a href="<?= site_url('Admin/import_model'); ?>" class="text-white"><i class="icofont-file-excel"></i> Import Excel</a></button>&nbsp;
					<button type="button" class="btn btn-danger btn-sm"><a href="<?= site_url('Admin/export_model'); ?>" class="text-white"><i class="icofont-download"></i> Download Excel</a></button>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">
							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="table-model">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>No</th>
											<th>Target/Jam</th>
											<th>Images</th>
											<th>Artikel</th>
											<th>Model</th>
											<th>MP Std Sew-Prep</th>
											<th>LC Sew-Prep</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal -->
	<form id="form_model" action="<?= base_url('Admin/tambah_data_model'); ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" id="id_model" name="id_model" />
		<div class="modal fade" id="modal_model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width: 50px; height: 50px">
						<h5 class=" modal-title text-dark text-bold" id="modal_model_title" style="font-weight: bold;">Edit Data Model</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<div class="row g-3">
								<div class="col-md-6">
									<label for="nama_model" class="form-label">Nama Model</label>
									<input type="text" class="form-control" id="nama_model" name="nama_model" placeholder="Nama Model" required />
								</div>

								<div class="col-md-6">
									<label for="artikel" class="form-label">Artikel</label>
									<input type="text" class="form-control" id="kode_model" name="kode_model" placeholder="Artikel" required />
								</div>
								<div class="col-md-6">
									<label for="target" class="form-label">Target</label>
									<select class="form-select" id="target" name="target" required>
										<option value="">--Pilih Target--</option>
										<option value="60">60</option>
										<option value="120">120</option>
										<option value="130">130</option>
									</select>

								</div>

								<div class="col-md-6">
									<label for="mp_sewing" class="form-label">MP Sewing</label>
									<input type="number" class="form-control" id="mp_sewing" name="mp_sewing" placeholder="MP Sewing" required />
								</div>
								<div class="col-md-6">
									<label for="mp_prep" class="form-label">MP Prep</label>
									<input type="number" class="form-control" id="mp_prep" name="mp_prep" placeholder="MP Prep" required />
								</div>
								<div class="col-md-6">
									<label for="mp_ws" class="form-label">MP WS</label>
									<input type="number" class="form-control" id="mp_ws" name="mp_ws" placeholder="MP WS" required />
								</div>

								<div class="col-md-6">
									<label for="lc" class="form-label">LC</label>
									<input type="number" class="form-control" id="lc" name="lc" placeholder="LC" required />
								</div>

								<div class="col-md-6">
									<label for="img_model" class="form-label">Gambar Model</label>
									<input type="file" class="form-control" id="img_model" name="img_model" />
									<img id="preview_img_model" src="#" alt="Preview" class="img-thumbnail mt-2" style="display: none; width: 120px; height: auto;" />
								</div>
							</div>

						</div>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	</form>


	<script>
		const base = $('#base').data('id');

		$(document).ready(function() {
			// const base = $('#base').data('id');
			// Tombol Tambah
			$('#btnTambah').on('click', function() {
				$('#modal_model_title').text('Tambah Data Model');
				$('#form_model')[0].reset();
				$('#id_model').val(''); // kosongkan hidden input
				$('#form_model').attr('action', base + 'Admin/tambah_data_model');
			});

			// Fungsi edit
			window.edit_model = function(el) {
				const id = $(el).data('id');
				$('#modal_model_title').text('Edit Data Model');
				$('#form_model').attr('action', base + 'Admin/tambah_data_model'); // tetap ke controller yg sama

				$.ajax({
					url: base + 'Admin/getDataModelById/' + id,
					type: 'GET',
					dataType: 'json',
					success: function(res) {
						if (res) {
							$('#id_model').val(res.id_model);
							$('#nama_model').val(res.nama_model);
							$('#kode_model').val(res.kode_model);
							$('#target').val(res.target);
							$('#mp_sewing').val(res.mp_sewing);
							$('#mp_prep').val(res.mp_prep);
							$('#mp_ws').val(res.mp_ws);
							$('#lc').val(res.lc);

							/* tampilkan apabila ada gambar */
							if (res.img_model) {
								$('#preview_img_model')
									.attr('src', base + 'assets/img/product_model/' + res.img_model)
									.show();
							} else {
								$('#preview_img_model').hide();
							}

						}
					},
					error: function() {
						alert('Gagal mengambil data');
					}
				});
			}

			$('#img_model').on('change', function() {
				const [file] = this.files;
				if (file) {
					$('#preview_img_model')
						.attr('src', URL.createObjectURL(file))
						.show();
				}
			});

		});
	</script>