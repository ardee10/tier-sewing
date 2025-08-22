<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Serversidemodel', 'Serverside');
		$this->load->model('M_Admin', 'Admin');
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
	public function master_model()
	{
		$data = [
			'title' 		=> 'MASTER DATA MODEL, MP & LC',
			'user' 			=> $this->user

		];
		$this->template->load('tema/index', 'model', $data);
	}
	// Server Side
	public function ajax_ModelServerside()
	{

		$list = $this->Serverside->get_datatables();
		$data = array();
		$no = $_POST['start'] + 1;

		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_model(this)" 
				data-id="' . $o->id_model . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_model">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('Admin/hapus_data/' . $o->id_model) . '">
				<i class="icofont-trash"></i>
			</a>';

			$path = 'assets/img/product_model/' . $o->img_model;

			if (file_exists($path) && $o->img_model != null) {
				$img = base_url() . 'assets/img/product_model/' . $o->img_model;
			} else {
				$img = base_url() . 'assets/img/product_model/no_image.png';
			}


			$row = array();
			$row[] = $no++;
			$row[] = $o->target;
			$row[] = '<img width="80px" src="' . $img . '">';
			$row[] = $o->kode_model;
			$row[] = $o->nama_model;
			$row[] = $o->mp_sewing + $o->mp_prep + $o->mp_ws;
			$row[] = $o->lc;
			$row[] = $option;
			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Serverside->count_all(),
			"recordsFiltered" 	=> $this->Serverside->count_filtered(),
			"data" 				=> $data,
		);
		echo json_encode($output);
	}
	/* Insert and Update */
	public function tambah_data_model()
	{
		$result = $this->Admin->tambahDataModel();

		if ($result == 'update') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Model berhasil diupdate',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} elseif ($result == 'insert') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Model berhasil ditambahkan',
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

		redirect('Admin/master_model', 'refresh');
	}
	/* mengambil data model by Id */
	public function getDataModelById($id)
	{
		$data = $this->db->get_where('model', ['id_model' => $id])->row();
		echo json_encode($data);
	}
	/* Hapus data */
	function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);

		$this->Admin->hapusDataModel($id);
		redirect('Admin/master_model', 'refresh');
	}

	/* Halaman Import Model */
	public function import_model()
	{
		$data = [
			'title' 		=> 'IMPORT DATA MASTER MODEL',
			'user' 			=> $this->user
		];
		$this->template->load('tema/index', 'import/import_model', $data);
	}

	/* Action di arahkan ke method ini */
	public function upload_model()
	{
		$result = $this->Admin->processImportModel();

		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Model berhasil diimport',
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

		redirect('Admin/master_model', 'refresh');
	}

	/* export data model */
	function export_model()
	{
		$data['model'] = $this->db->get('model')->result();
		$this->load->view('export/export_model', $data);
	}
}

/* End of file: Admin.php */
