<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';
class CatOcupacionEspecificaModel extends ModeloBase
{
	private $usuario;

	public function __construct()
	{
		parent::__construct('cat_ocupacion_especifica', 'cse');
	}

	public function catalogo(){
		try{
			$retorno = $this->cat_ocupacion_especifica_area();
			foreach($retorno as $r){
				$r->subAreas = $this->cat_ocupacion_especifica_subarea($r->id_cat_ocupacion_especifica);
			}
			return $retorno;
		}catch (Exception $ex){
			log_message('error',$this->table.'->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}
	}

	public function cat_ocupacion_especifica_area(){
		$this->db->where('id_cat_ocupacion_especifica_parent',null);
		$query = $this->db->get('cat_ocupacion_especifica');
		return $query->result();
	}

	public function cat_ocupacion_especifica_subarea($id_parent){
		$this->db->where('id_cat_ocupacion_especifica_parent',$id_parent);
		$query = $this->db->get('cat_ocupacion_especifica');
		return $query->result();
	}
	
}
