

var data = [
	{
		id_entregable : 1,
		nombre:'Entregable1',
		tipo_entregable: 'prod',
		instrumentos:[
			'La carta descriptiva elaborada',
			'La carta descriptiva elaborada',
			'La carta descriptiva elaborada'
		]
	}
];

$(document).ready(function (){

	methods.buscarEntregables();

	$(document).on('click','#btn_nuevo_entregable',function(){
		methods.agregarModificar();
	});
	$(document).on('click','.modificar_entregable',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		methods.agregarModificar(id);
	});

	$(document).on('click','#btn_buscar_entregables',function(){
		methods.buscarEntregables();
	});

	$(document).on('click','#btn_guardar_form_entregable',function(e){
		e.preventDefault();
		methods.guardar_entregable();
	});

	$(window).scroll(function(){
		//validamos lo del scroll
		var pagina_select = $('#paginacion_usuario').val();
		var max_paginacion = $('#paginacion_usuario').data('max_paginacion');
		if(pagina_select < max_paginacion){
			if(Math.round($(window).scrollTop()) == Math.round($(document).height() - $(window).height())){
				pagina_select++;
				CatSector.buscarSectores(pagina_select);
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});
});

var methods = {
	agregarModificar : function(id = 0){
		console.log(id);
		if (id !== 0){
			$('#contenedor_modal_sector').empty();
			Comun.obtener_contenido_peticion_html('obtener_sector/'+id,{},function (response) {
				$('#contenedor_modal_sector').append(response);
				Comun.mostrar_ocultar_modal('#modal_form_entregable',true);
				Comun.funcion_fileinput('#material_apoyo','Archivo de apoyo');
				methods.iniciar_carga_material_apoyo();
			})
		}else{
			Comun.mostrar_ocultar_modal('#modal_form_entregable',true);
		}

	},

	guardar_entregable : function (){
		Comun.enviar_formulario_post(
			'#form_agregar_modificar_entregable',
			base_url + 'Entregable/guardar_entregable/',
			function(response){
				if(response.success){
					data.push(response.data)
					Comun.mostrar_ocultar_modal('#modal_form_entregable',false);
					Comun.mensajes_operacion(response.msg,'success');
					// Comun.recargar_pagina(base_url + 'evidencias_esperadas/1',2000);
					methods.buscarEntregables();
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	},
	buscarEntregables : function (pagina = 1, registros = 10){
		$('#contenedor_entregables').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url +'Entregable/obtener_entregables/'+pagina+'/'+registros,{data},
			function(response){
				$('#contenedor_entregables').html(response);
			},
		);
	},
	iniciar_carga_material_apoyo : function(){
		Comun.iniciar_carga_imagen('#material_apoyo','#procesando_material_apoyo',function(archivo){
			$('#input_material_apoyo').val(archivo.id_archivo);
			var html_img = '<img src="'+base_url + archivo.ruta_directorio + archivo.nombre+'" style="max-width: 120px" class="img-fluid img-thumbnail" alt="Imagen banner EC">';
			$('#procesando_material_apoyo').html(html_img);
		})
	}
};
