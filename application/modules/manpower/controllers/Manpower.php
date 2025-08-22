<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manpower extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Serversidemp', 'Servesidemp');
		$this->load->model('M_Manpower', 'Manpower');

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

	public function index()
	{

		$data = [
			'title' 		=> 'SEWING MANPOWER DASHBOARD',
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'index', $data);
	}
	// Import ManPower
	public function import_mp()
	{

		$data = [
			'title' 		=> 'IMPORT DATA MANPOWER SEWING',
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'import_mp', $data);
	}
	// Upload Manpower
	function upload_mp()
	{

		$result = $this->Manpower->processImportManpower();
		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data MP berhasil diimport',
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
		redirect('Manpower', 'refresh');
	}

	/* ManPower ServerSide */
	public function ajax_ManpowerServerSide($building = null, $tanggal = null)
	{

		$list = $this->Servesidemp->get_datatables($building, $tanggal);
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_mp(this)" 
				data-id="' . $o->id_mp . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_mp">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('Manpower/hapus_data/' . $o->id_mp) . '">
				<i class="icofont-trash"></i>
			</a>';


			$row = array();
			$row[] = $no++;
			$row[] = $o->factory;
			$row[] = $o->nama_cell;
			$row[] = $o->LINE_CD;
			$row[] = $o->mp_date;
			$row[] = $o->mp_bz_sew_prep;
			$row[] = $o->mp_sew_prep;
			$row[] = $o->mp_bz_sew_prep + $o->mp_sew_prep;
			$row[] = $option;
			$data[] = $row;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Servesidemp->count_all(),
			"recordsFiltered" 	=> $this->Servesidemp->count_filtered($building, $tanggal),
			"data" 				=> $data
		);
		echo json_encode($output);
	}

	/* Update */

	public function getDataManpowerById($id)
	{
		$query = $this->db->get_where('mp_actual', ['id_mp' => $id])->row();
		echo json_encode($query);
	}

	//Insert and Update
	public function tambah_data()
	{

		$result = $this->Manpower->tambahDataManpower();
		/* Array ( [id_mp] => 6882e02b4a3ea [factory] => F1 [LINE_CD] => S601 [mp_date] => 2025-07-25 [mp_bz_sew_prep] => 10 [mp_sew_prep] => 10 [total_mp_sew] => 20 ) */
		if ($result == 'update') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data MP berhasil diupdate',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} elseif ($result == 'insert') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data MP berhasil ditambahkan',
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

		redirect('Manpower', 'refresh');
	}

	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->Manpower->hapusdatabyId($id);
		redirect('Manpower', 'refresh');
	}

	/* Bulk Delete */

	public function bulkDelete()
	{
		$factory  = $this->input->post('factory');
		$mp_date  = $this->input->post('mp_date');

		if (!$factory || !$mp_date) {
			$this->session->set_flashdata('message', [
				'title' => 'Error',
				'text' => 'Factory dan tanggal wajib dipilih!',
				'icon' => 'error',
				'type' => 'danger'
			]);
			redirect('Manpower');
		}

		$deleted = $this->Manpower->deleteByFactoryAndDate($factory, $mp_date);

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

		redirect('Manpower');
	}
}

/* End of file: Manpower.php */
