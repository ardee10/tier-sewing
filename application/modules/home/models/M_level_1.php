<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_level_1 extends CI_Model
{
	protected $reguler;
	protected $targetReguler;
	protected $asc;
	protected $targetAsc;
	protected $arrContextOptions; //Protectec

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
		$this->reguler 			=  	120;
		$this->targetReguler 	= 	100;
	}
	// Ajax filter KPI
	function ajaxfilterKpi($kode_factory, $cell, $tgl)
	{
		// Cek terlebih dahulu ada tidak code cellnya
		$cekCell = $this->db->get_where('cell', ['id_cell'   => $cell])->row();
		if (!$cekCell) {
			return [
				'status'  => 'error',
				'msg'   => 'KODEL CELL TIDAK TERDAFTAR'
			];
		}

		if ($tgl && $tgl != date('Y-m-d')) {
			return [
				'status'  => 'success',
				'data'  => $this->ajaxFilterSebelum($kode_factory, $cell, $tgl)
			];
		} else {
			return [
				'status'  => 'success',
				'data'  => $this->eksekusiPekerjaan($kode_factory, $cell, $tgl)
			];
		}
	}
	/* Jika tanggal pekerjaan tidak sama dengan Hari ini */
	//http://192.168.44.97/tier-sewing/Home/ajaxfilterKpi/F1/S601/2025-07-29
	public function ajaxFilterSebelum($kode_factory, $cell, $tgl)
	{
		// echo "DATA KEMARIN AKAN DIINSERT KE DATABASE";
		$where = [
			'LINE_CD'               => $cell,
			'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
		];
		$pekerjaan = $this->db->get_where('pekerjaan', $where)->row_array();
		if ($pekerjaan) {
			if (!$pekerjaan['grafik']) {
				//hapus data pekerjaan
				$where = [
					'LINE_CD'               => $cell,
					'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
				];
				$this->db->where($where);
				$this->db->delete('pekerjaan');

				$res = $this->eksekusiPekerjaan($kode_factory, $cell, $tgl);
			} else {
				$res = $pekerjaan;
			}
		} else {
			$where = [
				'LINE_CD'               => $cell,
				'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
			];
			$this->db->where($where);
			$this->db->delete('pekerjaan');
			$res = $this->eksekusiPekerjaan($kode_factory, $cell, $tgl);
		}
		return $res;
	}
	/* Jika tanggal pekerjaan sama dengan Hari ini */
	//http://192.168.44.97/tier-sewing/Home/ajaxfilterKpi/F1/S601/2025-07-30
	public function eksekusiPekerjaan($kode_factory, $cell, $tgl)
	{

		// variable 
		$targetMp = 0;
		$modelInfo = null;
		$layout = 'no_data.pdf';

		//cot
		$this->db->where('id_cell', $cell);
		$this->db->where('cot_date', $tgl);
		$cot = $this->db->get('cot')->row();

		//sixs
		$this->db->where('cell', $cell);
		$this->db->where('audit_date', $tgl);
		$audit = $this->db->get('audit')->row();

		//safety
		$this->db->where('cell', $cell);
		$this->db->where('safety_date', $tgl);
		$safety = $this->db->get('safety')->row();

		//kaizen
		$this->db->where('cell', $cell);
		$this->db->where('kaizen_date', $tgl);
		$kaizen = $this->db->get('kaizen')->row();

		//cek file Kaizen
		$img_kaizen = "no_images.png";
		if ($kaizen) {
			$path = './assets/img/kaizen_file/' . $kaizen->file;
			if (file_exists($path) && $kaizen->file) {
				$img_kaizen = $kaizen->file;
			}
		}

		//mpactual
		$this->db->where('LINE_CD', $cell);
		$this->db->where('mp_date', $tgl);
		$actMp = $this->db->get('mp_actual')->row();

		//rft
		$this->db->where('id_cell', $cell);
		$this->db->where('rft_date', $tgl);
		$actRft = $this->db->get('rft')->row();

		//SAFETY
		$this->db->where('kode_factory', $kode_factory);
		$this->db->where('cell', $cell);
		$this->db->where('safety_date', $tgl);
		$safety = $this->db->get('safety')->row();

		$img_safety = "no_images.png";
		if ($safety) {
			$path = 'assets/img/safety_file/' . $safety->file_safety;
			if (file_exists($path) && $safety->file_safety) {
				$img_safety = $safety->file_safety;
			}
		}

		// Defect Data
		//mpactual
		$this->db->where('cell', $cell);
		$this->db->where('defect_date', $tgl);

		$defect = $this->db->get('defect')->row();



		//jenis cell 60 / 120
		$jenisCell      = $this->db->get_where('cell', ['id_cell' => $cell])->row(); //data cell berdasarkan ID
		//stdClass Object ( [urutan] => 1 [id_cell] => S601 [kode_factory] => F1 [nama_cell] => F1-1 [jenis] => reguler [is_active] => 1 )
		$LINE_NM        = $this->db->get_where('cell', ['id_cell'   => $cell])->row()->nama_cell; //F1-1
		//cek model di data pekerjaan source masih dari assembly out
		$model = $this->cekScanProduct($cell, $tgl);
		// Output Array ( [artikel_actual] => JP6928 [model_actual] => Runblaze M )

		//dicek terlebih dahulu ada layoutnya tidak di model tersebut
		if ($model) {
			// Array ( [artikel_actual] => ID5252 [model_actual] => ADIDAS SWITCH MOVE U )
			$layout     =  $this->db->get_where('layout', ['nama_model' => $model['model_actual']])->row();
			$layout     = ($layout) ? $layout->nama_file : 'no_data.pdf';
			$this->db->where('kode_model', $model['artikel_actual']);
			// $this->db->where('target', strval($jenisCell));

			if ($jenisCell->jenis == 'reguler') {
				$cariMp  = 120;
			} elseif ($jenisCell->jenis == 'asc') {
				$cariMp  = 60;
			} else {
				$cariMp  = 130;
			}
			$this->db->where('target', strval($cariMp));
			$modelInfo =  $this->db->get('model')->row();

			if ($modelInfo) {
				$targetMp   =  $modelInfo->mp_prep + $modelInfo->mp_sewing;
			}

			$flexim = $this->db->get_where('flexim', ['model' => $model['model_actual']])->row();
		}
		$grafik             = $this->mssOutputCell($cell, $tgl);

		//F1-3
		$grafikData 		= $grafik->data ?? [];
		$lastOutput 		= end($grafikData); //20
		$jumlah_data 		= count($grafikData);
		$actualOutput       = array_column($grafikData, 'SCAN_QTY'); //180
		$actualOutput       = array_sum($actualOutput);
		$grafikFormatted 	= $this->_generateGrafik($grafikData);
		$grafikDb 			= json_encode($grafikFormatted);

		//eolr
		// $targetOutput = $this->db->get_where('target_output', ['LINE_CD' => $cell, 'tanggal_kerja'   => $tgl])->row();

		/* Mengambil nilai target daily total dalam satu hari dari jam 07-selesai */
		$targetOutput = $this->mssTargetCell($cell, $tgl); //Total target 1200
		//stdClass Object ( [status] => success [cell] => S601 [date] => 20250806 [time_cd] => 10 [total_qty] => 1200 )
		$actEolr = $this->_hitungActualEolr($targetOutput, $actualOutput, $jumlah_data, $tgl);

		//Critical
		$cellCritical = $this->db->get_where('critical_destination', ['id_cell' => $cell, 'tanggal_kerja'    => $tgl])->row();

		// target Output permodel = mengambil dari data master Model
		$targetOutputModel = isset($modelInfo->target) ? $modelInfo->target : 0;
		// $targetOutputModel = ($targetOutputModel == 0) ? $jenisCell : $targetOutputModel; // --error masalahna ada disini

		//pph target
		//120 / 51
		$targetPph  = ($targetMp > 0) ? $targetOutputModel / $targetMp : 0;
		$actPph     = ($actMp && $actMp->total_mp_sew > 0) ? $actEolr / $actMp->total_mp_sew : 0;

		//efficiency
		// = pph * lc / 233 
		$targetEff  = ($modelInfo) ? ($targetPph * $modelInfo->lc) / 233 : 0;

		$actEff     = ($modelInfo) ? ($actPph * $modelInfo->lc) / 233 : 0;

		$data = [
			'LINE_CD'                   => $cell, //"S678"
			'LINE_NM'                   => $LINE_NM, //"F4-12"
			'gedung'                    => strtoupper($kode_factory), //"F4"
			'model_actual'              => $model['model_actual'], //"DURAMO SPEED 2 W"
			'artikel_actual'            => $model['artikel_actual'], //"IH8211"
			'layout'                    => $layout, //"no_data.pdf"
			'ART_IMAGE'                 => ($modelInfo) ? $modelInfo->img_model : 'no_image.png', //"IH8211.PNG"
			'tanggal_pekerjaan'         => $tgl, //"2025-08-06"
			'lc_model'                  => ($modelInfo) ? $modelInfo->lc : '', //"146.71"
			// 'target_output_perjam'      => (string)$targetOutputModel,
			'actual_output'             => $actualOutput, //144
			'actual_output_last'        => ($lastOutput) ? $lastOutput->SCAN_QTY : 0, //144
			'grafik'                    => $grafikDb, // "[{"x":"A007","y":130},{"x":"A008","y":144}]"
			'cot'                       => ($cot) ? $cot->qty_cot : 0, //dari table cot
			'file_cot'                  => ($cot) ? $cot->file_cot : null, // dari table cot
			'six_s'                     => ($audit) ? $audit->total_audit : 0, //dari table_audit
			'file_six'                  => ($audit) ? $audit->file_six : null, //dari table_audit
			'kaizen'                    => ($kaizen) ? $kaizen->total_kaizen : 0, // dari table_kaizen
			'kaizen_file'               => $img_kaizen, // dari table_kaizen
			'kpi_target_mp'             => ($modelInfo) ? number_format($targetMp, 0) : 0, // Ambil dari ModelInfo 32
			// 'kpi_target_eolr'           => (string)$targetOutputModel,
			'kpi_target_pph'            => $targetPph, //3.3
			'kpi_target_eff'            => $targetEff * 100, //183.7
			'kpi_target_ller'           => TARGETLLER, // 85
			'kpi_target_rft'            => TARGETRFT, // 95
			'kpi_act_mp'                => ($actMp) ? $actMp->total_mp_sew : 0, // dari table mp_actual
			'kpi_act_eolr'              => $actEolr, // 61.5
			'kpi_act_pph'               => $actPph,
			'kpi_act_eff'               => $actEff * 100,
			'kpi_act_ller'              => ($actMp && $actMp->total_mp_sew > 0) ? ($targetMp / $actMp->total_mp_sew) * 100 : 0,
			'kpi_act_rft'               => ($actRft) ? $actRft->rft : 0, //96
			'flexim'                    => ($flexim) ? $flexim->nama_file : '', // dari table flexim
			// 'osa'                       => $this->cekOsa($cell, $tgl),
			'critical_destination'      => ($cellCritical) ? 1 : null,
			'no_po'                     => ($cellCritical) ? $cellCritical->no_po : '',
			'nlti'                      => ($safety) ? $safety->nlti : 0,
			'lti'                       => ($safety) ? $safety->lti : 0,
			'total_nlti'                => ($safety) ? $safety->total_nlti : 0,
			'total_lti'                 => ($safety) ? $safety->total_lti : 0,
			'file_safety'               => $img_safety,
			'defect_name'               => ($defect) ? $defect->defect_name : null,
			'qty'                      	=> ($defect) ? $defect->qty : 0,
			'defect_name1'              => ($defect) ? $defect->defect_name1 : null,
			'qty1'                      => ($defect) ? $defect->qty1 : 0,
			'defect_name2'              => ($defect) ? $defect->defect_name2 : null,
			'qty2'                      => ($defect) ? $defect->qty2 : 0,
		];

		if ($tgl < date('Y-m-d')) {
			$target = ($targetOutput) ? $targetOutput->time_cd * $targetOutputModel : $jumlah_data * $jenisCell;
			$data['kpi_target_eolr']    = $targetOutputModel;
			$data['target_output']      = $target;
			$data['target_output_perjam']   = $targetOutputModel;
			$whereModel = [
				'LINE_CD'               => $cell,
				'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
			];
			$this->db->where($whereModel);
			$this->db->update('pekerjaan', $data);
		} else {
			$tOutput = 0;
			$jam = date('H');
			$menit = date('i');

			$workingHour = ($jam >= 12) ? $jam - (1 + MULAIKERJA) : $jam - MULAIKERJA;
			// $workingHour = $jam - MULAIKERJA;
			$pembagiEolr = (($workingHour * 60) + $menit) / 60;

			$targetPermenit = number_format(($targetOutputModel / 60), 2);
			$menit = number_format(($targetPermenit * $menit), 0);

			if ($targetOutput) {
				if ($jam >= 12) {
					if ($workingHour >= $targetOutput->time_cd) {
						$tOutput = $targetOutput->time_cd * $targetOutputModel;
						$data['kpi_target_eolr']    = number_format($tOutput / $targetOutput->time_cd, 0);
					} else {
						$tOutput = ($workingHour * $targetOutputModel) + $menit;
						$data['kpi_target_eolr']    = number_format($tOutput / $pembagiEolr, 0);
					}
				} else {
					$tOutput = ($workingHour * $targetOutputModel) + $menit;
					$data['kpi_target_eolr']    = number_format($tOutput / $pembagiEolr, 0);
				}
			} else {
				$tOutput = ($workingHour * $targetOutputModel) + $menit;
				$data['kpi_target_eolr']    = number_format($tOutput / $pembagiEolr, 0);
			}

			$data['target_output_perjam']   = number_format($menit, 0);
			$data['target_output'] = $tOutput;
			$data['jam'] = $jam;
		}
		return $data;
	}
	function _hitungActualEolr($targetOutput, $actualOutput, $jumlah_data, $tgl)
	{
		$jam = date('H');
		$menit = date('i');
		$workingHour = ($jam >= 12) ? $jam - (1 + MULAIKERJA) : $jam - MULAIKERJA;
		$pembagiEolr = (($workingHour * 60) + $menit) / 60;

		if ($tgl < date('Y-m-d')) {
			if ($targetOutput) {
				$actEolr = $actualOutput / 10;
			} else {
				$actEolr = $actualOutput / $jumlah_data;
			}
		} else {

			if ($targetOutput) {
				if ($jam >= 12) {
					if ($workingHour >= $targetOutput->time_cd) {
						$actEolr =  $actualOutput / $targetOutput->time_cd;
					} else {
						$actEolr = $actualOutput / $pembagiEolr;
					}
				} else {
					$actEolr = ($jam == 7) ? $actualOutput : $actualOutput / $pembagiEolr;
				}
			} else {
				$actEolr = $actualOutput / $pembagiEolr;
			}
		}
		return $actEolr;
	}
	/* Mendapatkan data Artikel dan Model berdasarkan output Scan dan insert ke table pekerjaan*/
	function cekScanProduct($cell, $tgl)
	{
		$whereModel = [
			'LINE_CD'               => $cell,
			'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
		];
		$this->db->where($whereModel);
		$datMod = $this->db->get('pekerjaan')->row();
		if ($datMod) {

			if ($datMod->artikel_actual && $datMod->model_actual) {
				$array = [
					'artikel_actual'        =>  $datMod->artikel_actual,
					'model_actual'          =>  $datMod->model_actual,
				];
			} else {
				$model             			=  $this->mssGetModel($cell, $tgl);
				$whereModel = [
					'LINE_CD'               => $cell,
					'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
				];
				$array = [
					'artikel_actual'        =>  $model->ARTNO, // data ini didapatkan apabila terdapat ID cell yang sama di database dengan erp
					'model_actual'          =>  $model->ARTICLEDESC, //
				];
				$this->db->where($whereModel);
				$this->db->update('pekerjaan', $array);
			}
		} else {
			$model             			=  $this->mssGetModel($cell, $tgl);
			$array = [
				'artikel_actual'        =>  $model->ARTNO,
				'model_actual'          =>  $model->ARTICLEDESC,
				'LINE_CD'               => 	$cell,
				'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
			];
			$this->db->insert('pekerjaan', $array);
		}

		return $array;
	}
	// HELPER MSS http://192.168.44.97/apidata/produk/produkCell/S601/20250731 
	//mendapatkan data artikel dan model berdasarkan scan
	function mssGetModel($idcell, $date)
	{
		$date = date('Ymd', strtotime($date));
		$path     = SERVER2 . "produk/produkCell/" . $idcell . '/' . $date;
		$data     = file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$data     = json_decode($data);
		return $data;
	}
	//Mendapatkan Ouput scan by Hour berdasarkan parameter cell dan date
	function mssOutputCell($idcell, $date)
	{
		$date = date('Ymd', strtotime($date));
		$path     = SERVER2 . "output/scanOutput/" . $idcell . '/' . $date;
		$data     = file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$data     = json_decode($data);
		return $data;
	}
	//Target from ERP
	function mssTargetCell($idcell, $date)
	{
		$date = date('Ymd', strtotime($date));
		$path 	= TARGETCELLBYDAY . $idcell . '/' . $date;
		$data 	= file_get_contents($path, false, stream_context_create($this->arrContextOptions));
		$data 	= json_decode($data);;
		return $data;
	}
	// Grafik
	function _generateGrafik($grafik)
	{
		$no = 0;
		$graf = [];

		if ($grafik) {
			$totalJam12 = 0;
			foreach ($grafik as $g) {
				if ($g->TIME_CD == 'A012') {
					$totalJam12 = $g->SCAN_QTY;
				}

				if ($g->TIME_CD != 'A012') {
					if ($g->TIME_CD == 'A013') {
						$graf[$no]        = [
							'x'        => $g->TIME_CD,
							'y'        => $g->SCAN_QTY + $totalJam12,
						];
					} else {
						$graf[$no]        = [
							'x'        => $g->TIME_CD,
							'y'        => $g->SCAN_QTY,
						];
					}

					$no++;
				}
			}
		}
		return $graf;
	}

	//Perbarui data KPI
	function perbaruiDataKpi($kode_factory, $cell, $tgl)
	{
		//hapus data pekerjaan
		$where = [
			'LINE_CD'               => $cell,
			'tanggal_pekerjaan'     => date('Y-m-d', strtotime($tgl))
		];
		$this->db->where($where);
		$this->db->delete('pekerjaan');

		//update data pekerjaan
		return [
			'kode'  => 'success',
			'data'  => $this->ajaxFilterSebelum($kode_factory, $cell, $tgl)
		];
	}
}

/* End of file: M_level_1.php */
