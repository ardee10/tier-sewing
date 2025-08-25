<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Cot extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function tambahDataCot()
	{
		$nama_file	 	= null; // inisialisasi awal untuk data di table pekerjaan
		$cell        	= $this->input->post('cell');
		$cot_date 		= $this->input->post('cot_date');

		// Cek apakah data cot sudah ada (berdasarkan cell dan tanggal)
		$exist = $this->db->get_where('cot', [
			'id_cell' 		=> $cell,
			'cot_date' 		=> $cot_date
		])->row();

		$data = [
			'kode_factory'  => $this->input->post('kode_factory'),
			'id_cell'       => $cell,
			'cot_date'   	=> $cot_date,
			'qty_cot'  		=> $this->input->post('qty_cot'),
		];

		// ===== Upload file jika ada =====
		if (!empty($_FILES['file_cot']['name'])) {
			$ext = pathinfo($_FILES['file_cot']['name'], PATHINFO_EXTENSION);
			$nama_file = strtoupper('COT_' . $cell . '_' . $cot_date) . '.' . $ext;
			$config['upload_path']   = './assets/img/cot_file/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 2048;
			$config['file_name']     = $nama_file;
			$config['overwrite']     = true;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('file_cot')) {
				$upload_data = $this->upload->data();
				// $data['file'] = $upload_data['file_name'];
				$data['file_cot'] = $upload_data['file_name']; // update Cot table

				// Hapus file lama jika ada
				if ($exist && !empty($exist->file_cot) && $exist->file_cot != $upload_data['file_name']) {
					$old_img = './assets/img/cot_file/' . $exist->file_cot;
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
				redirect('Cot');
				return false;
			}
		}

		// ==== Simpan atau Update ke tabel Cot ====
		if ($exist) {
			$this->db->where('id_cell', $cell);
			$this->db->where('cot_date', $cot_date);
			$success = $this->db->update('cot', $data);
			$jenis = 'update';
		} else {
			$data['id_cot'] = uniqid('COT_');
			$success = $this->db->insert('cot', $data);
			$jenis = 'insert';
		}

		// ==== Jika berhasil, update juga ke tabel pekerjaan ====
		if ($success) {
			$update_pekerjaan = [
				'cot' => $this->input->post('qty_cot')
			];
			if ($nama_file) {
				$update_pekerjaan['file_cot'] = $nama_file;
			}

			$this->db->where([
				'LINE_CD' 	=> $cell,
				'tanggal_pekerjaan' => date('Y-m-d', strtotime($cot_date))
			]);
			$this->db->update('pekerjaan', $update_pekerjaan);
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Cot berhasil di' . $jenis,
				'icon'  => 'success',
				'type'  => 'success'
			]);

			return $jenis;
		}
		// Jika gagal
		$this->session->set_flashdata('message', [
			'title' => 'Error',
			'text'  => 'Gagal menyimpan data Cot',
			'icon'  => 'error',
			'type'  => 'danger'
		]);

		return false;
	}
	/* Hapus data by_id */
	public function hapusdatabyId($id)
	{

		// Ambil data cot sebelum dihapus untuk referensi cell & safety_date
		$cot = $this->db->get_where('cot', ['id_cot' => $id])->row();
		if ($cot) {
			// Hapus data cot
			$this->db->where('id_cot', $id);
			$query = $this->db->delete('cot');

			if ($query) {
				// Kosongkan kolom terkait di tabel pekerjaan
				$this->db->where([
					'LINE_CD' 			=> $cot->id_cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($cot->cot_date))
				]);
				$this->db->update('pekerjaan', [
					'cot'         		=> null,
					'file_cot'        	=> null,

				]);
			}

			return $query;
		}

		return false;
	}

	/* Import Excel File */
	function processImportCot()
	{
		$nama_file 					= uniqid('Cot_', true) . '.xlsx';
		$config['upload_path']   	= './file/temp/cot'; //Lokasi temp File
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
			$qty_cot  		= isset($data[$i][3]) ? str_replace(',', '.', $data[$i][3]) : null;
			$cot_date  		= isset($data[$i][4]) ? trim($data[$i][4]) : null;

			// Validasi dasar
			if (!empty($kode_cell) && !empty($factory) && !empty($cot_date)) {
				$where = [
					'id_cell' 			=> $kode_cell,
					'cot_date' 			=> $cot_date
				];
				$cek = $this->db->get_where('cot', $where)->row();
				$dataInsert = [
					'id_cell' 			=> $kode_cell,
					'kode_factory' 		=> $factory,
					'qty_cot' 			=> $qty_cot,
					'cot_date' 			=> $cot_date
				];
				//lakukan insert atau update di table pekerjaan
				$cek_pekerjaan = $this->db->get_where('pekerjaan', [
					'LINE_CD'           => $kode_cell,
					'tanggal_pekerjaan' => $cot_date
				])->row();

				if ($cek_pekerjaan) {
					// Update pekerjaan
					$this->db->where([
						'LINE_CD'           => $kode_cell,
						'tanggal_pekerjaan' => $cot_date
					]);
					$this->db->update('pekerjaan', [
						'cot' 		=> $qty_cot
					]);
				} else {
					// Insert pekerjaan baru
					$this->db->insert('pekerjaan', [
						'LINE_CD'           => $kode_cell,
						'tanggal_pekerjaan' => $cot_date,
						'cot'             	=> $qty_cot
					]);
				}
				if ($cek) {
					// Jika sudah ada, update
					$this->db->where('id_cot', $cek->id_cot);
					$this->db->update('cot', $dataInsert);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('cot', $dataInsert);
				}
			}
		}
		return true;
	}

	function Import($data)
	{
		return $this->getDataImport($data);
	}
}

/* End of file: M_Cot.php */
