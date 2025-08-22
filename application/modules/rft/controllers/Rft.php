<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RFt extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_ServerSideRft', 'ServersideRft');
		$this->load->model('M_Rft', 'Rft');

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
			'title' 		=> 'RFT DASHBOARD',
			'factory'		=> $this->db->get_where('factory', ['active' => '1'])->result(),
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'index', $data);
	}

	/* ManPower ServerSide */
	public function ajax_RftServerSide($building = null, $tanggal = null)
	{

		$list = $this->ServersideRft->get_datatables($building, $tanggal);
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $o) {
			$option = '';
			/* Edit */
			$option .= '<a class="btn btn-info" onclick="edit_rft(this)" 
				data-id="' . $o->id_rft . '" 
				data-bs-toggle="modal" 
				data-bs-target="#modal_rft">
				<i class="icofont-ui-settings text-white"></i>
				</a>&nbsp;';
			/* Hapus */
			$option .= '<a class="btn btn-danger tombol-hapus" 
				href="' . base_url('Rft/hapus_data/' . $o->id_rft) . '">
				<i class="icofont-trash"></i>
			</a>';


			$row = array();
			$row[] = $no++;
			$row[] = $o->rft_date;
			$row[] = $o->factory;
			$row[] = $o->nama_cell;
			$row[] = $o->rft;
			$row[] = $option;
			$data[] = $row;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->ServersideRft->count_all(),
			"recordsFiltered" 	=> $this->ServersideRft->count_filtered($building, $tanggal),
			"data" 				=> $data
		);
		echo json_encode($output);
	}

	public function tambah_data()
	{
		$result = $this->Rft->tambahDataRft();

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

		redirect('Rft', 'refresh');
	}

	/* Edit and Update */
	public function getDataRftById($id)
	{
		$query = $this->db->get_where('rft', ['id_rft' => $id])->row();
		echo json_encode($query);
	}

	/* Delete Data */
	public function hapus_data($id)
	{
		$this->session->set_flashdata('message', [
			'title' => 'Success',
			'text' => 'Data berhasil dihapus',
			'icon' => 'success',
			'type' => 'success'
		]);
		$this->Rft->hapusRftById($id);
		redirect('Rft', 'refresh');
	}

	/* Import Page */
	public function import_rft()
	{
		$data = [
			'title' 		=> 'IMPORT DATA RFT',
			'user'			=> $this->user
		];

		$this->template->load('tema/index', 'import_rft', $data);
	}

	// Process Import

	public function upload_rft()
	{
		$result = $this->Rft->processImportRft();
		if ($result === 'success') {
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data RFT berhasil diimport',
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
		redirect('Rft', 'refresh');
	}

	/* Bulk delete */
	public function bulkDelete()
	{

		$factory  	= $this->input->post('factory');
		$rft_date  	= $this->input->post('rft_date');
		if (!$factory || !$rft_date) {
			$this->session->set_flashdata('message', [
				'title' => 'Error',
				'text' => 'Factory dan tanggal wajib dipilih!',
				'icon' => 'error',
				'type' => 'danger'
			]);
			redirect('Rft');
		}
		$deleted = $this->Rft->deleteByFactoryAndDate($factory, $rft_date);
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

		redirect('Rft');
	}
}

/* End of file: RFt.php */
