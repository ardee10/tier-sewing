<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sixs extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Serversidesixs', 'Sixs');
		$this->load->model('M_Sixs');

		$sesi = ['superadmin', 'kaizen', 'sixs'];
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
			'title' 		=> '6S ADMIN DASHBOARD',
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'index', $data);
	}

	/* Ajax ServerSIdeSixS */
	function ajax_SixsServerSide($building = null, $tanggal = null)
	{
		$list = $this->Sixs->get_datatables($building, $tanggal);
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_sixs(this)" 
				data-id="' . $o->id_audit . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_sixs">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('sixs/hapus_data/' . $o->id_audit) . '">
				<i class="icofont-trash"></i>
			</a>';

			/* Path Location */
			$path = 'assets/img/sixs_file/' . $o->file_six;
			if (file_exists($path) && $o->file_six != null) {
				$img = base_url() . 'assets/img/sixs_file/' . $o->file_six;
			} else {
				$img = base_url() . 'assets/img/sixs_file/picture.png';
			}

			$row = array();
			$row[] = $no++;
			$row[] = $o->audit_date;
			$row[] = $o->factory;
			$row[] = $o->nama_cell;
			$row[] = $o->total_audit;
			$row[] = '<img width="50px" src="' . $img . '">';
			$row[] = $option;
			$data[] = $row;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Sixs->count_all(),
			"recordsFiltered" 	=> $this->Sixs->count_filtered($building, $tanggal),
			"data" 				=> $data
		);
		echo json_encode($output);
	}

	/* Insert and Update */
	public function tambah_data()
	{
		$result = $this->M_Sixs->tambahDataSixs();

		if ($result == 'update') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Sixs berhasil diupdate',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} elseif ($result == 'insert') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Sixs berhasil ditambahkan',
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

		redirect('Sixs', 'refresh');
	}

	public function getDataSixsById($id)
	{
		$query = $this->db->get_where('audit', ['id_audit' => $id])->row();
		echo json_encode($query);
	}

	/* Hapus data */
	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->M_Sixs->deleteById($id);
		redirect('Sixs', 'refresh');
	}

	/* Import SixS */
	public function import_sixs()
	{

		$data = [
			'title' 		=> 'IMPORT FILE SIXS',
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'import_sixs', $data);
	}
	/* Upload Sixs */
	public function upload_sixs()
	{
		$result = $this->M_Sixs->processImportSixs();
		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data SixS berhasil diimport',
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
		redirect('sixs', 'refresh');
	}

	/* Bulk Hapus */

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
		$deleted = $this->M_Sixs->deleteByFactoryAndDate($factory, $mp_date);
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

		redirect('Sixs');
	}
}

/* End of file: Sixs.php */
