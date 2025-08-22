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
					<button type="button" class="btn btn-primary btn-sm" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modal_cot">
						<i class="icofont-plus-circle"></i> Tambah Data
					</button>&nbsp;
					<button type="button" class="btn btn-success btn-sm"><a href="<?= site_url('Cot/import_cot') ?>" class="text-white"><i class="icofont-file-excel"></i> Import Excel</a></button>&nbsp;
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">
							<div class="row mb-3">
								<!-- BUILDING -->
								<div class="col-md-2">
									<label for="buildingsixs" class="form-label font-weight-bold">BUILDING</label>
									<select class="form-control" id="buildingcot" name="buildingcot">
										<option value="semua">SEMUA</option>
										<?php foreach ($factory as $f): ?>
											<option value="<?= $f->gedung ?>"><?= $f->gedung ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<!-- DATE -->
								<div class="col-md-2">
									<label for="cotdate" class="form-label font-weight-bold">DATE</label>
									<input type="date" name="cotdate" id="cotdate" class="form-control" value="<?= date('Y-m-d') ?>" />
								</div>
							</div>
							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="table-cot">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>No</th>
											<th>Date</th>
											<th>Factory</th>
											<th>Cell</th>
											<th>Qty</th>
											<th>Images</th>
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
	<form id="form_cot" action="<?= site_url('cot/tambah_data'); ?>" method="POST" enctype="multipart/form-data">
		<div class="modal fade" id="modal_cot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width: 50px; height: 50px">
						<h5 class=" modal-title text-dark text-bold" id="modal_sixs_title" style="font-weight: bold;">Tambah Data Cot</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hapusImages(this)"></button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<input type="hidden" id="id_cot" name="id_cot" />
							<div class="row g-3">
								<div class="col-md-6">
									<label for="date" class="form-label">Date</label>
									<input type="date" class="form-control" id="cot_date" name="cot_date" placeholder="Date" required />
								</div>
								<div class="col-md-6">
									<label for="qty_cot" class="form-label">Qty</label>
									<input type="number" class="form-control" id="qty_cot" name="qty_cot" placeholder="Total Cot" required />
								</div>
								<div class="col-md-6">
									<label for="factory" class="form-label">Factory</label>
									<select class="form-select" id="selectFactory" name="kode_factory" required>
										<option value="">--Pilih--</option>
										<?php foreach ($factory as $f): ?>
											<option value="<?= $f->gedung ?>"><?= $f->gedung ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="cell" class="form-label">Cell</label>
									<select class="form-select" id="selectCell" name="cell" required>
										<option value="">--Pilih--</option>
									</select>
								</div>
								<div class="col-cot12">
									<div class="input-group mb-3">
										<input type="file" class="form-control" name="file_cot" />
										<label class="input-group-text" for="inputGroupFile02">Upload</label>
									</div>
								</div>
								<div class="col-md-6">
									<!-- <label for="cell" class="form-label">Preview</label> -->
									<img id="preview_img_cot" src="#" alt="Preview" class="img-thumbnail mt-2 form-control" style="display: none; width: 120px; height: auto;" />
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hapusImages(this)">Close</button>
						<button type=" submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	</form>


	<script>
		const base = $('#base').data('id');

		function loadCotTable() {
			let building = $('#buildingcot').val();
			let date = $('#cotdate').val();

			if (building && date) {
				$('#table-cot').DataTable().destroy();
				$('#table-cot').DataTable({
					processing: true,
					serverSide: true,
					pageLength: 10,
					order: [],
					ajax: {
						url: base + `cot/ajax_CotServerSide/${building}/${date}`,
						type: "POST"
					}
				});
			}
		}

		function hapusImages(el) {
			const img = document.getElementById('preview_img_cot');
			if (img) {
				img.removeAttribute('src'); // Hapus src agar kosong
				img.style.display = 'none'; // Sembunyikan kembali
			}
		}

		$(document).ready(function() {
			// Tombol Tambah
			$('#btnTambah').on('click', function() {
				$('#modal_cot_title').text('Tambah Data Cot');
				$('#form_cot')[0].reset();
				$('#id_cot').val(''); // kosongkan hidden input
				$('#form_cot').attr('action', base + 'cot/tambah_data');
			});
			// Fungsi edit
			window.edit_cot = function(el) {
				const id = $(el).data('id');
				$('#modal_cot_title').text('Edit Data Cot');
				$('#form_cot').attr('action', base + 'cot/tambah_data'); // tetap ke controller yg sama

				$.ajax({
					url: base + 'Cot/getDataCotById/' + id,
					type: 'GET',
					dataType: 'json',
					success: function(res) {
						if (res) {
							console.log(res);
							$('#id_cot').val(res.id_cot);
							$('select[name="kode_factory"]').val(res.kode_factory).change()
							$('select[name="cell"]').val(res.cell).change()
							$('#qty_cot').val(res.qty_cot);
							$('#cot_date').val(res.cot_date);

							/* tampilkan apabila ada gambar */
							if (res.file_cot) {
								$('#preview_img_cot')
									.attr('src', base + 'assets/img/cot_file/' + res.file_cot)
									.show();
							} else {
								$('#preview_img_cot').hide();
							}
						}
					},
					error: function() {
						alert('Gagal mengambil data');
					}


				});
			}

			$("#selectFactory").change(function(e) {
				var f = $("#selectFactory").val();
				$.ajax({
						url: base + `home/mssGetCellSewing/` + f,
						type: "get",
						dataType: "json"
					})
					.done(function(e) {
						for (var a = "<option value=''>--- PILIH ---</option>", l = 0; l < e.length; l++) "A953" != e[l].LINE_CD && (a += "<option value='" + e[l].LINE_CD + "'>" + e[l].LINE_NM + "</option>");
						$("#selectCell").html(a);
					})
					.fail(function() {
						console.log("error");
					});
			})
			$('#img_cot').on('change', function() {
				const [file] = this.files;
				if (file) {
					$('#preview_img_cot')
						.attr('src', URL.createObjectURL(file))
						.show();
				}
			});


			/* OnChange Date and Building */
			$('#buildingcot, #cotdate').on('change', loadCotTable);

		});
	</script>
