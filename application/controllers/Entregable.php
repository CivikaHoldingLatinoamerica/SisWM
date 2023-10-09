<?php

class entregable extends CI_Controller
{
	private $usuario;
	public $entregables;
	function __construct()
	{
		parent:: __construct();
		$this->load->model('EntregableECModel');
		$this->load->model('ActividadIEModel');
	}

	function index($id_estandar_competencia){
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
		try{
			$data['titulo_pagina'] = 'Entregables esperados';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => '#'),
				array('nombre' => 'Entregables esperados','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = '';
			$data['extra_js'] = array(
				base_url().'assets/js/ec/entregables.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js'
			);
			$data['extra_css'] = array(
				base_url().'assets/css/EC/entregables.css',
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',

			);
			$data['usuario'] = $this->usuario;
			$data['estandar'] = $id_estandar_competencia;



			$data['instrumentos'] = $this->ActividadIEModel->obtener_instrumentos_ec_entregable($id_estandar_competencia);

			$datos = $this->EntregableECModel->obtener_entregables(1,10,$id_estandar_competencia);

			$data['entregables'] = $datos;

			$this->load->view('entregables/evidencias_esperadas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	function index_candidato(){
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
		try{
			$data['titulo_pagina'] = 'Entregables esperados';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => '#'),
				array('nombre' => 'Entregables esperados','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = '';
			$data['extra_js'] = array(
				base_url().'assets/js/ec/entregable_candidato.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/css/EC/entregables.css'
			);
			$data['usuario'] = $this->usuario;
			$this->entregables[] = (object)array(
				"nombre" => "Entregable 1",
				"instrumentos" => array(
					0 => "La carta descriptiva elaborada",
					1 => "El objetivo general del curso redactado.",
					2 => "Los objetivos particulares y/o específicos elaborados."
				));
			$data['entregables'] = $this->entregables;
			$this->load->view('entregables/candidato/evidencias_candidato',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	function guardar_entregable(){
		try {


			$post = $this->input->post();

			$id= false;
			if (isset($post['id_entregable'])){
				$id = $post['id_entregable'];
			}
			$data = $this->EntregableECModel->guardar_entregable($post,$id);




			$data['success'] = true;

			if($data['success']){
				$response['success'] = true;
				$response['data'] = (object) $post;
				$response['msg'] = array('Se guardo el entregable correctamente');
			}else{
				$response['success'] = false;
				$response['msg'] = array('No fue posible guardar el entregable, favor de intentar más tarde');
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);

	}

	public function obtener_entregables($pagina = 1, $limit = 10){
		$post = $this->input->post();
		$datos = $this->EntregableECModel->obtener_entregables($pagina,$limit,$post['id_estandar_competencia']);

		$data['entregables'] = $datos;
		$this->load->view('entregables/cards_evidencias',$data);
	}
	public function obtener_entregable($id){
		$data['entregable'] = $this->EntregableECModel->obtener_entregable($id);

		$data['instrumentos'] = $this->ActividadIEModel->obtener_instrumentos_ec_entregable(1);

		$this->load->view('entregables/modal_formulario',$data);
	}

	public function eliminar($id){
		try{
			$eliminar =  $this->EntregableECModel->eliminar($id);
			if($eliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $eliminar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $eliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}
}
