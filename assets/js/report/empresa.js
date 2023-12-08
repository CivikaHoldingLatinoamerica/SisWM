$(document).ready(function() {

	$('#btn_buscar_reporte_empresa').click(function(){
		Reportes.buscar_reporte_empresa();
	});

	$(document).on('click','#btn_empresa_excel',function(){
		Reportes.descargar_excel_empresa();
	});

	// $('#btn_empresa_excel').click(function(){
	// 	Reportes.descargar_excel_empresa();
	// });
	

	Reportes.iniciar_tablero_empresa();

});

var Reportes = {

	iniciar_tablero_empresa : function(){
		$('#btn_buscar_reporte_empresa').trigger('click');
	},

	buscar_reporte_empresa : function(){
		var params_busqueda = $('#input_buscar_reporte_empresa').val();
		$('#contenedor_resultados_reporte_empresa').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Reportes/tablero_empresa?params='+params_busqueda ,{},
			function(response){
				$('#contenedor_resultados_reporte_empresa').html(response);
				
			}
		);
	},

	descargar_excel_empresa : function(){
		var params_busqueda = $('#input_buscar_reporte_empresa').val();
		window.open(base_url+'reportes/empresa/descargar?tipo_reporte=excel&params='+params_busqueda,'_blank');
	},

};
