<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Target extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_target', 'target', 'lc');

		$sesi = ['superadmin', 'lc', 'safety', 'kaizen', 'mp', 'rft'];
		$level = $this->session->userdata('level');

		if (!in_array($level, $sesi)) {
			redirect('pengguna', 'refresh');
		}
		// Set user once
		$this->user = $this->db->get_where('users', [
			'username' => $this->session->userdata('username')
		])->row();
	}

	public function targetErp($date = null)
	{
		$date = ($date) ? $date : date('Y-m-d');

		$data = [
			'title'        => 'Target Sewing Output ERP',
			'user'         => $this->user,
			'factory'      => $this->db->get_where('factory', ['active' => '1'])->result(),
			'celltarget'   => $this->target->targetAllCell(str_replace('-', '', $date)),
			'date'         => $date
		];

		$this->template->load('tema/index', 'targetCell', $data);
	}
}

/* End of file: Target.php */
