<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EntregableHasEvaluacionModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('entregable_has_evaluacion','ehe');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_join(){
		$joins = ' inner join evaluacion e on e.id_evaluacion = ehe.id_evaluacion ';
		return $joins;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_entregable']) && $data['id_entregable'] != ''){
			$criterios .= " and ehe.id_entregable = ".$data['id_entregable'];
		}if(isset($data['id_cat_evaluacion']) && $data['id_cat_evaluacion'] != ''){
			$criterios .= " and e.id_cat_evaluacion = ".$data['id_cat_evaluacion'];
		}if(isset($data['eliminado']) && $data['eliminado'] != ''){
			$criterios .= " and e.eliminado = '".$data['eliminado']."'";
		}
		return $criterios;
	}

}
