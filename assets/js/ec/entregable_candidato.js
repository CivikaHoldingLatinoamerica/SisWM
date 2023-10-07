$(document).ready(function (){
	$(document).on('click', '.evidencia-card', function () {
		console.log("hola")
		Comun.mostrar_ocultar_modal('#modal_form_entregable_candidato', true);
	});
});
