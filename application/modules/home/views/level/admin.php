<style>
	.table-kpi {
		background-image: var(--gradient-table);
		color: white !important;
	}

	.table-kpi .label-kpi {
		font-size: 1.3vw;
		margin-top: 10px;
		margin-bottom: 0 !important;
	}

	.table-kpi-2 .label-kpi-2 {
		font-size: 1.4vw;
		/* background: #007bff; */
		margin-bottom: 0 !important;
		/* background: linear-gradient(to right, #212529, #343a40) !important;
		color: white; */

	}

	.label-kpi-2 {
		font-size: 1.2vw;
	}

	.isian-kpi-2 {
		font-size: 1.3vw;
	}

	.table-kpi-2 .text-btn-table-kpi {
		font-size: 0.5vw;
	}

	.table-kpi-2 .isian-kpi-2 {
		font-size: 1.8vw;
		font-weight: bold;
		text-align: center;
		margin-bottom: 0 !important;
	}

	.table-kpi .text-kpi-value {
		font-size: 3.5em;
		font-weight: bold;
		padding: 0.2em;
		margin-top: 0 !important;
	}

	#imgModel {
		max-width: 200px;
		max-height: 100px;
		height: auto;
		width: auto;
		border-radius: 10px;
		margin-top: 10px;
	}


	#textModelName {
		font-size: 1.5vw;
		margin-bottom: 0 !important;
	}

	.text-model p {
		margin-top: 0 !important;
		margin-bottom: 0 !important;
	}

	.card-kpi-input .label {
		font-size: 1.5vw;
		margin-bottom: 0 !important;
		font-weight: bold;

	}

	.card-kpi-input .a {
		font-size: 1.5vw;
		text-decoration: none;

	}

	.card-kpi-input .isian {
		font-size: 1.9vw;
		margin-bottom: 0 !important;
	}

	.card-kpi-input span {
		font-size: 1.9vw;
		margin-bottom: 0 !important;
	}

	.card-refresh h3 {
		font-size: 1vw;
	}

	.card-refresh h1 {
		/* font-size: 1.5vw; */
		font-size: 1vw;
	}

	.custom-title-box {
		background: linear-gradient(90deg, #0d6efd, #93bcfaff);
		padding: 1rem;
		border-radius: 0.5rem;
		color: #000000;
	}

	.output-box {
		background: linear-gradient(180deg, #0d6efd, #5b9af8ff);

		border-radius: 10px;
		padding: 1rem;
		height: 120px;

		margin-bottom: 1rem;

	}

	.bg-gradient-primary {
		background: linear-gradient(to right, #0d6efd, #0d6dfdbb) !important;
		color: white;
	}

	.bg-gradient-secondary {
		background: linear-gradient(to right, #6c757d, #aeb8c0ff) !important;
		color: white;
	}

	.bg-gradient-success {
		background: linear-gradient(to right, #198754, #3ee798ff) !important;
		color: white;
	}

	.bg-gradient-danger {
		background: linear-gradient(to right, #dc3545, #bb2d3b) !important;
		color: white;
	}

	.bg-gradient-warning {
		background: linear-gradient(to right, #ffc107, #e0a800) !important;
		color: black;
		/* kontras lebih baik */
	}

	.bg-gradient-info {
		background: linear-gradient(to right, #0dcaf0, #31d2f2) !important;
		color: black;
	}

	.bg-gradient-light {
		background: linear-gradient(to right, #f8f9fa, #e9ecef) !important;
		color: black;
	}

	.bg-gradient-dark {
		background: linear-gradient(to right, #212529, #343a40) !important;
		color: white;
	}

	/* Header row */
	#rhead td {
		background: linear-gradient(to right, #6c757d, #565e64);
		color: white;
		vertical-align: middle;
		text-align: center;
	}

	/* Kolom TGT dan ACT */
	#ind,
	#act {
		background: linear-gradient(to right, #6c757d, #565e64);
		color: white;
		text-align: center;
		vertical-align: middle;
	}

	.info-box {
		box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
		border-radius: .25rem;
		background-color: #fff;
		display: flex;
		margin-bottom: 0;
		min-height: 80px;
		padding: .5rem;
	}

	.info-box-content {
		display: flex;
		flex-direction: column;
		justify-content: center;
		line-height: 1.2;
		flex: 1;
		padding: 0 10px;
	}

	.info-box-text {
		display: block;
		font-size: .875rem;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		text-transform: uppercase;
		font-weight: 600;
	}

	.info-box-number {
		display: block;
		font-weight: 700;
		font-size: 1.5rem;
	}

	.card.bg-gradient-primary {
		background: linear-gradient(to right, #4b6cb7, #182848) !important;
		color: white;
	}

	.card.bg-gradient-success {
		background: linear-gradient(to right, #11998e, #11998e) !important;
		color: white;
	}

	.card.bg-gradient-info {
		background: linear-gradient(to right, #1fa2ff, #12d8fa, #a6ffcb) !important;
		color: white;
	}

	.small-box {
		display: block;
		position: relative;
		color: white;
		border-radius: .25rem;
		box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
	}

	.bg-primary {
		background-color: #007bff !important;
	}

	.label {
		font-size: 0.875rem;
		font-weight: 600;
	}

	@media (max-width: 768px) {
		.text-uppercase {
			font-size: 1rem !important;
		}
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
					<h3 class="mb-0 text-lg-center text-uppercase">DASHBOARD</h3>
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
							<div class="row mb-3">
								<div class="col-12 col-md-12 mb-2 mb-md-0">
									<div class="area-critical" hidden>
										<div class="col-12 col-md-12 float-end">
											<div class="info-box mb-3 text-bg-danger float-end animate__animated animate__flash animate__faster">
												<span class="info-box-icon">
													<i class="icofont-truck fw-medium"></i>
												</span>
												<div class="info-box-content">
													<h5 class="info-box-text m-0">CRITICAL DESTINATION</h5>
													<span class="info-box-number fw-bold small" id="no_po_critical"></span>
												</div>
											</div>
										</div>
									</div>

								</div>
								<div class="col-12 col-md-5 mb-2 mb-md-0">
									<div class="custom-title-box bg-gradient-primary rounded-1">
										<div class="inner">
											<h2 class="text-bold text-uppercase text-white text-center mb-0" style="font-size: 1.5rem;">
												Tier Sewing Dashboard Level 1 & 2
											</h2>
										</div>
									</div>
								</div>


								<!-- Filter Section: 7 kolom -->
								<div class="col-12 col-md-7">
									<div class="row">
										<!-- Building -->
										<div class="col-12 col-sm-4 mb-2 mb-sm-0">
											<div class="form-group">
												<label class="label mb-1"><b>Building</b></label>
												<select id="factoryFilterHome" class="form-control form-control-sm" name="factory">
													<option value="">---PILIH---</option>
													<?php foreach ($factory as $f) : ?>
														<option value="<?= $f->gedung ?>"><?= $f->gedung ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>

										<!-- Cell -->
										<div class="col-12 col-sm-4 mb-2 mb-sm-0">
											<div class="form-group">
												<label class="label mb-1"><b>Cell</b></label>
												<select id="cellFilterHome" class="form-control form-control-sm" name="cell">
													<option value="">--- PILIH ---</option>
													<!-- <option value="semua" <?= $cell == 'semua' ? 'selected' : '' ?>>SEMUA</option> -->
													<?php foreach ($cell as $c) : ?>
														<?php if ($c->LINE_CD != 'A953') : ?>
															<option value="<?= $c->LINE_CD ?>" <?= $c->LINE_CD == $cell ? 'selected' : '' ?>><?= $c->LINE_NM ?></option>
														<?php endif ?>
													<?php endforeach ?>
												</select>
											</div>
										</div>
										<!-- Date -->
										<div class="col-12 col-sm-4">
											<div class="form-group">
												<label class="label mb-1"><b>Date</b></label>
												<input type="date" name="dateFilterHome" id="dateFilterHome" class="form-control form-control-sm" value="<?= $tgl ?>">
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class=" row table-kpi">
								<div class="col-md-7">
									<div class="table-responsive mt-2">
										<table class="table responsive table-kpi" id="table-kpi">
											<thead>
												<tr>
													<th class="bg-gradient-secondary rounded-1">
														<!-- <th class="bg-gradient-info"> -->
														<h4 class="text-bold text-center" style="font-family: AdiHausBold; font-weight:bold">TGT OUTPUT</h4>
													</th>

													<th class="bg-gradient-secondary rounded-1">
														<h4 class="text-bold text-center" style="font-family: AdiHausBold; font-weight:bold">ACT OUTPUT</h4>
													</th>
												</tr>
											</thead>
											<tbody>
												<tr class>
													<td class="bg-gradient-secondary rounded-1">
														<div class="bg-gradient-primary rounded text-white mb-2" style="height: 45%">
															<div class="card-body text-center p-0">
																<h2 class="text-bold label-kpi">DAILY</h2>
																<h2 class="text-bold text-kpi-value" id="textTargetDaily">-</h2>
															</div>
														</div>
														<div class="bg-gradient-primary rounded text-white mb-2" style="height: 45%">
															<div class="card-body text-center p-0">
																<h2 class="text-bold label-kpi">HOURLY TARGET</h2>
																<h2 class="text-bold text-kpi-value" id="textTargetHour">-</h2>
															</div>
														</div>
													</td>
													<td class="bg-gradient-secondary rounded-1">
														<div class="bg-gradient-primary rounded text-white mb-2" style="height: 90%">
															<div class="card-body text-center p-0">
																<h2 class="text-bold label-kpi">DAILY</h2>
																<h2 class="text-bold t-shadow-white text-kpi-value" id="textActualDaily">-</h2>
															</div>
														</div>
														<div class="bg-gradient-primary rounded text-white mb-2" style="height: 90%">
															<div class="card-body text-center p-0">
																<H2 class="text-bold label-kpi">HOURLY PRODUCTION</H2>
																<h2 class="text-bold t-shadow-white text-kpi-value" id="textActualHour">-</h2>
															</div>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<!-- KPI -->
									<div class="table-responsive mt-1 table-kpi-2">
										<table class="table responsive table-bordered table-kpi-2">
											<tr id="rhead">
												<td>
													<a href="#" onclick="updateKpi()" class="btn btn-info text-btn-table-kpi text-white text-bold"><i class="icofont-refresh"></i> Perbarui Data KPI</a>
												</td>
												<td class="align-middle p-0" width="15%">
													<h2 class="text-bold label-kpi-2"><small><i class="icofont-users-alt-5 text-warning"></i></small> MP</h2>
												</td>
												<td class="align-middle p-0" width="15%">
													<h2 class="text-bold label-kpi-2"><small><i class="icofont-chart-line text-warning"></i></small> EOLR</h2>
												</td>
												<td class="align-middle p-0" width="15%">
													<h2 class="text-bold label-kpi-2"><small><i class="icofont-memorial text-warning"></i></small> PPH</h2>
												</td>
												<td class="align-middle p-0" width="15%">
													<h2 class="btn btn-warning text-bold label-kpi-2 pointer" onclick="trackingEff(this)"><small><i class="icofont-spreadsheet"></i></small> EFF <small style="font-size: 0.7vw ;">(%)</small></h2>
												</td>
												<td class="align-middle p-0" width="15%">
													<h2 class="text-bold label-kpi-2"><small><i class="icofont-chart-arrows-axis text-warning"></i></small> LLER <small style="font-size: 0.7vw ;">(%)</small></h2>
												</td>
												<td class="align-middle p-0" width="15%">
													<h2 class="text-bold label-kpi-2"><small><i class="icofont-checked text-warning"></i></small> RFT <small style="font-size: 0.7vw ;">(%)</small></h2>
												</td>

											</tr>
											<tr>
												<td id="ind" class="align-middle p-3">
													<h2 class="text-bold label-kpi-2">TGT</h2>
												</td>
												<td class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2" id="textTargetMp">-</h2>
												</td>
												<td class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2" id="textTargetEolr">-</h2>
												</td>
												<td class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2" id="textTargetPph">-</h2>
												</td>
												<td class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2" id="textTargetEff">-</h2>
												</td>
												<td class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2" id="textTargetLler">-</h2>
												</td>
												<td class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2" id="textTargetRft">-</h2>
												</td>


											</tr>
											<tr>
												<td id="act" class="align-middle p-3">
													<h2 class="text-bold label-kpi-2">ACT</h2>
												</td>
												<td rowspan="3" class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2 t-shadow-black" id="textMpActual">-</h2>
												</td>
												<td rowspan="3" class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2 t-shadow-black" id="textActEolr">-</h2>
												</td>
												<td rowspan="3" class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2 t-shadow-black" id="textActPph">-</h2>
												</td>
												<td rowspan="3" class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2 t-shadow-black" id="textRealEff">-</h2>
												</td>
												<td rowspan="3" class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2 t-shadow-black" id="textActLler">-</h2>
												</td>
												<td rowspan="3" class="align-middle p-3">
													<h2 class="text-bold isian-kpi-2 t-shadow-black" id="textActRft">-</h2>
												</td>

											</tr>
										</table>
									</div>
									<!-- KPI -->
								</div>
								<div class="col-md-5">
									<div class="row">
										<div class="col">
											<div id="chart" style="height: 120px;"></div>
											<!-- <div id="chart" style="height:250px;"></div> -->
										</div>
									</div>

									<!-- Model Shoes -->

									<div class="row bg-primary rounded-1 mb-2" style="border-radius: 3px; margin-right: 1px; margin-left: 1px">
										<div class="col d-flex justify-content-center align-content-center p-1">
											<img id="imgModel" src="<?= base_url('assets/img/') ?>no_images.png" alt="kode produk">
										</div>
										<div class="col text-center text-model">
											<h2 class="text-bold mt-2" id="textModelName">-</h2>
											<p class="text-bold" id="textModelArt">-</p>
											<p class="text-bold">LC : <span id="textLc">....</span></p>
											<div class="my-2">
												<a href="#" id="link_layout" hidden class="btn btn-success text-white" style="--bs-btn-padding-y: .25rem; text-decoration:none;--bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Layout</a>
												<a href="#" id="data-flexim" hidden class="btn btn-success btn-sm text-white" style="--bs-btn-padding-y: .25rem; text-decoration:none;--bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Flexim</a>
												<a target="_blank" href="#" id="data-ie" class="btn btn-success btn-sm text-white" style="--bs-btn-padding-y: .25rem; text-decoration:none;--bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">IE Data</a>
											</div>
										</div>
									</div>
									<!-- End Mode Shoe -->
									<div class="row">
										<div class="col-md-4">
											<div class="card card-body bg-primary rounded-1 mb-2 h-80 card-kpi-input p-1">
												<h3 class="text-bold text-center label" style="font-size: medium;">DT <small>(min / pairs)</small></h3>
												<div class="row align-items-center">
													<div class="col text-right">
														<span class="text-bold text-danger t-shadow-black isian" id="textDownTime">-</span>
														<small class="text-white">min</small>
													</div>
													<div class="col text-left">
														<span class="text-bold text-danger t-shadow-black isian" id="textPairDownTime">-</span>
														<small class="text-white">pairs</small>
													</div>
												</div>
												<p class="mt-1 text-center text-sm">
													<a href="#" class="text-white" id="downloadDTCell" style="text-decoration: none;">
														<i class="icofont-folder-open"></i>Lihat Detail
													</a>
												</p>
											</div>
										</div>

										<div class="col-md-2 mb-2">
											<div class="card card-body bg-primary rounded-1 mb-2 text-center h-80 card-kpi-input py-3 d-flex justify-content-center align-content-center">

												<div>
													<h3 class="text-bold label">CO <small style="font-size: 12px;">(Qty)</small></h3>
													<a href="#modalCot" class="text-white" data-bs-toggle="modal" style="text-decoration: none;">
														<h3 class="text-bold t-shadow-black isian" id="textCot">-</h3>
													</a>
												</div>
											</div>
										</div>
										<div class="col-md-3 mb-2">
											<div class="card card-body bg-primary rounded-1 mb-2 text-center h-80 card-kpi-input py-3 d-flex justify-content-center align-content-center">
												<h3 class="text-bold label">6S <small style="font-size: 12px;">(%)</small></h3>
												<a href="#modalSix" class="text-white" data-bs-toggle="modal" style="text-decoration: none;">
													<h1 class="text-bold t-shadow-black isian" id="textAccident">-</h1>
												</a>
											</div>
										</div>

										<div class="col-md-3 mb-2">
											<div class="card card-body bg-primary rounded-1 mb-2 text-center h-80 card-kpi-input py-3 d-flex justify-content-center align-content-center">
												<h3 class="text-bold label">KAIZEN <small style="font-size: 12px;"></small></h3>
												<a href="#modalKaizen" class="text-white" id="link_Kaizen" data-bs-toggle="modal" style="text-decoration: none;">
													<h1 class="text-bold t-shadow-black isian" id="textKaizen">-</h1>
												</a>
											</div>
										</div>

									</div>
									<div class="row">
										<!-- Accident Safety -->
										<div class="col-md-5 mb-2">
											<div class="table-responsive">
												<div class="row mb-2" style="border-radius: 3px; margin-right: 1px; margin-left: 1px">
													<table class="table table-responsive table-striped">
														<thead>
															<tr>
																<th id="act" colspan="4">
																	<p class="text-uppercase text-left text-bold"><span><i class="icofont-medical-sign text-danger"></i></span> SAFETY </p>
																</th>
															</tr>
															<tr>
																<th id="act">NLTI</th>
																<th id="act">LTI</th>
																<th id="act">T NLTI</th>
																<th id="act">T LTI</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td class="text-center" style="font-weight: bold;" id="nlti">-</td>
																<td class="text-center" style="font-weight: bold;" id="lti">-</td>
																<td class="text-center" style="font-weight: bold;" id="total_nlti">-</td>
																<td class="text-center" style="font-weight: bold;" id="total_lti">-</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="col-md-7 mb-2">
											<!-- TOP DEFECT -->
											<div class="table-responsive">
												<div class="row mb-2" style="border-radius: 3px; margin-right: 1px; margin-left: 1px">
													<table class="table table-responsive table-striped">
														<thead>
															<tr>
																<th id="act">
																	<p class="text-uppercase text-left text-bold"><span><i class="icofont-listing-number text-warning"></i></span> QTY </p>
																</th>
																<th id="act">
																	<p class="text-uppercase text-left text-bold"><span><i class="icofont-book-alt text-warning"></i></span> DEFECT NAME </p>
																</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td class="text-center" style="font-weight: normal;" id="textQty">-</td>
																<td class="text-left" style="font-weight: normal;" id="textdefectName">-</td>
															</tr>
															<tr>
																<td class="text-center" style="font-weight: normal;" id="textQty1">-</td>
																<td class="text-left" style="font-weight: normal;" id="textdefectName1">-</td>
															</tr>
															<tr>
																<td class="text-center" style="font-weight: normal;" id="textQty2">-</td>
																<td class="text-left" style="font-weight: normal;" id="textdefectName2">-</td>
															</tr>

														</tbody>
													</table>
												</div>
											</div>
										</div>

									</div>

									<div class="row">
										<div class="col-8 mb-2">
											<div class="bg-gradient-success text-center card-filter card-refresh p-2">
												<?php
												$jam = date('H');
												if ($jam >= 8) { ?>
													<h3><b><i class="icofont-info-circle text-danger"></i> Note:</b> <span class="text-muted"></span>data diupdate setiap <span class="text-warning text-bold"><?= REFRESHSIANG / 60 ?> mnt <small>( <?= REFRESHSIANG ?> sec )</small></span></h3>
												<?php } else { ?>
													<h3><b><i class="icofont-info-circle text-danger"></i> Note:</b> <span class="text-muted"></span>data diupdate setiap <span class="text-warning text-bold"><?= REFRESHPAGI / 60 ?> mnt <small>( <?= REFRESHPAGI ?> sec )</small></span></h3>
												<?php } ?>

											</div>
										</div>
										<div class="col-4">
											<div class="bg-gradient-success text-center card-filter p-1 card-refresh">
												<span>Waktu Refresh</span>
												<?php
												$jam = date('H');
												if ($jam >= 8) { ?>
													<h1 id="timer" class="m-0 p-0"><?= REFRESHSIANG ?></h1>
												<?php } else { ?>
													<h1 id="timer" class="m-0 p-0"><?= REFRESHPAGI ?></h1>
												<?php } ?>

											</div>
										</div>
									</div>
								</div>
								<!-- End Defect -->
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel"> -->
	<div class="modal fade" id="loadingModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
					<p class="mt-2">Sedang memuat...</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Kaizen -->
	<div class="modal fade" id="modalKaizen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark text-bold"><i class="icofont-brainstorming"></i> KAIZEN</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<img id="iframeKaizen" class="w-100">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal SixS -->
	<div class="modal fade" id="modalSix" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark text-bold"><i class="icofont-check-circled"></i> 6S</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<img id="iframeSix" class="w-100">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Cot -->
	<div class="modal fade" id="modalCot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark text-bold"><i class="icofont-ui-timer"></i> COT</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<img id="iframeCot" class="w-100">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Flexim -->
	<div class="modal fade" id="modalFlexim" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark text-bold"><i class="icofont-video-alt"></i> Flexim</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<!-- <img id="iframeFlexim" class="w-100"> -->
						<iframe src="#" width="100%" height="400" frameborder="0" id="iFrameFlexim" allowfullscreen>
						</iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Layout -->
	<div class="modal fade" id="modalLayout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark text-bold"><i class="icofont-layout"></i> Layout</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<!-- <img id="iframeFlexim" class="w-100"> -->
						<iframe src="#" style="width:100%; height:800px;" frameborder="0" id="iframeLayout" class="text-center">
						</iframe>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Downtime -->
	<div class="modal fade" id="modalDowntime" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDowntimeLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark text-bold" id="modalDowntimeLabel">
						<i class="icofont-clock-time"></i> Tambah Downtime ( KODE JAM : <span class="text-danger text-bold" id="kode_jam"></span> )
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<form>
							<div class="row g-3">
								<div class="col">
									<div class="mb-3">
										<label for="text_kode_jam" class="form-label">Kode Jam</label>
										<input type="text" name="kode_jam" id="text_kode_jam" readonly class="form-control" required>
									</div>
								</div>
								<div class="col">
									<div class="mb-3">
										<label for="text_menit_jam" class="form-label">Menit DT</label>
										<input type="text" name="menit_dt" id="text_menit_jam" readonly class="form-control" required>
									</div>
								</div>
								<div class="col">
									<div class="mb-3">
										<label for="text_lost_dt" class="form-label">Lost Pair</label>
										<input type="text" name="lost_dt" id="text_lost_dt" readonly class="form-control" required>
									</div>
								</div>
							</div>

							<div class="row g-3">
								<div class="col-md-3">
									<div class="mb-3">
										<label for="kelompok_dt" class="form-label">Kelompok Downtime</label>
										<select name="kelompok_dt" id="kelompok_dt" class="form-select" required>
											<option value="">--PILIH--</option>
											<?php foreach ($dt as $d) : ?>
												<option value="<?= $d->kelompok ?>"><?= strtoupper(str_replace('_', ' ', $d->kelompok)) ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="col">
									<div class="mb-3">
										<label for="remark_dt" class="form-label">DownTime Remark</label>
										<select name="remark" id="remark_dt" class="form-select" required>
											<option value="">--PILIH REMARK--</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row g-3">
								<div class="col text-end">
									<button type="submit" class="btn btn-success" id="simpan_dt">
										<i class="icofont-save"></i> <span id="text-btn">Simpan Downtime</span>
									</button>
								</div>
							</div>
						</form>

						<div class="row mt-3">
							<div class="col">
								<div class="app-table"></div>
							</div>
						</div>

						<div class="mt-3 mb-3" style="height: 1px; background-color: #E1E5EA;"></div>

						<div class="row">
							<div class="col text-end">
								<button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">
									<i class="icofont-ui-close"></i> Close
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Rekap Downtime -->
	<div class="modal fade" id="modalRekapDT" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark text-bold"><i class="icofont-data text-success"></i> Rekap Downtime</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<iframe src="#" style="width:100%; height: 1000px;;" frameborder="0" id="frameDT" class="text-center">
						</iframe>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		const base = $('#base').data('id');
		let grafikData;
		//Load Data KPI										
		function loadDataKpi() {

			let f = $('#factoryFilterHome').val(); // factory
			let c = $('#cellFilterHome').val(); // cell
			let d = $('#dateFilterHome').val(); // date

			// Validasi input (pastikan cell dan tanggal tidak kosong)
			if (c !== "" && d !== "") {
				// Tampilkan loading modal jika ada
				$('#loadingModal').modal('show');
				// Lakukan AJAX
				$.ajax({
					url: base + 'Home/ajaxfilterKpi/' + f + '/' + c + '/' + d,
					type: 'GET',
					dataType: 'JSON',
					success: function(res) {

						if (res.status === 'success' && res.data && Object.keys(res.data).length > 0) {
							setTimeout(function() {
								$('#loadingModal').modal('hide');
								$('#loadingModal').removeClass('show').addClass('hide').css('display', 'none');
								$('body').removeClass('modal-open');
								$('.modal-backdrop').remove();
							}, 1000); // Sembunyikan setelah 1 detik
							/* KPI DATA */
							let a = parseFloat(res.data.target_output) > parseFloat(res.data.actual_output) ? "red" : "#6ECB63";
							let l = parseFloat(res.data.target_output_perjam) > parseFloat(res.data.actual_output_last) ? "red" : "#6ECB63";

							//Critical Destination cek
							if (res.data.critical_destination) {
								$("#form-filter-critical").attr("hidden", false);
								$(".area-critical").attr("hidden", false);
								$(".area-non-critical").attr("hidden", true);
								$("#no_po_critical").text('PO NUMBER : ' + res.data.no_po);
							} else {
								$("#form-filter-critical").attr("hidden", true);
								$(".area-critical").attr("hidden", true);
								$(".area-non-critical").attr("hidden", false);
							}

							// Set warna
							$("#textActualDaily").css("color", a);
							$("#textActualHour").css("color", l);
							// KPI
							$("#textTargetDaily").text(Number(res.data.target_output).toLocaleString());
							$("#textTargetHour").text(Number(res.data.target_output_perjam).toLocaleString());
							$("#textActualDaily").text(Number(res.data.actual_output).toLocaleString());
							$("#textActualHour").text(Number(res.data.actual_output_last).toLocaleString());
							// DOWNTIME
							let targetOutput = res.data.target_output ? parseFloat(res.data.target_output) : 0;
							let actualOutput = res.data.actual_output ? parseFloat(res.data.actual_output) : 0;
							let taktTime = res.data.jam ? parseFloat(res.data.jam) : 0;
							// Panggil function yang sudah kita buat
							getDowntime(targetOutput, actualOutput, taktTime);
							//MODEL
							$("#textModelName").text(res.data.model_actual);
							$("#textModelArt").text(res.data.artikel_actual);
							$("#textLc").text(res.data.lc_model);
							$("#textKaizen").text(res.data.kaizen);
							$("#textCot").text(res.data.cot);
							//Defect Data
							$("#textQty").text(res.data.qty);
							$("#textdefectName").text(res.data.defect_name);
							$("#textQty1").text(res.data.qty1);
							$("#textdefectName1").text(res.data.defect_name1);
							$("#textQty2").text(res.data.qty2);
							$("#textdefectName2").text(res.data.defect_name2);
							let o = res.data.six_s,
								i = "";
							(o = o ? parseFloat(o) : 0), (i = o >= 80 ? "#25ef25" : o >= 60 && o < 80 ? "yellow" : o >= 30 && o < 60 ? "#839AA8" : "red"), $("#textAccident").css("color", i), $("#textAccident").text(o);
							/* MEDIA IMAGES*/
							let r = base + 'assets/';
							/* MODEL */
							$("#imgModel").attr("src", r + "img/product_model/" + res.data.ART_IMAGE);
							/* LAYOUT IFRAME*/
							$("#iframeLayout").attr("src", r + "layout/" + res.data.layout);
							// Tampilkan tombol layout jika layout bukan 'no_data.pdf'
							if (res.data.layout !== "no_data.pdf") {
								$("#link_layout").attr("hidden", false);
								$("#link_layout").on("click", function() {
									$("#modalLayout").modal("show");
								});
							} else {
								$("#link_layout").attr("hidden", true);
							}

							if (res.data.kaizen_file === "no_images.png" || res.data.kaizen_file === null) {
								$("#iframeKaizen").attr("src", r + "img/no_images.png");
							} else {
								$("#iframeKaizen").attr("src", r + "img/kaizen_file/" + res.data.kaizen_file);
							}
							// Tampilkan gambar COT
							if (res.data.fil_cot === "no_images.png" || res.data.file_cot === null) {
								$("#iframeCot").attr("src", r + "img/no_images.png");
							} else {
								$("#iframeCot").attr("src", r + "img/cot_file/" + res.data.file_cot);
							}
							// Tampilkan gambar Six S
							if (res.data.file_six === "no_images.png" || res.data.file_six === null) {
								$("#iframeSix").attr("src", r + "img/no_images.png");
							} else {
								$("#iframeSix").attr("src", r + "img/sixs_file/" + res.data.file_six);
							}

							// Tampilkan video Flexim apabila ada
							if (res.data.flexim && res.data.flexim.length > 0) {
								$("#data-flexim").removeAttr("hidden").off("click").on("click", function() {
									$.ajax({
										url: base + "home/cekFleximdata",
										type: "post",
										data: {
											id_data: res.data.flexim
										},
										success: function() {
											$("#iFrameFlexim").attr("src", r + "fleximData/" + res.data.flexim);
											$("#modalFlexim").modal("show");
										}
									});
								});
							} else {
								$("#data-flexim").attr("hidden", true);
							}
							/* TARGET KPI */
							$("#textTargetMp").text(parseFloat(res.data.kpi_target_mp));
							$("#textTargetEolr").text(res.data.kpi_target_eolr);
							$("#textTargetPph").text(parseFloat(res.data.kpi_target_pph).toFixed(2));
							$("#textTargetEff").text(parseFloat(res.data.kpi_target_eff).toFixed(1));
							$("#textTargetLler").text(res.data.kpi_target_ller);
							$("#textTargetRft").text(res.data.kpi_target_rft);

							/* ACTUAL */
							let n = parseFloat(res.data.kpi_target_mp) < parseFloat(res.data.kpi_act_mp) ? "red" : "#6ECB63";
							$("#textMpActual").css("color", n), $("#textMpActual").text(res.data.kpi_act_mp);

							let s = parseFloat(res.data.kpi_target_eolr) > parseFloat(res.data.kpi_act_eolr) ? "red" : "#6ECB63";
							$("#textActEolr").css("color", s), $("#textActEolr").text(parseFloat(res.data.kpi_act_eolr).toFixed(0));

							let d = parseFloat(res.data.kpi_target_pph) > parseFloat(res.data.kpi_act_pph) ? "red" : "#6ECB63";
							$("#textActPph").css("color", d), $("#textActPph").text(parseFloat(res.data.kpi_act_pph).toFixed(2));

							let m = parseFloat(res.data.kpi_target_eff) > parseFloat(res.data.kpi_act_eff) ? "red" : "#6ECB63";
							$("#textRealEff").css("color", m), $("#textRealEff").text(parseFloat(res.data.kpi_act_eff).toFixed(1));

							let c = parseFloat(res.data.kpi_target_ller) > parseFloat(res.data.kpi_act_ller) ? "red" : "#6ECB63";
							$("#textActLler").css("color", c), $("#textActLler").text(parseFloat(res.data.kpi_act_ller).toFixed(0));

							let p = parseFloat(res.data.kpi_target_rft) > parseFloat(res.data.kpi_act_rft) ? "red" : "#6ECB63";
							$("#textActRft").css("color", p);
							$("#textActRft").text(parseFloat(res.data.kpi_act_rft).toFixed(1))

							let z = res.data.nlti;
							let kk = (z != 0) ? "red" : "#6ECB63";
							$("#nlti").css("color", kk), $("#nlti").text(res.data.nlti);

							let y = res.data.lti;
							let ky = (y != 0) ? "red" : "#6ECB63";
							$("#lti").css("color", ky), $("#lti").text(res.data.lti);

							let h = res.data.total_lti;
							let kh = (h != 0) ? "red" : "#6ECB63";
							$("#total_lti").css("color", kh), $("#total_lti").text(res.data.total_lti);

							let ix = res.data.total_nlti;
							let kj = (ix != 0) ? "red" : "#6ECB63";
							$("#total_nlti").css("color", kj), $("#total_nlti").text(res.data.total_nlti);

							let grafikData = JSON.parse(res.data.grafik);
							console.log('DATA KPI:', grafikData);
							chart.updateOptions({
								series: [{
									data: JSON.parse(res.data.grafik)
								}],
								chart: {
									toolbar: {
										show: !1
									}
								},
								annotations: {
									yaxis: [{
										y: res.data.kpi_target_eolr,
										borderColor: "#0F00FF",
										label: {
											borderColor: "#0F00FF",
											text: res.data.kpi_target_eolr
										}
									}]
								},
								colors: [
									function({
										value: t,
										seriesIndex: a,
										w: l
									}) {
										return t <= (89 / 100) * res.data.kpi_target_eolr ? "#ff0000" : "#00A19D";
									},
								],
							});
						} else {
							alert('Data tidak ditemukan.');
						}
					},
					error: function() {
						$('#loadingModal').modal('hide');
						alert('Gagal mengambil data dari server.');
					},
					complete: function() {
						// Sembunyikan loading modal setelah selesai
						setTimeout(function() {
							$('#loadingModal').modal('hide');
							$('#loadingModal').removeClass('show').addClass('hide').css('display', 'none');
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
						}, 9000); // Sembunyikan setelah 1 detik
					}
				});

			} else {
				alert('Silakan isi Cell dan Tanggal terlebih dahulu.');
			}
		}
		$(document).ready(function() {
			/* Factory Filter Home */
			$("#factoryFilterHome").change(function() {
				let factory = $(this).val();
				if (factory !== "") {
					$.ajax({
							url: base + `home/mssGetCellSewing/` + factory,
							type: "get",
							dataType: "json"
						})
						.done(function(response) {
							$("#cellFilterHome").attr("disabled", false);
							$("#dateFilterHome").attr("disabled", false);

							let html = "<option value=''>--- PILIH ---</option>";
							// html += "<option value='semua'>SEMUA</option>";

							response.forEach(cell => {
								if (cell.LINE_CD !== "A953") {
									html += `<option value="${cell.LINE_CD}">${cell.LINE_NM}</option>`;
								}
							});

							$("#cellFilterHome").html(html);
						})
						.fail(function() {
							console.log("Gagal mengambil data cell");
						});
				}
			});
			let refreshIntervalId = null;
			let countdownIntervalId = null;

			$('#cellFilterHome, #dateFilterHome').on('change', function() {
				let c = $('#cellFilterHome').val();
				let d = $('#dateFilterHome').val();

				if (c !== "" && d !== "") {
					loadDataKpi();

					let refreshInterval = parseFloat($("#refresh").data("id"));
					let timerCountdown = refreshInterval;

					// Bersihkan interval lama agar tidak ganda
					if (refreshIntervalId) clearInterval(refreshIntervalId);
					if (countdownIntervalId) clearInterval(countdownIntervalId);

					// Interval untuk countdown timer
					countdownIntervalId = setInterval(() => {
						let now = new Date();
						let currentTime =
							now.getHours() + ":" +
							String(now.getMinutes()).padStart(2, '0') + ":" +
							String(now.getSeconds()).padStart(2, '0');

						// Reload jika jam menunjukkan 08:00:01
						if (currentTime === "8:00:01") {
							location.reload();
						}

						// Update countdown
						timerCountdown--;
						$("#timer").text(timerCountdown);
					}, 1000);

					// Interval untuk refresh data KPI
					refreshIntervalId = setInterval(() => {
						loadDataKpi();
						timerCountdown = refreshInterval;
						$("#timer").text(refreshInterval);
					}, refreshInterval * 1000);
				}
			});
		});
		// Fungsi untuk menghitung downtime secara akumulasi per jam kerja
		function getDowntime(targetOutput, actualOutput, taktTime) {
			// Pastikan semua parameter adalah angka
			targetOutput = parseFloat(targetOutput) || 0;
			actualOutput = parseFloat(actualOutput) || 0;
			taktTime = parseFloat(taktTime) || 0; // --> ini dari mana ?

			// Hitung loss pair (selisih target dan aktual)
			let lossPair = targetOutput - actualOutput;
			if (lossPair < 0) lossPair = 0;

			// Hitung downtime dalam detik dan menit
			let downtimeSeconds = lossPair * taktTime;
			let downtimeMinutes = downtimeSeconds / 60; // Konversi ke menit
			// Set hasil ke elemen HTML
			$("#textDownTime").text(downtimeMinutes.toFixed(0)); // downtime dalam menit
			$("#textPairDownTime").text(lossPair);

		}
		/* Dontime pairs and time */
		$("#downloadDTCell").click(function() {
			// alert("Fitur ini akan segera hadir. Silakan hubungi tim IT untuk informasi lebih lanjut.");
			// Ambil nilai filter
			const cell = $("#cellFilterHome").val();
			const date = $("#dateFilterHome").val();
			const targetHour = $("#textTargetHour").text();
			const downTime = $("#textDownTime").text();
			const pairDownTime = $("#textPairDownTime").text();

			// alert(date);

			// Bentuk URL download
			const urlDowntime = `${base}home/downloadDTCell/${cell}/${date}/${targetHour}/${downTime}/${pairDownTime}`;

			console.log("URL Downtime:", urlDowntime);

			// Set iframe untuk preview/download
			$("#frameDT").attr("src", urlDowntime);

			// Tampilkan modal
			$("#modalRekapDT").modal("show");
		});
		/* detail donwtime */
		$("#kelompok_dt").change(function() {
			let selected = $(this).val();
			$.ajax({
					url: base + "home/ajaxGetDtDetil/" + selected,
					type: "GET",
					dataType: "json"
				})
				.done(function(response) {
					let options = "<option value=''>--- PILIH ---</option>";
					response.forEach(item => {
						options += `<option value="${item.remark}">${item.remark}</option>`;
					});
					$("#remark_dt").html(options);
				})
				.fail(function() {
					console.error("Gagal mengambil data remark downtime");
				});
		});
		// Simpan downtime
		$("#simpan_dt").click(function() {
			let menit = $("#text_menit_jam").val(),
				lost = $("#text_lost_dt").val(),
				kodeJam = $("#text_kode_jam").val(),
				remark = $("#remark_dt").val(),
				factory = $("#factoryFilterHome").val(),
				cell = $("#cellFilterHome").val(),
				tanggal = $("#dateFilterHome").val();
			// Data yang dikirim ke server
			let data = {
				kode_jam: kodeJam,
				LINE_CD: cell,
				kode_factory: factory,
				tanggal_dt: tanggal,
				remark: remark,
				lost_dt: lost,
				menit_dt: menit
			};
			// Validasi dan konfirmasi
			if (!confirm("Apakah data yang Anda masukkan sudah benar? Data tidak bisa diedit.")) {
				return;
			}

			if (remark === "") {
				alert("Remark belum diisi");
				return;
			}
			// Disable tombol simpan sementara
			$("#simpan_dt").attr("disabled", true);
			$("#text-btn").val("Mengirim...");
			// Kirim data via AJAX
			$.ajax({
					url: base + "home/ajaxSimpanDt/",
					type: "POST",
					dataType: "json",
					data: data
				})
				.done(function(response) {
					alert(response.msg);

					if (response.kode === "success") {
						let newRow = `
				<tr class="bg-white">
					<td>${kodeJam}</td>
					<td>${menit}</td>
					<td>${lost}</td>
					<td>${remark}</td>
				</tr>
			`;

						$(".app-table tr:last").after(newRow);
					}
				})
				.fail(function() {
					console.error("Gagal menyimpan data downtime");
				})
				.always(function() {
					// Re-enable tombol
					$("#simpan_dt").attr("disabled", false);
					$("#text-btn").val("Simpan DownTime");
				});
		});
		//Update data KPI

		function updateKpi() {
			// alert('ASASA');
			let factory = $('#factoryFilterHome').val(); // factory
			let cell = $('#cellFilterHome').val(); // cell
			let date = $('#dateFilterHome').val(); // date

			$.ajax({
				type: "GET",
				url: `${base}home/perbaruiDataKpi/${factory}/${cell}/${date}`,
				dataType: "json",
				success: function() {
					loadDataKpi();
				},
			});

		}

		function trackingEff() {

			let building = $('#factoryFilterHome').val();
			let tgl = $('#dateFilterHome').val();

			window.open(base + 'trackingEff/tracking/' + building + '/' + tgl + '/' + tgl);
		}
	</script>