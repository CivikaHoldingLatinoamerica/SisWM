<?php
$data['extra_css_pdf'] = array(
	base_url().'assets/css/pdf/portafolio_evidencia.css'
);
$this->load->view('pdf/header',$data);
?>

<?php $this->load->view('pdf/portafolio_evidencia/0-1-portada'); ?>
<!-- SE QUITO LA FICHA DE REGISTRO DADO QUE NO ES UN PDF QUE SE GENERER VIA SISTEMA
SE CARGA COMO UN PDF EXTERNO QUE SE SE GENERO EN EL CONOCER -->

<?php $this->load->view('pdf/footer')?>
