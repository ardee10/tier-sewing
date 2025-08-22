<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class M_Safety extends CI_Model
{

	protected $table = '';

	public function __construct()
	{
		parent::__construct();
	}

	// public function tambahDataSafety()
	// {
	// 	$cell        = $this->input->post('cell');
	// 	$safety_date = $this->input->post('safety_date');

	// 	// Cek apakah sudah ada data dengan parameter cell dan date yang sama
	// 	$exist = $this->db->get_where('safety', [
	// 		'cell' 		=> $cell,
	// 		'safety_date' => $safety_date
	// 	])->row();

	// 	$data = [
	// 		'kode_factory'  => $this->input->post('factory'),
	// 		'cell'          => $cell,
	// 		'safety_date'   => $safety_date,
	// 		'lti'  			=> $this->input->post('lti'),
	// 		'nlti'  		=> $this->input->post('nlti'),
	// 		'total_lti'  	=> $this->input->post('total_lti'),
	// 		'total_nlti'  	=> $this->input->post('total_nlti'),
	// 	];

	// 	// ==== Proses Upload File ====
	// 	// if (!empty($_FILES['file']['name'])) {
	// 	// 	$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	// 	// 	$nama_file = strtoupper('SAFETY_' . $cell . '_' . $safety_date) . '.' . $ext;
	// 	// 	$config['upload_path']   = './assets/img/safety_file/';
	// 	// 	$config['allowed_types'] = 'jpg|jpeg|png|x-png|pjpeg';
	// 	// 	$config['max_size']      = 2048; // 2MB
	// 	// 	$config['file_name']     = $nama_file;
	// 	// 	$config['overwrite']     = true;

	// 	// 	$this->load->library('upload', $config);

	// 	// 	if ($this->upload->do_upload('file')) {
	// 	// 		$upload_data = $this->upload->data();
	// 	// 		$data['file'] = $upload_data['file_name'];

	// 	// 		// Hapus file lama jika ada
	// 	// 		if ($exist && !empty($exist->file_safety) && $exist->file_safety != $upload_data['file_name']) {
	// 	// 			$old_img = './assets/img/safety_file/' . $exist->file_safety;
	// 	// 			if (file_exists($old_img)) {
	// 	// 				@unlink($old_img);
	// 	// 			}
	// 	// 		}
	// 	// 	} else {
	// 	// 		$this->session->set_flashdata('message', [
	// 	// 			'title' => 'Error Upload',
	// 	// 			'text'  => strip_tags($this->upload->display_errors()),
	// 	// 			'icon'  => 'error',
	// 	// 			'type'  => 'danger'
	// 	// 		]);
	// 	// 		redirect('Safety');
	// 	// 		return false;
	// 	// 	}
	// 	// }

	// 	if (!empty($_FILES['file']['name'])) {
	// 		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	// 		$nama_file = strtoupper('SAFETY_' . $cell . '_' . $safety_date) . '.' . $ext;

	// 		$config['upload_path']   = './assets/img/safety_file/';
	// 		$config['allowed_types'] = 'jpg|jpeg|png';
	// 		$config['max_size']      = 2048; // 2MB
	// 		$config['file_name']     = $nama_file;
	// 		$config['overwrite']     = true;

	// 		$this->load->library('upload', $config);

	// 		if ($this->upload->do_upload('file')) {
	// 			$upload_data = $this->upload->data();
	// 			$data['file_safety'] = $upload_data['file_name'];  // ✅ Perbaikan di sini

	// 			// Hapus file lama jika ada
	// 			if ($exist && !empty($exist->file_safety) && $exist->file_safety != $upload_data['file_name']) {
	// 				$old_img = './assets/img/safety_file/' . $exist->file_safety;
	// 				if (file_exists($old_img)) {
	// 					@unlink($old_img);
	// 				}
	// 			}
	// 		} else {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Error Upload',
	// 				'text'  => strip_tags($this->upload->display_errors()),
	// 				'icon'  => 'error',
	// 				'type'  => 'danger'
	// 			]);
	// 			redirect('Safety');
	// 			return false;
	// 		}
	// 	}


	// 	// ==== Simpan atau Update ====
	// 	if ($exist) {
	// 		$this->db->where('cell', $cell);
	// 		$this->db->where('safety_date', $safety_date);
	// 		if ($this->db->update('safety', $data)) {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Success',
	// 				'text'  => 'Data Safety berhasil diupdate',
	// 				'icon'  => 'success',
	// 				'type'  => 'success'
	// 			]);
	// 			return 'update';
	// 		}
	// 	} else {
	// 		// Generate ID safety baru
	// 		$data['id_safety'] = uniqid('SF_');
	// 		if ($this->db->insert('safety', $data)) {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Success',
	// 				'text'  => 'Data Safety berhasil ditambahkan',
	// 				'icon'  => 'success',
	// 				'type'  => 'success'
	// 			]);
	// 			return 'insert';
	// 		}
	// 	}

	// 	return false;
	// }
	public function tambahDataSafety()
	{
		$cell        = $this->input->post('cell');
		$safety_date = $this->input->post('safety_date');

		// Cek apakah sudah ada data dengan parameter cell dan date yang sama
		$exist = $this->db->get_where('safety', [
			'cell' 		=> $cell,
			'safety_date' => $safety_date
		])->row();

		$data = [
			'kode_factory'  => $this->input->post('factory'),
			'cell'          => $cell,
			'safety_date'   => $safety_date,
			'lti'  			=> $this->input->post('lti'),
			'nlti'  		=> $this->input->post('nlti'),
			'total_lti'  	=> $this->input->post('total_lti'),
			'total_nlti'  	=> $this->input->post('total_nlti'),
		];

		// === Proses Upload File ===
		if (!empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$nama_file = strtoupper('SAFETY_' . $cell . '_' . $safety_date) . '.' . $ext;

			$config['upload_path']   = './assets/img/safety_file/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 2048; // 2MB
			$config['file_name']     = $nama_file;
			$config['overwrite']     = true;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('file')) {
				$upload_data = $this->upload->data();
				$data['file_safety'] = $upload_data['file_name'];

				// Hapus file lama jika ada
				if ($exist && !empty($exist->file_safety) && $exist->file_safety != $upload_data['file_name']) {
					$old_img = './assets/img/safety_file/' . $exist->file_safety;
					if (file_exists($old_img)) {
						@unlink($old_img);
					}
				}
			} else {
				$this->session->set_flashdata('message', [
					'title' => 'Error Upload',
					'text'  => strip_tags($this->upload->display_errors()),
					'icon'  => 'error',
					'type'  => 'danger'
				]);
				redirect('Safety');
				return false;
			}
		}

		// ==== Simpan atau Update ====
		if ($exist) {
			$this->db->where('cell', $cell);
			$this->db->where('safety_date', $safety_date);
			if ($this->db->update('safety', $data)) {

				// === UPDATE DATA PEKERJAAN ===
				$this->db->where([
					'LINE_CD' => $cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($safety_date))
				]);
				$this->db->update('pekerjaan', [
					'lti'         => $data['lti'],
					'nlti'        => $data['nlti'],
					'total_lti'   => $data['total_lti'],
					'total_nlti'  => $data['total_nlti'],
					'file_safety' => isset($data['file_safety']) ? $data['file_safety'] : null
				]);

				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text'  => 'Data Safety berhasil diupdate',
					'icon'  => 'success',
					'type'  => 'success'
				]);
				return 'update';
			}
		} else {
			// Generate ID safety baru
			$data['id_safety'] = uniqid('SF_');
			if ($this->db->insert('safety', $data)) {
				// === LAKUKAN INSERT DI TABLE PEKERJAAN ===

				$this->db->where([
					'LINE_CD' => $cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($safety_date))
				]);
				$exist_pekerjaan = $this->db->get('pekerjaan')->row();

				$data_pekerjaan = [
					'lti'         => $data['lti'],
					'nlti'        => $data['nlti'],
					'total_lti'   => $data['total_lti'],
					'total_nlti'  => $data['total_nlti'],
					'file_safety' => isset($data['file_safety']) ? $data['file_safety'] : null
				];

				if ($exist_pekerjaan) {
					// Update jika ada
					$this->db->where([
						'LINE_CD' => $cell,
						'tanggal_pekerjaan' => date('Y-m-d', strtotime($safety_date))
					]);
					$this->db->update('pekerjaan', $data_pekerjaan);
				} else {
					// Insert jika belum ada
					$data_pekerjaan['LINE_CD'] = $cell;
					$data_pekerjaan['tanggal_pekerjaan'] = date('Y-m-d', strtotime($safety_date));
					$this->db->insert('pekerjaan', $data_pekerjaan);
				}

				// === UPDATE DATA PEKERJAAN ===
				$this->db->where([
					'LINE_CD' => $cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($safety_date))
				]);
				$this->db->update('pekerjaan', [
					'lti'         => $data['lti'],
					'nlti'        => $data['nlti'],
					'total_lti'   => $data['total_lti'],
					'total_nlti'  => $data['total_nlti'],
					'file_safety' => isset($data['file_safety']) ? $data['file_safety'] : null
				]);

				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text'  => 'Data Safety berhasil ditambahkan',
					'icon'  => 'success',
					'type'  => 'success'
				]);
				return 'insert';
			}
		}
		return false;
	}

	function hapusdatabyId($id)
	{
		// Ambil data safety sebelum dihapus untuk referensi cell & safety_date
		$safety = $this->db->get_where('safety', ['id_safety' => $id])->row();

		if ($safety) {
			// Hapus data safety
			$this->db->where('id_safety', $id);
			$query = $this->db->delete('safety');

			if ($query) {
				// Kosongkan kolom terkait di tabel pekerjaan
				$this->db->where([
					'LINE_CD' => $safety->cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($safety->safety_date))
				]);
				$this->db->update('pekerjaan', [
					'lti'         => null,
					'nlti'        => null,
					'total_lti'   => null,
					'total_nlti'  => null,
					'file_safety' => null
				]);
			}

			return $query;
		}

		return false;
	}



	/* Import Excel File */
	function processImportSafety()
	{
		$nama_file = uniqid('Safety_', true) . '.xlsx';
		$config['upload_path']   = './file/temp/safety';
		$config['allowed_types'] = 'xls|xlsx';
		$config['file_name']     = $nama_file;
		$config['overwrite']     = true;
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
			$kode_cell   = trim($data[$i][0]); // Kolom A
			$factory     = trim($data[$i][1]); // Kolom B
			// Kolom C = nama cell (tidak dipakai)
			$lti         = (int) $data[$i][3]; // Kolom D
			$nlti        = (int) $data[$i][4]; // Kolom E
			$total_lti   = (int) $data[$i][5]; // Kolom F
			$total_nlti  = (int) $data[$i][6]; // Kolom G
			$safety_date = trim($data[$i][7]); // Kolom H

			// Validasi data minimal
			if (!empty($kode_cell) && !empty($factory) && !empty($safety_date)) {
				$where = [
					'cell'         => $kode_cell,
					'safety_date'  => $safety_date
				];

				$cek = $this->db->get_where('safety', $where)->row();

				$dataInsert = [
					'cell'         => $kode_cell,
					'kode_factory' => $factory,
					'lti'          => $lti,
					'nlti'         => $nlti,
					'total_lti'    => $total_lti,
					'total_nlti'   => $total_nlti,
					'safety_date'  => $safety_date
				];

				//Lakukan update atau insert pada table pekerjaan
				$this->db->where([
					'LINE_CD' => $kode_cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($safety_date))
				]);

				$exist_pekerjaan = $this->db->get('pekerjaan')->row();
				$data_pekerjaan = [
					'lti'         => $lti,
					'nlti'        => $nlti,
					'total_lti'   => $total_lti,
					'total_nlti'  => $total_nlti,
					'file_safety' => null // Tidak ada file di import
				];

				if ($exist_pekerjaan) {
					// Update jika ada
					$this->db->where([
						'LINE_CD' => $kode_cell,
						'tanggal_pekerjaan' => date('Y-m-d', strtotime($safety_date))
					]);
					$this->db->update('pekerjaan', $data_pekerjaan);
				} else {
					// Insert jika belum ada
					$data_pekerjaan['LINE_CD'] = $kode_cell;
					$data_pekerjaan['tanggal_pekerjaan'] = date('Y-m-d', strtotime($safety_date));
					$this->db->insert('pekerjaan', $data_pekerjaan);
				}
				//Final check untuk insert atau update data safety

				if ($cek) {
					// Update jika sudah ada
					$this->db->where('cell', $kode_cell);
					$this->db->where('safety_date', $safety_date);
					$this->db->update('safety', $dataInsert);
				} else {
					// Insert baru jika belum ada
					$this->db->insert('safety', $dataInsert);
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
		$this->db->where('kode_factory', $factory);
		$this->db->where('safety_date', $date);
		return $this->db->delete('safety');
	}
}

/* End of file: M_Safety.php */
