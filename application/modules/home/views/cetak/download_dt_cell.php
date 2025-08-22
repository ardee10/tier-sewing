<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>

	<body>
		<div class="row">
			<div class="col p-3">
				<h5 class="text-center text-bold">REKAP DOWNTIME</h5>
				<p class="text-center text-bold">CELL : <?= $kode_cell ?> || Tanggal : <?= $this->indo->konversi($tgl) ?></p>
				<div class="table-responsive">

					<table width="100%" border="1px">
						<!-- 						<tr>
							<td colspan="7" style="text-align: center; font-size: 22px; font-weight: bold"></td>
						</tr>	
						<tr>
							<td colspan="7" style="text-align: center;">CELL : <?= $kode_cell ?> || Tanggal : <?= $this->indo->konversi($tgl) ?></td>
						</tr>
						<tr>
							<td colspan="7" style="padding: 10px"></td>
						</tr> -->
						<tr class="text-center">
							<th style=" background-color: blue; color: white">Kode Jam</th>
							<th style=" background-color: blue; color: white">Target</th>
							<th style=" background-color: blue; color: white">Output</th>
							<th style=" background-color: blue; color: white">Status Pencapaian Target</th>
							<th style=" background-color: blue; color: white">Downtime</th>
							<th style=" background-color: blue; color: white">Lost Pair</th>
							<th style=" background-color: blue; color: white">Remark</th>
						</tr>
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
								<td style="text-align: center"><?= $d['TOTAL_QTY'] ?></td>
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
							<td style=" background-color: blue; color: white">Perhitungan ( presentase inputan x Total DT System ) min</td>
						</tr>
						<?php foreach ($komparasi as $k): ?>
							<tr>
								<?php $persen = ($k['total'] / $total_dt) ?>
								<td style="word-wrap: break-word; " width="15%"><?= $k['remark'] ?></td>
								<td style="text-align: center"><?= $k['total'] ?></td>
								<td style="text-align: center"><?= number_format($persen * 100, 2) ?>%</td>
								<td style="text-align: center"><?= $persen * $dt_sistem ?></td>
							</tr>
						<?php endforeach ?>
						<tr style="font-weight: bold; font-size: 25px">
							<td style="font-weight: bold; text-align: center" width="15%">TOTAL</td>
							<td style="text-align: center"><?= $total_dt ?></td>
							<td style="text-align: center">100%</td>
							<td style="text-align: center"><?= $dt_sistem ?></td>
						</tr>
					</table>

				</div>
			</div>
		</div>
	</body>

</body>

</html>