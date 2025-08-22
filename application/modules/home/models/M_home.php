<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_home extends CI_Model
{

	protected $arrContextOptions; //Protected

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_level_1', 'Lev1');
	}
	// Simpan Downtime
	function ajaxSimpanDt()
	{
		$data = [
			'kode_jam'		=> $this->input->post('kode_jam'),
			'LINE_CD'		=> $this->input->post('LINE_CD'),
			'kode_factory'	=> $this->input->post('kode_factory'),
			'tanggal_dt'	=> date('Y-m-d', strtotime($this->input->post('tanggal_dt'))),
			'remark'		=> $this->input->post('remark'),
			'menit_dt'		=> $this->input->post('menit_dt'),
			'lost_dt'		=> $this->input->post('lost_dt')
		];

		$where = [
			'kode_jam'		=> $this->input->post('kode_jam'),
			'tanggal_dt'	=> $this->input->post('tanggal_dt'),
			'LINE_CD'		=> $this->input->post('LINE_CD')
		];

		$cek = $this->db->get_where('downtime', $where)->row();
		if ($cek) {
			$res = [
				'kode'		=> 'error',
				'msg'		=> 'Downtime Pada kode Jam Tersebut Sudah Pernah Diinput'
			];
		} else {
			$cek = $this->db->insert('downtime', $data);
			if ($cek) {
				$res = [
					'kode'		=> 'success',
					'msg'		=> 'Data Downtime Berhasil Disimpan'
				];
			} else {
				$res = [
					'kode'		=> 'error',
					'msg'		=> 'Gagal Simpan Downtime'
				];
			}
		}
		return $res;
	}
	/* Donwtime */
	function downloadDTCell($idcell, $tgl, $target)
	{
		$no 	= 1;
		$hasil 	= [];
		$jam = $this->mssOutputScanByCell($idcell, $tgl); // Ambil data dari API

		if (isset($jam->status) && $jam->status == "success") {
			$jam = $jam->data; // Ambil array data dari objek
		} else {
			$jam = []; // Jika tidak ada data, inisialisasi sebagai array kosong
		}
		if ($jam) {
			foreach ($jam as $j) {
				$dt = $this->db->get_where('downtime', [
					'kode_jam' 			=> $j->TIME_CD,
					'LINE_CD'			=> $idcell,
					'date(tanggal_dt)'	=> date('Y-m-d', strtotime($tgl))
				])->row();

				$hasil[$no++] = [
					'kode_jam'		=> $j->TIME_CD,
					'SCAN_QTY'		=> $j->SCAN_QTY,
					'TARGET'		=> $target,
					'STATUS'		=> ($target > $j->SCAN_QTY) ? "BELUM" : "TARGET",
					'lost'			=> ($dt) ? $dt->lost_dt : 0,
					'dt_menit'		=> ($dt) ? $dt->menit_dt : 0,
					'remark'		=> ($dt) ? $dt->remark : "-",
				];
			}
		}

		return $hasil;
	}
	/* Komparasi */
	function komparasiDt($idcell, $tgl, $target, $dt, $lost)
	{
		$komp 	= [];
		$no 	= 0;
		$this->db->select('remark');
		$this->db->group_by('remark');
		$dt 	= $this->db->get_where('downtime', ['LINE_CD' => $idcell, 'date(tanggal_dt)' => date('Y-m-d', strtotime($tgl))])->result();
		if ($dt) {
			foreach ($dt as $d) {
				$komp[$no]		= [
					'remark'	=> $d->remark,
					'total'		=> $this->hitungTotalKomparasi($d->remark, $idcell, $tgl)
				];
				$no++;
			}
		}
		return $komp;
	}
	/* Hitung Komparasi */
	function hitungTotalKomparasi($remark, $idcell, $tgl)
	{
		$total = 0;
		$hasil = [];
		$no = 0;
		$data = $this->db->get_where('downtime', [
			'LINE_CD' 			=> $idcell,
			'date(tanggal_dt)' 	=> date('Y-m-d', strtotime($tgl)),
			'remark'			=> $remark
		])->result();

		if ($data) {
			foreach ($data as $a) {
				$hasil[$no]		= [
					'total'		=> $a->menit_dt
				];

				$total += $hasil[$no]['total'];
				$no++;
			}
		}
		return $total;
	}
	//Factory
	public function factory()
	{
		$this->db->where('active', '1');
		$this->db->order_by('id_gedung', 'ASC');
		$query = $this->db->get('factory');
		return $query;
	}
	// API MSS
	function mssGetCell($id = null)
	{
		//http://192.168.44.97/apimss/index.php/Mastercell/cellByBuilding
		$cell = null;
		if ($id != null) {
			$path 	= SERVER . "Mastercell/cellByBuilding/" . $id;
			$cell 	= file_get_contents($path, false, stream_context_create($this->arrContextOptions));
			$cell 	= json_decode($cell);
		}

		return $cell;
	}
	// Scan Output By Cell
	function mssOutputScanByCell($idcell, $date)
	{
		$date = date('Ymd', strtotime($date));
		$path     = SERVER2 . "output/scanOutput/" . $idcell . '/' . $date;
		$data     = file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$data     = json_decode($data);
		return $data;
	}
}

/* End of file: M_home.php */
