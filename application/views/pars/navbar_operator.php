<nav class="app-header navbar navbar-expand bg-body">
	<div class="container-fluid">
		<ul class="navbar-nav">
			<nav class="navbar navbar-expand-lg navbar-light">

				<a href="#" class="navbar-brand"> <img src="<?= base_url('assets'); ?>/img/logo/logo-dash.png" alt=""></a>

			</nav>
		</ul>
		<ul class="navbar-nav ms-auto">
			<li class="nav-item dropdown user-menu">
				<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

					<p class="d-flex align-items-center">
						<i class="bi bi-person-circle"></i> <?php echo strtoupper($this->session->userdata('ses_display')) == null ? 'OPERATOR' : strtoupper($this->session->userdata('ses_display')); ?>
					</p>
				</a>

				<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
					<li class="user-header">
						<div class="media">
							<img src="<?= base_url('assets/img/') ?>3.jpeg" alt="User Avatar" class="img-size-50 mr-3 img-circle rounded-2">
						</div>
						<p><?php echo strtoupper($this->session->userdata('ses_display')) == null ? 'OPERATOR' : strtoupper($this->session->userdata('ses_display')); ?></p>
						<p><?php echo $this->session->userdata('user_id') == null ? '<span class="text-danger">Anda Belum Login</span>' : '<span class="text-success">Sesi Login Anda Telah Aktif</span>' ?></p>
					</li>

					<li class="user-footer">
						<!-- <a href="#" class="btn btn-default btn-flat"><?= $operator->level;  ?></a> -->
						<a href="<?= base_url('Auth/logout_op') ?>" class="btn btn-danger btn-sm float-end"> <i class="icofont-sign-out"></i> Sign out</a>
					</li>

				</ul>
			</li>

		</ul>

	</div>

</nav>