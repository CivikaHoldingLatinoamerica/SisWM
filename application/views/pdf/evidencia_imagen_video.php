<?php
$data['extra_css_pdf'] = array(
		base_url() . 'assets/css/pdf/portafolio_evidencia.css'
);
$this->load->view('pdf/header', $data);
?>

<?php if ($es_evidencia_imagen && !$es_pdf_protegido): ?>
	<strong>Evidencia del candidato en imagen</strong>
	<br>
	<img src="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>" style="width: 100%; height: auto">
<?php endif; ?>

<?php if($es_evidencia_video && !$es_pdf_protegido): ?>
	<strong>Evidencia del candidato en link de video</strong>
	<br>
	<strong><a href="<?=$evidencia->url_video?>"><?=$evidencia->url_video?></a></strong>
<?php endif; ?>

<?php if($es_pdf_protegido): ?>
	<strong>El link del PDF adjunto, se genero de forma protegida o con herramientas de version superior a los soportados por el sistema; se entrega como link en este PDF</strong>
	<br>
	<strong><a href="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>"><?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?></a></strong>
<?php endif; ?>

<?php $this->load->view('pdf/footer') ?>
