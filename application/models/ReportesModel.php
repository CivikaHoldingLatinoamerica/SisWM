<?php
defined('BASEPATH') OR exit('No tiene access al script');

use \PHPMailer\PHPMailer\PHPMailer;

require_once FCPATH.'application/models/ModeloBase.php';

class ReportesModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('',''); 
		
	}

	public function obtener_reporte_empresa($para_vista = false,$params = false){
		try{
			$params = strtoupper($params);
			$consulta = "select 
					de.nombre nombre_empresa,
					upper(de.rfc) as rfc_empresa,
					'Inscrita' as estatus_inscripcion,
					if(count(uhec.id_usuario_has_estandar_competencia) <> 0 and count(uhec.id_usuario_has_estandar_competencia) = count(uhec.jucio_evaluacion = 'competente' ),'Finalizada','Iniciada' ) as proceso_evaluacion,
					count(u.id_usuario) candidatos_registrados_empresa,
					count(uhec.id_usuario_has_estandar_competencia) candidatos_preceso_certificacion,
					count(uhec.jucio_evaluacion = 'competente' ) candidatos_certificados
				from datos_empresa de
					inner join usuario u on u.id_usuario = de.id_usuario
					left join usuario_has_estandar_competencia uhec on uhec.id_usuario = u.id_usuario 
				where 1=1";
			if($params != false){
				$consulta .= " and (
					UPPER(de.nombre) like '%".$params."%' OR
					UPPER(de.rfc) like '%".$params."%'
				)";
			}
			$consulta .= ' group by upper(de.rfc)';
			if($para_vista != false){
				$consulta .= " order by de.id_datos_empresa desc
				limit 20";
			}
			$query = $this->db->query($consulta);
			return $query->result();
		}catch (Exception $ex){
			$data = [];
		}
		return $data;
	}

}
