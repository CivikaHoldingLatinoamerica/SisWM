<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class CatalogoPreguntaFormAbiertoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('cat_pregunta_formulario_abierto', 'cpfa');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function tablero($data,$pagina = 1, $registros = 10){
		try{
			$sql_limit = " limit ".(($pagina*$registros)-$registros).",$registros";
			if($pagina == 0){
				$sql_limit = '';
			}
			$consulta = $this->obtener_query_base().' '.$this->criterios_join().' '.$this->criterios_busqueda($data).' '.$this->group_by().' '.$this->order_by().' '.$sql_limit;
			$query = $this->db->query($consulta);
			$retorno['success'] = true;
			$retorno['preguntas_abiertas'] = $query->result();
			$retorno['total_registros'] = $this->obtener_total_registros($data);
			return $retorno;
		}catch (Exception $ex){
			log_message('error',$this->table.'->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_entregable_evidencia']) && $data['id_entregable_evidencia'] != ''){
			$criterios .= " and cpfa .id_entregable_evidencia = ".$data['id_entregable_evidencia'];
		}
		return $criterios;
	}



	public function guardar_pregunta_abierta($post,$id_entregable_evidencia,$id_cat_pregunta_formulario_abierto){
		//var_dump($post, $id_cat_pregunta_formulario_abierto, $id_cat_pregunta_formulario_abierto === false); exit();
		if($id_cat_pregunta_formulario_abierto === false){
			return $this->guardar_row(array(
				'id_entregable_evidencia' => $id_entregable_evidencia,
				'pregunta_formulario_abierto' => $post['pregunta_formulario_abierto']));
		} else {
			return $this->actualizar_row_criterios(array('id_cat_pregunta_formulario_abierto' => $id_cat_pregunta_formulario_abierto,
				'id_entregable_evidencia' => $id_entregable_evidencia), array(
				'pregunta_formulario_abierto' => $post['pregunta_formulario_abierto']));
			
		}
	}

	public function eliminar_pregunta_abierta($id){
		try{
			$this->eliminar_row($id);//eliminamos la pregunta
			$return['success'] = true;
			$return['msg'] = 'Se eliminó el registro con exito';
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

}