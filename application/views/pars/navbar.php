<nav class="app-header navbar navbar-expand bg-body">
	<!--begin::Container-->
	<div class="container-fluid">
		<!--begin::Start Navbar Links-->
		<ul class="navbar-nav">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container-fluid">
					<a href="<?= base_url('Home/HomeLev12'); ?>" class="navbar-brand"> <img src="<?= base_url('assets'); ?>/img/logo/logo-dash.png" alt=""></a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<?php
					if ($this->session->userdata('level') == 'superadmin') {
					?>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Admin
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a href="#" class="dropdown-item"><i class="icofont-labour text-danger"></i> LC</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Cot'); ?>" class="dropdown-item"><i class="icofont-clock-time text-primary"></i> COT</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Safety') ?>" class="dropdown-item"><i class="icofont-safety text-success"></i> SAFETY</a></li>
										<!-- <li><a href="#" class="dropdown-item"><i class="icofont-safety-hat-light text-danger"></i> ACCIDENT KERJA</a></li> -->
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Kaizen'); ?>" class="dropdown-item"><i class="icofont-unique-idea text-warning"></i> KAIZEN</a></li>
										<li><a href="<?= base_url('Sixs') ?>" class="dropdown-item"><i class="icofont-list text-info"></i> 6S</a></li>
										<li><a href="<?= base_url('Layout') ?>" class="dropdown-item"><i class="icofont-layout text-primary"></i> LAYOUT</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Manpower') ?>" class="dropdown-item"><i class="icofont-users-social text-info"></i> MP ADMIN</a></li>
										<li><a href="<?= base_url('Critical') ?>" class="dropdown-item"><i class="icofont-bell-alt text-info"></i> CRITICAL DESTINATION</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Flexim'); ?>" class="dropdown-item"><i class="icofont-video-alt text-danger"></i> FLEXIM VIDEO</a></li>
									</ul>
								</li>

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Information
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a href="<?= base_url('Defect') ?>" class="dropdown-item"><i class="icofont-papers text-success"></i> DEFECT</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Rft') ?>" class="dropdown-item"><i class="icofont-broken text-danger"></i> RFT</a></li>

										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('admin/master_model') ?>" class="dropdown-item"><i class="icofont-users-social text-info"></i> MASTER MP STANDAR &amp; LC</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Target/targetErp') ?>" class="dropdown-item"><i class="icofont-clock-time text-danger"></i> TARGET &amp; WORKING HOUR</a></li>
									</ul>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Set Admin
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a href="<?= base_url('Setting/cellErp') ?>" class="dropdown-item"><i class="icofont-gears text-danger"></i> CELL ERP</a></li>
										<li><a href="<?= base_url('Setting/cellTier') ?>" class="dropdown-item"><i class="icofont-trello text-danger"></i> CELL TIER SEWING</a></li>

									</ul>
								</li>

							</ul>
						</div>

					<?php
					} else if ($this->session->userdata('level') == 'lc') {
					?>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Admin
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a href="#" class="dropdown-item"><i class="icofont-labour text-danger"></i> LC</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Cot'); ?>" class="dropdown-item"><i class="icofont-clock-time text-primary"></i> COT</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Layout') ?>" class="dropdown-item"><i class="icofont-layout text-primary"></i> LAYOUT</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Flexim'); ?>" class="dropdown-item"><i class="icofont-video-alt text-danger"></i> FLEXIM VIDEO</a></li>
									</ul>
								</li>

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Information
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a href="<?= base_url('admin/master_model') ?>" class="dropdown-item"><i class="icofont-users-social text-info"></i> MASTER MP STANDAR &amp; LC</a></li>
										<!-- <div class="dropdown-divider"></div> -->
									</ul>
								</li>
							</ul>
						</div>

					<?php
					} else if ($this->session->userdata('level') == 'kaizen') {
					?>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Admin
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">

										<li><a href="<?= base_url('Kaizen'); ?>" class="dropdown-item"><i class="icofont-unique-idea text-warning"></i> KAIZEN</a></li>
										<li><a href="<?= base_url('Sixs') ?>" class="dropdown-item"><i class="icofont-list text-info"></i> 6S</a></li>


									</ul>
								</li>
							</ul>
						</div>

					<?php
					} else if ($this->session->userdata('level') == 'safety') {
					?>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Admin
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a href="<?= base_url('Safety') ?>" class="dropdown-item"><i class="icofont-safety text-success"></i> SAFETY</a></li>
										<div class="dropdown-divider"></div>
										<!-- <li><a href="#" class="dropdown-item"><i class="icofont-safety-hat-light text-danger"></i> ACCIDENT KERJA</a></li> -->
									</ul>
								</li>
							</ul>
						</div>

					<?php
					} else if ($this->session->userdata('level') == 'mp') {
					?>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Admin
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a href="<?= base_url('Manpower') ?>" class="dropdown-item"><i class="icofont-users-social text-info"></i> MP ADMIN</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Critical') ?>" class="dropdown-item"><i class="icofont-bell-alt text-info"></i> CRITICAL DESTINATION</a></li>
									</ul>
								</li>
							</ul>
						</div>

					<?php
					} else if ($this->session->userdata('level') == 'rft') {
					?>

						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Master Information
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<!-- <li><a href="#" class="dropdown-item"><i class="icofont-broken text-danger"></i> RFT</a></li> -->
										<li><a href="<?= base_url('Defect') ?>" class="dropdown-item"><i class="icofont-papers text-success"></i> DEFECT</a></li>
										<div class="dropdown-divider"></div>
										<li><a href="<?= base_url('Rft') ?>" class="dropdown-item"><i class="icofont-broken text-danger"></i> RFT</a></li>
									</ul>
								</li>
							</ul>
						</div>

					<?php
					}
					?>

				</div>
			</nav>
		</ul>
		<!--end::Start Navbar Links-->

		<!--begin::End Navbar Links-->
		<ul class="navbar-nav ms-auto">
			<li class="nav-item dropdown user-menu">
				<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
					<img
						src="<?= base_url('assets/') ?>dist/assets/img/avatar5.png"
						class="user-image rounded-circle shadow"
						alt="User Image" />
					<span class="d-none d-md-inline"><?= $user->nama_lengkap;  ?></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
					<!--begin::User Image-->
					<li class="user-header text-bg-primary">
						<img
							src="<?= base_url('assets/') ?>dist/assets/img/avatar5.png"
							class="rounded-circle shadow"
							alt="User Image" />
						<p>
							<?= $user->username ?>
						</p>
					</li>

					<li class="user-footer">
						<a href="#" class="btn btn-default btn-flat"><?= $user->username;  ?></a>
						<a href="<?= base_url('Auth/logout') ?>" class="btn btn-default btn-flat float-end">Sign out</a>
					</li>
					<!--end::Menu Footer-->
				</ul>
			</li>
			<!--end::User Menu Dropdown-->
		</ul>
		<!--end::End Navbar Links-->
	</div>
	<!--end::Container-->
</nav>
