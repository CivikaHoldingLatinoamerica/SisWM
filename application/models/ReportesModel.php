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

	

}
