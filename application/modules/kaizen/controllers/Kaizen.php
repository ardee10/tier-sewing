<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaizen extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_KaizenServerSide', 'Serverside');
		$this->load->model('M_Kaizen', 'Kaizen');

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
			'title' 		=> 'Kaizen Admin Dashboard',
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'index', $data);
	}

	public function ajax_KaizenServerSide($building = null, $tanggal = null)
	{

		$list = $this->Serverside->get_datatables($building, $tanggal);
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_kaizen(this)" 
				data-id="' . $o->id_kaizen . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_kaizen">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('Kaizen/hapus_data/' . $o->id_kaizen) . '">
				<i class="icofont-trash"></i>
			</a>';

			/* Path Location */
			$path = 'assets/img/kaizen_file/' . $o->file;
			if (file_exists($path) && $o->file != null) {
				$img = base_url() . 'assets/img/kaizen_file/' . $o->file;
			} else {
				$img = base_url() . 'assets/img/kaizen_file/no_image.png';
			}


			$row = array();
			$row[] = $no++;
			$row[] = $o->kaizen_date;
			$row[] = $o->factory;
			$row[] = $o->nama_cell;
			$row[] = $o->total_kaizen;
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
		$result = $this->Kaizen->tambahDataKaizen();

		if ($result == 'update') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Kaizen berhasil diupdate',
				'icon'  => 'success',
				'type'  => 'success'
			]);
		} elseif ($result == 'insert') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Kaizen berhasil ditambahkan',
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

		redirect('Kaizen', 'refresh');
	}

	public function getDataKaizenById($id)
	{
		$data = $this->db->get_where('kaizen', ['id_kaizen' => $id])->row();
		echo json_encode($data);
	}

	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->Kaizen->hapusdatabyID($id);
		redirect('Kaizen', 'refresh');
	}

	public function import_kaizen()
	{
		/* Import File Kazien */
		$data = [
			'title' 		=> 'IMPORT FILE KAIZEN',
			'user'			=> $this->user
		];
		$this->template->load('tema/index', 'import_kaizen', $data);
	}

	public function upload_kaizen()
	{
		$result = $this->Kaizen->processImportKaizen();
		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Kaizen berhasil diimport',
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
		redirect('kaizen', 'refresh');
	}
}

/* End of file: Kaizen.php */
