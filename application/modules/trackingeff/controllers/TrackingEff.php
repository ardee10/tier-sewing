<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TrackingEff extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_trackingeff');
	}

	public function tracking($building, $start = null, $end = null, $download = null)
	{
		$rangeDate = [];
		if ($end) {
			$startDate = strtotime($start);
			$endDate = strtotime($end);
			for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
				$date = date('Y-m-d', $currentDate);
				$rangeDate[] = $date;
			}
		}

		$data = [
			'title'				=> 'Tracking Efficiency Building' . ' ' . $building,
			'date'              => $rangeDate,
			'building'          => $building,
			'filterStart'       => $start ? $start : date('Y-m-d'),
			'filterEnd'         => $end ? $end : date('Y-m-d'),
			'loopBuilding'		=> $this->db->get_where('factory', ['active' => '1'])->result(), //Loop Building
			'dataCell'          => $this->M_trackingeff->getData($building, $start, $end, $rangeDate)
		];


		if ($download) {
			$this->load->view('download', $data);
		} else {

			$this->load->view('pars/header');
			$this->load->view('index', $data);
		}
	}

	function filterEff()
	{
		$building 	= $this->input->post('building_eff');
		$start 		= $this->input->post('startFilter');
		$end 		= $this->input->post('endFilter');

		$rangeDate = [];
		if ($end) {
			$startDate = strtotime($start);
			$endDate = strtotime($end);
			for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
				$date = date('Y-m-d', $currentDate);
				$rangeDate[] = $date;
			}
		}

		$data = [
			'title'				=> 'Tracking Efficiency Building' . ' ' . $building,
			'date'              => $rangeDate,
			'building'          => $building,
			'filterStart'       => $start ? $start : date('Y-m-d'),
			'filterEnd'         => $end ? $end : date('Y-m-d'),
			'loopBuilding'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'dataCell'          => $this->M_trackingeff->getData($building, $start, $end, $rangeDate)
		];
		// echo json_encode($data);
		$this->load->view('pars/header');
		$this->load->view('index', $data);
	}
}

/* End of file: TrackingEff.php */
