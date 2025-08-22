<!doctype html>
<html lang="en">

<!-- Header -->
<?php $this->load->view('pars/header') ?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
	<!--begin::App Wrapper-->
	<div class="app-wrapper">
		<!-- NAVBAR -->
		<?php $this->load->view('pars/navbar') ?>
		<!-- SIDEBAR -->
		<!--begin::App Main-->
		<?php $this->load->view('pars/main'); ?>
		<!--end::App Main-->
		<!--begin::Footer-->
		<footer class="app-footer">
			<?php $this->load->view('pars/footer'); ?>
		</footer>
		<!--end::Footer-->
	</div>
	<?php $this->load->view('pars/script'); ?>
</body>

</html>