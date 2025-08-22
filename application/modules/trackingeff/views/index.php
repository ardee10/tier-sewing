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
					<h3 class="mb-0 text-lg-center fw-bold"><?= $title ?></h3>
				</div>

			</div>
			<!--end::Row-->
		</div>
		<!--end::Container-->
	</div>

	<div class="app-content">
		<!--begin::Container-->
		<div class="container-fluid">
			<div class="row mb-3">
				<div class="col-md-12">
					<div class="card card-primary bg-gradient card-outline">
						<div class="card-body">

							<div class="row mb-3 align-items-center">
								<form action="<?= site_url('trackingEff/filterEff') ?>" method="post">
									<div class="row">
										<div class="col-md-3">
											<label for="" class="text-dark">Building</label>
											<select class="form-control" name="building_eff" id="building_eff" required>
												<option value="">--BUILDING--</option>
												<?php foreach ($loopBuilding as $fac) : ?>
													<option <?= $fac->gedung == $building ? 'selected' : '' ?> value="<?php echo $fac->gedung ?>"><?php echo $fac->gedung ?></option>
												<?php endforeach ?>
											</select>
										</div>
										<div class="col-md-3">
											<label for="" class="text-dark">Startdate</label>
											<input type="date" class="form-control" name="startFilter" value="<?= $filterStart ?>" required>
										</div>
										<div class="col-md-3">
											<label for="" class="text-dark">EndDate</label>
											<input type="date" class="form-control" name="endFilter" value="<?= $filterEnd ?>" required>
										</div>
										<div class="col-md-3">
											<label for="" class="text-dark">&nbsp</label>
											<br>
											<button type="submit" class="btn btn-primary text-white"><i class="icofont-search-stock"></i> Filter</button>
											<a type="btn" href="#" onclick="downloadData()" class="btn btn-info text-white"><i class="icofont-download"></i> Download</a>
										</div>
									</div>
								</form>
								<hr>

								<style>
									table {
										position: relative;
									}

									table>thead>tr>th {
										padding: 10px !important;
									}

									table>tbody>tr>td {
										padding: 10px !important;
									}

									tr>th:first-child,
									tr>td:first-child {
										position: sticky;
										left: 0;
									}

									tr>th:nth-child(1),
									tr>td:nth-child(1) {
										position: sticky;
										left: 0;
									}
								</style>

								<div class="table-responsive">
									<table class="table table-hover table-bordered text-xs" style="width: 100%;">
										<thead>
											<tr class="text-light text-center" style="background-color: #5a894f;">
												<th>Cell</th>
												<th class="text-center">#</th>
												<?php foreach ($date as $var) : ?>
													<th><?= date('d M', strtotime($var)) ?></th>
												<?php endforeach ?>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($dataCell as $var) : ?>
												<tr>
													<td rowspan="3" class="text-center align-middle p-0" style="background-color: #5a894f;">
														<div class=" card card-body text-light m-auto text-bold text-md" style="background-color: #5a894f; width: 100px;">
															<?= $var['LINE_NM'] ?>
														</div>
													</td>
												</tr>
												<tr>
													<td class="text-light text-center" style="background-color: #5a894f;">Tgt</td>
													<?php foreach ($var['eff'] as $eff) : ?>
														<td class="bg-light text-center"><?= $eff['tgt_eff'] && $eff['tgt_eff'] != 0.00 ? $eff['tgt_eff'] : '-' ?></td>
													<?php endforeach ?>
												</tr>
												<tr>
													<td class="text-light text-center" style="background-color: #5a894f;">Act</td>
													<?php foreach ($var['eff'] as $eff) : ?>
														<td class="text-bold text-center <?= $eff['colorAct'] ?>"><?= $eff['act_eff'] && $eff['act_eff'] != 0.00 ? $eff['act_eff'] : '-' ?></td>
													<?php endforeach ?>
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
	</div>

	<script>
		function downloadData() {
			let building = $('select[name="building_eff"]').val()
			let start = $('input[name="startFilter"]').val()
			let end = $('input[name="endFilter"]').val()
			let base = $('#base').val()

			location.href = `${base}trackingEff/tracking/${building}/${start}/${end}/download`
		}
	</script>