<main class="app-main">
	<!--begin::App Content Header-->
	<div class="app-content-header">
		<!--begin::Container-->
		<div class="container-fluid">
			<!--begin::Row-->
			<div class="row">
				<div class="col-sm-12">
					<h3 class="mb-0 text-lg-center text-uppercase">DATA CELL TIER SEWING</h3>
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
								<table class="table table-striped" style="width:100%" id="cellERP">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>LINE_CD</th>
											<th>KODE_FACTORY</th>
											<th>LINE_NM</th>
											<th>JENIS</th>
											<th>STATUS</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($cell as $var) : ?>
											<tr>
												<td><?= $var->id_cell ?></td>
												<td><?= $var->kode_factory ?></td>
												<td><?= $var->nama_cell ?></td>
												<td><?= $var->jenis ?></td>
												<td><?= ($var->is_active == '1') ? "<button type='button' class='btn btn-success btn-sm text-white'><i class='icofont-ui-check'></i> Active</button>" : "<button type='button' class='btn btn-warning btn-sm text-white'><i class='icofont-not-allowed'></i> Not Active</button>"; ?></td>
												<td><a class="btn btn-info" href="#" onclick="editCell(this)" data-id="<?= $var->id_cell; ?>" data-bs-toggle="modal" data-bs-target="#modalCell"><i class="icofont-ui-settings text-white"></i></a> <a href="<?= base_url('Setting/hapus_data/' . $var->id_cell) ?>" class="btn btn-danger tombol-hapus"><i class="icofont-trash"></i></a></td>


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


	<!-- Modal Edit -->

	<form action="<?= base_url('setting/tambah_data'); ?>" method="POST">
		<div class="modal fade" id="modalCell" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark" id="staticBackdropLabel">Edit Data Cell</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label for="id_cell" class="form-label">ID Cell</label>
							<input type="text" class="form-control" id="id_cell" name="id_cell" />
						</div>
						<div class="mb-3">
							<label for="kode_factory" class="form-label">Kode Factory</label>
							<!-- <input type="text" class="form-control" id="kode_factory" name="kode_factory" /> -->
							<select class="form-select" aria-label="Default select example" name="kode_factory" id="kode_factory">
								<?php foreach ($factory as $var) {
								?>
									<option value="<?= $var->gedung ?>"><?= $var->gedung ?></option>
								<?php
								} ?>
								<option value="">Active</option>


							</select>
						</div>
						<div class="mb-3">
							<label for="nama_cell" class="form-label">Nama Cell</label>
							<input type="text" class="form-control" id="nama_cell" name="nama_cell" />
						</div>
						<div class="mb-3">
							<label for="jenis" class="form-label">Jenis</label>
							<input type="text" class="form-control" id="jenis" name="jenis" />
						</div>
						<div class="mb-3">
							<label for="is_active" class="form-label">Is Active</label>
							<select class="form-select" aria-label="Default select example" name="is_active" id="is_active">
								<option value="1">Active</option>
								<option value="0">Not Active</option>

							</select>
						</div>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Update</button>
						<!-- <button type="button" class="btn btn-primary">Understood</button> -->
					</div>
				</div>
			</div>
		</div>

	</form>


	<script>
		var base = $('#base').data('id');
		// alert(base);
		function editCell(edit) {
			let id = $(edit).data('id')

			// Mengambil element berdasarkan ID
			document.getElementById('id_cell')
			document.getElementById('kode_factory')
			document.getElementById('nama_cell')
			document.getElementById('jenis')
			document.getElementById('is_active')

			// Jika IDnya ada
			if (id) {
				$.ajax({
					type: 'GET',
					url: `${base}setting/detailcell/${id}`,
					dataType: 'json',
					success: function(data) {
						console.log(data);
						$('#id_cell').val(data.id_cell)
						$('#kode_factory').val(data.kode_factory)
						$('#nama_cell').val(data.nama_cell)
						$('#jenis').val(data.jenis)
						$('#is_active').val(data.is_active)
					}
				});



			}
			$('#modalCell').modal('show')



		}
	</script>