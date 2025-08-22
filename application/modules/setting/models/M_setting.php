<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_setting extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$arrContextOptions = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
			),
		);
		$this->arrContextOptions = $arrContextOptions;
	}
	// ERP
	function viewCellErp()
	{
		$path     = SERVER2 . "mastercell/SewingCellAllBuilding";
		$data     = file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$data     = json_decode($data);
		return $data;
	}

	// DB TIER
	function viewCell()
	{
		$query = $this->db->get('cell')->result();
		return $query;
	}

	/* Tambah data Cell */
	function tambahDataCell()
	{

		$where = $this->input->post('id_cell');
		$exist = $this->db->get_where('cell', ['id_cell' => $where])->row();
		//Jika ada datanya
		if ($exist) {
			//Siapkan data yang akan di update
			$data = [

				'id_cell'		=> $this->input->post('id_cell'),
				'kode_factory' 	=> $this->input->post('kode_factory'),
				'nama_cell'		=> $this->input->post('nama_cell'),
				'jenis'			=> $this->input->post('jenis'),
				'is_active'		=> $this->input->post('is_active')

			];

			$this->db->where('id_cell', $this->input->post('id_cell'));
			$this->session->set_flashdata('message', [
				'title' => 'Success',
				'text' => 'Data cell berhasil diupdate',
				'icon' => 'success',
				'type' => 'success'
			]);
			$this->db->update('cell', $data);
		} else {
			// Jika datanya tidak ada, maka jalankan query insert
		}
	}
	//  Edit data cell
	function detailcellid($id)
	{
		$data = $this->db->get_where('cell', ['id_cell' => $id]);
		return $data;
	}
	/* Hapus data cell */
	function hapusDataCell($id)
	{
		$this->db->where('id_cell', $id);
		$query = $this->db->delete('cell', ['id_cell' => $id]);
		return $query;
	}
}

/* End of file: M_setting.php */
