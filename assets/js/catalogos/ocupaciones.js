$(document).ready(function (){

	$(document).on('click','#btn_nuevo_ocupacion',function(){
		CatOcupacionEspecifica.agregarModificar();
	});
	$(document).on('click','.modificar_ocupacion',function(){
		var id = $(this).data('id');
		CatOcupacionEspecifica.agregarModificar(id);
	});

	$(document).on('click','#btn_guardar_form_ocupacion',function(e){
		e.preventDefault();
		CatOcupacionEspecifica.guardar_ocupacion();
	});
});

var CatOcupacionEspecifica = {

	agregarModificar : function(btn_lnk){
		var post = {
			tipo_ocupacion_especifica : btn_lnk.data('tipo_ocupacion_especifica')
		};
		if(btn_lnk.data('id_cat_ocupacion_especifica') != undefined && btn_lnk.data('id_cat_ocupacion_especifica') != ''){
			post['id_cat_ocupacion_especifica'] = btn_lnk.data('id_cat_ocupacion_especifica');
		}
		Comun.obtener_contenido_peticion_html(
			base_url + 'EC/tablero/' + pagina + '/' + registros,
			post,
			function(response){
				$('#contenedor_resultados_estandar_competencia').html(response);
				Comun.tooltips();
				$('.popoverShowHTML').trigger('click');
			}
		);
		
	},

	guardar_ocupacion : function (){
		Comun.enviar_formulario_post(
			'#form_agregar_modificar_ocupacion',
			base_url + 'Catalogos/guardar_ocupacion/',
			function(response){
				if(response.success){
					Comun.mostrar_ocultar_modal('#modal_form_ocupacion',false);
					Comun.mensajes_operacion(response.msg,'success');
					Comun.recargar_pagina(base_url + 'catalogos/sectores',2000);
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	},
	
};
