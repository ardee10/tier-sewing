<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_layout extends CI_Model
{
	function getModel()
	{
		$this->db->distinct();
		$this->db->select('nama_model');
		return $this->db->get('model')->result();
	}

	function getLayout()
	{
		$this->db->select('nama_model');
		$this->db->group_by('nama_model');
		$data =  $this->db->get('model')->result();

		$array = [];
		$a = 0;
		while ($a <= count($data) - 1) {
			$dat = [
				'model_name'	=> $data[$a]->nama_model,
				'gambar'		=> $this->cekFileImage($data[$a]->nama_model),
				'nama_layout'	=> $this->cekFileLayout($data[$a]->nama_model)
			];
			array_push($array, $dat);
			$a++;
		}
		return $array;
	}

	function cekFileImage($nama_model)
	{
		$img = $this->db->get_where('model', ['nama_model' => $nama_model])->row();
		if ($img) {
			$namaGambar = $img->img_model;
			$path = './assets/img/product_model/' . $namaGambar;
			if (file_exists($path) && $namaGambar != null) {
				return 'assets/img/product_model/' . $namaGambar;
			} else {
				return "assets/img/no_images.png";
			}
		}
		return "assets/img/no_images.png";
	}

	function cekFileLayout($nama_model)
	{
		$layout =  $this->db->get_where('layout', ['nama_model' => $nama_model])->row();
		if ($layout) {
			$namaLayout = $layout->nama_file;
			$path = './assets/layout/' . $namaLayout;
			if (file_exists($path) && $namaLayout != null) {
				return '/assets/layout/' . $namaLayout;
			}
		}
	}

	function uploadLayout()
	{
		$nama_model 		= $this->input->post('nama_model');
		$nama_file 			= uniqid() . '.pdf';

		$config['upload_path']          = './assets/layout/';
		$config['allowed_types']        = 'pdf|PDF';
		$config['file_name']           	= $nama_file;
		$this->load->library('upload', $config);
		$this->upload->overwrite = true;

		if (!$this->upload->do_upload('file')) {
			$msg = $this->upload->display_errors();
			return [
				'kode'		=> 'error',
				'msg'		=> $msg
			];
		} else {
			$data = [
				'nama_model'		=> $nama_model,
				'nama_file'			=> $nama_file
			];

			$cek_model = $this->db->get_where('layout', ['nama_model' => $nama_model])->row();
			if (!$cek_model) {
				$cek = $this->db->insert('layout', $data);
			} else {
				$path = './assets/layout/' . $cek_model->nama_file;
				if (file_exists($path) && $cek_model->nama_file != null) {
					unlink('./assets/layout/' . $cek_model->nama_file);
				}

				$this->db->where('nama_model', $nama_model);
				$cek = $this->db->update('layout', $data);
			}

			// UPDATE DATA PEKERJAAN
			if ($cek) {
				$this->db->where(['model_actual'		=> $nama_model]);
				$this->db->update('pekerjaan', ['layout' => $nama_file]);
			}

			return ($cek) ? [
				'kode'		=> 'success',
				'msg'		=> 'upload file sukses'
			] : [
				'kode'		=> 'error',
				'msg'		=> 'error update database'
			];
		}
	}
}


/* End of file: M_Layout.php */
