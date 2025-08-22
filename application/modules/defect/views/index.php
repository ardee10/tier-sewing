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
					<button type="button" class="btn btn-primary btn-sm" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modal_defect">
						<i class="icofont-plus-circle"></i> Tambah Data
					</button>&nbsp;
					<button type="button" class="btn btn-success btn-sm"><a href="<?= base_url('Defect/import_defect') ?>" class="text-white"><i class="icofont-file-excel"></i> Import Excel</a></button>&nbsp;
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
									<label for="buildingdefect" class="form-label font-weight-bold">BUILDING</label>
									<select class="form-control" id="buildingdefect" name="buildingdefect">
										<option value="semua">SEMUA</option>
										<?php foreach ($factory as $f): ?>
											<option value="<?= $f->gedung ?>"><?= $f->gedung ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<!-- DATE -->
								<div class="col-md-2">
									<label for="defectdate" class="form-label font-weight-bold">DATE</label>
									<input type="date" name="defectdate" id="defectdate" class="form-control" value="<?= date('Y-m-d') ?>" />
								</div>
							</div>

							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="table-defect">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th rowspan="2">No</th>
											<th rowspan="2">Date</th>
											<th rowspan="2">Factory</th>
											<th rowspan="2">Cell</th>
											<th rowspan="2">Model</th>
											<th colspan="2">TOP DEFECT NO.1</th>
											<th colspan="2">TOP DEFECT NO.2</th>
											<th colspan="2">TOP DEFECT NO.3</th>
											<th rowspan="2">Action</th>
										</tr>
										<tr>
											<th>Defect Name</th>
											<th>QTY</th>
											<th>Defect Name</th>
											<th>QTY</th>
											<th>Defect Name</th>
											<th>QTY</th>
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
	<form id="form_defect" action="<?= site_url('defect/tambah_data'); ?>" method="POST">
		<input type="hidden" id="id_defect" name="id_defect" />
		<div class="modal fade" id="modal_defect" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="width: 50px; height: 50px">
						<h5 class=" modal-title text-dark text-bold" id="modal_defect_title" style="font-weight: bold;">Edit Data Defect</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<div class="row g-3">
								<div class="col-md-6">
									<label for="date" class="form-label">Date</label>
									<input type="date" class="form-control" id="defect_date" name="defect_date" placeholder="Date" />
								</div>
								<div class="col-md-6">
									<label for="factory" class="form-label">Factory</label>
									<select class="form-select" id="selectFactory" name="factory">
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
								<div class="col-md-6">
									<label for="model" class="form-label">Model</label>
									<input type="text" class="form-control" id="model" name="model" placeholder="Model" />
								</div>
								<!-- DEFECT NO.1 -->
								<div class="card-header">
									<div class="card-title">DEFECT NO.1</div>
								</div>
								<div class="row defect-group mb-3">
									<div class="col-md-4">
										<label>Defect Category</label>
										<select class="form-select defect-category" name="defect_category" id="defect_category">
											<option value="">--Pilih--</option>
											<?php foreach ($defect as $d): ?>
												<option value="<?= $d->defect_category ?>"><?= $d->defect_category ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="col-md-4">
										<label>Defect Name</label>
										<select class="form-select defect-name" name="defect_name" id="defect_name">
											<option value="">--Pilih--</option>
										</select>
									</div>
									<div class="col-md-4">
										<label>QTY</label>
										<input type="number" class="form-control" name="qty" placeholder="Qty" id="qty" />
									</div>
								</div>

								<!-- DEFECT NO.2 -->
								<div class="card-header">
									<div class="card-title">DEFECT NO.2</div>
								</div>
								<div class="row defect-group mb-3">
									<div class="col-md-4">
										<label>Defect Category</label>
										<select class="form-select defect-category" name="defect_category1" id="defect_category1">
											<option value="">--Pilih--</option>
											<?php foreach ($defect as $d): ?>
												<option value="<?= $d->defect_category ?>"><?= $d->defect_category ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="col-md-4">
										<label>Defect Name</label>
										<select class="form-select defect-name" name="defect_name1" id="defect_name1">
											<option value="">--Pilih--</option>
										</select>
									</div>
									<div class="col-md-4">
										<label>QTY</label>
										<input type="number" class="form-control" name="qty1" placeholder="Qty" id="qty1" />
									</div>
								</div>

								<!-- DEFECT NO.3 -->
								<div class="card-header">
									<div class="card-title">DEFECT NO.3</div>
								</div>
								<div class="row defect-group mb-3">
									<div class="col-md-4">
										<label>Defect Category</label>
										<select class="form-select defect-category" name="defect_category2">
											<option value="">--Pilih--</option>
											<?php foreach ($defect as $d): ?>
												<option value="<?= $d->defect_category ?>"><?= $d->defect_category ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="col-md-4">
										<label>Defect Name</label>
										<select class="form-select defect-name" name="defect_name2" id="defect_name2">
											<option value="">--Pilih--</option>
										</select>
									</div>
									<div class="col-md-4">
										<label>QTY</label>
										<input type="number" class="form-control" name="qty2" placeholder="Qty" id="qty2" />
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

		function loadDefectTable() {
			let building = $('#buildingdefect').val();
			let date = $('#defectdate').val();

			if (building && date) {
				$('#table-defect').DataTable().destroy();
				$('#table-defect').DataTable({
					processing: true,
					serverSide: true,
					pageLength: 10,
					order: [],
					ajax: {
						url: base + `defect/ajax_DefectServerSide/${building}/${date}`,
						type: "POST"
					}
				});
			}
		}

		$(document).ready(function() {
			// Tombol Tambah
			$('#btnTambah').on('click', function() {
				$('#modal_defect_title').text('Tambah Data Defect');
				$('#form_defect')[0].reset();
				$('#id_defect').val(''); // kosongkan hidden input
				$('#form_defect').attr('action', base + 'defect/tambah_data');
			});

			// Fungsi edit
			window.edit_defect = function(el) {
				const id = $(el).data('id');
				// alert(id);
				$('#modal_defect_title').text('Edit Data Defect');
				$('#form_defect').attr('action', base + 'defect/tambah_data'); // tetap ke controller yg sama

				$.ajax({
					url: base + 'Defect/getDataDefectById/' + id,
					type: 'GET',
					dataType: 'json',
					success: function(res) {
						if (res) {

							$('#id_defect').val(res.id_defect);
							$('select[name="factory"]').val(res.factory).change()
							$('select[name="cell"]').val(res.cell).change();
							$('#defect_date').val(res.defect_date);
							$('#model').val(res.model);

							// Defect No.1
							$('select[name="defect_category"]').val(res.defect_category).change();
							setTimeout(() => {
								$('select[name="defect_name"]').val(res.defect_name).change();
							}, 300);
							$('input[name="qty"]').val(res.qty);

							// Defect No.2
							$('select[name="defect_category1"]').val(res.defect_category1).change();
							setTimeout(() => {
								$('select[name="defect_name1"]').val(res.defect_name1).change();
							}, 300);
							$('input[name="qty1"]').val(res.qty1);

							// Defect No.3
							$('select[name="defect_category2"]').val(res.defect_category2).change();
							setTimeout(() => {
								$('select[name="defect_name2"]').val(res.defect_name2).change();
							}, 300);
							$('input[name="qty2"]').val(res.qty2);

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
			$('#buildingdefect, #defectdate').on('change', loadDefectTable);

		});

		//Auto Select Defect Name
		$(".defect-category").on("change", function() {
			let category = $(this).val();
			let nameSelect = $(this).closest(".defect-group").find(".defect-name");

			if (category !== "") {
				$.ajax({
					url: base + 'defect/get_defect_name/',
					type: "POST",
					data: {
						category: category
					},
					dataType: "json",
					success: function(data) {
						let html = '<option value="">--Pilih--</option>';
						$.each(data, function(i, item) {
							html += '<option value="' + item.defect_name + '">' + item.defect_name + '</option>';
						});
						nameSelect.html(html);
					}
				});
			} else {
				nameSelect.html('<option value="">--Pilih--</option>');
			}
		});
	</script>