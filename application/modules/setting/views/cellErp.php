<main class="app-main">
	<!--begin::App Content Header-->
	<div class="app-content-header">
		<!--begin::Container-->
		<div class="container-fluid">
			<!--begin::Row-->
			<div class="row">
				<div class="col-sm-12">
					<h3 class="mb-0 text-lg-center text-uppercase">DATA CELL ERP</h3>
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
							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="cellERP">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>LINE_CD</th>
											<th>LINE_GRP5</th>
											<th>LINE_NM</th>
											<th>LINE_TYPE</th>
											<th>CAPA_HOUR</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($cell as $var) : ?>
											<tr>
												<td><?= $var->LINE_CD ?></td>
												<td><?= $var->LINE_GRP5 ?></td>
												<td><?= $var->LINE_NM ?></td>
												<td><?= $var->LINE_TYPE ?></td>
												<td><?= $var->CAPA_HOUR ?></td>
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

	<!-- <script>
		var base = $('#base').data('id');
		alert(base);
	</script> -->