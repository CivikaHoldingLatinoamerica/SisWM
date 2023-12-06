<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
			//$data
			$this->load->view('reportes/empresa',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function candidato(){

	}

	
}
