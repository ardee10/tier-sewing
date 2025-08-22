<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_trackingeff extends CI_Model
{
	protected $arrContextOptions;
	public function __construct()
	{
		parent::__construct();
		$arrContextOptions = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
			),
		);
		$this->arrContextOptions = $arrContextOptions;
	}

	function getData($building, $startDate, $endDate, $rangeDate)
	{
		if (!$rangeDate) {
			return [];
		}
		// API DATA SEWING CELL
		$path     = SERVER2 . "mastercell/SewingcellByBuilding/" . $building;
		$cell     = file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$cell     = json_decode($cell);
		//echo json_encode($cell);
		$pekerjaan = [];
		if ($cell) {
			$pekerjaan = $this->getPekerjaan($cell, $startDate, $endDate);
		}

		foreach ($cell as $c) {
			$data[] = [
				'LINE_CD'       => $c->LINE_CD,
				'LINE_NM'       => $c->LINE_NM,
				'eff'           => $this->getEff($c->LINE_CD, $pekerjaan, $rangeDate)
			];
		}

		return $data;
	}

	function getPekerjaan($cell, $startDate, $endDate)
	{
		$LINE_CD = array_column($cell, 'LINE_CD');

		$where = [
			'tanggal_pekerjaan >='      => $startDate,
			'tanggal_pekerjaan <='      => $endDate,
		];
		$this->db->where_in('LINE_CD', $LINE_CD);
		return $this->db->get_where('pekerjaan', $where)->result();
	}

	function getEff($LINE_CD, $pekerjaan, $rangeDate)
	{
		$data = [];
		foreach ($rangeDate as $date) {
			$eff = 0;
			$target_eff = 0;
			foreach ($pekerjaan as $kerja) {
				if ($date == $kerja->tanggal_pekerjaan && $LINE_CD == $kerja->LINE_CD) {
					$eff 	= $kerja->kpi_act_eff;
					$target_eff = $kerja->kpi_target_eff;
				}
			}

			$colorAct = ($target_eff > $eff) ? 'bg-warning' : 'bg-success';
			$colorAct = ($eff == 0.00) ? '' : $colorAct;
			$data[]     = [
				'tanggal_kerja'         => $date,
				'colorAct'              => $colorAct,
				'tgt_eff'               => $target_eff,
				'act_eff'               => $eff
			];
		}
		return $data;
	}
}

/* End of file: M_trackingeff.php */
