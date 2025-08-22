<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_setting', 'setting');

		$sesi = ['superadmin', 'cot'];
		$level = $this->session->userdata('level');

		if (!in_array($level, $sesi)) {
			redirect('pengguna', 'refresh');
		}

		// Set user once
		$this->user = $this->db->get_where('users', [
			'username' => $this->session->userdata('username')
		])->row();
	}

	public function cellTier()
	{
		$data = [
			'title' 		=> 'Data Cell Tier',
			'user' 			=> $this->user,
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'cell'			=> $this->setting->viewCell()
		];
		$this->template->load('tema/index', 'cell', $data);
	}
	public function cellErp()
	{
		$data = [
			'title' 		=> 'Data Cell ERP',
			'user' 			=> $this->user,
			'cell'			=> $this->setting->viewCellErp()->cell
		];

		$this->template->load('tema/index', 'cellErp', $data);
	}

	/* tambah dan update */
	public function tambah_data()
	{

		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data cell berhasil ditambah',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->setting->tambahDataCell();
		redirect('Setting/cellTier', 'refresh');
	}

	/* hapus */
	function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->setting->hapusDataCell($id);
		redirect('Setting/cellTier', 'refresh');
	}

	// Mengambil data detail cell
	function detailcell($id)
	{
		$detailcell =  $this->setting->detailcellid($id)->row();
		echo json_encode($detailcell);
	}
}

/* End of file: Setting.php */
