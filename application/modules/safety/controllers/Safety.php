<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Safety extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_ServersideSafety', 'Serverside');
		$this->load->model('M_Safety', 'Safety');

		$sesi = ['superadmin', 'safety'];
		$level = $this->session->userdata('level');

		if (!in_array($level, $sesi)) {
			redirect('pengguna', 'refresh');
		}
		// Set user once
		$this->user = $this->db->get_where('users', [
			'username' => $this->session->userdata('username')
		])->row();
	}


	// Index
	public function index()
	{
		$data = [
			'title' 		=> 'Safety Admin Dashboard',
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'index', $data);
	}
	/* Import Data Safety */
	public function import_safety()
	{
		$data = [
			'title' 		=> 'IMPORT DATA SAFETY',
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'import_safety', $data);
	}
	/* Ajax ServersideSafety */
	public function ajax_SafetyServerSide($building = null, $tanggal = null)
	{

		$list = $this->Serverside->get_datatables($building, $tanggal);
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_safety(this)" 
				data-id="' . $o->id_safety . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_safety">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('Safety/hapus_data/' . $o->id_safety) . '">
				<i class="icofont-trash"></i>
			</a>';

			/* Path Location */
			$path = 'assets/img/safety_file/' . $o->file_safety;
			if (file_exists($path) && $o->file_safety != null) {
				$img = base_url() . 'assets/img/safety_file/' . $o->file_safety;
			} else {
				$img = base_url() . 'assets/img/no_images.png';
			}


			$row = array();
			$row[] = $no++;
			$row[] = $o->safety_date;
			$row[] = $o->kode_factory;
			$row[] = $o->nama_cell;
			$row[] = $o->lti;
			$row[] = $o->nlti;
			$row[] = $o->total_lti;
			$row[] = $o->total_nlti;
			$row[] = '<img width="60px" src="' . $img . '">';
			$row[] = $option;
			$data[] = $row;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Serverside->count_all(),
			"recordsFiltered" 	=> $this->Serverside->count_filtered($building, $tanggal),
			"data" 				=> $data
		);
		echo json_encode($output);
	}
	/* Insert and Update */
	public function tambah_data()
	{
		$result = $this->Safety->tambahDataSafety();

		if ($result == 'update') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Safety berhasil diupdate',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} elseif ($result == 'insert') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Safety berhasil ditambahkan',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} else {
			$this->session->set_flashdata('message', [
				'title' => 'Gagal',
				'text'  => 'Terjadi kesalahan saat menyimpan data',
				'icon'  => 'error',
				'type'  => 'danger'
			]);
		}

		redirect('Safety', 'refresh');
	}
	// Hapus data Safety
	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->Safety->hapusdatabyId($id);
		redirect('Safety', 'refresh');
	}
	/* Edit and Update */
	public function getDataSafetyById($id)
	{
		$data = $this->db->get_where('safety', ['id_safety' => $id])->row();
		echo json_encode($data);
	}
	// Upload Safety
	public function upload_safety()
	{
		$result = $this->Safety->processImportSafety();
		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Safety berhasil diimport',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} else {
			$pesan_error = is_array($result) ? $result['msg'] : 'Terjadi kesalahan saat menyimpan data';
			$this->session->set_flashdata('message', [
				'title' => 'Gagal',
				'text'  => $pesan_error,
				'icon'  => 'error',
				'type'  => 'danger'
			]);
		}
		redirect('Safety', 'refresh');
	}
	/* Bulk Hapus */
	public function bulkDelete()
	{

		$factory  = $this->input->post('factory');
		$safety_date  = $this->input->post('safety_date');
		if (!$factory || !$safety_date) {
			$this->session->set_flashdata('message', [
				'title' => 'Error',
				'text' => 'Factory dan tanggal wajib dipilih!',
				'icon' => 'error',
				'type' => 'danger'
			]);
			redirect('Manpower');
		}
		$deleted = $this->Safety->deleteByFactoryAndDate($factory, $safety_date);
		if ($deleted) {
			$this->session->set_flashdata('message', [
				'title' => 'Berhasil',
				'text' => 'Data berhasil dihapus.',
				'icon' => 'success',
				'type' => 'success'
			]);
		} else {
			$this->session->set_flashdata('message', [
				'title' => 'Gagal',
				'text' => 'Tidak ada data yang dihapus.',
				'icon' => 'warning',
				'type' => 'warning'
			]);
		}

		redirect('Safety');
	}
}

/* End of file: Safety.php */
