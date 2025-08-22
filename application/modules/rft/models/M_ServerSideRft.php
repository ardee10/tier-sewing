<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ServerSideRft extends CI_Model
{
	var $table 			= "rft";
	var $column_order 	= ['', "rft_date", "factory", "LINE_NM", "rft", ''];
	var $column_search 	= ["rft_date", "factory", "LINE_NM", "rft"];
	var $order 			= ["rft_date" => "desc"];

	private function _get_datatables_query($building, $tanggal)
	{
		$tanggal = ($tanggal) ? $tanggal : date('Y-m-d');
		$building = ($building) ? $building : 'semua';

		$this->db->select('*');
		$this->db->from('rft');
		if ($building != 'semua') {
			$this->db->where('rft.factory', $building);
		}
		$this->db->where('rft_date', $tanggal);
		$this->db->join('cell', 'rft.id_cell = cell.id_cell');
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

/* End of file: M_ServerSideRft.php */
