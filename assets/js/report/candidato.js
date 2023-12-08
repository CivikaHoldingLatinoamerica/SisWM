$(document).ready(function() {

	$('#btn_buscar_reporte_candidato').click(function(){
		ReporteCandidato.buscar_reporte();
	});

	$(document).on('click','#btn_candidato_excel',function(){
		ReporteCandidato.descargar_excel();
	});
	

	ReporteCandidato.iniciar_tablero();

});

var ReporteCandidato = {

	iniciar_tablero : function(){
		$('#btn_buscar_reporte_candidato').trigger('click');
	},

	buscar_reporte : function(){
		var params_busqueda = $('#input_buscar_reporte_candidato').val();
		$('#contenedor_resultados_reporte_candidato').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Reportes/tablero_candidato?params='+params_busqueda ,{},
			function(response){
				$('#contenedor_resultados_reporte_candidato').html(response);
				
			}
		);
	},

	descargar_excel : function(){
		var params_busqueda = $('#input_buscar_reporte_candidato').val();
		window.open(base_url+'reportes/candidato/descargar?tipo_reporte=excel&params='+params_busqueda,'_blank');
	},

};
