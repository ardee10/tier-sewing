<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tracking EFF</title>
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Report Tracking Eff.xls");
	?>
</head>

<body>
	<style>
		.bg-warning {
			background-color: peachpuff;
		}

		.bg-success {
			background-color: yellowgreen;
			color: white;
		}

		.bg-export {
			background-color: #5a894f;
			color: white;
		}
	</style>

	<table style="width: 100%;">
		<tr>
			<td>Report Efficiency:</td>
			<td><?= $building ?></td>
		</tr>
		<tr>
			<td>Startdate:</td>
			<td><?= $filterStart ?></td>
		</tr>
		<tr>
			<td>EndDate:</td>
			<td><?= $filterEnd ?></td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td class="bg-export">Cell</td>
			<td class="bg-export">#</td>
			<?php foreach ($date as $var) : ?>
				<td class="bg-export"><?= $var ?></td>
			<?php endforeach ?>
		</tr>
		<?php foreach ($dataCell as $var) : ?>
			<tr>
				<td rowspan="2" class="bg-export"><?= $var['LINE_NM'] ?></td>
				<td class="bg-export">Tgt</td>
				<?php foreach ($var['eff'] as $eff) : ?>
					<td class="bg-light"><?= $eff['tgt_eff'] && $eff['tgt_eff'] != 0.00 ? $eff['tgt_eff'] : '-' ?></td>
				<?php endforeach ?>
			</tr>
			<tr>
				<td class="text-light bg-export">Act</td>
				<?php foreach ($var['eff'] as $eff) : ?>
					<td class="<?= $eff['colorAct'] ?>"><?= $eff['act_eff'] && $eff['act_eff'] != 0.00 ? $eff['act_eff'] : '-' ?></td>
				<?php endforeach ?>
			</tr>
		<?php endforeach ?>
	</table>
</body>

</html>