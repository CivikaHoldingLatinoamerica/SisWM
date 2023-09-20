$(document).ready(function(){

	ConvocatoriasPublicas.tablero();

});

var ConvocatoriasPublicas = {

	tablero : function(inicial = true,pagina = 1, registros = 5){
		var post = {
			id_estandar_competencia : $('#id_estandar_competencia').val()
		};
		//condicional para el scroll de obtener los registros :-D
		if(inicial){
			$('#contenedor_resultados_convocatoria_ec').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Publico/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_convocatoria_ec').html(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'Publico/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_convocatoria_ec').append(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
					$('#overlay_full_page').fadeOut();
				}
			);
		}
	},

}
