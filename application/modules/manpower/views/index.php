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
					<button type="button" class="btn btn-primary btn-sm" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modal_mp">
						<i class="icofont-plus-circle"></i> Tambah Data
					</button>&nbsp;
					<button type="button" class="btn btn-success btn-sm"><a href="<?= base_url('Manpower/import_mp') ?>" class="text-white"><i class="icofont-file-excel"></i> Import Excel</a></button>&nbsp;
					<button type="button" class="btn btn-danger btn-sm" id="btn-hapus" data-bs-toggle="modal" data-bs-target="#modal_bulkhapus">
						<i class="icofont-delete-alt"></i> Bulk Hapus
					</button>

				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">
							<div class="row mb-3">
								<!-- BUILDING -->
								<div class="col-md-2">
									<label for="buildingmp" class="form-label font-weight-bold">BUILDING</label>
									<select class="form-control" id="buildingmp" name="buildingmp">
										<option value="semua">SEMUA</option>
										<?php foreach ($factory as $f): ?>
											<option value="<?= $f->gedung ?>"><?= $f->gedung ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<!-- DATE -->
								<div class="col-md-2">
									<label for="mpdate" class="form-label font-weight-bold">DATE</label>
									<input type="date" name="mpdate" id="mpdate" class="form-control" value="<?= date('Y-m-d') ?>" />
								</div>
							</div>

							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="table-mp">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>No</th>
											<th>Factory</th>
											<th>Cell</th>
											<th>Kode Cell</th>
											<th>Date</th>
											<th>MP BZ</th>
											<th>MP Sew-Prep</th>
											<th>Total MP</th>
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
	<form id="form_mp" action="<?= site_url('Manpower/tambah_data'); ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" id="id_mp" name="id_mp" />
		<div class="modal fade" id="modal_mp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width: 50px; height: 50px">
						<h5 class=" modal-title text-dark text-bold" id="modal_mp_title" style="font-weight: bold;">Edit Data ManPower</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<div class="row g-3">
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
									<label for="date" class="form-label">Date</label>
									<input type="date" class="form-control" name="mp_date" id="mp_date" required>
								</div>
								<div class="col-md-4">
									<label for="mp_bz_sew_prep" class="form-label">MP BZ Sew Prep</label>
									<input type="number" class="form-control" name="mp_bz_sew_prep" id="mp_bz_sew_prep" placeholder="0" oninput="hitungMP()">
								</div>
								<div class=" col-md-4">
									<label for="cell" class="form-label">MP Sew Prep</label>
									<input type="number" class="form-control" name="mp_sew_prep" id="mp_sew_prep" placeholder="0" oninput="hitungMP()">
								</div>
								<div class=" col-md-4">
									<label for="cell" class="form-label">Total MP</label>
									<input type="number" class="form-control" name="total_mp_sew" id="total_mp_sew" placeholder="0" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class=" modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- Modal Hapus Berdasarkan Factory dan Tanggal -->
	<form id="form_mp_hapus" action="<?= base_url('Manpower/bulkDelete') ?>" method="POST">
		<div class="modal fade" id="modal_bulkhapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width: 50px; height: 50px">
						<h5 class=" modal-title text-dark text-bold" style="font-weight: bold;">Hapus Data Bersamaan</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<div class="row g-3">
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
									<label for="date" class="form-label">Date</label>
									<input type="date" class="form-control" name="mp_date" id="mp_date" required>
								</div>

							</div>
						</div>
					</div>
					<div class=" modal-footer">

						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</div>
			</div>
		</div>
	</form>



	<script>
		const base = $('#base').data('id');

		function loadmpTable() {
			let building = $('#buildingmp').val();
			let date = $('#mpdate').val();

			if (building && date) {
				$('#table-mp').DataTable().destroy();
				$('#table-mp').DataTable({
					processing: true,
					serverSide: true,
					pageLength: 10,
					order: [],
					ajax: {
						url: base + `Manpower/ajax_ManpowerServerSide/${building}/${date}`,
						type: "POST"
					}
				});
			}
		}

		/* Total MP SEW dan Prep */
		function hitungMP() {
			var e,
				a = $("#mp_bz_sew_prep").val(),
				l = $("#mp_sew_prep").val();
			(e = (a = "" != a ? parseFloat(a) : 0) + (l = "" != l ? parseFloat(l) : 0)), $("#total_mp_sew").val(e);
		}

		$(document).ready(function() {
			// Tombol Tambah
			$('#btnTambah').on('click', function() {
				$('#modal_mp_title').text('Tambah Data ManPower');
				$('#form_mp')[0].reset();
				$('#id_mp').val(''); // kosongkan hidden input
				$('#form_mp').attr('action', base + 'manpower/tambah_data');
			});

			// Fungsi edit
			window.edit_mp = function(el) {
				const id = $(el).data('id');
				$('#modal_mp_title').text('Edit Data ManPower');
				$('#form_mp').attr('action', base + 'manpower/tambah_data');

				$.ajax({
					url: base + 'Manpower/getDataManpowerById/' + id,
					type: 'GET',
					dataType: 'json',
					success: function(res) {
						if (res) {
							console.log(res);
							$('#id_mp').val(res.id_mp);
							$('select[name="factory"]').val(res.factory).change()
							$('select[name="cell"]').val(res.cell).change()
							$('#mp_date').val(res.mp_date);
							$('#kaizen_date').val(res.kaizen_date);
							$('#mp_bz_sew_prep').val(res.mp_bz_sew_prep);
							$('#mp_sew_prep').val(res.mp_sew_prep);
							$('#total_mp_sew').val(res.total_mp_sew);
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
			$('#buildingmp, #mpdate').on('change', loadmpTable);

		});
	</script>