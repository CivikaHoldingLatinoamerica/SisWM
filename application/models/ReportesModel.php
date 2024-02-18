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
					de.nombre_corto as nombre_empresa_corto,
					if(de.id_cat_categoria_empresa is null,'Sin categoria',cce.nombre) categoria_empresa,
					upper(de.rfc) as rfc_empresa,
					'Inscrita' as estatus_inscripcion,
					if(count(uhec.id_usuario_has_estandar_competencia) <> 0 and count(uhec.id_usuario_has_estandar_competencia) = count(uhec.jucio_evaluacion = 'competente' ),'Finalizada','Iniciada' ) as proceso_evaluacion,
					count(u.id_usuario) candidatos_registrados_empresa,
					count(uhec.id_usuario_has_estandar_competencia) candidatos_preceso_certificacion,
					count(uhec.jucio_evaluacion = 'competente' ) candidatos_certificados
				from datos_empresa de
					inner join usuario u on u.id_usuario = de.id_usuario
					left join usuario_has_estandar_competencia uhec on uhec.id_usuario = u.id_usuario 
					left join cat_categoria_empresa cce on cce.id_cat_categoria_empresa = de.id_cat_categoria_empresa
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

	public function obtener_reporte_alumno($para_vista = false,$params = false){
		try{
			$params = strtoupper($params);
			$consulta = "select 
					ec.codigo codigo_ec, ec.titulo titulo_ec,
					du.nombre, du.apellido_p, du.apellido_m,du.correo, du.curp, du.celular,
					de.nombre nombre_empresa, de.nombre_corto as nombre_empresa_corto,
					upper(de.rfc) rfc_empresa,
					if(de.id_cat_categoria_empresa is null,'Sin categoria',cce.nombre) categoria_empresa, 
					if(du.id_cat_ocupacion_especifica  is null,'Sin ocupacion',coe.denominacion) ocupacion_especifica, 
					if(uhec.jucio_evaluacion is null,'En proceso', upper(uhec.jucio_evaluacion)) as juicio_evaluacion,
					format((select if(count(*) = 0,0, ((count(*) / 7) * 100)) from usuario_has_ec_progreso uhep where uhep.id_usuario_has_estandar_competencia = uhec.id_usuario_has_estandar_competencia),'N2') progreso
				from usuario u
					inner join datos_empresa de on de.id_usuario = u.id_usuario 
					inner join datos_usuario du on du.id_usuario = u.id_usuario 
					inner join usuario_has_estandar_competencia uhec on uhec.id_usuario = u.id_usuario
					inner join estandar_competencia ec on ec.id_estandar_competencia = uhec.id_estandar_competencia
					left join cat_categoria_empresa cce on cce.id_cat_categoria_empresa = de.id_cat_categoria_empresa 
					left join cat_ocupacion_especifica coe on coe.id_cat_ocupacion_especifica = du.id_cat_ocupacion_especifica
				where 1=1";
			if($params != false){
				$consulta .= " and (
					UPPER(ec.codigo) like '%".$params."%' OR
					UPPER(ec.titulo) like '%".$params."%' OR
					UPPER(du.nombre) like '%".$params."%' OR
					UPPER(du.apellido_p) like '%".$params."%' OR
					UPPER(du.apellido_m) like '%".$params."%' OR
					UPPER(du.curp) like '%".$params."%' OR
					UPPER(de.nombre) like '%".$params."%' OR
					UPPER(de.rfc) like '%".$params."%'
				)";
			}
			//$consulta .= ' group by upper(de.rfc)';
			if($para_vista != false){
				$consulta .= " order by u.id_usuario desc
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
