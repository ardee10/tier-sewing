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
					<button type="button" class="btn btn-primary btn-sm" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modal_kaizen">
						<i class="icofont-plus-circle"></i> Tambah Data
					</button>&nbsp;
					<button type="button" class="btn btn-success btn-sm"><a href="<?= base_url('Kaizen/import_kaizen') ?>" class="text-white"><i class="icofont-file-excel"></i> Import Excel</a></button>&nbsp;
					<!-- <button type="button" class="btn btn-danger btn-sm"><a href="3" class="text-white"><i class="icofont-download"></i> Download Excel</a></button> -->
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">
							<div class="row mb-3">
								<!-- BUILDING -->
								<div class="col-md-2">
									<label for="buildingkaizen" class="form-label font-weight-bold">BUILDING</label>
									<select class="form-control" id="buildingkaizen" name="buildingkaizen">
										<option value="semua">SEMUA</option>
										<?php foreach ($factory as $f): ?>
											<option value="<?= $f->gedung ?>"><?= $f->gedung ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<!-- DATE -->
								<div class="col-md-2">
									<label for="kaizendate" class="form-label font-weight-bold">DATE</label>
									<input type="date" name="kaizendate" id="kaizendate" class="form-control" value="<?= date('Y-m-d') ?>" />
								</div>
							</div>

							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="table-kaizen">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>No</th>
											<th>Date</th>
											<th>Factory</th>
											<th>Cell</th>
											<th>Total Kaizen</th>
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
	<form id="form_kaizen" action="<?= site_url('kaizen/tambah_data'); ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" id="id_kaizen" name="id_kaizen" />
		<div class="modal fade" id="modal_kaizen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width: 50px; height: 50px">
						<h5 class=" modal-title text-dark text-bold" id="modal_kaizen_title" style="font-weight: bold;">Edit Data Model</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<div class="row g-3">
								<div class="col-md-6">
									<label for="date" class="form-label">Date</label>
									<input type="date" class="form-control" id="kaizen_date" name="kaizen_date" placeholder="Date" required />
								</div>
								<div class="col-md-6">
									<label for="artikel" class="form-label">Total Kaizen</label>
									<input type="number" class="form-control" id="total_kaizen" name="total_kaizen" placeholder="Total Kaizen" required />
								</div>
								<div class="col-md-6">
									<label for="factory" class="form-label">Factory</label>
									<select class="form-select" id="selectFactory" name="factory" required>
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
								<div class="col-md-12">
									<div class="input-group mb-3">
										<input type="file" class="form-control" name="file" />
										<label class="input-group-text" for="inputGroupFile02">Upload</label>
									</div>
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

		function loadKaizenTable() {
			let building = $('#buildingkaizen').val();
			let date = $('#kaizendate').val();

			if (building && date) {
				$('#table-kaizen').DataTable().destroy();
				$('#table-kaizen').DataTable({
					processing: true,
					serverSide: true,
					pageLength: 10,
					order: [],
					ajax: {
						url: base + `kaizen/ajax_KaizenServerSide/${building}/${date}`,
						type: "POST"
					}
				});
			}
		}

		$(document).ready(function() {
			// Tombol Tambah
			$('#btnTambah').on('click', function() {
				$('#modal_kaizen_title').text('Tambah Data Kaizen');
				$('#form_kaizen')[0].reset();
				$('#id_kaizen').val(''); // kosongkan hidden input
				$('#form_kaizen').attr('action', base + 'kaizen/tambah_data');
			});

			// Fungsi edit
			window.edit_kaizen = function(el) {
				const id = $(el).data('id');
				$('#modal_kaizen_title').text('Edit Data Kaizen');
				$('#form_kaizen').attr('action', base + 'kaizen/tambah_data'); // tetap ke controller yg sama

				$.ajax({
					url: base + 'Kaizen/getDataKaizenById/' + id,
					type: 'GET',
					dataType: 'json',
					success: function(res) {
						if (res) {

							console.log(res);
							$('#id_kaizen').val(res.id_kaizen);
							$('select[name="factory"]').val(res.factory).change()
							$('select[name="cell"]').val(res.cell).change()
							$('#total_kaizen').val(res.total_kaizen);
							$('#kaizen_date').val(res.kaizen_date);
						}
					},
					error: function() {
						alert('Gagal mengambil data');
					}
				});
			}

			$("#selectFactory").change(function(e) {
				var f = $("#selectFactory").val();
				// alert(a);
				$.ajax({
						url: base + "home/mssGetCellSewing/" + f,
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
			/* OnChange Date and Building */
			$('#buildingkaizen, #kaizendate').on('change', loadKaizenTable);

		});
	</script>