$(document).ready(function(){

	FormPreguntasAbiertas.obtener_formulario();

	$(document).on('click','#btn_buscar_preguntas_abiertas',function(){
		FormPreguntasAbiertas.obtener_preguntas_formulario(id_entregable_evidencia);
	});


	$(document).on('click','#agregar_pregunta_abierta',function(){
		var id_entregable_evidencia = $(this).data('id_entregable_evidencia');
		FormPreguntasAbiertas.agregar_pregunta_abierta(id_entregable_evidencia);
	});

	$(document).on('click','.modificar_pregunta_abierta',function(){
		var id_entregable_evidencia = $(this).data('id_entregable_evidencia');
		var id_cat_pregunta_formulario_abierto = $(this).data('id_cat_pregunta_formulario_abierto');
		FormPreguntasAbiertas.agregar_pregunta_abierta(id_entregable_evidencia,id_cat_pregunta_formulario_abierto);
	});

	$(document).on('click','#guardar_preguntas_abiertas',function(){
		var id_entregable_evidencia = $(this).data('id_entregable_evidencia');
		var id_cat_pregunta_formulario_abierto = $(this).data('id_cat_pregunta_formulario_abierto');
		FormPreguntasAbiertas.guardar_form_registro_pregunta_abierta(id_entregable_evidencia,id_cat_pregunta_formulario_abierto);
	});

	FormPreguntasAbiertas.iniciar_editor_summernote();

});

var FormPreguntasAbiertas = {

	iniciar_editor_summernote : function(){
		$('.txt_pregunta_abierta_rich').summernote({
			minHeight : 300,
			lang : 'es-ES',
			placeholder : 'Escribe tu respuesta',
			codeviewFilter: false,
			codeviewIframeFilter: true,
			toolbar : [
				['style', ['bold', 'italic', 'underline']],
				['font',['fontname','fontsize','forecolor']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link', 'picture', 'video']],
				['view', [ 'help']],
			]
		});
	},

	obtener_formulario : function(){
		var id_entregable_evidencia = $('#input_id_entregable_evidencia').val();
		$('#contenedor_resultados_preguntas_abiertas').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'PreguntasAbiertas/resultado/' + id_entregable_evidencia,{},
			function(response){
				$('#contenedor_preguntas_abiertas_entregable_').html(response);
				Comun.tooltips();
				FormPreguntasAbiertas.obtener_preguntas_formulario(id_entregable_evidencia);
				//$('.buscar_preguntas_evaluacion').trigger('click');
			}
		);
	},

	obtener_preguntas_formulario : function(id_entregable_evidencia){
		Comun.obtener_contenido_peticion_html(
			base_url + 'PreguntasAbiertas/resultado/' + id_entregable_evidencia,{},
			function(response){
				$('#contenedor_preguntas_abiertas_entregable_'+id_entregable_evidencia).html(response);
				Comun.tooltips();
				$('.popoverShowImage').trigger('click');
			}
		);
	},

	agregar_pregunta_abierta : function(id_entregable_evidencia,id_cat_pregunta_formulario_abierto = ''){
		Comun.obtener_contenido_peticion_html(
			base_url + 'PreguntasAbiertas/agregar_pregunta/' + id_entregable_evidencia + '/' + id_cat_pregunta_formulario_abierto,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.tooltips();
				Comun.mostrar_ocultar_modal('#modal_form_pregunta_abierta',true);
			}
		);
	},

	validar_form_pregunta_abierta: function (){
		$('.error').remove();
		var msg_error = [];
		var pregunta_valido = Comun.validar_string_no_vacio($('#form_guardar_pregunta_abierta').find("#txt_pregunta_abierta").val());
		var form = $('#form_guardar_pregunta_abierta');
		var form_valido = true;
		
		if(!pregunta_valido){
			form_valido = false;
			msg_error.push('Debe agregar una pregunta');
		}
		Comun.mensajes_operacion(msg_error,'error');
		return form_valido;
	},

	guardar_form_registro_pregunta_abierta : function(id_entregable_evidencia,id_cat_pregunta_formulario_abierto = ''){
		if(FormPreguntasAbiertas.validar_form_pregunta_abierta()){
			Comun.enviar_formulario_post('#form_guardar_pregunta_abierta',
				base_url + 'PreguntasAbiertas/guardar_pregunta_abierta/'+id_entregable_evidencia + '/' + id_cat_pregunta_formulario_abierto,function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_pregunta_abierta',false);
						Comun.mensajes_operacion(response.msg,'success');
						//$('#btn_buscar_pregunta_'+id_entregable_evidencia).trigger('click');
						FormPreguntasAbiertas.obtener_preguntas_formulario(id_entregable_evidencia);
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}
	},

};
