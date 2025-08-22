<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Defect extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_ServerSideDefect', 'DefectServerside');
		$this->load->model('M_defect');

		$sesi = ['superadmin', 'rft'];
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
			'title' 		=> 'DEFECT DASHBOARD',
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'defect'    	=> $this->M_defect->master_defect(),
			'user'			=> $this->user,
		];

		$this->template->load('tema/index', 'index', $data);
	}


	/* Import View */
	public function import_defect()
	{
		$data = [
			'title' 		=> 'IMPORT DATA DEFECT',
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'import', $data);
	}
	/* Hapus Data */
	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->M_defect->hapusdatabyId($id);
		redirect('Defect', 'refresh');
	}

	/* Edit & Update */
	public function getDataDefectById($id)
	{
		$data = $this->db->get_where('defect', ['id_defect' => $id])->row();
		echo json_encode($data);
	}

	public function ajax_DefectServerSide($building = null, $tanggal = null)
	{

		$list = $this->DefectServerside->get_datatables($building, $tanggal);
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_defect(this)" 
				data-id="' . $o->id_defect . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_defect">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('Defect/hapus_data/' . $o->id_defect) . '">
				<i class="icofont-trash"></i>
			</a>';

			$row = array();
			$row[] = $no++;
			$row[] = $o->defect_date;
			$row[] = $o->factory;
			$row[] = $o->nama_cell;
			$row[] = $o->model;
			$row[] = $o->defect_name;
			$row[] = $o->qty;
			$row[] = $o->defect_name1;
			$row[] = $o->qty1;
			$row[] = $o->defect_name2;
			$row[] = $o->qty2;
			$row[] = $option;
			$data[] = $row;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->DefectServerside->count_all(),
			"recordsFiltered" 	=> $this->DefectServerside->count_filtered($building, $tanggal),
			"data" 				=> $data
		);
		echo json_encode($output);
	}

	/* Get defect Name */
	public function get_defect_name()
	{
		$category = $this->input->post('category');
		$result = $this->db
			->select('defect_name')
			->from('master_defect')
			->where('defect_category', $category)
			->get()
			->result();

		echo json_encode($result);
	}
	/* Tambah Data Defect */
	public function tambah_data()
	{
		$result = $this->M_defect->tambahDataDefect();

		if ($result == 'update') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Defect berhasil diupdate',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} elseif ($result == 'insert') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Defect berhasil ditambahkan',
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

		redirect('Defect', 'refresh');
	}
	/* Upload data defect */
	public function upload_defect()
	{
		$result = $this->M_defect->processImportDefect();
		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Defect berhasil diimport',
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
		redirect('Defect', 'refresh');
	}
}

/* End of file: Defect.php */
