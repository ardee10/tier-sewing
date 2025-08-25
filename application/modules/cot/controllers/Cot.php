<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cot extends CI_Controller
{
	protected $arrContextOptions;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Serversidecot', 'Serverside');
		$this->load->model('M_Cot');

		$sesi = ['superadmin', 'lc', 'lexim', 'layout', 'cot'];
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
			'title' 		=> 'COT ADMIN DASHBOARD',
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'index', $data);
	}
	/* AjaxCotServerside */
	function ajax_CotServerSide($building = null, $tanggal = null)
	{
		$list = $this->Serverside->get_datatables($building, $tanggal);
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_cot(this)" 
				data-id="' . $o->id_cot . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_cot">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('cot/hapus_data/' . $o->id_cot) . '">
				<i class="icofont-trash"></i>
			</a>';

			/* Path Location */
			$path = 'assets/img/cot_file/' . $o->file_cot;
			if (file_exists($path) && $o->file_cot != null) {
				$img = base_url() . 'assets/img/cot_file/' . $o->file_cot;
			} else {
				$img = base_url() . 'assets/img/no_images.png';
			}

			$row = array();
			$row[] = $no++;
			$row[] = $o->cot_date;
			$row[] = $o->kode_factory;
			$row[] = $o->nama_cell;
			$row[] = $o->qty_cot;
			$row[] = '<img width="50px" src="' . $img . '">';
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
		$result = $this->M_Cot->tambahDataCot();
		if ($result == 'update') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Cot berhasil diupdate',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} elseif ($result == 'insert') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Cot berhasil ditambahkan',
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

		redirect('Cot', 'refresh');
	}

	/* Edit */
	public function getDataCotById($id)
	{
		$query = $this->db->get_where('cot', ['id_cot' => $id])->row();
		echo json_encode($query);
	}

	/* Hapus data by Id */
	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->M_Cot->hapusdatabyId($id);
		redirect('Cot', 'refresh');
	}

	/* Import COt From Excel File */

	public function import_cot()
	{
		/* Import File Kazien */
		$data = [
			'title' 		=> 'IMPORT FILE COT',
			'user'			=> $this->user
		];
		$this->template->load('tema/index', 'import', $data);
	}
	/* Action Import File Cot */
	public function upload_cot()
	{
		$result = $this->M_Cot->processImportCot();
		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Cot berhasil diimport',
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
		redirect('Cot', 'refresh');
	}
}

/* End of file: Cot.php */
