<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';
class DatosEmpresaModel extends ModeloBase
{
	private $usuario;

	public function __construct()
	{
		parent::__construct('datos_empresa', 'de');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function actualizar_vigente($id_usuario){
		$this->db->where('id_usuario',$id_usuario);
		return $this->db->update('datos_empresa',array('vigente' => 'no'));
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_usuario']) && $data['id_usuario'] != ''){
			$criterios .= " and de.id_usuario = ".$data['id_usuario'];
		}if(isset($data['rfc']) && $data['rfc'] != ''){
			$criterios .= " and upper(de.rfc) like '%".strtoupper($data['rfc'])."%'";
		}if(isset($data['busqueda']) && $data['busqueda'] != ''){
			$criterios .= " and (
				upper(de.nombre) like '%".strtoupper($data['busqueda'])."%' OR
				upper(de.nombre_corto) like '%".strtoupper($data['busqueda'])."%' OR
				upper(de.rfc) like '%".strtoupper($data['busqueda'])."%' OR
				upper(de.domicilio_fiscal) like '%".strtoupper($data['busqueda'])."%' OR
				upper(de.telefono) like '%".strtoupper($data['busqueda'])."%' OR
				upper(de.correo) like '%".strtoupper($data['busqueda'])."%'
			)";
		}
		return $criterios;
	}

	public function obtenerEmpresaDesdeRFC($rfc){
		$rfc = strtoupper($rfc);
		$this->db->where('rfc',$rfc);
		$query = $this->db->get('datos_empresa');
		if($query->num_rows() != 0){
			return $query->row();
		}return null;
	}

}
