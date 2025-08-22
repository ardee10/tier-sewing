<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Critical extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Critical', 'Critical');
		$sesi = ['superadmin', 'mp', 'critical'];
		$level = $this->session->userdata('level');

		if (!in_array($level, $sesi)) {
			redirect('pengguna', 'refresh');
		}
		// Set user once
		$this->user = $this->db->get_where('users', [
			'username' => $this->session->userdata('username')
		])->row();
	}

	public function index($tanggal = null)
	{
		$tanggal = ($tanggal) ? $tanggal : date('Y-m-d');
		$data = [
			'title' 		=> 'CRITICAL DESTINATION SETTING',
			'cell'          => $this->Critical->cekCell($tanggal),
			'user'			=> $this->user,
			'tanggal_kerja' => $tanggal
		];

		$this->template->load('tema/index', 'index', $data);
	}

	function eksekusi()
	{
		$cek = $this->Critical->eksekusi();
		echo json_encode($cek);
	}

	function eksekusiPo()
	{
		$cek = $this->Critical->eksekusiPo();
		echo json_encode($cek);
	}

	function hapusCellCritical()
	{
		$cek = $this->Critical->hapusCellCritical();
		echo json_encode($cek);
	}
}

/* End of file: Critical.php */
