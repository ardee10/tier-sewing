<style>
	a {
		text-decoration: none !important;
	}


	.bg-gradient-danger {
		background: linear-gradient(to right, #dc3545, #bb2d3b) !important;
		color: white;
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
		<!-- <div class="container-fluid"> -->
		<div class="container-sm">

			<?php if ($this->session->flashdata('message')): ?>
				<div class="flash-data"
					data-flashdata='<?= htmlspecialchars(json_encode($this->session->flashdata("message")), ENT_QUOTES, "UTF-8") ?>'></div>
			<?php endif; ?>


			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">
							<div class="info-box text-bg-danger bg-gradient">
								<span class="info-box-icon"> <i class="bi bi-bookmark-fill"></i> </span>
								<div class="info-box-content">
									<div class="row mb-3">
										<div class="col-md-6">
											<label for="date_critical" class="form-label font-weight-bold">Setting Tanggal Pekerjaan</label>
											<input type="date" name="date_critical" id="date_critical" class="form-control" value="<?= $tanggal_kerja; ?>">
										</div>
										<div class="col-md-6">
											<div class="callout bg-gradient-danger rounded-1">
												<label for="Ubah Dropdown" class="form-label">
													<h4 class="text-uppercase">Ubah Dropdown menjadi Critical Destination senyesuaikan dengan Cell</h4>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Isian disini -->
							<div class="table-responsive bi-boxes">
								<table class="table table-striped" style="width:100%" id="table-critical">
									<thead class="table-primary text-white rounded-1 mb-1">
										<tr>
											<th>No</th>
											<th>Factory</th>
											<th>Cell</th>
											<th>Line Code</th>
											<th>Status</th>
											<th>PO Number</th>

										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										foreach ($cell as $var) : ?>
											<?php
											$cssTable = ($var['critical']) ? 'bg-select text-white' : '';
											$cssDropdown = ($var['critical']) ? 'bg-danger text-white' : '';
											?>
											<tr class="<?= $cssTable ?>">
												<td class="font-weight-bold text-center"><?= $no++; ?></td>
												<td class="font-weight-bold text-center"><?= $var['kode_factory'] ?></td>
												<td class="font-weight-bold text-center"><?= $var['id_cell'] ?></td>
												<td class="font-weight-bold text-center"><?= $var['nama_cell'] ?></td>
												<td class="text-center">
													<select name="critical" id="critical-option" class="form-control pointer critical-option <?= $cssDropdown ?>" data-id="<?= $var['id_cell'] ?>" data-factory="<?= $var['kode_factory'] ?>">
														<option value="N" <?= $var['critical'] ? '' : 'selected' ?>>Non critical</option>
														<option value="Y" <?= $var['critical'] ? 'selected' : '' ?>>Critical Destination</option>
													</select>
												</td>
												<td class="text-center align-middle">
													<input type="text" class="form-control font-weight-bold <?= $cssDropdown ?>" placeholder="inputkan No Po" name="no_po" value="<?= $var['no_po'] ?>" data-id="<?= $var['id_cell'] ?>" data-factory="<?= $var['kode_factory'] ?>" oninput="po_critical(this)">
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

	<!-- Modal -->


	<script>
		const base = $('#base').data('id');

		$(document).ready(function() {
			$('#date_critical').on('change', function() {
				let tanggal = $(this).val()
				location.href = base + 'critical/index/' + tanggal
			})

			$('.critical-option').on('change', function() {
				let option = $(this)
				let val = option.val()
				let tanggal = $('#date_critical').val()
				let id_cell = $(this).data('id')
				let kode_factory = $(this).data('factory')
				let no_po = option.closest('tr').find('input[name="no_po"]')

				if (tanggal == null) {
					alert('Tanggal Kerja Belum Diisi')
				} else {
					if (val == 'Y') {
						$.ajax({
							type: "post",
							url: `${base}critical/eksekusi`,
							data: {
								'id_cell': id_cell,
								'kode_factory': kode_factory,
								'tanggal_kerja': tanggal,
								'no_po': no_po.val()
							},
							dataType: "json",
							success: function(res) {
								option.addClass('bg-danger text-white');
								option.closest('tr').addClass('bg-select text-white');
								no_po.addClass('bg-danger text-white')
							},
							error: function(error) {
								no_po.removeClass('bg-danger text-white')
								option.removeClass('bg-danger text-white');
								option.closest('tr').removeClass('bg-select text-white');
							},
						});
					} else {
						$.ajax({
							type: "post",
							url: `${base}critical/hapusCellCritical`,
							data: {
								'id_cell': id_cell,
								'kode_factory': kode_factory,
								'tanggal_kerja': tanggal,
							},
							dataType: "json",
							success: function(res) {
								no_po.val("")
								no_po.removeClass('bg-danger text-white')
								option.removeClass('bg-danger text-white');
								option.closest('tr').removeClass('bg-select text-white');
							}
						});
					}
				}

			});
		});

		function po_critical(ctx) {
			let option = $(ctx)
			let no_po = option.val()
			let tanggal = $('#date_critical').val()
			let id_cell = $(ctx).data('id')
			let kode_factory = $(ctx).data('factory')
			let critical = option.closest('tr').find('.critical-option').val();
			if (critical == 'Y') {
				$.ajax({
					type: "post",
					url: `${base}critical/eksekusiPo`,
					data: {
						'id_cell': id_cell,
						'kode_factory': kode_factory,
						'tanggal_kerja': tanggal,
						'no_po': no_po
					},
					dataType: "json",
					success: function(res) {
						console.log(res);
					},
					error: function(error) {
						console.log(error);
					},
				});
			}
		}
	</script>