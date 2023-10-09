<?php
defined('BASEPATH') or exit('No tiene access al script');
require_once FCPATH . 'application/models/ModeloBase.php';

class EntregableECModel extends ModeloBase
{
	private $usuario;

	public function __construct()
	{
		parent::__construct('entregable_ec', 'ee');
		if (sesionActive()) {
			$this->usuario = usuarioSession();
		}
	}

	public function guardar_entregable($parametros, $id = false)
	{
		try {
			$return['success'] = false;
			$return['msg'] = 'Se guardo el nuevo registro con exito';


			if ($id) {
				$this->db->set('nombre', $parametros['nombre']);
				$this->db->set('descripcion', $parametros['descripcion']);
				$this->db->set('instrucciones', $parametros['instrucciones']);
				$this->db->set('tipo_entregable', $parametros['tipo_entregable']);
				$this->db->where('id_entregable', $id);
				$this->db->update('entregable_ec');
			} else {
				$this->db->insert('entregable_ec', array(
					'nombre' => $parametros['nombre'],
					'descripcion' => $parametros['descripcion'],
					'instrucciones' => $parametros['instrucciones'],
					'tipo_entregable' => $parametros['tipo_entregable'],
					'activo' => true,
					'id_estandar_competencia' => $parametros['id_estandar_comptencia'],
				));

				$id = $this->db->insert_id();
			}

			$this->db->where('id_entregable', $id);
			$this->db->delete('entregable_has_instrumento');

			$this->db->where('id_entregable', $id);
			$this->db->delete('entregable_has_archivo');


			foreach ($parametros['instrumentos'] as $item) {
				$this->db->insert('entregable_has_instrumento', array(
					'id_entregable' => $id,
					'id_ec_instrumento_has_actividad' => $item));
				$this->db->insert_id();
			}

			$this->db->insert('entregable_has_archivo', array(
				'id_entregable' => $id,
				'id_archivo' => $parametros['id_archivo']));
			$this->db->insert_id();


		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function obtener_entregables($pagina, $limit, $id_estandar_competencia)
	{
		$sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";

		if ($pagina == 0) {
			$sql_limit = '';
		}
		$consulta = "select * from entregable_ec ee where activo = 1 and ee.id_estandar_competencia = " . $id_estandar_competencia;
		$consulta .= $sql_limit;
		$query = $this->db->query($consulta);
		$data = $query->result();

		foreach ($data as $item) {

			$consulta = "select eiha.actividad from ec_instrumento_has_actividad eiha
                      join entregable_has_instrumento ehi on ehi.id_ec_instrumento_has_actividad = eiha.id_ec_instrumento_has_actividad
                      where ehi.id_entregable = " . $item->id_entregable;
			$query = $this->db->query($consulta);
			$item->instrumentos = $query->result();

		}

		return $data;
	}

	public function obtener_entregable($id)
	{
		$consulta = "select * from entregable_ec ee where ee.id_entregable = " . $id;
		$query = $this->db->query($consulta);
		$data = $query->row();


		$consulta = "select ehi.id_ec_instrumento_has_actividad from entregable_has_instrumento ehi
                      where ehi.id_entregable = " . $id;
		$query = $this->db->query($consulta);

		$instrumentos = $query->result();
		$data->instrumentos = array();
		foreach ($instrumentos as $item) {
			$data->instrumentos[] = $item->id_ec_instrumento_has_actividad;
		}

		$consulta = "select a.* from entregable_has_archivo eha
                                  join archivo a on a.id_archivo = eha.id_archivo
                      where eha.id_entregable = " . $id;
		$query = $this->db->query($consulta);

		$archivos= $query->result();

		if (!empty($archivos)){
			$data->archivo = $archivos[0]->nombre;
			$data->id_archivo =$archivos[0]-> id_archivo;
		}


		return $data;
	}

	public function eliminar($id)
	{
		try {
			$this->db->set('activo', 0);
			$this->db->where('id_entregable', $id);
			$this->db->update('entregable_ec');
			$return['success'] = true;
			$return['msg'] = 'Se eliminó el registro con exito';
		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}
}
