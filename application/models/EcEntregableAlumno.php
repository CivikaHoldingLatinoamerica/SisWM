<?php

defined('BASEPATH') or exit('No tiene access al script');
require_once FCPATH . 'application/models/ModeloBase.php';
class EcEntregableAlumno  extends ModeloBase
{
	function __construct()
	{
		parent::__construct('ec_entregable_alumno', 'eea');
	}

	public function cambiar_estatus($id_entregable, $id_alumno, $id_estatus,$id_entregable_formulario = false){

		try {
			//pasamos por la funcion  de si existe el registro del entregable
			$this->registroEntregable($id_entregable,$id_alumno);
			$this->db->set('id_cat_proceso', $id_estatus);
			$this->db->where('id_entregable', $id_entregable);
			$this->db->where('id_usuario', $id_alumno);
			$this->db->update('ec_entregable_alumno');

			if ($id_entregable_formulario){
				$this->db->set('id_cat_proceso', $id_estatus);
				$this->db->where('id_entregable_formulario', $id_entregable_formulario);
				$this->db->where('id_usuario', $id_alumno);
				$this->db->update('entregable_formulario_has_alumno');
			}

			$return['success'] = true;
			$return['msg'] = 'Se actualizó el registro con exito';
		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}

	public function registrar_calificacion_entregable($id_entregable,$id_usuario_alumno,$calificacion){
		try{
			$return['success'] = true;
			$return['msg'] = 'Se registro la calificación del entregable correctamente';
			$this->db->set('calificacion',$calificacion);
			$this->db->where('id_entregable', $id_entregable);
			$this->db->where('id_usuario', $id_usuario_alumno);
			$this->db->update('ec_entregable_alumno');
		}catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	private function registroEntregable($id_entregable,$id_alumno){
		$this->db->where('id_entregable', $id_entregable);
		$this->db->where('id_usuario', $id_alumno);
		$query = $this->db->get('ec_entregable_alumno');
		if($query->num_rows() == 0){
			$this->insertar(['id_entregable' => $id_entregable,'id_usuario' => $id_alumno,'id_cat_proceso' => ESTATUS_EN_CAPTURA]);
		}
	}
}
