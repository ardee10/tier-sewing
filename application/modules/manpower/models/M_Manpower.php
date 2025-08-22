<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class M_Manpower extends CI_Model
{

	// protected $table = '';

	public function __construct()
	{
		parent::__construct();
	}

	// public function tambahDataManpower()
	// {

	// 	$id_mp		 = $this->input->post('id_mp');
	// 	$exist 		= $this->db->get_where('mp_actual', ['id_mp' => $id_mp])->row();
	// 	$data = [

	// 		'id_mp' 			=> uniqid(),
	// 		'factory'			=> $this->input->post('factory'),
	// 		'LINE_CD'			=> $this->input->post('cell'),
	// 		'mp_date'			=> $this->input->post('mp_date'),
	// 		'mp_bz_sew_prep' 	=> $this->input->post('mp_bz_sew_prep'),
	// 		'mp_sew_prep'		=> $this->input->post('mp_sew_prep'),
	// 		'total_mp_sew'		=> $this->input->post('total_mp_sew')

	// 	];
	// 	// ==== Simpan atau Update ====
	// 	if ($exist) {
	// 		$this->db->where('id_mp', $id_mp);
	// 		if ($this->db->update('mp_actual', $data)) {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Success',
	// 				'text' => 'Data Manpower berhasil diupdate',
	// 				'icon' => 'success',
	// 				'type' => 'success'
	// 			]);
	// 			return 'update';
	// 		}
	// 	} else {
	// 		if ($this->db->insert('mp_actual', $data)) {
	// 			$this->session->set_flashdata('message', [
	// 				'title' => 'Success',
	// 				'text' => 'Data Manpower berhasil ditambahkan',
	// 				'icon' => 'success',
	// 				'type' => 'success'
	// 			]);
	// 			return 'insert';
	// 		}
	// 	}

	// 	return false;
	// }

	public function tambahDataManpower()
	{
		$factory 		= $this->input->post('factory');
		$line_cd 		= $this->input->post('cell');
		$mp_date 		= $this->input->post('mp_date');

		// Cek apakah data dengan LINE_CD dan mp_date sudah ada
		$exist = $this->db->get_where('mp_actual', [
			'LINE_CD' => $line_cd,
			'mp_date' => $mp_date
		])->row();

		$data = [
			'factory'			=> $factory,
			'LINE_CD'			=> $line_cd,
			'mp_date'			=> $mp_date,
			'mp_bz_sew_prep' 	=> $this->input->post('mp_bz_sew_prep'),
			'mp_sew_prep'		=> $this->input->post('mp_sew_prep'),
			'total_mp_sew'		=> $this->input->post('total_mp_sew')
		];

		if ($exist) {
			// Update berdasarkan LINE_CD dan mp_date
			$this->db->where('LINE_CD', $line_cd);
			$this->db->where('mp_date', $mp_date);
			if ($this->db->update('mp_actual', $data)) {
				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text' => 'Data Manpower berhasil diupdate',
					'icon' => 'success',
					'type' => 'success'
				]);
				return 'update';
			}
		} else {
			// Tambahkan ID unik baru
			$data['id_mp'] = uniqid();
			if ($this->db->insert('mp_actual', $data)) {
				$this->session->set_flashdata('message', [
					'title' => 'Success',
					'text' => 'Data Manpower berhasil ditambahkan',
					'icon' => 'success',
					'type' => 'success'
				]);
				return 'insert';
			}
		}

		return false;
	}


	public function hapusdatabyId($id)
	{

		$this->db->where('id_mp', $id);
		$query = $this->db->delete('mp_actual', ['id_mp' => $id]);
		return $query;
	}

	public function processImportManpower()
	{

		$nama_file = uniqid('mp_', true) . '.xlsx';
		$config['upload_path']   = './file/temp/mp';
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
			// Ambil data dari file Excel berdasarkan kolom
			$mp_date    = isset($data[$i][0]) ? date('Y-m-d', strtotime($data[$i][0])) : null;  // tanggal
			$kode_cell  = isset($data[$i][1]) ? trim($data[$i][1]) : null;                      // kode Cell (LINE_CD)
			$factory    = isset($data[$i][2]) ? trim($data[$i][2]) : null;                      // factory
			$mp_bz      = isset($data[$i][4]) ? (int)$data[$i][4] : 0;                          // MP BUFFER ZONE
			$mp_cell    = isset($data[$i][5]) ? (int)$data[$i][5] : 0;                          // MP CELL
			$total_mp   = $mp_bz + $mp_cell;

			if (!empty($kode_cell) && !empty($mp_date)) {
				$where = [
					'LINE_CD'  => $kode_cell,
					'mp_date'  => $mp_date
				];

				$cek = $this->db->get_where('mp_actual', $where)->row();

				$dataInsert = [
					'factory'         => $factory,
					'LINE_CD'         => $kode_cell,
					'mp_date'         => $mp_date,
					'mp_bz_sew_prep'  => $mp_bz,
					'mp_sew_prep'     => $mp_cell,
					'total_mp_sew'    => $total_mp,
				];


				//Lakukan insert atau update di table pekerjaan hanya field kpi_act_mp
				// Cek apakah sudah ada apa belum di table pekerjaan
				$this->db->where('LINE_CD', $kode_cell);
				$this->db->where('tanggal_pekerjaan', date('Y-m-d', strtotime($mp_date)));
				$pekerjaan = $this->db->get('pekerjaan')->row();
				// Jika sudah ada, update
				if ($pekerjaan) {
					// Jika sudah ada, update
					$this->db->where('LINE_CD', $kode_cell);
					$this->db->where('tanggal_pekerjaan', date('Y-m-d', strtotime($mp_date)));
					$this->db->update('pekerjaan', [
						'LINE_CD' => $kode_cell,
						'tanggal_pekerjaan' => date('Y-m-d', strtotime($mp_date)),
						'kpi_act_mp' => $total_mp
					]);
				} else {
					// Jika belum ada, insert baru
					$this->db->insert('pekerjaan', [
						'LINE_CD' 			=> $kode_cell,
						'tanggal_pekerjaan' => date('Y-m-d', strtotime($mp_date)),
						'kpi_act_mp' 		=> $total_mp
					]);
				}

				if ($cek) {
					// Update jika sudah ada
					$this->db->where('id_mp', $cek->id_mp);
					$this->db->update('mp_actual', $dataInsert);
				} else {
					// Insert baru
					$dataInsert['id_mp'] = uniqid();
					$this->db->insert('mp_actual', $dataInsert);
				}
			}
		}

		return true;
	}

	function Import($data)
	{
		return $this->getDataImport($data);
	}

	public function deleteByFactoryAndDate($factory, $date)
	{
		$this->db->where('factory', $factory);
		$this->db->where('mp_date', $date);
		return $this->db->delete('mp_actual');
	}
}

/* End of file: M_Manpower.php */
