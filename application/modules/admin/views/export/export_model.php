<!DOCTYPE html>
<html>

<head>
	<title>Model</title>
	<style>
		table {
			text-align: center;
		}
	</style>
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Model_MP_LC_report.xls");
	?>
</head>

<body>
	<h4 style="text-align: center">Man Power & LC DATA</h4>
	<table border="1px">
		<thead>
			<tr>
				<th>No</th>
				<th>TARGET / jam</th>
				<th>Kode Model</th>
				<th>Nama Model</th>
				<th>MP Prepparation</th>
				<th>MP Sewing</th>
				<th>MP WS</th>
				<th>Total MP</th>
				<th>LC</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 2;
			foreach ($model as $m): ?>
				<tr>
					<td><?= $no++ ?></td>
					<td><?= $m->target ?></td>
					<td><?= $m->kode_model ?></td>
					<td><?= $m->nama_model ?></td>
					<td><?= $m->mp_prep ?></td>
					<td><?= $m->mp_sewing ?></td>
					<td><?= $m->mp_ws ?></td>
					<td><?= $m->mp_prep + $m->mp_sewing + $m->mp_ws ?></td>
					<td><?= $m->lc ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>

</html>