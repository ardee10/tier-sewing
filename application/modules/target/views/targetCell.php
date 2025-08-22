<?php
function timeCodeToHour($code)
{
	$map = [
		'A007' => '07:00 - 08:00',
		'A008' => '08:00 - 09:00',
		'A009' => '09:00 - 10:00',
		'A010' => '10:00 - 11:00',
		'A011' => '11:00 - 12:00',
		'A013' => '13:00 - 14:00',
		'A014' => '14:00 - 15:00',
		'A015' => '15:00 - 16:00',
		'A016' => '16:00 - 17:00',
		'A017' => '17:00 - 18:00'
	];
	return isset($map[$code]) ? $map[$code] : $code;
}

?>

<main class="app-main">
	<!--begin::App Content Header-->
	<div class="app-content-header">
		<!--begin::Container-->
		<div class="container-fluid">
			<!--begin::Row-->
			<div class="row">
				<div class="col-sm-12">
					<h3 class="mb-0 text-lg-center text-uppercase"><?= $title; ?></h3>
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

							<div class="row mb-3">
								<!-- BUILDING -->
								<!-- <div class="col-md-2">
									<label for="buildingkaizen" class="form-label font-weight-bold">BUILDING</label>
									<select class="form-control" id="buildingkaizen" name="buildingkaizen">
										<option value="semua">SEMUA</option>
										<?php foreach ($factory as $f): ?>
											<option value="<?= $f->gedung ?>"><?= $f->gedung ?></option>
										<?php endforeach; ?>
									</select>
								</div> -->

								<!-- DATE -->
								<div class="col-md-3">
									<label for="date" class="form-label font-weight-bold">DATE</label>
									<input type="date" name="targetdate" id="targetdate" class="form-control" value="<?= $date ?>" />


								</div>
							</div>

							<!-- Isian disini -->
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="targetERP">
									<thead class="table-dark rounded-1 mb-1">
										<tr>
											<th>LINE_CD</th>
											<th>PROD_DATE</th>
											<th>FACTORY</th>
											<th>CELL</th>
											<th>TIME_CD</th>
											<th>CREATE_USER</th>
											<th>TARGET</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($celltarget->data as $var):

											$date = date('Y-m-d', strtotime($var->PROD_DATE));
										?>
											<tr>
												<td><?= $var->LINE_CD ?></td>
												<td><?= $date ?></td>
												<td><?= $var->LINE_GRP5 ?></td>
												<td><?= $var->LINE_NM ?></td>
												<td><?= timeCodeToHour($var->TIME_CD) ?></td>
												<td><?= $var->CREATE_USER ?></td>
												<td><?= $var->QTY ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		const base = $('#base').data('id');

		function loadtargetErp() {
			let selectedDate = $('#targetdate').val(); // Y-m-d
			if (selectedDate) {
				const newUrl = base + `Target/targetErp/` + selectedDate; // format: Y-m-d
				window.location.href = newUrl; // redirect ke URL baru
			}
		}

		$(document).ready(function() {
			/* OnChange Date */
			$('#targetdate').on('change', loadtargetErp);

		});
	</script>