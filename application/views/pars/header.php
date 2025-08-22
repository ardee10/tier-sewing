<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?= SITENAME ?></title>
	<!-- favicon -->
	<link rel="icon" type="image/x-icon" href="<?= base_url('assets') ?>/img/3.jpeg">
	<!--begin::Primary Meta Tags-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="title" content="<?= SITENAME ?>" />
	<meta name="author" content="ColorlibHQ" />

	<!-- ApexChart -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css/apexcharts.css" />
	<!-- Annimation Effetc -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css/animate.min.css" />
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
	<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

	<!-- JQuery -->
	<script src="<?= base_url('assets/'); ?>dist/js/jquery-3.7.1.js"></script>

	<!-- Bootstrap Datepicker CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>plugin/css/bootstrap-datepicker.min.css" />

	<!-- Base Url -->
	<div id="base" data-id="<?= site_url('') ?>"></div>

	<!-- Refresh Time -->
	<?php
	$jam = date('H');
	if ($jam >= 8) { ?>
		<div id="refresh" data-id="<?= REFRESHSIANG ?>"></div>
	<?php
	} else {

	?>
		<div id="refresh" data-id="<?= REFRESHPAGI ?>"></div>

	<?php

	} ?>

</head>
