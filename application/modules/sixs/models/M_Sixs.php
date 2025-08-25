<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class M_Sixs extends CI_Model
{

	// protected $table = '';

	public function __construct()
	{
		parent::__construct();
	}

	// public function tambahDataSixs()
	// {
	// 	// $id_audit  	= $this->input->post('id_audit');
	// 	$audit_date = $this->input->post('audit_date');
	// 	$cell 		= $this->input->post('cell');

	// 	// Cek apakah data dengan cell dan date sudah ada
	// 	$exist = $this->db->get_where('audit', [
	// 		'cell' 			=> $cell,
	// 		'audit_date' 	=> $audit_date
	// 	])->row();

	// 	$data = [
	// 		// 'id_audit'     => $id_audit,
	// 		'audit_date'   => $audit_date,
	// 		'factory'      => $this->input->post('factory'),
	// 		'cell'         => $cell,
	// 		'total_audit'  => $this->input->post('total_audit'),
	// 	];

	// 	// ==== Upload file jika ada ====
	// 	if (!empty($_FILES['file_six']['name'])) {
	// 		$ext = pathinfo($_FILES['file_six']['name'], PATHINFO_EXTENSION);
	// 		$nama_file = strtoupper('AUDIT_' . $cell . '_' . $audit_date) . '.' . $ext;
	// 		$config['upload_path']   = './assets/img/sixs_file/';
	// 		$config['allowed_types'] = 'jpg|jpeg|png|x-png|pjpeg';
	// 		$config['max_size']      = 2048; // 2MB
	// 		$config['file_name']     = $nama_file;
	// 		$config['overwrite']     = true;

	// 		$this->load->library('upload', $config);

	// 		if ($this->upload->do_upload('file_six')) {
	// 			$upload_data = $this->upload->data();
	// 			$data['file_six'] = $upload_data['file_name'];

	// 			// Hapus file lama jika ada dan beda
	// 			if ($exist && !empty($exist->file_six) && $exist->file_six != $upload_data['file_name']) {
	// 				$old_file = './assets/img/sixs_file/' . $exist->file_six;
	// 				if (file_exists($old_file)) {
	// 					@unlink($old_file);
	// 				}
	// 			}
	// 		} else {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Error Upload',
	// 				'text'  => strip_tags($this->upload->display_errors()),
	// 				'icon'  => 'error',
	// 				'type'  => 'danger'
	// 			]);
	// 			redirect('Sixs');
	// 			return false;
	// 		}
	// 	}

	// 	// ==== Simpan atau Update ====
	// 	if ($exist) {
	// 		// Update berdasarkan cell dan date
	// 		$this->db->where('cell', $cell);
	// 		$this->db->where('audit_date', $audit_date);
	// 		if ($this->db->update('audit', $data)) {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Success',
	// 				'text'  => 'Data SixS berhasil diupdate (by cell & date)',
	// 				'icon'  => 'success',
	// 				'type'  => 'success'
	// 			]);
	// 			return 'update';
	// 		}
	// 	} else {
	// 		// Insert baru
	// 		if ($this->db->insert('audit', $data)) {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Success',
	// 				'text'  => 'Data SixS berhasil ditambahkan',
	// 				'icon'  => 'success',
	// 				'type'  => 'success'
	// 			]);
	// 			return 'insert';
	// 		}
	// 	}

	// 	return false;
	// }

	public function tambahDataSixs()
	{
		$audit_date = $this->input->post('audit_date');
		$cell       = $this->input->post('cell');
		$total_audit = $this->input->post('total_audit');
		$factory     = $this->input->post('factory');

		// Cek apakah data sudah ada di tabel audit
		$exist = $this->db->get_where('audit', [
			'cell'       => $cell,
			'audit_date' => $audit_date
		])->row();

		$data = [
			'audit_date'  => $audit_date,
			'factory'     => $factory,
			'cell'        => $cell,
			'total_audit' => $total_audit,
		];

		$nama_file = null;

		// ==== Upload file jika ada ====
		if (!empty($_FILES['file_six']['name'])) {
			$ext = pathinfo($_FILES['file_six']['name'], PATHINFO_EXTENSION);
			$nama_file = strtoupper('AUDIT_' . $cell . '_' . $audit_date) . '.' . $ext;
			$config['upload_path']   = './assets/img/sixs_file/';
			$config['allowed_types'] = 'jpg|jpeg|png|x-png|pjpeg';
			$config['max_size']      = 2048;
			$config['file_name']     = $nama_file;
			$config['overwrite']     = true;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('file_six')) {
				$upload_data = $this->upload->data();
				$data['file_six'] = $upload_data['file_name'];

				// Hapus file lama jika berbeda
				if ($exist && !empty($exist->file_six) && $exist->file_six != $upload_data['file_name']) {
					$old_file = './assets/img/sixs_file/' . $exist->file_six;
					if (file_exists($old_file)) {
						@unlink($old_file);
					}
				}
			} else {
				$this->session->set_flashdata('message', [
					'title' => 'Error Upload',
					'text'  => strip_tags($this->upload->display_errors()),
					'icon'  => 'error',
					'type'  => 'danger'
				]);
				redirect('Sixs');
				return false;
			}
		}

		// ==== Insert / Update ke audit ====
		$success = false;

		if ($exist) {
			$this->db->where('cell', $cell);
			$this->db->where('audit_date', $audit_date);
			$success = $this->db->update('audit', $data);
			$text_success = 'Data SixS berhasil diupdate (by cell & date)';
		} else {
			$success = $this->db->insert('audit', $data);
			$text_success = 'Data SixS berhasil ditambahkan';
		}

		// ==== Update / Insert ke pekerjaan ====
		if ($success) {
			$update_pekerjaan = [
				'six_s' => $total_audit
			];
			if ($nama_file) {
				$update_pekerjaan['file_six'] = $nama_file;
			}

			$cek_pekerjaan = $this->db->get_where('pekerjaan', [
				'LINE_CD'           => $cell,
				'tanggal_pekerjaan' => $audit_date
			])->row();

			if ($cek_pekerjaan) {
				// Update
				$this->db->where([
					'LINE_CD'           => $cell,
					'tanggal_pekerjaan' => $audit_date
				]);
				$this->db->update('pekerjaan', $update_pekerjaan);
			} else {
				// Insert baru
				$insert_pekerjaan = [
					'LINE_CD'           => $cell,
					'tanggal_pekerjaan' => $audit_date,
					'six_s'             => $total_audit
				];
				if ($nama_file) {
					$insert_pekerjaan['file_six'] = $nama_file;
				}
				$this->db->insert('pekerjaan', $insert_pekerjaan);
			}

			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => $text_success,
				'icon'  => 'success',
				'type'  => 'success'
			]);
			return $exist ? 'update' : 'insert';
		}

		return false;
	}
	public function deleteById($id)
	{
		// Ambil data Sixs sebelum dihapus untuk referensi cell & audit_date
		$sixs = $this->db->get_where('audit', ['id_audit' => $id])->row();
		if ($sixs) {
			// Hapus data Sixs
			$this->db->where('id_audit', $id);
			$query = $this->db->delete('audit');

			if ($query) {
				// Kosongkan kolom terkait di tabel pekerjaan
				$this->db->where([
					'LINE_CD' 			=> $sixs->cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($sixs->audit_date))
				]);
				$this->db->update('pekerjaan', [
					'six_s'         	=> null,
					'file_six'        	=> null,

				]);
			}

			return $query;
		}

		return false;
	}
	/* Import Excel File */
	function processImportSixs()
	{

		$nama_file 					= uniqid('Sixs_', true) . '.xlsx';
		$config['upload_path']   	= './file/temp/SixS'; //Lokasi temp File
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
			$kode_cell   = isset($data[$i][0]) ? trim($data[$i][0]) : null;
			$factory     = isset($data[$i][1]) ? trim($data[$i][1]) : null;
			$total_sixs  = isset($data[$i][3]) ? str_replace(',', '.', $data[$i][3]) : null;
			$audit_date  = isset($data[$i][4]) ? trim($data[$i][4]) : null;

			// Validasi dasar
			if (!empty($kode_cell) && !empty($factory) && !empty($audit_date)) {
				$where = [
					'cell' 			=> $kode_cell,
					'audit_date' 	=> $audit_date
				];

				$cek = $this->db->get_where('audit', $where)->row();

				$dataInsert = [
					'cell' 			=> $kode_cell,
					'factory' 		=> $factory,
					'total_audit' 	=> $total_sixs,
					'audit_date' 	=> $audit_date
				];
				//lakukan insert atau update di table pekerjaan
				$cek_pekerjaan = $this->db->get_where('pekerjaan', [
					'LINE_CD'           => $kode_cell,
					'tanggal_pekerjaan' => $audit_date
				])->row();

				if ($cek_pekerjaan) {
					// Update pekerjaan
					$this->db->where([
						'LINE_CD'           => $kode_cell,
						'tanggal_pekerjaan' => $audit_date
					]);
					$this->db->update('pekerjaan', [
						'six_s' => $total_sixs
					]);
				} else {
					// Insert pekerjaan baru
					$this->db->insert('pekerjaan', [
						'LINE_CD'           => $kode_cell,
						'tanggal_pekerjaan' => $audit_date,
						'six_s'             => $total_sixs
					]);
				}
				if ($cek) {
					// Jika sudah ada, update
					$this->db->where('id_audit', $cek->id_audit);
					$this->db->update('audit', $dataInsert);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('audit', $dataInsert);
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
		$this->db->where('audit_date', $date);
		return $this->db->delete('audit');
	}
}

/* End of file: M_Sixs.php */
