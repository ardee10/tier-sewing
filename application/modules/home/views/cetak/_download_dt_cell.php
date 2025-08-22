<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?= SITENAME ?></title>
	<!-- favicon -->
	<link rel="icon" type="image/x-icon" href="<?= base_url('assets') ?>/img/3.jpeg">
	<!--begin::Primary Meta Tags-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="title" content="<?= SITENAME ?>" />
	<meta name="author" content="ColorlibHQ" />

	<!-- Custom css -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/mycss.css" />
	<!-- Sweet Alert -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/sweetalert2.min.css" />
	<!-- Icon Font -->
	<link rel="stylesheet" href="<?= base_url('assets/icofont/icofont.min.css') ?>">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url('assets/plugin/dataTables/css/dataTables.bootstrap5.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/plugin/dataTables/css/responsive.bootstrap5.min.css') ?>">
	<!-- AdminLte Css -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css/adminlte.css" />
	<!-- ApexChart -->
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<!-- JQuery -->
	<script src="<?= base_url('assets/'); ?>dist/js/jquery-3.7.1.js"></script>
	<!-- Bootstrap Datepicker CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>plugin/css/bootstrap-datepicker.min.css" />
	<!-- Base Url -->
	<div id="base" data-id="<?= site_url('') ?>"></div>


</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

	<div class="app-wrapper">
		<main class="app-main">
			<div class="app-content">
				<!--begin::Container-->
				<div class="container-fluid">
					<!--begin::Row-->
					<div class="row">
						<h5 class="text-center text-bold">REKAP DOWNTIME</h5>
						<p class="text-center text-bold">CELL : <?= $kode_cell ?> || Tanggal : <?= $this->indo->konversi($tgl) ?></p>


						<div class="table-responsive">
							<table class="table table-striped" style="width:100%" id="table-kaizen">
								<thead class="table-dark rounded-1 mb-1">
									<tr>
										<th>Kode Jam</th>
										<th>Target</th>
										<th>Output</th>
										<th>Status Pencapaian Target</th>
										<th>Downtime</th>
										<th>Lost Pair</th>
										<th>Remark</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$total_dt = 0;
									$total_lost = 0;
									foreach ($downtime as $d): ?>
										<?php switch ($d['STATUS']) {
											case "BELUM":
												$bg = "orange";
												$color = "black";
												break;

											default:
												$color = "white";
												$bg = "green";
												break;
										} ?>
										<?php
										if ($d['STATUS'] == "BELUM" && $d['remark'] == "-") {
											$bgremark = "red";
											$colorremark = "white";
										} else {
											$bgremark = "white";
											$colorremark = "black";
										}
										?>
										<tr>
											<td style="text-align: center"><?= $d['kode_jam'] ?></td>
											<td style="text-align: center"><?= $d['TARGET'] ?></td>
											<td style="text-align: center"><?= $d['SCAN_QTY'] ?></td>
											<td style="background-color: <?= $bg ?>; color: <?= $color ?>; text-align: center"><?= $d['STATUS'] ?></td>
											<td class="text-center" style="background-color: <?= $bgremark ?> ; color: <?= $colorremark ?>"><?= $d['dt_menit'] ?></td>
											<td class="text-center" style="background-color: <?= $bgremark ?> ; color: <?= $colorremark ?>"><?= $d['lost'] ?></td>
											<td class="text-center" style="background-color: <?= $bgremark ?> ; color: <?= $colorremark ?>"><?= $d['remark'] ?></td>
										</tr>
									<?php
										$total_dt 		+=  $d['dt_menit'];
										$total_lost 	+=  $d['lost'];
									endforeach ?>
									<tr style="font-weight: bold; font-size: 20px">
										<td colspan="4" style="text-align: center; padding: 10px"><b>TOTAL</b></td>
										<td class="text-center"><?= $total_dt ?></td>
										<td class="text-center"><?= $total_lost ?></td>
										<td></td>
									</tr>

									<tr>
										<td colspan="7" style="padding: 10px;"></td>
									</tr>
									<tr>
										<td colspan="7" style="padding: 10px;"></td>
									</tr>

									<tr>
										<td rowspan="2" style="text-align: center;  background-color: orange; color: black">Komparasi : </td>
										<td style="text-align: center">Input Manual</td>
										<td style="font-weight: bold; text-align: center"><?= $total_dt ?></td>
									</tr>
									<tr>
										<td style="text-align: center">Rekap Sistem</td>
										<td style="font-weight: bold; text-align: center"><?= $dt_sistem ?></td>
									</tr>
									<tr>
										<td colspan="7" style="padding: 10px;"></td>
									</tr>
									<tr>
										<td style="text-align: center;  background-color: orange; color: black">Analisa : </td>
									</tr>
									<tr style="text-align: center; font-weight: bold;">
										<td style=" background-color: blue; color: white">Remark</td>
										<td style=" background-color: blue; color: white">Total DT Input</td>
										<td style=" background-color: blue; color: white">Presentase</td>
										<td style=" background-color: blue; color: white" colspan="4">Perhitungan ( presentase inputan x Total DT System ) min</td>
									</tr>
									<?php foreach ($komparasi as $k): ?>
										<tr>
											<?php
											$persen = 0;
											if ($persen != 0) {
												$persen = ($k['total'] / $total_dt);
											} else {
												$persen = 0;
											}
											?>
											<td style="word-wrap: break-word; " width="15%"><?= $k['remark'] ?></td>
											<td style="text-align: center"><?= $k['total'] ?></td>
											<td style="text-align: center"><?= number_format($persen * 100, 2) ?>%</td>
											<td style="text-align: center" colspan="4"><?= $persen * $dt_sistem ?></td>
										</tr>
									<?php endforeach ?>
									<tr style="font-weight: bold; font-size: 25px">
										<td style="font-weight: bold; text-align: left" width="15%">TOTAL</td>
										<td style="text-align: center"><?= $total_dt ?></td>
										<td style="text-align: center">100%</td>
										<td style="text-align: center" colspan="4"><?= $dt_sistem ?></td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>

				</div>
				<!--end::Container-->
			</div>
			<!--end::App Content-->
		</main>
		<footer class="app-footer">
			<div class="float-center d-none d-sm-inline text-center">
				<p class="text-center"><?= FOOTER; ?> | <?= DEV; ?> All rights reserved.</p>
			</div>
		</footer>

	</div>


</html>
