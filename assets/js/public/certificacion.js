$(document).ready(function(){
	
	$(document).on('click','.ver_detalle_certificacion_candidato',function(){
		var id_usuario_has_estandar_competencia = $(this).data('id_usuario_has_estandar_competencia');
		Certificacion.ver_detalle(id_usuario_has_estandar_competencia);
	});

});

var Certificacion = {

	ver_detalle : function(id_usuario_has_estandar_competencia){
		Comun.obtener_contenido_peticion_html(base_url + 'Publico/ver_detalle_certificacion/'+id_usuario_has_estandar_competencia,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_proceso_certificacion_ec_candidato',true);
		});
	}

}
