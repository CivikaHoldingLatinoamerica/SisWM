<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Mpdf\Config\ConfigVariables;
use \Mpdf\Config\FontVariables;
use \iio\libmergepdf\Merger;
//librerias para modificar los pdf cargados en el sistema
use setasign\Fpdi\Fpdi;
require_once FCPATH.'vendor/setasign/fpdf/fpdf.php';
require_once FCPATH.'vendor/setasign/fpdi/src/autoload.php';

class DocsPDF extends CI_Controller {

	private $usuario;
	private $default_pdf_params;
	

	function __construct()
	{
		parent:: __construct();
		$this->load->library('pdf');
		$this->load->model('ActividadIEModel');
		$this->load->model('ArchivoModel');
		$this->load->model('CatalogoModel');
		$this->load->model('ECUsuarioHasExpedientePEDModel');
		$this->load->model('EntregableECModel');
		$this->load->model('DocsPDFModel');
		$this->load->model('PerfilModel');
		$this->load->model('UsuarioModel');
		$this->load->model('UsuarioHasECModel');
		$this->load->model('UsuarioHasEncuestaModel');
		$this->load->model('UsuarioHasEvaluacionRealizadaModel');
		$this->set_variables_defaults_pdf();
	}

	public function validar_datos_generar_ped_pdf($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$data['evaluacion_diagnostica_realizada'] = false;
			$data['cargo_evidencia_ati'] = false;
			$data['cargo_expediente_digital_ped'] = false;
			$data['firma_evaluador'] = false;
			$data['candidato_expediente_digital'] = true;//foto de certificados, ine, curp, firma digital
			$data['fecha_evidencia_ati_evaluador'] = false;
			$data['ficha_registro_admin'] = false;
			$data['legend_candidato_expediente_digital'] = '';
			$data['candidato_encuesta_satisfacion'] = false;

			//validación de la evaluacion diagnostica
			$buscar_usuario_has_evaluacion_enviada =  array('id_estandar_competencia' => $id_estandar_competencia, 'id_usuario' => $id_usuario_alumno, 'enviada' => 'si');
			$usuario_has_evaluacion_enviada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
			$usuario_has_evaluacion_enviada['total_registros'] != 0 ? $data['evaluacion_diagnostica_realizada'] = true : $data['evaluacion_diagnostica_realizada'] = false;

			//validacion carga de evidencia ati
			// $instrumentos_ec_candidato = $this->ActividadIEModel->instrumentos_ec_entregados_candidato($id_estandar_competencia,$id_usuario_alumno);
			// $instrumentos_ec_candidato['instrumentos_ec']->num_entregables_ati == $instrumentos_ec_candidato['instrumentos_ec_candidato']->num_entregables_ati_candidato ? $data['cargo_evidencia_ati'] = true : false;
			//nueva validacion de la evidencia de los instrumentos por la actualización de los entregables
			$entregables_por_liberar = $this->EntregableECModel->obtenerEntregablesPorLiberarCandidato($id_usuario_alumno,$id_estandar_competencia);
			if(is_array($entregables_por_liberar) && sizeof($entregables_por_liberar) == 0){
				$data['cargo_evidencia_ati'] = true;
			}

			//validacion cargo_expediente_digital
			$buscar_expediente_ped = array('id_estandar_competencia' => $id_estandar_competencia, 'id_usuario' => $id_usuario_alumno);
			$expediente_ped = $this->ECUsuarioHasExpedientePEDModel->tablero($buscar_expediente_ped,0);
			$expediente_ped['total_registros'] == 3 ? $data['cargo_expediente_digital_ped'] = true : false;

			//validar la firma del evaluador
			$foto_firma = $this->PerfilModel->obtener_datos_expediente($id_usuario_instructor,8);
			is_object($foto_firma) ? $data['firma_evaluador'] = true : false;

			//validar expediente del candidato
			$foto_certificado_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,2);
			$foto_firma_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,8);
			$curp_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,7);
			$ine_anverso_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,3);
			$ine_reverso_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,4);
			if(!is_object($foto_certificado_candidato) || is_null($foto_certificado_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema la foto del candidato</li>';
			}if(!is_object($foto_firma_candidato) || is_null($foto_firma_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema la firma del candidato</li>';
			}if(!is_object($curp_candidato) || is_null($curp_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema el CURP del candidato</li>';
			}if(!is_object($ine_anverso_candidato) || is_null($ine_anverso_candidato) || !is_object($ine_reverso_candidato) || is_null($ine_reverso_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema el INE del Candidato (falta el anverso o reverso o ambos)</li>';
			}

			//validar fecha_evidencia_ati_evaluador
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $id_usuario_alumno),0);
			if(isset($usuario_has_ec['usuario_has_estandar_competencia'][0]->fecha_evidencia_ati) && !Validaciones_Helper::isCampoVacio($usuario_has_ec['usuario_has_estandar_competencia'][0]->fecha_evidencia_ati)){
				$data['fecha_evidencia_ati_evaluador'] = true;
			}

			$candidato_encuesta_satisfaccion = $this->UsuarioHasEncuestaModel->tablero(array('id_usuario_has_estandar_competencia' => $usuario_has_ec['usuario_has_estandar_competencia'][0]->id_usuario_has_estandar_competencia));
			if($candidato_encuesta_satisfaccion['total_registros'] != 0){
				$data['candidato_encuesta_satisfacion'] = true;
			}

			$response['success'] = true;
			$response['msg'][] = 'Se validó la información del sistema y estos son los resultados';
			$response['validaciones'] = $data;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function obtener_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$usuario_has_ec = $this->DocsPDFModel->obtener_usuario_has_ec($id_usuario_alumno,$id_estandar_competencia);
			if(is_object($usuario_has_ec) && isset($usuario_has_ec->id_archivo_ped) && !is_null($usuario_has_ec->id_archivo_ped) && $usuario_has_ec->id_archivo_ped != ''){
				$doc_ped = $this->ArchivoModel->obtener_archivo($usuario_has_ec->id_archivo_ped);
				$response['success'] = true;
				$response['existe_ped'] = true;
				$response['existe_ped_wm'] = false;
				$response['msg'][] = array('');
				$response['doc_portafolio_evidencia'] = base_url() . $doc_ped->ruta_directorio . $doc_ped->nombre;
				//para el ped de wm
				if(is_object($usuario_has_ec) && isset($usuario_has_ec->id_archivo_ped_wm) && !is_null($usuario_has_ec->id_archivo_ped_wm) && $usuario_has_ec->id_archivo_ped_wm != ''){
					$doc_ped = $this->ArchivoModel->obtener_archivo($usuario_has_ec->id_archivo_ped_wm);
					$response['existe_ped_wm'] = true;
					$response['doc_portafolio_evidencia_wm'] = base_url() . $doc_ped->ruta_directorio . $doc_ped->nombre;
				}
			}else{
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				$response['success'] = true;
				$response['existe_ped'] = false;
				$response['existe_ped_wm'] = false;
				$response['msg'][] = array('');
				$response['data'] = $data;
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_portada_to_ficha_registro($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-01-portafolio_portada_ficha_registro.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 0;
				$this->default_pdf_params['margin_bottom'] = 0;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_portada_ficha_registro', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}

			//agreamos el apartado para el ped que es de walmart
			$nombre_documento_wm = $pre.'-01-portafolio_portada_wm.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento_wm)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 0;
				$this->default_pdf_params['margin_bottom'] = 0;
				$mpdfWM = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdfWM->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdfWM->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia_wm/generar_portada', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdfWM->WriteHTML($paginaHTML);
				$mpdfWM->Output(RUTA_PDF_TEMP.$nombre_documento_wm, $output);
			}

			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Portada hasta Ficha de registro)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
			$response['data']['documento_wm'] = RUTA_PDF_TEMP.$nombre_documento_wm;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);die();
	}

	public function generar_pdf_diagnostico($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-02-portafolio-evaluacion_diagnostica.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//echo json_encode($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 38;
				$this->default_pdf_params['margin_bottom'] = 8;
				$this->default_pdf_params['orientation'] = 'L';
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_diagnostico', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (evaluación diagnostica)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_acuse_to_plan_evaluacion($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-03-portafolio-acuse_plan_evaluacion.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 20;
				$this->default_pdf_params['margin_bottom'] = 20;
				$this->default_pdf_params['orientation'] = 'L';
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_acuse_plan_evaluacion', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Acuse hasta plan de evaluación)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_plan_evaluacion_requerimientos($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$pre = date('Ymd').'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-03-portafolio-evaluacion-requerimientos.pdf';
			$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
			//echo '<pre>'.print_r($data);exit;
			$this->default_pdf_params['margin_left'] = 0;
			$this->default_pdf_params['margin_right'] = 0;
			$this->default_pdf_params['margin_top'] = 40;
			$this->default_pdf_params['margin_bottom'] = 20;
			$this->default_pdf_params['orientation'] = 'P';
			$mpdf = $this->pdf->load($this->default_pdf_params);
			if(!es_produccion()){
				$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
			}
			$mpdf->showWatermarkText = true;
			$paginaHTML = $this->load->view('pdf/portafolio_evidencia/plan_evaluacion_requerimientos', $data, true);
			$mpdf->WriteHTML($paginaHTML);
			$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, 'I');
			$response['success'] = true;
			$response['msg'][] = 'se genero el pdf del plan evaluacion requerimientos';
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_resultados_evaluacion($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$pre = date('Ymd').'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-03-portafolio-resultados-evaluacion.pdf';
			$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
			//echo '<pre>'.print_r($data);exit;
			$this->default_pdf_params['margin_left'] = 0;
			$this->default_pdf_params['margin_right'] = 0;
			$this->default_pdf_params['margin_top'] = 40;
			$this->default_pdf_params['margin_bottom'] = 20;
			$this->default_pdf_params['orientation'] = 'P';
			$mpdf = $this->pdf->load($this->default_pdf_params);
			if(!es_produccion()){
				$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
			}
			$mpdf->showWatermarkText = true;
			$paginaHTML = $this->load->view('pdf/portafolio_evidencia/resultados_evaluacion', $data, true);
			$mpdf->WriteHTML($paginaHTML);
			$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, 'I');
			$response['success'] = true;
			$response['msg'][] = 'se genero el pdf del plan resultados evaluacion';
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_cierre_eva_to_entrega_certificado($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false, $output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-04-cierre_evaluacion_entrega_certificado.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 0;
				$this->default_pdf_params['margin_bottom'] = 0;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_cierre_entrega_evaluacion', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Cierre de evaluación Entrega de certificado)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_cedula_evaluacion($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false, $output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-04-cierre_evaluacion.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 0;
				$this->default_pdf_params['margin_bottom'] = 0;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_cedula_evaluacion', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Cierre de evaluación Entrega de certificado)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generando_pdf_completo($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$post = $this->input->post();
			//$documentos_alumno_evidencia = $this->DocsPDFModel->obtener_archivos_ec_alumno($id_usuario_alumno,$id_estandar_competencia);
			//nueva consulta de información de la evidencia de los candidatos
			$documentos_alumno_evidencia = $this->DocsPDFModel->obtener_archivos_ec_alumno_entregables($id_usuario_alumno,$id_estandar_competencia);
			$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
			$archivos_conjuntar = array();
			$archivos_conjuntar_ped_wm = array();
			$archivos_conjuntar[] = $post['docs_generados'][0];//portada a antes de la ficha de registro
			$archivos_conjuntar_ped_wm[] = $post['docs_generados_wm'][0]; //portada
			if(!es_produccion()){
				//ficha registro cargado al sistema por el admin/evaluador y se le pone la marca de agua del sistema
				$archivos_conjuntar[] = $this->poner_marca_agua_doc($data['usuario_has_expediente_ped'][0]->ruta_directorio,$data['usuario_has_expediente_ped'][0]->nombre);
			}else{
				//ficha registro cargado al sistema por el admin/evaluador
				$archivos_conjuntar[] = $data['usuario_has_expediente_ped'][0]->ruta_directorio.$data['usuario_has_expediente_ped'][0]->nombre;
			}
			$archivos_conjuntar[] = $post['docs_generados'][1];//evaluacion diagnostica
			$archivos_conjuntar[] = $post['docs_generados'][2];//acuse a plan de evaluacion
			$archivos_conjuntar[] = $this->generar_entregables_instrumento(
				$data['foto_firma']->ruta_directorio.$data['foto_firma']->nombre,
				$data['foto_firma_instructor']->ruta_directorio.$data['foto_firma_instructor']->nombre,
				$data['usuario_has_expediente_ped'][1]
			); //instrumentos de evaluación de competencia al sistema por el admin/evaluador
			//entregables candidato
			$archivos_entregables_modificados = $this->generar_entregables($documentos_alumno_evidencia);
			$archivos_conjuntar = array_merge($archivos_conjuntar,$archivos_entregables_modificados);
			$archivos_conjuntar_ped_wm = array_merge($archivos_conjuntar_ped_wm,$archivos_entregables_modificados);

			$archivos_conjuntar[] = $post['docs_generados'][3];//cierre hasta antes del certificado
			
			//certificado del conocer
			$certificado_conocer = $this->certificado_formato_ped(
				$data['foto_firma']->ruta_directorio.$data['foto_firma']->nombre,
				$data['usuario_alumno']->nombre.' '.$data['usuario_alumno']->apellido_p.' '.$data['usuario_alumno']->apellido_m,
				$data['usuario_has_expediente_ped'][2] //certificado conocer original
			);

			$archivos_conjuntar[] = $certificado_conocer;
			$archivos_conjuntar_ped_wm[] = $certificado_conocer;
			$constancia_dc3 = $this->constancia_dc3($data['usuario_has_ec']->id_usuario_has_estandar_competencia,true);
			$archivos_conjuntar_ped_wm[] = $constancia_dc3->ruta_directorio.$constancia_dc3->nombre;
			$archivos_conjuntar[] = 'assets/docs/final_ped.pdf';
			$archivos_conjuntar_ped_wm[] = 'assets/docs/final_ped.pdf';
			//conjuntamos los archivos generados previamente para el ped
			$mergePDF = new Merger();
			foreach ($archivos_conjuntar as $dg){
				log_message('error',$dg);
				$mergePDF->addFile(FCPATH.$dg);
			}

			$archivo_combinado = $mergePDF->merge();
			//var_dump($archivo_combinado);exit;
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-final-portafolio-evidencias.pdf';
			$directorio = $this->subdirectorio_peds_generados();
			subdirectorios_files($directorio);
			$isArchivo_generado = file_put_contents($directorio.$nombre_documento,$archivo_combinado);

			//conjuntamos los archivos generados para el ped de walmart
			$mergePDFPEDWM = new Merger();
			foreach($archivos_conjuntar_ped_wm as $dg){
				log_message('error',$dg);
				$mergePDFPEDWM->addFile(FCPATH.$dg);
			}
			
			$archivo_combinado_ped_wm = $mergePDFPEDWM->merge();
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento_wm = $pre.'-final-portafolio-evidencias-wm.pdf';
			$directorio = $this->subdirectorio_peds_generados();
			subdirectorios_files($directorio);
			$isArchivo_generado_wm = file_put_contents($directorio.$nombre_documento_wm,$archivo_combinado_ped_wm);

			if($isArchivo_generado){
				foreach ($archivos_conjuntar as $dg){
					if(strpos($dg,RUTA_PDF_TEMP) !== false && file_exists(FCPATH.$dg)){
						unlink(FCPATH.$dg);
					}
				}
				//almacenamos el archivo en la tabla de archivo y luego en la tabla de referencia de que se genero el PED
				$datos_doc['nombre'] = $nombre_documento;
				$datos_doc['ruta_directorio'] = $directorio;
				$datos_doc['fecha'] = date('Y-m-d H:i:s');
				$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
				$this->DocsPDFModel->actualizar_ped_generado($id_usuario_alumno,$id_estandar_competencia,$id_archivo);
				$response['success'] = true;
				$response['msg'][] = 'Se genero el Portafolio de evidencias del alumno correctamente';
				$response['data']['ped'] = $datos_doc;
			}else{
				$response['success'] = false;
				$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			}

			if($isArchivo_generado_wm){
				foreach ($archivos_conjuntar_ped_wm as $dg){
					if(strpos($dg,RUTA_PDF_TEMP) !== false && file_exists(FCPATH.$dg)){
						unlink(FCPATH.$dg);
					}
				}
				//almacenamos el archivo en la tabla de archivo y luego en la tabla de referencia de que se genero el PED
				$datos_doc['nombre'] = $nombre_documento_wm;
				$datos_doc['ruta_directorio'] = $directorio;
				$datos_doc['fecha'] = date('Y-m-d H:i:s');
				$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
				$this->DocsPDFModel->actualizar_ped_wm_generado($id_usuario_alumno,$id_estandar_competencia,$id_archivo);
				$response['success'] = true;
				$response['msg'][] = 'Se genero el Portafolio de evidencias del alumno correctamente';
				$response['data']['ped_wm'] = $datos_doc;
			}else{
				$response['success'] = false;
				$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			}

		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	/**
	 * apartado de funciones para generar el gafete de los candidatos que ya completaron su certificacion de la ec
	 */
	public function gafete_candidato($id_usuario_has_estandar_competencia){
		try{
			$pdf = new Fpdi();
			//leemos la plantilla para generar el GAFETE
			$pdf->setSourceFile(RUTA_PLANTILLA_GAFETE);
			
			$paginaActual = $pdf->importPage(1);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos la marca de agua para pruebas
			if(!es_produccion()) {
				//agregamos el texto
				$pdf->SetFont('Arial','',40);
				$pdf->SetTextColor(150, 150, 150);
				$pdf->SetXY(20, $paPlantilla[1] / 2);
				$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
			}

			$pdf->Output('I', 'GAFETE-'.$id_usuario_has_estandar_competencia);
			$pdf->cleanUp();
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			log_message('error','***** DocsPDFModel -> gafete_candidato');
			log_message('error',$ex->getMessage());
		}
		echo json_encode($response);exit;
	}

	public function gafete_candidato_sewm($id_usuario_has_estandar_competencia){
		try{
			//traemos los datos para poder generar la credencial y codigoqr
			$usuario_has_estandar_competencia = $this->UsuarioHasECModel->obtener_row($id_usuario_has_estandar_competencia);
			//validamos que ya se pueda emitir la credencial con una calificacion aprobatoria
			if((int)$usuario_has_estandar_competencia->id_cat_calibracion_desempeno < JUICIO_CALIFICADO){
				echo 'Candidato aun no calificado';exit;
			}
			$cat_calibracion_desempeno = $this->CatalogoModel->get_catalogo('cat_calibracion_desempeno',$usuario_has_estandar_competencia->id_cat_calibracion_desempeno);
			$datos_usuario = $this->UsuarioModel->obtener_data_usuario_id($usuario_has_estandar_competencia->id_usuario);
			$usuario = $this->UsuarioModel->obtener_usuario_by_id($usuario_has_estandar_competencia->id_usuario);
			$foto_perfil = $this->PerfilModel->foto_perfil($usuario_has_estandar_competencia->id_usuario);
			$datos_empresa = $this->PerfilModel->obtener_datos_empresa($usuario_has_estandar_competencia->id_usuario,true);
			if(isset($usuario->id_archivo_qr) && !is_null($usuario->id_archivo_qr)){
				$codigoQRCandidato = $this->ArchivoModel->obtener_archivo($usuario->id_archivo_qr);
			}else{
				//en caso de que no exista el codigo QR para el candidato se genera uno nuevo
				//el codigo qr es generico o general para el usuario ya que al escanear se manda a un perfil publico
				$qrGenerado = $this->generar_qr_usuario_candidato($usuario->usuario,$usuario->id_usuario);
				if($qrGenerado['success']){
					$codigoQRCandidato = $qrGenerado['data']['archivo_qr'];
				}
			}
			// var_dump($datos_usuario,$cat_calibracion_desempeno,$foto_perfil,$datos_empresa,$codigoQRCandidato);exit;
			$fecha_emision_certificado = date('Y-m-d',strtotime($usuario_has_estandar_competencia->fecha_emision_certificado));
			$fecha_fin_vigencia=date('Y-m-d', strtotime('+1 year', strtotime($fecha_emision_certificado)) );
			$vigencia = fechaBDToHtml($fecha_emision_certificado). ' al '.fechaBDToHtml($fecha_fin_vigencia);

			$pdf = new Fpdi();
			$mpdf = $this->pdf->load($this->default_pdf_params);
			//leemos la plantilla para generar el GAFETE
			$pdf->setSourceFile(RUTA_PLANTILLA_GAFETE_SEWM);
			
			$paginaActual = $pdf->importPage(1);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos la marca de agua para pruebas
			if(!es_produccion()) {
				//agregamos el texto
				$pdf->SetFont('Arial','',40);
				$pdf->SetTextColor(150, 150, 150);
				$pdf->SetXY(20, $paPlantilla[1] / 2);
				$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
			}

			//para los datos de la plantilla en la credencial
			if(es_yosoyliderwm()){
				//$pdf->AddFont('fontwm','',FCPATH.'assets/fonts/wm.TTF',true);
				//$pdf->SetFont('fontwm','B',9);
				$pdf->SetFont('Arial','B',11);
				$pdf->SetTextColor(255,255,255);
				$nombre = utf8_decode($datos_usuario->nombre.' '.$datos_usuario->apellido_p.' '.$datos_usuario->apellido_m);
				$titulo = utf8_decode($datos_empresa->cargo);
				$clasificacion = utf8_decode($cat_calibracion_desempeno->nombre);

				$pos = 5;
				//adding XY as well helped me, for some reaons without it again it wasn't entirely centered
				$pdf->SetXY(0, 105);
				//with SetX I use numbers instead of lMargin, and I also use half of the size I added as margin for the page when I did SetMargins
				$pdf->SetX(0);
				$pdf->Cell(160,$pos,$nombre,0,0,'R');
				$pdf->SetX(-46);
				$pos = $pos + 10;
				$pdf->Cell(-132,$pos,$titulo,0,0,'R');
				
				$pdf->SetTextColor(0,0,0);
				$pdf->SetX(-46);
				$pos = $pos + 10;
				$pdf->Cell(-132,$pos,$clasificacion,0,0,'R');
				
				//se agregan las palomitas conforme al desempeño
				$starPos = 155;
				for($i = 2; $i <= (int)$cat_calibracion_desempeno->id_cat_calibracion_desempeno; $i++){
					$pdf->Image(FCPATH.'assets/imgs/iconos/01_check.png',$starPos,121,4,4); //palomitas
					$starPos -= 5;
				}

				//foto de perfil
				$pdf->Image(FCPATH.$foto_perfil->ruta_directorio.$foto_perfil->nombre,200,40,25,30);

				//codigo qr del candidato
				$pdf->Image(FCPATH.$codigoQRCandidato->ruta_directorio.$codigoQRCandidato->nombre,190,78,45,45);

				//imagen de la empresa del candidato
				$pdf->Image(FCPATH.$datos_empresa->ruta_directorio_logo.$datos_empresa->nombre_archivo_logo,185,126,50,25);

				//vigencia
				$pdf->SetXY(200, 156);
				$pdf->Write(0, utf8_decode($vigencia));
			}

			$pdf->Output('I', 'GAFETE-SEWM-'.$id_usuario_has_estandar_competencia);
			$pdf->cleanUp();
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			log_message('error','***** DocsPDFModel -> gafete_candidato_sewm');
			log_message('error',$ex->getMessage());
		}
		echo 'Ocurrio un error en el proceso de generar la firma, intente más tarde';
	}

	public function constancia_dc3($id_usuario_has_estandar_competencia,$para_ped_wm = false){
		try{
			$this->load->model('EstandarCompetenciaModel');
			$this->load->model('EstandarCompetenciaGrupoModel');
			$this->load->model('PerfilModel');
			//apartado de los datos del candidato para la dc3
			
			//traemos los datos para poder generar la credencial y codigoqr
			$usuario_has_estandar_competencia = $this->UsuarioHasECModel->obtener_row($id_usuario_has_estandar_competencia);
			//validamos que ya se pueda emitir la credencial con una calificacion aprobatoria
			if((int)$usuario_has_estandar_competencia->id_cat_calibracion_desempeno < JUICIO_CALIFICADO){
				echo 'Candidato aun no calificado';exit;
			}

			//validamos si existe la dc3 de este usuario y el estandar de competencia
			if(isset($usuario_has_estandar_competencia->id_archivo_dc3) && !is_null($usuario_has_estandar_competencia->id_archivo_dc3)){
				$constanciaDC3 = $this->ArchivoModel->obtener_archivo($usuario_has_estandar_competencia->id_archivo_dc3);
				if($para_ped_wm){
					return $constanciaDC3;
				}else{
					redirect(base_url().$constanciaDC3->ruta_directorio.$constanciaDC3->nombre);
				}
			}else{
				$datos_usuario = $this->UsuarioModel->obtener_data_usuario_id($usuario_has_estandar_competencia->id_usuario);
				$datos_instructor = $this->UsuarioModel->obtener_data_usuario_id($usuario_has_estandar_competencia->id_usuario_evaluador);
				$firma_instructor = $this->PerfilModel->obtener_datos_expediente($usuario_has_estandar_competencia->id_usuario_evaluador,EXPEDIENTE_FIRMA_DIGITAL);
				$datos_empresa = $this->PerfilModel->obtener_datos_empresa($usuario_has_estandar_competencia->id_usuario,true);
				$cat_ocupacion_especifica = $this->CatalogoModel->get_catalogo('cat_ocupacion_especifica',$datos_usuario->id_cat_ocupacion_especifica);
				$estandar_competencia = $this->EstandarCompetenciaModel->obtener_row($usuario_has_estandar_competencia->id_estandar_competencia);
				$estandar_competencia_grupo = $this->EstandarCompetenciaGrupoModel->obtener_row($usuario_has_estandar_competencia->id_estandar_competencia_grupo);
				$cat_area_tematica = $this->CatalogoModel->get_catalogo('cat_area_tematica',$estandar_competencia_grupo->id_cat_area_tematica);
				
				$pdf = new Fpdi();
				$mpdf = $this->pdf->load($this->default_pdf_params);
				//leemos la plantilla para generar el GAFETE
				$pdf->setSourceFile(RUTA_PLANTILLA_CONSTANCIA_DC3);
				
				$paginaActual = $pdf->importPage(1);
				$paPlantilla = $pdf->getTemplatesize($paginaActual);
				$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
				$pdf->useImportedPage($paginaActual);
				//agregamos la marca de agua para pruebas
				if(!es_produccion()) {
					//agregamos el texto
					$pdf->SetFont('Arial','',40);
					$pdf->SetTextColor(150, 150, 150);
					$pdf->SetXY(20, $paPlantilla[1] / 2);
					$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
				}

				//agregamos los logotipos de la constancia
				//imagen de la empresa del candidato
				$pdf->Image(FCPATH.$datos_empresa->ruta_directorio_logo.$datos_empresa->nombre_archivo_logo,10,5,60,20);
				//logotipo civika
				$pdf->Image(FCPATH.RUTA_LOGO_CIVIKA_PDF,145,5,60,20);

				//nombre del trabajador
				$pdf->SetFont('Arial','B',10);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetXY(10,64);
				$pdf->Write(0,utf8_decode($datos_usuario->apellido_p.' '.$datos_usuario->apellido_m.' '.$datos_usuario->nombre));
				//curp
				$curp = str_split($datos_usuario->curp);
				$posXCurp = [10,15.5,21.5,27, 33,38.5,44,49, 55,60,65.5,71.4, 76.6,82,88,93.5, 99,105];
				foreach($curp as $index => $letra_curp){
					$pdf->SetXY($posXCurp[$index],76);
					$pdf->Write(0,utf8_decode($letra_curp));
				}
				//ocupacion especifica
				$pdf->SetXY(110.5,76);
				$pdf->Write(0,utf8_decode($cat_ocupacion_especifica->clave_area_subarea.' - '. $cat_ocupacion_especifica->denominacion));
				//puesto
				$pdf->SetXY(10,85);
				$pdf->Write(0,utf8_decode($datos_empresa->cargo));
				
				//nombre de la empresa
				$pdf->SetXY(10,106);
				$pdf->Write(0,utf8_decode($datos_empresa->nombre));
				//rfc empresa
				$rfc_empresa = str_split($datos_empresa->rfc);
				if(sizeof($rfc_empresa) == 12){
					$posXRfc = [15,20.5,26.2, 37,42.5,48,53,59,64, 75,80,86 ];
				}else{
					$posXRfc = [10,15,20.5,26.2, 37,42.5,48,53,59,64, 75,80,86 ];
				}
				foreach($rfc_empresa as $index => $letra_rfc){
					$pdf->SetXY($posXRfc[$index],117.5);
					$pdf->Write(0,utf8_decode($letra_rfc));
				}

				//estandar de competencia
				$pdf->SetXY(10,137);
				$pdf->Write(0,utf8_decode($estandar_competencia->codigo.' - '.$estandar_competencia->titulo));
				//duracion en horas
				$pdf->SetXY(10,148);
				$pdf->Write(0,utf8_decode($estandar_competencia_grupo->duracion));
				//periodo de ejecucion
				$periodo_ejecucion = str_split(str_replace('-','',$estandar_competencia_grupo->periodo_inicio.$estandar_competencia_grupo->periodo_fin));
				$posXPeriodo = [91.5,98,105,112, 119,126, 133,140, 153,160,167,174, 181,188, 195,201.5 ];
				foreach($periodo_ejecucion as $index => $letra_periodo){
					$pdf->SetXY($posXPeriodo[$index],148);
					$pdf->Write(0,$letra_periodo);
				}

				//area tematica
				$pdf->SetXY(10,158.5);
				$pdf->Write(0,utf8_decode($cat_area_tematica->clave.' - '.$cat_area_tematica->area_tematica));
				//agente capacitador
				$pdf->SetXY(10,169);
				$pdf->Write(0,utf8_decode($estandar_competencia_grupo->agente_capacitador));

				//nombre y firma instructor
				$pdf->SetXY(15,207);
				$pdf->Write(0,utf8_decode($datos_instructor->apellido_p.' '.$datos_instructor->apellido_m.' '.$datos_instructor->nombre));
				$pdf->Image(FCPATH.$firma_instructor->ruta_directorio.$firma_instructor->nombre,25,185,35,18);

				//sello
				$pdf->Image(FCPATH.RUTA_SELLO_CIVIKA_PDF,62,185);

				//representante legal
				$pdf->SetXY(82,207);
				$pdf->Write(0,utf8_decode($datos_empresa->representante_legal));
				//representante de trabajadores
				$pdf->SetXY(147,207);
				$pdf->Write(0,utf8_decode($datos_empresa->representante_trabajadores));

				//el QR para la constancia dc3
				if(isset($usuario_has_estandar_competencia->id_archivo_dc3) && !is_null($usuario_has_estandar_competencia->id_archivo_dc3)){
					$codigoQRDC3 = $this->ArchivoModel->obtener_archivo($usuario_has_estandar_competencia->id_archivo_dc3);
				}else{
					//en caso de que no exista el codigo QR para el candidato se genera uno nuevo
					//el codigo qr es generico o general para el usuario ya que al escanear se manda a un perfil publico
					$qrGenerado = $this->generar_qr_dc3_usuario_candidato($id_usuario_has_estandar_competencia);
					if($qrGenerado['success']){
						$codigoQRDC3 = $qrGenerado['data']['archivo_qr'];
					}
				}

				$pdf->SetFont('Arial','B',6);
				$pdf->SetXY(184,249);
				$folio = 'Folio: '.str_replace('.png','',$codigoQRDC3->nombre);
				$pdf->Write(0,utf8_decode($folio));
				$pdf->Image(FCPATH.$codigoQRDC3->ruta_directorio.$codigoQRDC3->nombre,184,222,24,24);

				$directorio = RUTA_PDF_PED.date('Y').'/'.date('m').'/'.date('d').'/';
				subdirectorios_files($directorio);
				$datos_doc['nombre'] = 'CONSTANCIA-DC3-'.str_replace('.png','',$codigoQRDC3->nombre);
				$datos_doc['ruta_directorio'] = $directorio;
				$datos_doc['fecha'] = date('Y-m-d H:i:s');
				
				$pdf->Output('F', FCPATH.$datos_doc['ruta_directorio'].$datos_doc['nombre']);
				$pdf->cleanUp();

				$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
				$this->UsuarioHasECModel->guardar_row(array('id_archivo_dc3' => $id_archivo),$id_usuario_has_estandar_competencia);
				if($para_ped_wm){
					return $this->ArchivoModel->obtener_archivo($id_archivo);
				}else{
					redirect(base_url().$datos_doc['ruta_directorio'].$datos_doc['nombre']);
					echo 'Se genero la constancia DC3 correctamente';	
				}
			}
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> certificado_dc3');
			log_message('error',$ex->getMessage());
			log_message('error',$ex->getFile().' - '.$ex->getLine());
			echo 'Ocurrio un error en el proceso de generar la constancia DC3- favor de intentar mas tarde';
		}
	}

	protected function set_variables_defaults_pdf()
	{
		$configVariablrs =new ConfigVariables();
		$fontVariables = new FontVariables();
		$default_config = $configVariablrs->getDefaults();

		$default_font_config = $fontVariables->getDefaults();
		$font_dirs = $default_config['fontDir'];
		$font_data = $default_font_config['fontdata'];
		$this->default_pdf_params = array(
			'format' => 'Letter',
			'default_font_size' => '12',
			'default_font' => 'Arial',
			'margin_left' => 10,
			'margin_right' => 10,
			'margin_top' => 5,
			'margin_bottom' => 13,
			'orientation' => 'P',
			'fontDir' => array_merge($font_dirs, array(FCPATH . 'assets/fonts')),
			'fontdata' => $font_data + array(
					"nueva_fuente_modern" => array(
						'R' => "modern_led_board-7.ttf",
						'B' => "modern_led_board-7.ttf",
						'I' => "modern_led_board-7.ttf",
						'BI' => "modern_led_board-7.ttf",
					),

					"nueva_fuente_zillmo" => array(
						'R' => "ZILLMOO_.ttf",
						'B' => "ZILLMOO_.ttf",
						'I' => "ZILLMOO_.ttf",
						'BI' => "ZILLMOO_.ttf",
					),

					"nueva_fuente_bau" => array(
						'R' => "BauhausStd-Medium.ttf",
						'B' => "BauhausStd-Medium.ttf",
						'I' => "BauhausStd-Medium.ttf",
						'BI' => "BauhausStd-Medium.ttf",
					),

					"nuefa_fuente_wm" => array(
						'R' => "wm.TTF",
						'B' => "wm.TTF",
						'I' => "wm.TTF",
						'BI' => "wm.TTF",
					)
				)
		);
	}

	protected function subdirectorio_peds_generados(){
		return RUTA_PDF_PED.date('Y').'/'.date('m').'/'.date('d').'/';
	}

	protected function generar_entregables_instrumento($firma_candidato,$firma_evaluador,$instrumento){
		try{
			$pdf = new Fpdi();
			//leemos el entregable cargado por el candidato
			$paginasPDF = $pdf->setSourceFile($instrumento->ruta_directorio.$instrumento->nombre);
			for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
				$paginaActual = $pdf->importPage($pagina);
				$paPlantilla = $pdf->getTemplatesize($paginaActual);
				$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
				$pdf->useImportedPage($paginaActual);
				//agregamos la marca de agua para pruebas
				if(!es_produccion()) {
					//agregamos el texto
					$pdf->SetFont('Arial','',40);
					$pdf->SetTextColor(150, 150, 150);
					$pdf->SetXY(20, $paPlantilla[1] / 2);
					$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
				}
				$pdf->Image(FCPATH.$firma_evaluador,50,240,25,20);
				$pdf->Image(FCPATH.$firma_candidato,150,240,25,20);
			}

			$pdf->Output('F', RUTA_PDF_TEMP.$instrumento->nombre);
			$pdf->cleanUp();
			return RUTA_PDF_TEMP.$instrumento->nombre;
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> generar_entregables_instrumento');
			log_message('error',$ex->getMessage());
		}
		return false;
	}

	protected function generar_entregables($entregables){
		try{
			$archivos_modificados = array();
			if(es_produccion()) {
				foreach ($entregables as $e){
					//Para saber si es una url de video o es una imagen

					//se agrega el try catch para poder generar los pdf del ped completo
					try{
						//en caso de que se pueda generar el archivo del pdf, la imagen o el video de evidencia
						if(!is_null($e->url_video) && $e->url_video != ''){
							//es un video
							$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,false);
							$archivos_modificados[] = $archivos_modificado['ruta_directorio'].$archivos_modificado['nombre'];
						}else{
							if(!strpos(strMinusculas($e->nombre),'.pdf')){
								//es una imagen
								$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,true);
								$archivos_modificados[] = $archivos_modificado['ruta_directorio'].$archivos_modificado['nombre'];
							}if(strpos(strMinusculas($e->nombre),'.pdf')){
								//es un pdf
								$archivos_modificados[] = $e->ruta_directorio.$e->nombre;
							}
						}
					}catch(Exception $exception){
						//como no fue posible generar el pdf por la herramienta permitida entonces generamos un pdf con el link nadamas y la leyenda correspondiente
						$archivos_modificado[] = $this->generar_evidencia_pdf_img_video($e,false,true); //REUTILIZAMOS LA FUNCION para generar el pdf
					}
				}
			}else{
				//el else es para unicamente ponerle la marca de agua a los entregables del alumno
				foreach ($entregables as $e){
					
					//se agrega el try catch para poder generar los pdf del ped completo
					try{
						if(!is_null($e->url_video) && $e->url_video != ''){
							//es un video
							$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,false);
							$archivos_modificados[] = $this->poner_marca_agua_doc($archivos_modificado['ruta_directorio'],$archivos_modificado['nombre']);
						}else{
							if(!strpos(strMinusculas($e->nombre),'.pdf')){
								//es una imagen
								$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,true);
								$archivos_modificados[] = $this->poner_marca_agua_doc($archivos_modificado['ruta_directorio'],$archivos_modificado['nombre']);
							}if(strpos(strMinusculas($e->nombre),'.pdf')){
								//es un pdf
								$archivos_modificados[] = $this->poner_marca_agua_doc($e->ruta_directorio,$e->nombre);
							}
						}
					}catch(Exception $exception){
						//como no fue posible generar el pdf por la herramienta permitida entonces generamos un pdf con el link nadamas y la leyenda correspondiente
						$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,false,true); //REUTILIZAMOS LA FUNCION para generar el pdf
						$archivos_modificados[] = $this->poner_marca_agua_doc($archivos_modificado['ruta_directorio'],$archivos_modificado['nombre']);
					}
				}
			}
			return $archivos_modificados;
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> generar_entregables');
			log_message('error',$ex->getMessage());
			log_message('error',$ex->getLine());
			log_message('error',$ex->getFile());
			return array();
		}
	}

	protected function poner_marca_agua_doc($ruta_documento,$nombre_documento){
		$pdf = new Fpdi();
		//leemos el entregable cargado por el candidato
		$paginasPDF = $pdf->setSourceFile($ruta_documento.$nombre_documento);
		for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
			$paginaActual = $pdf->importPage($pagina);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos la marca de agua para pruebas
			$pdf->SetFont('Arial','',40);
			$pdf->SetTextColor(150, 150, 150);
			$pdf->SetXY(20, $paPlantilla[1] / 2);
			$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
		}

		$pdf->Output('F', RUTA_PDF_TEMP.$nombre_documento);
		$pdf->cleanUp();
		return RUTA_PDF_TEMP.$nombre_documento;
	}

	protected function certificado_formato_ped($firma_candidato,$nombre_candidato,$entregable){
		$pdf = new Fpdi();
		//leemos el entregable cargado por el candidato
		$paginasPDF = $pdf->setSourceFile(FCPATH.$entregable->ruta_directorio.$entregable->nombre);
		for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
			$paginaActual = $pdf->importPage($pagina);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos el texto
			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(255, 0, 0);
			$pdf->SetXY(135, 120);$pdf->Write(0, utf8_decode('RECIBI CERTIFICADO DIGITAL'));
			$pdf->SetXY(135, 125);$pdf->Write(0, utf8_decode($nombre_candidato));
			$pdf->SetXY(135, 130);$pdf->Write(0, utf8_decode(fechaBDToHtml($entregable->fecha)));
			//agregamos la marca de agua para pruebas
			if(!es_produccion()) {
				//agregamos el texto
				$pdf->SetFont('Arial','',40);
				$pdf->SetTextColor(150, 150, 150);
				$pdf->SetXY(20, $paPlantilla[1] / 2);
				$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
			}
			$pdf->Image(FCPATH.$firma_candidato,150,95,25,20);
		}

		$pdf->Output('F', RUTA_PDF_TEMP.$entregable->nombre);
		return RUTA_PDF_TEMP.$entregable->nombre;
	}

	protected function generar_evidencia_pdf_img_video($entregable,$esImg,$es_pdf_protegido = false){
		try{
			$pre = date('Ymd').'-';
			$nombre_documento = $pre.uniqid().'.pdf';
			$archivo_generado = RUTA_PDF_TEMP.$nombre_documento;
			$retorno = array('ruta_directorio' => RUTA_PDF_TEMP, 'nombre' =>$nombre_documento);
			if(!file_exists($archivo_generado)){
				subdirectorios_files(RUTA_PDF_TEMP);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 10;
				$this->default_pdf_params['margin_right'] = 10;
				$this->default_pdf_params['margin_top'] = 15;
				$this->default_pdf_params['margin_bottom'] = 15;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$data['es_evidencia_imagen'] = $esImg;
				$data['es_evidencia_video'] = !$esImg;
				$data['es_pdf_protegido'] = $es_pdf_protegido;
				$data['evidencia'] = $entregable;
				$paginaHTML = $this->load->view('pdf/evidencia_imagen_video', $data, true);
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, 'F');
			}
			return $retorno;
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> generar_evidencia_pdf_img_video');
			log_message('error',$ex->getMessage());
		}
		return false;
	}

	protected function generar_qr_usuario_candidato($strUsuario,$idUsuario){
		try{
			$response['success'] = true;
			$response['msg'][] = 'Se genero el QR correctamente';
			$stringToQR = base_url().'candidato/certificacion/'.$strUsuario;
			//var_dump('aqui toy');exit;
			$this->load->library('ciqrcode');
			$directorio = RUTA_QR_FILES_PERFIL.date('Y').'/'.date('m').'/'.date('d').'/';
			subdirectorios_files($directorio);
			$qr_image = $strUsuario.'.png';
			$params['data'] = $stringToQR;
			$params['level'] = 'l';
			$params['size'] = 300;
			$params['savename'] = FCPATH.$directorio.$qr_image;
			if(!file_exists($params['savename'])){
				$this->ciqrcode->generate($params);
			}
			//guardamo el archivo generado y lo almacenamos en la tabla de archivo
			$datos_doc['nombre'] = $qr_image;
			$datos_doc['ruta_directorio'] = $directorio;
			$datos_doc['fecha'] = date('Y-m-d H:i:s');
			$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
			$this->UsuarioModel->guardar_row(array('id_archivo_qr' => $id_archivo),$idUsuario);
			$archivoQr = new stdClass();
			$archivoQr->id_archivo = $id_archivo;
			$archivoQr->nombre = $qr_image;
			$archivoQr->ruta_directorio = $directorio;
			$archivoQr->fecha = $datos_doc['fecha'];
			$response['data']['archivo_qr'] = $archivoQr;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			log_message('error','***** DocsPDFModel -> generar_qr_usuario_candidato');
			log_message('error',$ex->getMessage());
		}
		return $response;
	}

	protected function generar_qr_dc3_usuario_candidato($id_usuario_has_estandar_competencia){
		try{
			$response['success'] = true;
			$response['msg'][] = 'Se genero el QR correctamente';
			$stringToQR = base_url().'constancia_dc3/'.$id_usuario_has_estandar_competencia;
			//var_dump('aqui toy');exit;
			$this->load->library('ciqrcode');
			$directorio = RUTA_QR_FILES_PERFIL.date('Y').'/'.date('m').'/'.date('d').'/';
			subdirectorios_files($directorio);
			$qr_image = date('Ymd').'-'.$id_usuario_has_estandar_competencia.'.png';
			$params['data'] = $stringToQR;
			$params['level'] = 'l';
			$params['size'] = 300;
			$params['savename'] = FCPATH.$directorio.$qr_image;
			if(!file_exists($params['savename'])){
				$this->ciqrcode->generate($params);
			}
			//guardamo el archivo generado y lo almacenamos en la tabla de archivo
			$datos_doc['nombre'] = $qr_image;
			$datos_doc['ruta_directorio'] = $directorio;
			$datos_doc['fecha'] = date('Y-m-d H:i:s');
			$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
			$this->UsuarioHasECModel->guardar_row(array('id_archivo_dc3_qr' => $id_archivo),$id_usuario_has_estandar_competencia);
			$archivoQr = new stdClass();
			$archivoQr->id_archivo = $id_archivo;
			$archivoQr->nombre = $qr_image;
			$archivoQr->ruta_directorio = $directorio;
			$archivoQr->fecha = $datos_doc['fecha'];
			$response['data']['archivo_qr'] = $archivoQr;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			log_message('error','***** DocsPDFModel -> generar_qr_usuario_candidato');
			log_message('error',$ex->getMessage());
		}
		return $response;
	}
}
