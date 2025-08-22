<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_flexim extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function getModel()
	{
		$this->db->select('nama_model');
		$this->db->group_by('nama_model');
		return $this->db->get('model')->result();
	}

	function hapusdataById($id)
	{
		$this->db->where('id_data', $id);
		$query = $this->db->delete('flexim', ['id_data' => $id]);
		return $query;
	}

	function uploadVideo()
	{
		$allowed_ext 	= ['webm'];
		$path 		= $_FILES['file']['name'];
		$ext 		= strtolower(pathinfo($path, PATHINFO_EXTENSION));
		$nama_file 	= uniqid() . '.' . $ext;
		$model 		= $this->input->post('model');

		// Cek ekstensi
		if (!in_array($ext, $allowed_ext)) {
			return [
				'kode' => 'error',
				'msg'  => 'Hanya file dengan format .webm yang diperbolehkan.'
			];
		}

		$config['upload_path']   = './assets/fleximData/';
		$config['allowed_types'] = 'webm';
		$config['file_name']     = $nama_file;
		$config['overwrite']     = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$msg = strip_tags($this->upload->display_errors());
			return [
				'kode' => 'error',
				'msg'  => "Gagal upload file: $msg"
			];
		}

		// Simpan/update DB
		$where = ['model' => $model];
		$cek = $this->db->get_where('flexim', $where)->row();

		if ($cek) {
			// Hapus file lama jika ada
			$old_path = './assets/fleximData/' . $cek->nama_file;
			if (file_exists($old_path) && $cek->nama_file != null) {
				unlink($old_path);
			}

			$this->db->where($where);
			$update = $this->db->update('flexim', ['nama_file' => $nama_file]);
		} else {
			$data = [
				'model'     => $model,
				'nama_file' => $nama_file
			];
			$update = $this->db->insert('flexim', $data);
		}

		// Update ke pekerjaan juga
		$this->db->where('model_actual', $model);
		$this->db->update('pekerjaan', ['flexim' => $nama_file]);

		return ($update) ? [
			'kode' => 'success',
			'msg'  => 'Upload video berhasil disimpan.'
		] : [
			'kode' => 'error',
			'msg'  => 'Upload berhasil, tetapi gagal menyimpan ke database.'
		];
	}
}

/* End of file: M_flexim.php */
