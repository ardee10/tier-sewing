<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_target extends CI_Model
{
	protected $arrContextOptions;

	// Target Cell By Day
	function targetCellByDay($cell = null, $date = null)
	{
		// $path 	= SERVER2 . "target/targetByHour/" . $cell . '/' . $date;
		$path 	= TARGETCELLBYDAY . $cell . '/' . $date;
		$data 	= file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$data 	= json_decode($data);;
		return $data;
	}

	// Target All Cell

	function targetAllCell($date = null)
	{
		// 
		$path 	= TARGETCELLALL . $date;
		$data 	= file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$data 	= json_decode($data);;
		return $data;
	}
}

/* End of file: M_target.php */
