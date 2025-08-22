<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ServersideDefect extends CI_Model
{

	var $table 			= "defect";
	var $column_order 	= ['', "defect_date", "factory", "cell", "model", ''];
	var $column_search 	= ["defect_date", "factory", "cell", "model"];
	var $order 			= ["defect_date" => "desc"];

	private function _get_datatables_query($building, $tanggal)
	{
		$tanggal = ($tanggal) ? $tanggal : date('Y-m-d');
		$building = ($building) ? $building : 'semua';

		$this->db->select('*');
		$this->db->from('defect');
		if ($building != 'semua') {
			$this->db->where('defect.factory', $building);
		}
		$this->db->where('defect_date', $tanggal);
		$this->db->join('cell', 'defect.cell = cell.id_cell');
		$i = 0;

		foreach ($this->column_search as $item) {
			if ($_POST["search"]["value"]) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST["search"]["value"]);
				} else {
					$this->db->or_like($item, $_POST["search"]["value"]);
				}
				if (count($this->column_search) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}

		if (isset($_POST["order"])) {
			$this->db->order_by(
				$this->column_order[$_POST["order"]["0"]["column"]],
				$_POST["order"]["0"]["dir"]
			);
		} else {
			if (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
	}

	function get_datatables($building, $tanggal)
	{
		$this->_get_datatables_query($building, $tanggal);
		if ($_POST["length"] != -1) {
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
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

/* End of file: M_ServersideDefect.php */
