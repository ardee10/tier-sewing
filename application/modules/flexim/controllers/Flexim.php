<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Flexim extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_flexim');
		$sesi = ['superadmin', 'lc', 'cot', 'layout', 'flexim', 'mp_standart'];
		$level = $this->session->userdata('level');

		if (!in_array($level, $sesi)) {
			redirect('pengguna', 'refresh');
		}
		// Set user once
		$this->user = $this->db->get_where('users', [
			'username' => $this->session->userdata('username')
		])->row();
	}

	/* index File */
	public function index()
	{
		$data = [
			'title' 		=> 'Flexim Video Dashboard',
			'model'     	=> $this->M_flexim->getModel(),
			'flexim'    	=> $this->db->get('flexim')->result(),
			'user' 			=> $this->user

		];
		$this->template->load('tema/index', 'index', $data);
	}

	public function uploadVideo()
	{
		$result = $this->M_flexim->uploadVideo();
		if (isset($result['kode']) && $result['kode'] === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => $result['msg'],
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} else {
			$this->session->set_flashdata('message', [
				'title' => 'Gagal',
				'text'  => $result['msg'],
				'icon'  => 'error',
				'type'  => 'danger'
			]);
		}

		redirect('Flexim', 'refresh');
	}

	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->M_flexim->hapusdataById($id);
		redirect('Flexim', 'refresh');
	}
}

/* End of file: Flexim.php */
