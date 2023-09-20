<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publico extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		$this->load->model('EstandarCompetenciaConvocatoriaModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = null;
		}
	}

	public function index()
	{
		$data['titulo_pagina'] = 'Walmart Certificaciones Civika';
		$data['usuario'] = $this->usuario;
		$data['extra_js'] = array(
			base_url() . 'assets/js/convocatorias_publicas.js',
		);
		$this->load->view('publico',$data);
	}

	public function tablero($pagina = 1, $registros = 5){
    		try{
			//integramos la fecha del sistema y poder filtrar las convocatorias vigentes. Se toma hasta antes del final de la alineación
    			$post = [
				'fecha' => date('Y-m-d')
			];
			if(!is_null($this->usuario) && in_array($this->usuario->perfil,array('instructor','alumno'))){
				$post['id_usuario'] = $this->usuario->id_usuario;
			}
			$data = $this->EstandarCompetenciaConvocatoriaModel->tablero($post,$pagina,$registros);
			//var_dump($data);
			// echo $this->EstandarCompetenciaConvocatoriaModel->ultima_query();
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$registros,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('convocatorias_publicadas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

}
