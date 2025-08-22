<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class M_Rft extends CI_Model
{

	protected $table = '';

	public function __construct()
	{
		parent::__construct();
	}

	public function tambahDataRft()
	{
		$rft_date 	= $this->input->post('rft_date');
		$cell 		= $this->input->post('cell');
		// Cek apakah data dengan cell dan date sudah ada
		$exist = $this->db->get_where('rft', [
			'id_cell' 			=> $cell,
			'rft_date' 			=> $rft_date
		])->row();

		$data = [
			// 'id_audit'     => $id_audit,
			'rft_date'   		=> $rft_date,
			'factory'      		=> $this->input->post('factory'),
			'id_cell'         	=> $cell,
			'rft'  				=> $this->input->post('rft'),
		];

		// ==== Simpan atau Update ====
		if ($exist) {
			// Update berdasarkan cell dan date
			$this->db->where('id_cell', $cell);
			$this->db->where('rft_date', $rft_date);
			if ($this->db->update('rft', $data)) {
				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text'  => 'Data Rft berhasil diupdate (by cell & date)',
					'icon'  => 'success',
					'type'  => 'success'
				]);
				return 'update';
			}
		} else {
			// Insert baru
			if ($this->db->insert('rft', $data)) {
				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text'  => 'Data Rft berhasil ditambahkan',
					'icon'  => 'success',
					'type'  => 'success'
				]);
				return 'insert';
			}
		}

		return false;
	}

	public function hapusRftById($id)
	{
		$this->db->where('id_rft', $id);
		$query = $this->db->delete('rft', ['id_rft' => $id]);
		return $query;
	}

	/* Import Excel File */
	function processImportRft()
	{

		$nama_file 					= uniqid('RFT_', true) . '.xlsx';
		$config['upload_path']   	= './file/temp/rft'; //Lokasi temp File
		$config['allowed_types'] 	= 'xls|xlsx';
		$config['file_name']     	= $nama_file;
		$config['overwrite']     	= true;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			// Gagal upload
			$response = $this->upload->display_errors();
			return [
				'kode' => 'error',
				'msg'  => $response
			];
		}
		// Berhasil upload
		$uploaded_data = $this->upload->data();
		$file_path = $uploaded_data['full_path'];

		try {
			$uploaded_data = $this->upload->data();
			$file_path = $uploaded_data['full_path']; // ✅ Ini path file sebenarnya

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
			$worksheet = $spreadsheet->getActiveSheet()->toArray();

			$result = $this->Import($worksheet);

			// Hapus file temp
			if (file_exists($file_path)) {
				unlink($file_path);
			}

			return 'success';
		} catch (\Throwable $e) {
			return [
				'kode' => 'error',
				'msg'  => 'Gagal membaca file: ' . $e->getMessage()
			];
		}
	}

	function getDataImport($data)
	{
		for ($i = 1; $i < count($data); $i++) {

			/* Sesuaikan Kolom yang ada */
			// Ambil data dari setiap baris (disesuaikan urutan kolom Excel)
			$kode_cell   	= isset($data[$i][0]) ? trim($data[$i][0]) : null;
			$factory     	= isset($data[$i][1]) ? trim($data[$i][1]) : null;
			$rft  			= isset($data[$i][3]) ? str_replace(',', '.', $data[$i][3]) : null;
			$rft_date  		= isset($data[$i][4]) ? trim($data[$i][4]) : null;

			// Validasi dasar
			if (!empty($kode_cell) && !empty($factory) && !empty($rft_date)) {
				$where = [
					'id_cell' 		=> $kode_cell,
					'rft_date' 		=> $rft_date
				];

				$cek = $this->db->get_where('rft', $where)->row();

				$dataInsert = [
					'id_cell' 		=> $kode_cell,
					'factory' 		=> $factory,
					'rft' 			=> $rft,
					'rft_date' 		=> $rft_date
				];
				// Lakukan insert atau update pada table pekerjaan

				// Cek apakah data sudah ada
				$this->db->where('LINE_CD', $kode_cell);
				$this->db->where('tanggal_pekerjaan', date('Y-m-d', strtotime($rft_date)));
				$pekerjaan = $this->db->get('pekerjaan')->row();
				// Jika sudah ada, update
				if ($pekerjaan) {
					// Jika sudah ada, update
					$this->db->where('LINE_CD', $kode_cell);
					$this->db->where('tanggal_pekerjaan', date('Y-m-d', strtotime($rft_date)));
					$this->db->update('pekerjaan', [
						'LINE_CD' => $kode_cell,
						'tanggal_pekerjaan' => date('Y-m-d', strtotime($rft_date)),
						'kpi_act_rft' => $rft
					]);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('pekerjaan', [
						'LINE_CD' 	=> $kode_cell,
						'tanggal_pekerjaan' => date('Y-m-d', strtotime($rft_date)),
						'kpi_act_rft' 		=> $rft
					]);
				}
				if ($cek) {
					// Jika sudah ada, update
					$this->db->where('id_rft', $cek->id_rft);
					$this->db->update('rft', $dataInsert);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('rft', $dataInsert);
				}
			}
		}
		return true;
	}

	function Import($data)
	{
		return $this->getDataImport($data);
	}

	/* BulkHapus */
	public function deleteByFactoryAndDate($factory, $date)
	{
		$this->db->where('factory', $factory);
		$this->db->where('rft_date', $date);
		return $this->db->delete('rft');
	}
}

/* End of file: M_Rft.php */
