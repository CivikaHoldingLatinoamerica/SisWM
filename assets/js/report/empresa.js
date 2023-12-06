$(document).ready(function() {

	$('#btn_buscar_reporte_empresa').click(function(){
		ReporteEmpresa.buscar_reporte();
	});

});

var ReporteEmpresa = {

	buscar_reporte : function(){
		Comun.obtener_contenido_peticion_html(
			base_url + 'Reportes/tablero_empresa' ,{},
			function(response){
				$('#contenedor_resultados_reporte_empresa').html(response);
			}
		);
	}

};
