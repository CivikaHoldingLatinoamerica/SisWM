<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PreguntasAbiertas extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
        
        $this->load->model('CatalogoPreguntaFormAbiertoModel');
        $this->load->model('RespuestaPreguntaFormAbiertoModel');
		$this->load->model('EstandarCompetenciaModel');
        $this->load->model('UsuarioHasECModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

	public function index($id_entregable_evidencia){
    	//tecnicas_instrumentos
		perfil_permiso_operacion('evaluacion.consultar');
		try{
			

			$data['titulo_pagina'] = 'Formulario de preguntas';
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_entregable_evidencia);
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Formulario de preguntas','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['id_entregable_evidencia'] = $id_entregable_evidencia;
			
			$data['extra_js'] = array(
				base_url() . 'assets/js/ec/formPreguntasAbiertas.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
			);
			$this->load->view('evaluacion/tableroPreguntasAbiertas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function resultado($id_entregable_evidencia){
		perfil_permiso_operacion('evaluacion.consultar');
    	try{
			
    		$busqueda = array(
    			'id_entregable_evidencia' => $id_entregable_evidencia
			);
			$data = $this->CatalogoPreguntaFormAbiertoModel->tablero($busqueda);
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_entregable_evidencia);
			
			$this->load->view('evaluacion/resultado_preguntas_abiertas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_pregunta($id_entregable_evidencia,$id_cat_pregunta_formulario_abierto = false){
		perfil_permiso_operacion('preguntas_evaluacion.agregar');
		try{
			$data['id_entregable_evidencia'] = $id_entregable_evidencia;
			if($id_cat_pregunta_formulario_abierto){
				$data['pregunta_abierta'] = $this->CatalogoPreguntaFormAbiertoModel->obtener_row($id_cat_pregunta_formulario_abierto);
			}
			$this->load->view('evaluacion/agregar_preguntas_abiertas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_pregunta_abierta($id_entregable_evidencia,$id_cat_pregunta_formulario_abierto = false){
		
		perfil_permiso_operacion('preguntas_evaluacion.agregar');
		try{
			$post = $this->input->post();
			if(isset($post['pregunta_formulario_abierto'])){
				$guardar_pregunta = $this->CatalogoPreguntaFormAbiertoModel->guardar_pregunta_abierta($post,$id_entregable_evidencia,$id_cat_pregunta_formulario_abierto);
				if($guardar_pregunta['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar_pregunta['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_pregunta['msg'];
				}
			}else{
				$response['success'] = false;
				$response['msg'] ="Debe agregar una pregunta";
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function eliminar_pregunta_abierta($id_cat_pregunta_formulario_abierto){
    	perfil_permiso_operacion('preguntas_evaluacion.eliminar');
		try{
			$eliminar = $this->CatalogoPreguntaFormAbiertoModel->eliminar_pregunta_abierta($id_cat_pregunta_formulario_abierto);
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

	public function formulario_respuestas($id_entregable_evidencia){
    	//tecnicas_instrumentos
		perfil_permiso_operacion('evaluacion.consultar');
		try{
			
			$data['titulo_pagina'] = 'Formulario de preguntas';
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_entregable_evidencia);
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Formulario de preguntas','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['id_entregable_evidencia'] = $id_entregable_evidencia;

			$busqueda = array(
    			'id_entregable_evidencia' => $id_entregable_evidencia
			);

			$data['catalogoPreguntaFormAbiertoModel'] = $this->CatalogoPreguntaFormAbiertoModel->tablero($busqueda);
			//var_dump($data['catalogoPreguntaFormAbiertoModel']['preguntas_abiertas']); exit();
			$data['extra_js'] = array(
				base_url() . 'assets/js/ec/formPreguntasAbiertas.js',
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
				base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
				
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
			);
			$this->load->view('evaluacion/tableroRespuestasPreguntasAbiertas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}
	
}
