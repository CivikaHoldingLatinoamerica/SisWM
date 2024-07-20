<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ECGrupos extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
		$this->load->model('EstandarCompetenciaGrupoModel');
		$this->load->model('CatalogoModel');
		$this->load->model('ECInstrumentoModel');
		$this->load->model('EstandarCompetenciaModel');
		$this->load->model('ECInstrumentoActividadHasArchivo');
		$this->load->model('ECInstrumentoHasActividadModel');
		$this->load->model('UsuarioHasECModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

	public function index($id_estandar_competencia){
    		//grupos del estandar de competencia
		perfil_permiso_operacion('estandar_competencia.consultar');
		try{
			$array_busqueda = [
				'id_estandar_competencia' => $id_estandar_competencia,
				'usuario_perfil' => $this->usuario->perfil
			];
			$data = $this->EstandarCompetenciaGrupoModel->tablero($array_busqueda,1,5);
			$data['titulo_pagina'] = 'Grupos del Estándar de Competencia';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Grupos','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			$data['extra_css'] = array();
			$data['extra_js'] = array(
				base_url().'assets/js/ec/grupos.js'
			);

			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data_paginacion = data_paginacion(1,5,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('ec/grupo/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function tablero($id_estandar_competencia,$pagina = 1,$registros = 5){
		perfil_permiso_operacion('estandar_competencia.consultar');
    		try{
			$array_busqueda = [
				'id_estandar_competencia' => $id_estandar_competencia,
				'usuario_perfil' => $this->usuario->perfil
			];
    			$post = $this->input->post();
			$post = array_merge($array_busqueda,$post);
			$data = $this->EstandarCompetenciaGrupoModel->tablero($post,$pagina,$registros);
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$registros,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			//var_dump($data);exit;
			$this->load->view('ec/grupo/resultado_tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_modificar($id_estandar_competencia,$id_estandar_competencia_grupo = false){
		perfil_permiso_operacion('estandar_competencia.agregar');
		$this->load->model('EstandarCompetenciaGrupoModel');
		$data['cat_area_tematica'] = $this->CatalogoModel->get_catalogo('cat_area_tematica');
		$data['id_estandar_competencia'] = $id_estandar_competencia;
		$instructores = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'perfil' => 'instructor'),0);
		$data['instructores_asignados'] = $instructores['usuario_has_estandar_competencia'];
		if($id_estandar_competencia_grupo){
			$data['estandar_competencia_grupo'] = $this->EstandarCompetenciaGrupoModel->obtener_row($id_estandar_competencia_grupo);
		}
		$this->load->view('ec/grupo/agregar_modificar_grupos',$data);
	}

	public function guardar_form($id_estandar_competencia_grupo = false){
		perfil_permiso_operacion('estandar_competencia.agregar');
    		try{
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::formEcGrupo($post);
			if($validaciones['success']){
				$guardar_ec = $this->EstandarCompetenciaGrupoModel->guardar_row($post,$id_estandar_competencia_grupo);
				if($guardar_ec['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar_ec['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_ec['msg'];
				}
			}else{
				$response['success'] = false;
				$response['msg'] = $validaciones['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function eliminar($id_estandar_competencia_grupo){
		perfil_permiso_operacion('estandar_competencia.agregar');
    		try{
			$eliminar = $this->EstandarCompetenciaGrupoModel->eliminar_row($id_estandar_competencia_grupo);
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
		echo json_encode($response);exit;
	}

	public function deseliminar($id_estandar_competencia_grupo){
		perfil_permiso_operacion('estandar_competencia.deseliminar');
		try{
			$deseliminar = $this->EstandarCompetenciaGrupoModel->deseliminar_row($id_estandar_competencia_grupo);
			if($deseliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $deseliminar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $deseliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

}
