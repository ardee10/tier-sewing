<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layout extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('M_Layout', 'Layout');
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

	public function index()
	{

		$data = [
			'title'		=> 'Layout Admin Dashboard',
			'model'		=> $this->Layout->getLayout(),
			'user'		=> $this->user
		];

		$this->template->load('tema/index', 'index', $data);
	}

	function uploadLayout()
	{
		$result = $this->Layout->uploadLayout();
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

		redirect('Layout', 'refresh');
	}
}

/* End of file: Layout.php */
