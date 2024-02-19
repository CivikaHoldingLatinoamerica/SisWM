<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioHasECEvaluadoresModel extends ModeloBase
{

	function __construct()
	{
		parent::__construct('usuario_has_ec_evaluadores','uhece');
	}

	

}
