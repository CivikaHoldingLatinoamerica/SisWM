<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EstandarCompetenciaGrupoModel extends ModeloBase
{

	function __construct()
	{
		parent::__construct('estandar_competencia_grupo','ecg');
		
	}

	public function select_data(){
		return 'ecg.*,cat.*,du.nombre,du.apellido_p,du.apellido_m';
	}

	public function criterios_join()
	{
		$joins = ' inner join cat_area_tematica cat on ecg.id_cat_area_tematica = cat.id_cat_area_tematica ';
		$joins .= ' left join datos_usuario du on du.id_usuario = ecg.id_instructor ';
		return $joins;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['busqueda']) && $data['busqueda'] != ''){
			$data['busqueda'] = strtoupper($data['busqueda']);
			$criterios .= " and (
					UPPER(ecg.clave_grupo) like '%".$data['busqueda']."%' OR 
					UPPER(ecg.nombre_grupo) LIKE '%".$data['busqueda']."%'
				)";
		}if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){
			$criterios .= " and ecg.id_estandar_competencia = ".$data['id_estandar_competencia'];
		}if(isset($data['usuario_perfil']) && $data['usuario_perfil'] != 'root'){
			$criterios .= " and ecg.eliminado = 'no'";
		}
		return $criterios;
	}

}
