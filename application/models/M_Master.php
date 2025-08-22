<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Master extends CI_Model
{

	function kelompokDT()
	{
		/*$this->db->group_by('kelompok');*/
		$this->db->distinct();
		$this->db->select('kelompok');
		return $this->db->get('master_dt')->result();
	}

	function masterDT($kelompok)
	{
		return $this->db->get_where('master_dt', ['kelompok' => $kelompok])->result();
	}
}

/* End of file: M_Master.php */
