<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class M_Admin extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	/* insert and update */
	public function tambahDataModel()
	{
		$id_model = $this->input->post('id_model');
		$exist = $this->db->get_where('model', ['id_model' => $id_model])->row();

		$kode_model = $this->input->post('kode_model');

		$data = [
			'nama_model'  	=> $this->input->post('nama_model'),
			'kode_model'  	=> $kode_model,
			'target'      	=> $this->input->post('target'),
			'mp_prep'     	=> $this->input->post('mp_prep'),
			'mp_sewing'   	=> $this->input->post('mp_sewing'),
			'mp_ws'       	=> $this->input->post('mp_ws'),
			'lc'          	=> $this->input->post('lc'),
			'model_created'	=> date('Y-m-d')
		];

		// Upload gambar jika ada
		if (!empty($_FILES['img_model']['name'])) {

			// Ambil ekstensi file asli
			$ext = pathinfo($_FILES['img_model']['name'], PATHINFO_EXTENSION);
			$nama_file = strtoupper(str_replace(' ', '_', $kode_model)) . '.' . $ext;

			$config['upload_path']   = './assets/img/product_model/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 2048;
			$config['file_name']     = $nama_file;
			$config['overwrite']     = true;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('img_model')) {
				$upload_data = $this->upload->data();
				$data['img_model'] = $upload_data['file_name'];

				// Hapus gambar lama jika beda nama
				if ($exist && !empty($exist->img_model) && $exist->img_model != $upload_data['file_name']) {
					$old_img = './assets/img/product_model/' . $exist->img_model;
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
			}
		}

		// Jika update
		if ($exist) {
			$this->db->where('id_model', $id_model);
			if ($this->db->update('model', $data)) {
				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text' => 'Data Model berhasil diupdate',
					'icon' => 'success',
					'type' => 'success'
				]);
				return 'update';
			}
		} else {
			if ($this->db->insert('model', $data)) {
				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text' => 'Data Model berhasil ditambahkan',
					'icon' => 'success',
					'type' => 'success'
				]);
				return 'insert';
			}
		}

		return false;
	}

	/* Hapus data */
	public function hapusDataModel($id)
	{

		$this->db->where('id_model', $id);
		$query = $this->db->delete('model', ['id_model' => $id]);
		return $query;
	}
	/* Import excel file */
	public function processImportModel()
	{
		$nama_file = uniqid('model_', true) . '.xlsx';
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
			$allowed_targets = ['60', '120', '130'];

			if (isset($data[$i][0]) && in_array(trim($data[$i][0]), $allowed_targets)) {
				$target 	= trim($data[$i][0]); // kolom A - target
				$kode_model  = $data[$i][1]; // kolom B - Artikel
				$nama_model  = $data[$i][2]; // kolom C - nama_model
				$mp_prep     = (float) str_replace(',', '.', $data[$i][3]); // kolom D
				$mp_sewing   = (float) str_replace(',', '.', $data[$i][4]); // kolom E
				$mp_ws       = (float) str_replace(',', '.', $data[$i][5]); // kolom F
				$lc          = (float) str_replace(',', '.', $data[$i][6]); // kolom G

				// Cek apakah data sudah ada
				$where = [
					'kode_model'  => $kode_model,
					'nama_model'  => $nama_model
				];

				$cek = $this->db->get_where('model', $where)->row();

				$dataInsert = [

					'target'        => $target,
					'nama_model'    => $nama_model,
					'mp_prep'       => $mp_prep,
					'mp_sewing'     => $mp_sewing,
					'mp_ws'         => $mp_ws,
					'lc'            => $lc,
					'kode_model'    => $kode_model,
					'model_created' => date('Y-m-d')
				];
				// Array ( [target] => 60 [nama_model] => Duramo 1 [mp_prep] => 10 [mp_sewing] => 10 [mp_ws] => 10 [lc] => 160 [kode_model] => test1 [model_created] => 2025-07-21 )

				if ($cek) {
					$this->db->where('id_model', $cek->id_model);
					$this->db->update('model', $dataInsert);
				} else {
					$this->db->insert('model', $dataInsert);
				}
			}
		}
		return true;
	}

	function Import($data)
	{
		return $this->getDataImport($data);
	}

	function export()
	{

		$data =  $this->db->get('model')->result();
		return $data;
	}
}

/* End of file: M_Admin.php */
