<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Critical extends CI_Model
{
	/* Menampilkan Semua Cell */
	function cekCell($tanggal)
	{
		$cellCritical = $this->db->get_where('critical_destination', ['tanggal_kerja'   => $tanggal])->result();
		$cellArray = array_column($cellCritical, 'id_cell');

		$hasil = [];
		$cell = $this->db->get('cell')->result();
		foreach ($cell as $c) {
			$status = (in_array($c->id_cell, $cellArray, true)) ? true : false;
			$no_po = $this->db->get_where('critical_destination', ['tanggal_kerja'   => $tanggal, 'id_cell'  => $c->id_cell])->row();
			$hasil[] = [
				'id_cell'       => $c->id_cell,
				'kode_factory'  => $c->kode_factory,
				'nama_cell'     => $c->nama_cell,
				'no_po'         => ($no_po) ? $no_po->no_po : '',
				'critical'      => $status
			];
		}
		return $hasil;
	}

	function eksekusi()
	{
		$no_po = $this->input->post('no_po');
		$data = [
			'id_cell'           => $this->input->post('id_cell'),
			'kode_factory'      => $this->input->post('kode_factory'),
			'no_po'             => $no_po,
			'tanggal_kerja'     => $this->input->post('tanggal_kerja'),
		];

		$cek = $this->db->insert('critical_destination', $data);

		//updadate Pekerjaan
		$this->db->where(['LINE_CD' => $this->input->post('id_cell'), 'tanggal_pekerjaan'   => $this->input->post('tanggal_kerja')]);
		$this->db->update('pekerjaan', ['critical_destination'  => 1]);

		return $cek ? 'success' : 'gagal';
	}

	function eksekusiPo()
	{
		$where = [
			'id_cell'           => $this->input->post('id_cell'),
			'tanggal_kerja'     => $this->input->post('tanggal_kerja'),
		];

		$cek = $this->db->get_where('critical_destination', $where);
		if ($cek) {
			$data = [
				'id_cell'           => $this->input->post('id_cell'),
				'kode_factory'      => $this->input->post('kode_factory'),
				'no_po'             => $this->input->post('no_po'),
				'tanggal_kerja'     => $this->input->post('tanggal_kerja'),
			];
			$this->db->where($where);
			$this->db->update('critical_destination', $data);
		}
		return $cek ? 'success' : 'gagal';
	}

	function hapusCellCritical()
	{
		$where = [
			'id_cell'           => $this->input->post('id_cell'),
			'tanggal_kerja'     => $this->input->post('tanggal_kerja'),
		];

		$this->db->where($where);
		$cek = $this->db->delete('critical_destination');

		//updadate Pekerjaan
		$this->db->where(['LINE_CD' => $this->input->post('id_cell'), 'tanggal_pekerjaan'   => $this->input->post('tanggal_kerja')]);
		$this->db->update('pekerjaan', ['critical_destination'  => null]);

		return $cek ? 'success' : 'gagal';
	}
}

/* End of file: M_Critical.php */
