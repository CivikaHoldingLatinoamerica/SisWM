$(document).ready(function (){

	$(document).on('click','#btn_buscar_datos_empresa',function(){
		DatosEmpresa.tablero();
	});

	//funcionalidad para el paginado por scroll
	$(window).scroll(function(){
		//validamos lo del scroll
		var pagina_select = $('#paginacion_usuario').val();
		var max_paginacion = $('#paginacion_usuario').data('max_paginacion');
		if(pagina_select < max_paginacion){
			var scroll_pos = Math.round($(window).scrollTop()) + 1;
			var scroll_length = Math.round($(document).height() - $(window).height())-1;
			if(scroll_pos >= scroll_length){
				pagina_select++;
				DatosEmpresa.tablero(false,pagina_select);
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});

});

var DatosEmpresa = {

	tablero : function(inicial = true,pagina = 1, registros = 10){
		var post = {
			busqueda : $('#input_buscar_datos_empresa').val()
		};
		//condicional para el scroll de obtener los registros :-D
		if(inicial){
			$('#contenedor_resultados_datos_empresa').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Catalogos/datos_empresa_resultado_tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_datos_empresa').html(response);
					Comun.tooltips();
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'Catalogos/datos_empresa_resultado_tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_datos_empresa').append(response);
					Comun.tooltips();
					$('#overlay_full_page').fadeOut();
				}
			);
		}
	},

};
