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
}

/* End of file: M_Cot.php */
