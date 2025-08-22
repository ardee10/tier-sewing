<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_auth', 'Auth');
	}

	public function index()
	{
		// HALAMAN LOGIN OPERATOR
		$data = [
			'title' 	=> 'HALAMAN LOGIN CELL',
			'factory' 	=> $this->db->get_where('factory', ['active' => '1'])->result()

		];

		$this->load->view('index', $data); //index operator
	}

	public function admin()
	{
		$data = [
			'title' => 'HALAMAN LOGIN ADMIN'
		];
		$this->load->view('index_admin', $data); //index admin
	}

	function process_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', [
				'type' => 'error',
				'text' => 'Username dan password harus diisi'
			]);
			redirect('pengguna');
		} else {
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);

			$login_result = $this->Auth->check_login($username, $password);

			if ($login_result['status'] == 'success') {
				$user = $login_result['user'];
				$session_data = [
					'user_id'   => $user->id,
					'username'  => $user->username,
					'nama'      => $user->nama_lengkap,
					'level'     => $user->level,
					'foto'      => $user->foto,
					'logged_in' => TRUE
				];
				$this->session->set_userdata($session_data);
				$this->session->set_flashdata('message', [
					'type' => 'success',
					'title' => 'Success',
					'icon'  => 'success',
					'text' => 'Login berhasil! Selamat datang ' . $user->nama_lengkap
				]);

				$redirect_levels = ['superadmin', 'lc', 'safety', 'kaizen', 'mp', 'rft'];

				if (in_array($user->level, $redirect_levels)) {
					redirect('home/homelev12');
				} else {
					redirect('pengguna');
				}
			} else if ($login_result['status'] == 'username_not_found') {
				$this->session->set_flashdata('message', [
					'type' => 'error',
					'text' => 'Username tidak ditemukan atau akun tidak aktif'
				]);
				redirect('pengguna');
			} else if ($login_result['status'] == 'wrong_password') {
				$this->session->set_flashdata('message', [
					'type' => 'warning',
					'text' => 'Password yang Anda masukkan salah'
				]);
				redirect('pengguna');
			} else {
				$this->session->set_flashdata('message', [
					'type' => 'error',
					'text' => 'Terjadi kesalahan saat proses login'
				]);
				redirect('pengguna');
			}
		}
	}

	/* Validasi Operatot */

	public function loginOperator()
	{
		//ambil variable building dan cell
		$building 	= $this->input->post('building');
		$cell 		= $this->input->post('cell');

		$this->form_validation->set_rules('building', 'building', 'required');
		$this->form_validation->set_rules('cell', 'cell', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', [
				'type' => 'error',
				'text' => 'Username dan password harus diisi'
			]);
			redirect('Auth');
		} else {

			$this->db->where('factory', $building);
			$this->db->where('LINE_CD', $cell);
			$data = $this->db->get('operator')->row();

			if ($data) {
				$session_data = [
					'user_id'   	=> $data->id_operator,
					'factory'  		=> $data->factory,
					'LINE_CD'    	=> $data->LINE_CD,
					'LINE_NM'     	=> $data->LINE_NM,
					'level'     	=> $data->level,
					'ses_display' 	=> strtoupper($data->level) . ' ' . $data->LINE_NM,
				];

				$this->session->set_userdata($session_data);

				$this->session->set_flashdata('message', [
					'title' => 'Login Berhasil',
					'text' => 'Selamat datang operator ' . strtoupper($data->level) . ' ' . $data->LINE_NM,
					'icon' => 'success',
					'type' => 'success'
				]);
				redirect('home/operator', 'refresh');
				// echo 'Login Berhasil';
			} else {
				$this->session->set_flashdata('message', [
					'title' => 'Gagal',
					'text' => 'Data operator tidak ditemukan',
					'icon' => 'error',
					'type' => 'error'
				]);
				redirect('Auth', 'refresh');
			}
		}
	}

	/* LOG OUT */
	public function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		$this->session->set_flashdata('message', [
			'title' => 'Logout Berhasil',
			'text' => 'Anda telah berhasil logout',
			'icon' => 'success',
			'type' => 'success'
		]);
		redirect('pengguna', 'refresh');
	}

	/* LOG OUT */
	public function logout_op()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('LINE_CD');
		$this->session->unset_userdata('level');
		$this->session->set_flashdata('message', [
			'title' => 'Logout Berhasil',
			'text' => 'Anda telah berhasil logout',
			'icon' => 'success',
			'type' => 'success'
		]);
		redirect('users', 'refresh');
	}
}
/* End of file: Auth.php */
