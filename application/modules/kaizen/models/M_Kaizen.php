<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class M_Kaizen extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function tambahDataKaizen()
	{
		$nama_file = null; // inisialisasi awal untuk data di table pekerjaan
		$cell        = $this->input->post('cell');
		$kaizen_date = $this->input->post('kaizen_date');

		// Cek apakah data kaizen sudah ada (berdasarkan cell dan tanggal)
		$exist = $this->db->get_where('kaizen', [
			'cell' => $cell,
			'kaizen_date' => $kaizen_date
		])->row();

		$data = [
			'factory'       => $this->input->post('factory'),
			'cell'          => $cell,
			'kaizen_date'   => $kaizen_date,
			'total_kaizen'  => $this->input->post('total_kaizen'),
		];

		// ===== Upload file jika ada =====
		if (!empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$nama_file = strtoupper('KAIZEN_' . $cell . '_' . $kaizen_date) . '.' . $ext;
			$config['upload_path']   = './assets/img/kaizen_file/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 2048;
			$config['file_name']     = $nama_file;
			$config['overwrite']     = true;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('file')) {
				$upload_data = $this->upload->data();
				// $data['file'] = $upload_data['file_name'];
				$data['file'] = $upload_data['file_name']; // update kaizen table

				// Hapus file lama jika ada
				if ($exist && !empty($exist->file) && $exist->file != $upload_data['file_name']) {
					$old_img = './assets/img/kaizen_file/' . $exist->file;
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
				redirect('Kaizen');
				return false;
			}
		}

		// ==== Simpan atau Update ke tabel kaizen ====
		if ($exist) {
			$this->db->where('cell', $cell);
			$this->db->where('kaizen_date', $kaizen_date);
			$success = $this->db->update('kaizen', $data);
			$jenis = 'update';
		} else {
			$data['id_kaizen'] = uniqid('KZ_');
			$success = $this->db->insert('kaizen', $data);
			$jenis = 'insert';
		}

		// ==== Jika berhasil, update juga ke tabel pekerjaan ====
		if ($success) {
			$update_pekerjaan = [
				'kaizen' => $this->input->post('total_kaizen')
			];
			if ($nama_file) {
				$update_pekerjaan['kaizen_file'] = $nama_file;
			}

			$this->db->where([
				'LINE_CD' => $cell,
				'tanggal_pekerjaan' => date('Y-m-d', strtotime($kaizen_date))
			]);
			$this->db->update('pekerjaan', $update_pekerjaan);
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text'  => 'Data Kaizen berhasil di' . $jenis,
				'icon'  => 'success',
				'type'  => 'success'
			]);

			return $jenis;
		}

		// Jika gagal
		$this->session->set_flashdata('message', [
			'title' => 'Error',
			'text'  => 'Gagal menyimpan data Kaizen',
			'icon'  => 'error',
			'type'  => 'danger'
		]);

		return false;
	}

	function hapusdatabyID($id)
	{
		// Ambil data kaizen sebelum dihapus untuk referensi cell & safety_date
		$kaizen = $this->db->get_where('kaizen', ['id_kaizen' => $id])->row();
		if ($kaizen) {
			// Hapus data kaizen
			$this->db->where('id_kaizen', $id);
			$query = $this->db->delete('kaizen');

			if ($query) {
				// Kosongkan kolom terkait di tabel pekerjaan
				$this->db->where([
					'LINE_CD' 			=> $kaizen->cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($kaizen->kaizen_date))
				]);
				$this->db->update('pekerjaan', [
					'kaizen'         		=> null,
					'kaizen_file'        	=> null,

				]);
			}

			return $query;
		}

		return false;
	}

	/* Import Excel File */
	function processImportKaizen()
	{

		$nama_file = uniqid('kaizen_', true) . '.xlsx';
		$config['upload_path']   = './file/temp/';
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
			$kode_cell = trim($data[$i][0]);  // Kolom A - kode Cell
			$factory   = trim($data[$i][1]);  // Kolom B - Factory
			// Kolom C = nama cell → tidak dipakai untuk insert
			$total_kaizen = (float) str_replace(',', '.', $data[$i][3]); // Kolom D - KAIZEN
			$kaizen_date  = trim($data[$i][4]);  // Kolom E - DATE (format: YYYY-MM-DD)

			// Validasi dasar
			if (!empty($kode_cell) && !empty($factory) && !empty($kaizen_date)) {
				$where = [
					'cell' 			=> $kode_cell,
					'kaizen_date' 	=> $kaizen_date
				];

				$cek = $this->db->get_where('kaizen', $where)->row();

				$dataInsert = [
					'cell' 			=> $kode_cell,
					'factory' 		=> $factory,
					'total_kaizen' 	=> $total_kaizen,
					'kaizen_date' 	=> $kaizen_date
				];

				//lakukan insert atau update ke tabel pekerjaan
				$this->db->where('LINE_CD', $kode_cell);
				$this->db->where('tanggal_pekerjaan', date('Y-m-d', strtotime($kaizen_date)));
				$pekerjaan = $this->db->get('pekerjaan')->row();
				if ($pekerjaan) {
					// Jika sudah ada, update
					$this->db->where('LINE_CD', $kode_cell);
					$this->db->where('tanggal_pekerjaan', date('Y-m-d', strtotime($kaizen_date)));
					$this->db->update('pekerjaan', [
						'kaizen' => $total_kaizen
					]);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('pekerjaan', [
						'LINE_CD' 	=> $kode_cell,
						'tanggal_pekerjaan' => date('Y-m-d', strtotime($kaizen_date)),
						'kaizen' 	=> $total_kaizen
					]);
				}
				if ($cek) {
					// Jika sudah ada, update
					$this->db->where('id_kaizen', $cek->id_kaizen);
					$this->db->update('kaizen', $dataInsert);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('kaizen', $dataInsert);
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

/* End of file: M_Kaizen.php */
