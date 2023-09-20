<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EstandarCompetenciaConvocatoriaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('estandar_competencia_convocatoria','ecc');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_join()
	{
		$joins = ' inner join estandar_competencia ec on ec.id_estandar_competencia = ecc.id_estandar_competencia ';
		$joins .= ' inner join archivo a on a.id_archivo = ec.id_archivo ';
		return $joins;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($this->usuario->perfil) && $this->usuario->perfil <> 'root'){
			$criterios .= " and ecc.eliminado = 'no'";
		}if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){ //para buscar por los EC asignados a los usuarios instructor y alumno
			$criterios .= ' and ecc.id_estandar_competencia = '.$data['id_estandar_competencia'];
		}if(isset($data['fecha']) && $data['fecha'] != ''){
			$criterios .= " and ecc.alineacion_fin >= '".$data['fecha']."'";
		}
		return $criterios;
	}

}
