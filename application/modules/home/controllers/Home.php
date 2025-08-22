<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	protected $arrContextOptions;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_home', 'Home');
		$this->load->model('M_level_1', 'Lev1');
		$this->load->model('M_Master', 'Master');
		$arrContextOptions = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
			),
		);
		$this->arrContextOptions = $arrContextOptions;
	}

	public function HomeLev12($kode_factory = null, $cell = null, $tgl = null)
	{
		$sesi = ['superadmin', 'lc', 'safety', 'kaizen', 'critical',  'mp', 'mp_standart', 'rft'];
		$level = $this->session->userdata('level');

		if (!in_array($level, $sesi)) {
			redirect('pengguna', 'refresh');
		}
		if ($tgl == null) {
			$tgl = date('Y-m-d');
		}
		$data = [
			'title'			=> '',
			'tgl'			=> $tgl,
			'cell'			=> $this->Home->mssGetCell($kode_factory),
			'factory'		=> $this->Home->factory()->result(),
			'dt'			=> $this->Master->kelompokDT(),
			'user' 			=> $this->db->get_where('users', ['username' =>  $this->session->userdata('username')])->row()
		];

		$this->template->load('tema/index', 'level/admin', $data);
	}
	/* Halaman Operator */
	function operator($tgl = null)
	{
		$sesi = ['superadmin', 'operator'];
		$level = $this->session->userdata('level');
		if (!in_array($level, $sesi)) {
			redirect('auth', 'refresh');
		}
		$build 	= $this->session->userdata('factory');
		$cell 	= $this->session->userdata('LINE_CD');

		$tgl 	= ($tgl == null) ? date('Y-m-d') : $tgl;

		$data = [
			'title'				=> '',
			'build'				=> $build,
			'cell'				=> $cell,
			'tgl'				=> $tgl,
			'dt'				=> $this->Master->kelompokDT(),
			'operator' 			=> $this->db->get_where('operator', ['LINE_CD' =>  $this->session->userdata('LINE_CD')])->row()

		];
		$this->template->load('tema/index_operator', 'level/user', $data);
	}
	/* Cek Flexim Data */
	function cekFleximdata()
	{
		$file = $this->input->post('id_data');
		$path = 'assets/fleximData/' . $file; //Lokasi File
		if (file_exists($path) && $file != '') {
			echo json_encode(1);
		}
	}
	//http://192.168.44.97/tier-sewing/Home/ajaxDowntimeLevel1/S601/2025-08-11
	function ajaxDowntimeLevel1($id_cell, $tanggal)
	{
		$data = $this->db->get_where('downtime', [
			'LINE_CD' 		=> $id_cell,
			'tanggal_dt'	=> date('Y-m-d', strtotime($tanggal))
		])->result();

		if (empty($data)) {
			$data = [];
		}
		echo json_encode($data);
	}
	/* Mengambil  */
	function ajaxGetDtDetil($kelompok)
	{
		$data = $this->db->get_where('master_dt', ['kelompok' => $kelompok])->result();
		echo json_encode($data);
	}

	/* AjaxSimpan Downtime */
	function ajaxSimpanDt()
	{
		$cek = $this->Home->ajaxSimpanDt();
		echo json_encode($cek);
	}

	/* Perbaharui Data KPI */

	function perbaruiDataKpi($kode_factory = null, $cell = null, $tgl = null)
	{
		$data = $this->Lev1->perbaruiDataKpi($kode_factory, $cell, $tgl);
		echo json_encode($data);
	}
	/* Downtime Cell*/
	function downloadDTCell($cell, $tgl, $target, $dt, $lost)
	{
		$sesi = ['superadmin', 'lc', 'safety', 'kaizen', 'critical',  'mp', 'mp_standart', 'rft', 'operator'];
		$level = $this->session->userdata('level');
		// Cek apakah user memiliki akses ke halaman ini
		if (!in_array($level, $sesi)) {
			redirect('pengguna', 'refresh');
		}

		if ($tgl == null) {
			$tgl = date('Y-m-d');
		}

		$data = [
			'downtime'		=> $this->Home->downloadDTCell($cell, $tgl, $target), // downtime data
			'kode_cell'		=> $this->db->get_where('operator', ['LINE_CD'	=> $cell])->row()->LINE_NM,
			'tgl'			=> $tgl,
			'target'		=> $target,
			'dt_sistem'		=> $dt,
			'lost_sistem'	=> $lost,
			'komparasi'		=> $this->Home->komparasiDt($cell, $tgl, $target, $dt, $lost),
		];

		$this->load->view('cetak/_download_dt_cell', $data);
	}

	/* AjaxFilterKpi Lev 1 & 2 */
	//http://192.168.44.97/tier-sewing/Home/ajaxfilterKpi/F1/S601/2025-08-06
	function ajaxfilterKpi($kode_factory = null, $cell = null, $tgl = null)
	{
		$data = $this->Lev1->ajaxfilterKpi($kode_factory, $cell, $tgl);
		echo json_encode($data);
	}

	/*API MSS ASSEMBLY CELL*/
	public function mssGetCell($id)
	{
		$path 	= SERVER . "mastercell/cellByBuilding/" . $id;
		$cell 	= file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$cell 	= json_decode($cell);
		echo json_encode($cell);
	}

	// API DATA SEWING CELL
	function mssGetCellSewing($id)
	{
		$path     = SERVER2 . "mastercell/SewingcellByBuilding/" . $id;
		$cell     = file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$cell     = json_decode($cell);
		echo json_encode($cell);
	}
}

/* End of file: Home.php */
