<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class M_defect extends CI_Model
{

	protected $table = '';

	public function __construct()
	{
		parent::__construct();
	}
	public function master_defect()
	{

		$this->db->select('defect_category');
		$this->db->distinct();
		$query = $this->db->get('master_defect');
		return $query->result();
	}
	/* Tambah Defect */
	public function tambahDataDefect()
	{
		$cell        = $this->input->post('cell');
		$defect_date = $this->input->post('defect_date');

		// Cek apakah data defect sudah ada
		$exist = $this->db->get_where('defect', [
			'cell'        => $cell,
			'defect_date' => $defect_date
		])->row();

		// Data yang akan disimpan
		$data = [
			'factory'          => $this->input->post('factory'),
			'cell'             => $cell,
			'defect_date'      => $defect_date,
			'model'            => $this->input->post('model'),

			'defect_category'  => $this->input->post('defect_category'),
			'defect_name'      => $this->input->post('defect_name'),
			'qty'              => $this->input->post('qty'),

			'defect_category1' => $this->input->post('defect_category1'),
			'defect_name1'     => $this->input->post('defect_name1'),
			'qty1'             => $this->input->post('qty1'),

			'defect_category2' => $this->input->post('defect_category2'),
			'defect_name2'     => $this->input->post('defect_name2'),
			'qty2'             => $this->input->post('qty2')
		];

		if ($exist) {
			$this->db->where('cell', $cell);
			$this->db->where('defect_date', $defect_date);
			$success = $this->db->update('defect', $data);
			$jenis = 'update';
		} else {
			$data['id_defect'] = uniqid('DF_');
			$success = $this->db->insert('defect', $data);
			$jenis = 'insert';
		}

		// Jika berhasil, update tabel pekerjaan
		if ($success) {
			$update_pekerjaan = [
				'defect_name'  => $this->input->post('defect_name'),
				'qty'          => $this->input->post('qty'),
				'defect_name1' => $this->input->post('defect_name1'),
				'qty1'         => $this->input->post('qty1'),
				'defect_name2' => $this->input->post('defect_name2'),
				'qty2'         => $this->input->post('qty2')
			];

			$this->db->where([
				'LINE_CD' => $cell,
				'tanggal_pekerjaan' => date('Y-m-d', strtotime($defect_date))
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
	/* Hapus data */
	public function hapusdatabyId($id)
	{
		// Ambil data defect sebelum dihapus untuk referensi cell & defect_date
		$defect = $this->db->get_where('defect', ['id_defect' => $id])->row();
		if ($defect) {
			// Hapus data defect
			$this->db->where('id_defect', $id);
			$query = $this->db->delete('defect');

			if ($query) {
				// Kosongkan kolom terkait di tabel pekerjaan
				$this->db->where([
					'LINE_CD' 			=> $defect->cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($defect->defect_date))
				]);
				$this->db->update('pekerjaan', [
					'defect_name'   => null,
					'qty'          	=> null,
					'defect_name1'  => null,
					'qty1'          => null,
					'defect_name2'  => null,
					'qty2'          => null

				]);
			}

			return $query;
		}

		return false;
	}
	/* Import Excel File */
	function processImportDefect()
	{

		$nama_file 					= uniqid('DEEFCT_', true) . '.xlsx';
		$config['upload_path']   	= './file/temp/defect'; //Lokasi temp File
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

			// Ambil data dari setiap baris (disesuaikan urutan kolom Excel)
			$kode_cell   		= isset($data[$i][0]) ? trim($data[$i][0]) : null;
			$factory     		= isset($data[$i][1]) ? trim($data[$i][1]) : null;
			$model       		= isset($data[$i][3]) ? trim($data[$i][3]) : null;
			$defect_category  	= isset($data[$i][4]) ? trim($data[$i][4]) : null;
			$defect_name      	= isset($data[$i][5]) ? trim($data[$i][5]) : null;
			$qty			 	= isset($data[$i][6]) ? str_replace(',', '.', $data[$i][6]) : null;
			$defect_category1 	= isset($data[$i][7]) ? trim($data[$i][7]) : null;
			$defect_name1     	= isset($data[$i][8]) ? trim($data[$i][8]) : null;
			$qty1			 	= isset($data[$i][9]) ? str_replace(',', '.', $data[$i][9]) : null;
			$defect_category2 	= isset($data[$i][10]) ? trim($data[$i][10]) : null;
			$defect_name2     	= isset($data[$i][11]) ? trim($data[$i][11]) : null;
			$qty2			 	= isset($data[$i][12]) ? str_replace(',', '.', $data[$i][12]) : null;
			$defect_date  		= isset($data[$i][13]) ? trim($data[$i][13]) : null;

			// Validasi 
			if (!empty($kode_cell) && !empty($factory) && !empty($defect_date)) {
				$where = [
					'cell' 				=> $kode_cell,
					'defect_date' 		=> $defect_date
				];
				$cek = $this->db->get_where('defect', $where)->row();

				$dataInsert = [
					// 'id_defect' 		=> $kode_cell,
					'cell'		 		=> $kode_cell,
					'factory' 			=> $factory,
					'model' 			=> $model,
					'defect_category' 	=> $defect_category,
					'defect_name' 		=> $defect_name,
					'qty' 				=> $qty,
					'defect_category1' 	=> $defect_category1,
					'defect_name1' 		=> $defect_name1,
					'qty1' 				=> $qty1,
					'defect_category2' 	=> $defect_category2,
					'defect_name2' 		=> $defect_name2,
					'qty2' 				=> $qty2,
					'defect_date' 		=> $defect_date
				];

				//Lakukan Insert atau Update juga di Table pekerjaan
				$dataPekerjaan = [
					'LINE_CD' 			=> $kode_cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($defect_date)),
					'defect_name' 		=> $defect_name,
					'qty' 				=> $qty,
					'defect_name1' 		=> $defect_name1,
					'qty1' 				=> $qty1,
					'defect_name2' 		=> $defect_name2,
					'qty2' 				=> $qty2
				];

				// Cek apakah data pekerjaan sudah ada
				$cekPekerjaan = $this->db->get_where('pekerjaan', [
					'LINE_CD' => $kode_cell,
					'tanggal_pekerjaan' => date('Y-m-d', strtotime($defect_date))
				])->row();

				if ($cekPekerjaan) {
					// Jika sudah ada, update
					$this->db->where('LINE_CD', $kode_cell);
					$this->db->where('tanggal_pekerjaan', date('Y-m-d', strtotime($defect_date)));
					$this->db->update('pekerjaan', $dataPekerjaan);
				} else {
					// Jika belum ada, insert baru
					$dataPekerjaan['id_pekerjaan'] = uniqid('PEK_');
					$this->db->insert('pekerjaan', $dataPekerjaan);
				}

				if ($cek) {
					// Jika sudah ada, update
					$this->db->where('id_defect', $cek->id_defect);
					$this->db->update('defect', $dataInsert);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('defect', $dataInsert);
				}
			}
		}
		return true;
	}

	// function getDataImport($data)
	// {
	// 	$status = [
	// 		'update' => 0,
	// 		'insert' => 0
	// 	];
	// 	for ($i = 1; $i < count($data); $i++) {
	// 		$kode_cell    = isset($data[$i][0]) ? trim($data[$i][0]) : null;
	// 		$factory      = isset($data[$i][1]) ? trim($data[$i][1]) : null;
	// 		$model        = isset($data[$i][3]) ? trim($data[$i][3]) : null;
	// 		$defect_category  = isset($data[$i][4]) ? trim($data[$i][4]) : null;
	// 		$defect_name      = isset($data[$i][5]) ? trim($data[$i][5]) : null;
	// 		$qty              = isset($data[$i][6]) ? str_replace(',', '.', $data[$i][6]) : null;
	// 		$defect_category1 = isset($data[$i][7]) ? trim($data[$i][7]) : null;
	// 		$defect_name1     = isset($data[$i][8]) ? trim($data[$i][8]) : null;
	// 		$qty1             = isset($data[$i][9]) ? str_replace(',', '.', $data[$i][9]) : null;
	// 		$defect_category2 = isset($data[$i][10]) ? trim($data[$i][10]) : null;
	// 		$defect_name2     = isset($data[$i][11]) ? trim($data[$i][11]) : null;
	// 		$qty2             = isset($data[$i][12]) ? str_replace(',', '.', $data[$i][12]) : null;
	// 		$defect_date      = isset($data[$i][13]) ? trim($data[$i][13]) : null;

	// 		if (!empty($kode_cell) && !empty($factory) && !empty($defect_date)) {
	// 			$where = [
	// 				'cell'       => $kode_cell,
	// 				'defect_date' => $defect_date
	// 			];
	// 			$cek = $this->db->get_where('defect', $where)->row();

	// 			$dataInsert = [
	// 				'cell'            => $kode_cell,
	// 				'factory'         => $factory,
	// 				'model'           => $model,
	// 				'defect_category' => $defect_category,
	// 				'defect_name'     => $defect_name,
	// 				'qty'             => $qty,
	// 				'defect_category1' => $defect_category1,
	// 				'defect_name1'    => $defect_name1,
	// 				'qty1'            => $qty1,
	// 				'defect_category2' => $defect_category2,
	// 				'defect_name2'    => $defect_name2,
	// 				'qty2'            => $qty2,
	// 				'defect_date'     => $defect_date
	// 			];

	// 			// ====== Proses data pekerjaan ======
	// 			$dataPekerjaan = [
	// 				'LINE_CD'           => $kode_cell,
	// 				'tanggal_pekerjaan' => date('Y-m-d', strtotime($defect_date)),
	// 				'defect_name'       => $defect_name,
	// 				'qty'               => $qty,
	// 				'defect_name1'      => $defect_name1,
	// 				'qty1'              => $qty1,
	// 				'defect_name2'      => $defect_name2,
	// 				'qty2'              => $qty2
	// 			];

	// 			$cekPekerjaan = $this->db->get_where('pekerjaan', [
	// 				'LINE_CD'           => $kode_cell,
	// 				'tanggal_pekerjaan' => date('Y-m-d', strtotime($defect_date))
	// 			])->row();

	// 			if ($cekPekerjaan) {
	// 				$this->db->where('LINE_CD', $kode_cell)
	// 					->where('tanggal_pekerjaan', date('Y-m-d', strtotime($defect_date)))
	// 					->update('pekerjaan', $dataPekerjaan);
	// 			} else {
	// 				$dataPekerjaan['id_pekerjaan'] = uniqid('PEK_');
	// 				$this->db->insert('pekerjaan', $dataPekerjaan);
	// 			}

	// 			// ====== Proses data defect ======
	// 			if ($cek) {
	// 				$this->db->where('id_defect', $cek->id_defect)
	// 					->update('defect', $dataInsert);
	// 				$status['update']++;
	// 			} else {
	// 				$this->db->insert('defect', $dataInsert);
	// 				$status['insert']++;
	// 			}
	// 		}
	// 	}

	// 	// Ceh status akhir insert atau update

	// 	if ($status['update'] > 0 && $status['insert'] == 0) {
	// 		return 'update';
	// 	} elseif ($status['insert'] > 0 && $status['update'] == 0) {
	// 		return 'insert';
	// 	} elseif ($status['update'] > 0 && $status['insert'] > 0) {
	// 		return 'mixed'; // kombinasi update dan insert
	// 	} else {
	// 		return false; // tidak ada data yang diproses
	// 	}
	// }


	function Import($data)
	{
		return $this->getDataImport($data);
	}
}

/* End of file: M_defect.php */
