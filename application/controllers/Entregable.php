<?php

class entregable extends CI_Controller
{
	private $usuario;
	public $entregables;
	function __construct()
	{
		parent:: __construct();
	}

	function index(){
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
			$this->load->view('entregables/evidencias_esperadas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	function guardar_entregable(){
		try {
			$this->load->model('CatSectorEc');
			$post = $this->input->post();

			$id= false;
			if (isset($post['id_cat_sector_ec'])){
				$id = $post['id_cat_sector_ec'];
			}
//			$data = $this->CatSectorEc->guardar_row($post,$id);

			$this->entregables[] = $post;

			$data['success'] = true;

			if($data['success']){
				$response['success'] = true;
				$response['data'] = (object) $post;
				$response['msg'] = array('Se guardo el sector correctamente');
			}else{
				$response['success'] = false;
				$response['msg'] = array('No fue posible guardar el sector, favor de intentar más tarde');
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);

	}

	public function obtener_entregables($pagina = 1, $limit = 10){
		$post = $this->input->post('data');
		$datos = array();
		foreach ($post as $item){
			$datos[] = (object)$item;
		}
		$data['entregables'] = $datos;
		$this->load->view('entregables/cards_evidencias',$data);
	}

	public function eliminar($id){
		try{
			$eliminar['success'] = true;
			$eliminar['msg'] = "Actualizado correctamente";
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
