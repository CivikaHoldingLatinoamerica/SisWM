<?php
defined('BASEPATH') OR exit('No tiene access al script');

class CatalogoModel extends CI_Model
{

	private $usuario;

	function __construct()
	{
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function cat_estado(){
		$query = $this->db->get('cat_estado');
		return $query->result();
	}

	public function cat_municipio($id_cat_estado){
		$this->db->where('id_cat_estado',$id_cat_estado);
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('cat_municipio');
		return $query->result();
	}

	public function cat_localidad($id_cat_municipio){
		$this->db->where('id_cat_municipio',$id_cat_municipio);
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('cat_localidad');
		return $query->result();
	}

	public function get_catalogo($tabla,$id = false){
		if($id !== false){
			$this->db->where('id_'.$tabla,$id);
			$query = $this->db->get($tabla);
			return $query->row();
		}
		$query = $this->db->get($tabla);
		return $query->result();
	}

	public function cat_perfil(){
		$this->db->where('id_cat_perfil <>',1);
		$query = $this->db->get('cat_perfil');
		return $query->result();
	}

	public function cat_modulo(){
		$this->db->where('id_cat_modulo <>',1);
		$query = $this->db->get('cat_modulo');
		return $query->result();
	}

	public function cat_permiso(){
		$this->db->where('id_cat_permiso <>',1);
		$query = $this->db->get('cat_permiso');
		return $query->result();
	}

	public function actividad_ec($id_cat_instrumento){
		$this->db->where('id_cat_instrumento',$id_cat_instrumento);
		$query = $this->db->get('activida_ec');
		return $query->result();
	}

	public function cat_sector_productivo(){
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('cat_sector_productivo');
		return $query->result();
	}

	public function cat_preguntas_encuesta(){
		$this->db->where('eliminado','no');
		$query = $this->db->get('cat_preguntas_encuesta');
		return $query->result();
	}

	public function cat_preguntas_encuesta_uno(){
		$this->db->where('eliminado','no');
		$this->db->order_by('id_cat_preguntas_encuesta','asc');
		$query = $this->db->get('cat_preguntas_encuesta');
		return $query->row();
	}

	public function cat_msg_bienvenida(){
		$query = $this->db->get('cat_msg_bienvenida');
		$row = $query->row();
		if($query->num_rows() == 0){
			$this->db->insert('cat_msg_bienvenida',array('nombre' => ''));
			$query = $this->db->get('cat_msg_bienvenida');
			$row = $query->row();
		}return $row;
	}

	public function cat_sector_ec(){
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('cat_sector_ec');
		return $query->result();
	}

	public function cat_ocupacion_especifica(){
		$this->db->where('id_cat_ocupacion_especifica_parent',null);
		$query = $this->db->get('cat_ocupacion_especifica');
		$result = $query->result();
		foreach($result as $r){
			$r->coe_child = $this->cat_ocupacion_especifica_child($r->id_cat_ocupacion_especifica);
		}
		return $result;
	}

	public function cat_ocupacion_especifica_child($id_cat_ocupacion_especifica_parent){
		$this->db->where('id_cat_ocupacion_especifica_parent',$id_cat_ocupacion_especifica_parent);
		$query = $this->db->get('cat_ocupacion_especifica');
		return $query->result();
	}

	public function cat_area_tematica(){
		$query = $this->db->get('cat_area_tematica');
		return $query->result();
	}
	

}
