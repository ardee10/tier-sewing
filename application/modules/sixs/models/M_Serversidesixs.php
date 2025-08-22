<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Serversidesixs extends CI_Model
{

	var $table             = 'audit';
	var $column_order     = ['', 'audit_date', 'factory', '', 'total_audit', ''];
	var $column_search     = ['audit_date', 'factory', 'total_audit'];
	var $order             = ['audit_date' => 'desc'];

	private function _get_datatables_query($building, $tanggal)
	{
		$tanggal = ($tanggal) ? $tanggal : date('Y-m-d');
		$building = ($building) ? $building : 'semua';


		$this->db->select('*');
		$this->db->from('audit');
		if ($building != 'semua') {
			$this->db->where('audit.factory', $building);
		}
		$this->db->where('audit_date', $tanggal);
		$this->db->join('cell', 'audit.cell = cell.id_cell');
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($building, $tanggal)
	{
		$this->_get_datatables_query($building, $tanggal);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}


	function count_filtered($building, $tanggal)
	{
		$this->_get_datatables_query($building, $tanggal);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}

/* End of file: M_Serversidesixs.php */
