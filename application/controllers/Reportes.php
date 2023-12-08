<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportes extends CI_Controller
{

	private $usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model('ReportesModel');
		if (sesionActive()) {
			$this->usuario = usuarioSession();
		} else {
			$this->usuario = false;
			redirect(base_url() . 'login');
		}
	}

	public function empresa()
	{
		perfil_permiso_operacion('reportes_ped.consultar');
		try{
			$data['titulo_pagina'] = 'Reportes empresa';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Reportes empresa','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'reporte_empresa';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/js/report/empresa.js',
			);
			$data['extra_css'] = array(
				//base_url().'assets/frm/fileinput/css/fileinput.css',
			);
			$this->load->view('reportes/empresa',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function tablero_empresa(){
		perfil_permiso_operacion('reportes_ped.consultar');
		try{
			$get = $this->input->get();
			$params = isset($get['params']) && $get['params'] != '' ? $get['params'] : false;
			$data['reporte_empresa'] = $this->ReportesModel->obtener_reporte_empresa(true,$params);
			$this->load->view('reportes/resultado_empresa',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function descargar_reporte_empresa(){
		try{
			$get = $this->input->get();
			$params = isset($get['params']) && $get['params'] != '' ? $get['params'] : false;
			$data = $this->ReportesModel->obtener_reporte_empresa(false,$params);
			if(is_array($data) && !empty($data)){
				switch($get['tipo_reporte']){
					case 'excel':
						$this->empresaExcel($data);
						break;
				};
			}else{
				echo 'Sin registros encontrados';exit;
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function candidato(){

	}

	/**
	 * funciones privadas para descargar reporte
	 */
	private function empresaExcel($data){
		try{
			/**
			 * preparamos los datos para vaciarlos al excel
			 */
			$encabezados = $this->obtenerEncabezados($data[0]);
			$hojaEmpresa = new Spreadsheet();
			$activeWorksheet = $hojaEmpresa->getActiveSheet();
			//$activeWorksheet->setCellValue('A1', 'reporte empresa');
			//agregamos los encabezados a la hoja
			$charInicial = 65;
			foreach($encabezados as $index => $e){
				$activeWorksheet->setCellValue(chr($charInicial+$index).'1', $e);
			}
			//vaciado de los datos
			$renglonInicio = 2;
			foreach($data as $registro){ //iteracion para los registros
				$index_columna = 0;
				foreach($registro as $info_columna){//iteración para las columnas de informacipon
					$activeWorksheet->setCellValue(chr($charInicial+$index_columna).''.$renglonInicio, $info_columna);	
					$index_columna++;
				}
				$renglonInicio++;
			}
			$writer = new Xlsx($hojaEmpresa);
			$ruta_reportes = getRouteFileReportes();
			subdirectorios_files($ruta_reportes);
			$nombreArchivoExcel = date('His').'-reporte_empresa.xlsx';
			$excel = FCPATH.$ruta_reportes.$nombreArchivoExcel;
			$writer->save($excel);
			//para descargar el
			$this->descargarExcel($excel,$nombreArchivoExcel);

		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	private function obtenerEncabezados($object){
		$encabezados = [];
		foreach($object as $columna => $valor){
			$encabezados[] = $columna;
		}
		return $encabezados;
	}

	private function descargarExcel($fileExcel,$nameFileExcel){
		try{
			ob_end_clean();
			header('Content-Disposition: attachment; filename=' . $nameFileExcel );
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Length: ' . filesize($fileExcel));
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			readfile($fileExcel);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}
}
