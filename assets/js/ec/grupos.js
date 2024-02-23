$(document).ready(function () {

	$(document).on('click','#btn_buscar_estandar_competencia_grupo',function(){
		ECGrupo.tablero();
	});

	$(document).on('click','#btn_agregar_ec_grupo',function(){
		ECGrupo.agregar_modificar();
	});

	$(document).on('click','#btn_guardar_ec_grupo',function(){
		var id_estandar_competencia_grupo = $(this).data('id_estandar_competencia_grupo');
		ECGrupo.guardar(id_estandar_competencia_grupo);
	});

	$(document).on('click','.modificar_ec_grupo',function(){
		var id_estandar_competencia_grupo = $(this).data('id_estandar_competencia_grupo');
		ECGrupo.agregar_modificar(id_estandar_competencia_grupo);
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
				ECGrupo.tablero(false,pagina_select);
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});

	

});

var ECGrupo = {

	tablero : function(inicial = true,pagina = 1, registros = 5){
		var id_estandar_competencia = $('#input_id_estandar_competencia').val();
		var post = {
			busqueda : $('#input_buscar_ec_grupo').val()
		};
		//condicional para el scroll de obtener los registros :-D
		if(inicial){
			$('#contenedor_resultados_ec_grupo').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'ECGrupos/tablero/' + id_estandar_competencia + '/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_ec_grupo').html(response);
					Comun.tooltips();
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'ECGrupos/tablero/' + id_estandar_competencia + '/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_ec_grupo').append(response);
					Comun.tooltips();
					$('#overlay_full_page').fadeOut();
				}
			);
		}
	},

	agregar_modificar : function(id_estandar_competencia_grupo = ''){
		var id_estandar_competencia = $('#input_id_estandar_competencia').val();
		Comun.obtener_contenido_peticion_html(base_url + 'ECGrupos/agregar_modificar/'+id_estandar_competencia + '/' + id_estandar_competencia_grupo,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_grupo_ec',true);
		});
	},

	validar_form_ec_grupo : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_ec_grupo',Comun.reglas_validacion_form());
		if(form_valido){
			
		}
		return form_valido;
	},

	guardar : function(id_estandar_competencia_grupo = ''){
		if(ECGrupo.validar_form_ec_grupo()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_ec_grupo',
				base_url + 'ECGrupos/guardar_form/' + id_estandar_competencia_grupo,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_grupo_ec',false);
						Comun.mensajes_operacion(response.msg,'success');
						ECGrupo.tablero();
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

}
