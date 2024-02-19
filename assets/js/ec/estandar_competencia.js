$(document).ready(function () {

	$(document).on('click','#btn_buscar_estandar_competencia',function(){
		EstandarCompetencia.tablero();
	});

	$(document).on('click','#agregar_estandar_competencia',function(){
		EstandarCompetencia.agregar_modificar_ec();
	});

	$(document).on('click','#btn_guardar_form_ec',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		EstandarCompetencia.guardar_estandar_compentencia(id_estandar_competencia);
	});

	$(document).on('click','.modificar_estandar_competencia',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		EstandarCompetencia.agregar_modificar_ec(id_estandar_competencia);
	});

	$(document).on('change','#cat_instrumento',function(){
		var id_cat_instrumento = $(this).val();
		$('select#actividad_ec').find('option').show();
		$('select#actividad_ec').find('option.actividad_instrumento_'+id_cat_instrumento).hide();
	});

	$(document).on('click','.btn_instructor_evaluador',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		EstandarCompetencia.ver_asignar_instructor_alumno_ec(id_estandar_competencia,'instructor');
	});

	$(document).on('click','.btn_alumnos_ec',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		EstandarCompetencia.ver_asignar_instructor_alumno_ec(id_estandar_competencia,'alumno');
	});

	$(document).on('click','.btn_asingar_alumno_ec',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		EstandarCompetencia.ver_asignar_alumno_ec(id_estandar_competencia);
	});

	$(document).on('click','.slt_instructor_alumno_ec',function(){
		var id_usuario = $(this).val()[0];
		var tipo = $(this).data('tipo');
		EstandarCompetencia.add_row_instructor_alumno_ec(id_usuario,tipo);
	});

	$(document).on('click','.btn_guardar_candidato_con_instructor',function(){
		var id_usuario = $(this).data('id_usuario'); //para guardar el id del candidato
		var tipo_guardar = $(this).data('tipo_guardar'); //para guardar el id del candidato
		var id_usuario_instructor = $(this).closest('tr').find('select.slt_usuarios_evaluadores_asignados').val();
		if(id_usuario_instructor != ''){
			EstandarCompetencia.guardar_row_instructor_alumno(id_usuario,id_usuario_instructor,tipo_guardar);
		}else{
			Comun.mensaje_operacion('Es necesario que seleccione un evaluador para el candidato','error');
		}
	});

	$(document).on('click','.lnk_agregar_modificacion_plan_requerimientos',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		EstandarCompetencia.agregar_modificar_plan_requerimientos(id_estandar_competencia);
	});

	$(document).on('click','#btn_guardar_form_plan_requerimientos',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		EstandarCompetencia.guardar_ec_plan_requerimientos(id_estandar_competencia);
	});

	$(document).on('click','.eliminar_usuario_ec',function(){
		var row_eliminar = $(this);
		row_eliminar.closest('tr').remove();
		// var opcion = $('option#instructor_alumno'+row_eliminar.data('id_usuario'));
		// opcion.show();
		//se cambia lo del volver a mostrar este usuario una vez se elimina
		var foto_perfil = $(this).data('foto_perfil');
		var nombre_usuario = $(this).data('nombre_usuario');
		var id_usuario = $(this).data('id_usuario');
		var html_opcion_regreso = '<option id="instructor_alumno'+id_usuario+'" data-foto_perfil="'+foto_perfil+'" value="'+id_usuario+'" >'+nombre_usuario+'</option>';
		$('#instructores_alumnos_disponibles').append(html_opcion_regreso);
	});

	//EstandarCompetencia.tablero();
	$(document).on('click','.btn_ver_titulo_completo_ec',function(){
		var parrafo = $(this).closest('p');
		if($(this).hasClass('mostrar_todo')){
			$(this).removeClass('mostrar_todo');
			parrafo.find('.span_titulo_ec').hide();
			parrafo.find('.complemento_titulo_ec').show();
			$(this).html('<i class="fa fa-eye-slash"></i>');
		}else{
			parrafo.find('.span_titulo_ec').show();
			parrafo.find('.complemento_titulo_ec').hide();
			$(this).addClass('mostrar_todo');
			$(this).html('<i class="fa fa-eye"></i>');
		}
	});

	$(document).on('click','.btn_asignacion_grupos',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
	});

	/**
	 * nueva funcionalidad para la asignación de candidatos al estandar de competencia
	 * @author: enrique corona
	 * @date: enero-2024
	 */

	$(document).on('click','#btn_asignar_candidato_estandar_competencia',function(){
		$('#contenedor_listado_candidatos_asignados_ec').fadeOut();
		EstandarCompetencia.agregar_modificar_asignacion_candidato();
	});

	$(document).on('click','.btn_modificar_candidato_asignado',function(){
		$('#contenedor_listado_candidatos_asignados_ec').fadeOut();
		var id_usuario_has_estandar_competencia = $(this).data('id_usuario_has_estandar_competencia');
		EstandarCompetencia.agregar_modificar_asignacion_candidato(id_usuario_has_estandar_competencia);
	});

	$(document).on('click','#btn_cancelar_asingar_candidato_ec',function(){
		$('#contenedor_listado_candidatos_asignados_ec').fadeIn();
		$('#contenedor_asignar_modificar_candidato_ec').fadeOut();
	});

	$(document).on('click','#btn_buscar_usr_candidatos_asignados',function(){
		var pagina = 1;
		var registros = $('#numero_registros_candidatos').val()
		EstandarCompetencia.tablero_candidatos_asignados(pagina,registros);	
	});

	$(document).on('click','#btn_buscar_mas_usr_candidatos_asignados',function(){
		var pagina = parseInt($('#paginacion_usuario_candidatos_asignados').val()) + 1;
		//var pagina = parseInt($('#paginacion_usuario_candidatos_asignados').data('pagina_select')) + 1;
		var registros = $('#numero_registros_candidatos').val()
		EstandarCompetencia.tablero_candidatos_asignados(pagina,registros);	
	});

	$(document).on('click','#btn_guardar_asignar_candidato_ec',function(){
		EstandarCompetencia.guardar_asignacion_candidato_ec();
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
				EstandarCompetencia.tablero(false,pagina_select);
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});

	/*$(document).on({
		mouseenter : function(){
			$(this).fadeOut();
			$(this).closest('p').find('.complemento_titulo_ec').fadeIn();
		},
		mouseleave : function(){
			$(this).fadeIn();
			$(this).closest('p').find('.complemento_titulo_ec').fadeOut();
		}
	},'.span_titulo_ec');*/

});

var EstandarCompetencia = {

	tablero : function(inicial = true,pagina = 1, registros = 5){
		var post = {
			busqueda : $('#input_buscar_estandar_competencia').val()
		};
		//condicional para el scroll de obtener los registros :-D
		if(inicial){
			$('#contenedor_resultados_estandar_competencia').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'EC/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_estandar_competencia').html(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'EC/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_estandar_competencia').append(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
					$('#overlay_full_page').fadeOut();
				}
			);
		}
	},

	tablero_candidatos_asignados : function(pagina = 1, registros = 5){
		var id_estandar_competencia = $('#id_estandar_competencia_asignar').val();
		var post = {
			busqueda : $('#input_buscar_candidatos_asignados_ec').val(),
			id_usuario_evaluador : $('#input_buscar_evaluador_asigando').val(),
		}
		$("#contenedor_footer_usuarios_asignados").fadeOut();
		if(pagina == 1){
			$("#contenedor_resultados_usr_asignados").html('<tr>'+
				'<td colspan="5" class="text-center"><i id="spinner_buscar_candidatos_asignados" class="fas fa-sync-alt fa-spin"></i></td>'+
			'</tr>');
			Comun.obtener_contenido_peticion_html(
				base_url + 'EC/listado_candidatos_asignados/' + id_estandar_competencia + '/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usr_asignados').html(response);
					Comun.tooltips();
					$('#spinner_buscar_candidatos_asignados').fadeOut();
					$('#paginacion_usuario_candidatos_asignados').val(pagina);
					var paginacion_usuario = $('#paginacion_usuario_candidatos_asignados').length != 0 ? true : false;
					var candidatos_registrados = $('#total_registros_candidatos_asignados').val();
					$('#numero_registros_candidatos_registrados').html(candidatos_registrados);
					if(paginacion_usuario){
						var paginas = parseInt($('#paginacion_usuario_candidatos_asignados').data('max_paginacion'));
						paginas > 1 ? $("#contenedor_footer_usuarios_asignados").fadeIn() : false;
					}
					
				}
			);
		}else{
			var paginacion_usuario_candidatos_asignados = parseInt($('#paginacion_usuario_candidatos_asignados').val());
			var max_paginacion = $('#paginacion_usuario_candidatos_asignados').data('max_paginacion');
			if(paginacion_usuario_candidatos_asignados < max_paginacion){	
				$('#spinner_buscar_candidatos_asignados').fadeIn();
				Comun.obtener_contenido_peticion_html(
					base_url + 'EC/listado_candidatos_asignados/' + id_estandar_competencia + '/' + pagina + '/' + registros,
					post,
					function(response){
						paginacion_usuario_candidatos_asignados++;
						$('#contenedor_resultados_usr_asignados').append(response)
						Comun.tooltips();
						$('#spinner_buscar_candidatos_asignados').fadeOut();
						$('#paginacion_usuario_candidatos_asignados').val(paginacion_usuario_candidatos_asignados);
						$("#contenedor_footer_usuarios_asignados").fadeIn()
					}
				);
			}
		}
	},

	agregar_modificar_ec : function(id_estandar_competencia = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'EC/agregar_modifcar/'+id_estandar_competencia,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_ec',true);
				Comun.funcion_fileinput('#img_banner_ec','Imágen Banner');
				EstandarCompetencia.iniciar_carga_img_banner();
		});
	},

	agregar_modificar_asignacion_candidato : function(id_usuario_has_estandar_competencia = ''){
		var id_estandar_competencia = $('#id_estandar_competencia_asignar').val();
		$('#contenedor_asignar_modificar_candidato_ec').fadeIn();
		$('#contenedor_asignar_modificar_candidato_ec').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'EC/agregar_modificar_asignacion_candidato/'+id_estandar_competencia+'/'+id_usuario_has_estandar_competencia,
			{},
			function(response){
				$('#contenedor_asignar_modificar_candidato_ec').html(response);
				EstandarCompetencia.iniciar_select2_candidatos();
			}
		);
	},

	iniciar_select2_candidatos : function(){
		$('.select2').select2({
			placeholder: 'Selecione una opción',
			theme: "classic",
		});
	},

	validar_form_ec : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_ec',Comun.reglas_validacion_form());
		if(form_valido){
			if($('#input_id_archivo_banner_ec').val() == ''){
				form_valido = false;
				Comun.mensaje_operacion('El archivo de imagen para el banner es requerido','error');
				$('#procesando_img_banner_ec').html('<span class="badge badge-danger">El banner es requerido</span>')
			}
		}
		return form_valido;
	},

	guardar_estandar_compentencia : function(id_estandar_competencia = ''){
		if(EstandarCompetencia.validar_form_ec()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_ec',
				base_url + 'EC/guardar_form/' + id_estandar_competencia,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_ec',false);
						Comun.mensajes_operacion(response.msg,'success');
						EstandarCompetencia.tablero();
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	ver_asignar_instructor_alumno_ec : function(id_estandar_competencia,tipo='instructor'){
		Comun.obtener_contenido_peticion_html(base_url + 'EC/agregar_instructor_alumno_ec/'+ id_estandar_competencia + '/' + tipo,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_instructor_ec',true);
				EstandarCompetencia.obtener_registro_instructores_alumnos_ec(id_estandar_competencia,tipo,true);
			}
		);
	},

	ver_asignar_alumno_ec : function(id_estandar_competencia){
		Comun.obtener_contenido_peticion_html(base_url + 'EC/agregar_modificar_alumno_ec/'+ id_estandar_competencia,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_alumno_ec',true);
			}
		);
	},

	obtener_registro_instructores_alumnos_ec : function(id_estandar_competencia,tipo='instructor',procesar_select = false){
		Comun.obtener_contenido_peticion_json(
			base_url + 'EC/instructores_alumnos_asignados/' + id_estandar_competencia + '/' +tipo,{},
			function(response){
				if(response.success){
					if(response.usuario_has_estandar_competencia != undefined && response.usuario_has_estandar_competencia.length != 0){
						$.each(response.usuario_has_estandar_competencia,function(index,u_ec){
							EstandarCompetencia.obtener_row_usuario_estandar_competencia(u_ec.id_usuario,tipo,u_ec.id_usuario_evaluador);
							procesar_select ? EstandarCompetencia.procesar_select_evaluador(u_ec.id_usuario) : false;
						});
					}
					EstandarCompetencia.filtro_instructores_candidatos_slt();
					//EstandarCompetencia.procesar_data_table_asignaciones();
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		);
	},

	add_row_instructor_alumno_ec : function(id_usuario,tipo='instructor'){
		if(tipo == 'instructor'){
			var id_estandar_competencia = $('#estandar_competencia_instructor').val();
			Comun.obtener_contenido_peticion_json(base_url + 'EC/guardar_instructor_alumno_ec/' + id_estandar_competencia + '/' + id_usuario,{},
				function(response){
					if(response.success){
						EstandarCompetencia.obtener_row_usuario_estandar_competencia(id_usuario,tipo);
						Comun.mensajes_operacion(response.msg,'confirmed');
						EstandarCompetencia.enviar_correo_notificacion_ec_usuario(id_usuario);
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}else{
			EstandarCompetencia.obtener_row_usuario_estandar_competencia(id_usuario,tipo);
		}
		//se cambia la logica para integrar el select de instructor que fue asignado
	},

	guardar_row_instructor_alumno : function(id_usuario,id_usuario_evaluador,tipo = 'instructor'){
		var id_estandar_competencia = $('#estandar_competencia_instructor').val();
		Comun.obtener_contenido_peticion_json(base_url + 'EC/guardar_instructor_alumno_ec/' + id_estandar_competencia + '/' + id_usuario + '/' + id_usuario_evaluador,{},
			function(response){
				if(response.success){
					EstandarCompetencia.procesar_select_evaluador(id_usuario);
					EstandarCompetencia.enviar_correo_notificacion_ec_usuario(id_usuario);
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		);
	},

	procesar_select_evaluador : function(id_usuario){
		$('#btn_eliminar_asignacion_'+id_usuario).fadeIn();
		$('#btn_guardar_asignacion_'+id_usuario).fadeOut();
		var row = $('#btn_eliminar_asignacion_'+id_usuario).closest('tr');
		var val_evaluador = row.find('select.slt_usuarios_evaluadores_asignados').val();
		var opcion_seleccionada = row.find('select.slt_usuarios_evaluadores_asignados').find('option[value='+val_evaluador+']').html();
		row.find('select.slt_usuarios_evaluadores_asignados').closest('td').html(opcion_seleccionada);
	},

	obtener_row_usuario_estandar_competencia : function(id_usuario,tipo = 'instructor',id_usuario_evaluador = false){
		var id_estandar_competencia = $('#estandar_competencia_instructor').val();
		var slt_instructores_asignados = '';
		var style_btn_eliminar = '';
		var style_btn_guardar = 'style="display:none"';
		if(tipo == 'alumno'){
			slt_instructores_asignados = '<td>'+ $('#listado_usuarios_evaluadores_asignados').html() + '</td>';
			style_btn_eliminar = 'style="display:none"';
			style_btn_guardar = '';
		}
		var opcion = $('option#instructor_alumno'+id_usuario);
		opcion.hide();
		var html_row = '<tr>' +
			'<td><img class="user-image img-circle elevation-2 img_foto_perfil" style="width: 50px; height: 50px;" src="'+opcion.data("foto_perfil")+'" alt="'+opcion.html()+'"></td>' +
			'<td>'+opcion.html()+'</td>' +
			slt_instructores_asignados +
			'<td class="text-center">' +
			'	<button '+style_btn_guardar+' id="btn_guardar_asignacion_'+id_usuario+'" type="button" class="btn btn-sm btn-success btn_guardar_candidato_con_instructor" data-tipo_guardar="'+tipo+'" data-id_usuario="'+id_usuario+'"><i class="fa fa-save"></i></button>' +
			'	<button style="display:none" type="button" class="eliminar_usuario_ec" data-foto_perfil="'+opcion.data("foto_perfil")+'" data-nombre_usuario="'+opcion.html()+'" data-id_usuario="'+id_usuario+'" id="btn_eliminar_usuario_ec_'+id_usuario+'"></button>' +
			'	<button '+style_btn_eliminar+' id="btn_eliminar_asignacion_'+id_usuario+'" type="button" class="btn btn-sm btn-danger iniciar_confirmacion_operacion" ' +
			'		data-toggle="tooltip" title="Eliminar instructor" ' +
			'		data-msg_confirmacion_general="¿Esta seguro de eliminar el usuario seleccionado del EC?, esta acción no podrá revertirse" ' +
			'		data-url_confirmacion_general="'+base_url+'EC/eliminar_instructor_alumno_ec/'+id_estandar_competencia+'/'+id_usuario+'" data-btn_trigger="#btn_eliminar_usuario_ec_'+id_usuario+'" >' +
			'		<i class="fa fa-trash"></i>' +
			'	</button>' +
			'</td>' +
			'</tr>';
		$('#tbody_instructores_alumnos_ec').append(html_row);
		opcion.remove();//eliminamos del select para que no aparezca de nuevo para el filtro
		$('#instructores_alumnos_disponibles').val('');
		if(id_usuario_evaluador != false && id_usuario_evaluador != undefined){
			$('#btn_guardar_asignacion_'+id_usuario).closest('tr').find('select.slt_usuarios_evaluadores_asignados').val(id_usuario_evaluador);
		}
	},

	enviar_correo_notificacion_ec_usuario : function(id_usuario){
		Comun.obtener_contenido_peticion_json(
			base_url + 'Notificaciones/guardar_notificacion/0/enviada',{
				destinatarios : [id_usuario],
				asunto : 'Asignación Estándar de Competencia en el sistema PED',
				mensaje : 'Hola muy buen día, se le informa que se le asignó un Estándar de Competencia en el sistema integral PED, favor de revisar en el tablero de Estándar de competencia en la opción de listado'
			},
			function(response){
				if(response.success){
					Comun.obtener_contenido_peticion_json(
						base_url + 'Notificaciones/enviar_correo/' + response.data.id_notificacion,{},
						function(response){
							if(response.success){
								Comun.mensajes_operacion(response.msg);
							}
						}
					)
				}
			}
		);
	},

	agregar_modificar_plan_requerimientos : function(id_estandar_competencia){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EC/agregar_modificar_plan_requerimientos/'+id_estandar_competencia,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_ec_plan_requerimientos',true);
			}
		);
	},

	guardar_ec_plan_requerimientos : function(id_estandar_competencia){
		if(EstandarCompetencia.validar_form_plan_requerimientos()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_plan_requerimientos',
				base_url + 'EC/guardar_form_plan_requerimientos/' + id_estandar_competencia,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_ec_plan_requerimientos',false);
						Comun.mensajes_operacion(response.msg,'success');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	agregar_modificar_grupos_estandar : function(){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EC/agregar_modificar_grupos/'+id_estandar_competencia,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_grupo_ec',true);
			}
		);
	},

	validar_form_plan_requerimientos : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_plan_requerimientos',Comun.reglas_validacion_form());
		//validaciones secundarias
		if(form_valido){
			var num_rows_plan_requerimientos = $('#tbody_destino_plan_requerimientos').find('tr').length;
			if(num_rows_plan_requerimientos == 0){
				form_valido = false;
				Comun.mensaje_operacion('Error, para continuar es necesario que registre por lo menos un plan de requerimientos','error');
			}
		}
		return form_valido;
	},

	iniciar_carga_img_banner : function(){
		Comun.iniciar_carga_imagen('#img_banner_ec','#procesando_img_banner_ec',function(archivo){
			$('#input_id_archivo_banner_ec').val(archivo.id_archivo);
			var html_img = '<img src="'+base_url + archivo.ruta_directorio + archivo.nombre+'" style="max-width: 120px" class="img-fluid img-thumbnail" alt="Imagen banner EC">';
			$('#procesando_img_banner_ec').html(html_img);
		})
	},

	filtro_instructores_candidatos_slt : function(){
		$('#input_filtro_instructores_candidatos').on('keyup',function(){
			var filtro = $(this).val().toLowerCase();
			$('#instructores_alumnos_disponibles option').filter(function(){
			   $(this).toggle($(this).text().toLowerCase().indexOf(filtro) > -1);
		    });
		});
	},

	procesar_data_table_asignaciones : function(){
		$('#table_asignaciones_evaluador_instructor').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});
	},

	/**
	 * para la nueva interfaz de la asignación de candidatos al estandar
	 * se integra lo del actualizar para cambiar el evaluador por requerimiento
	 */
	validar_form_asignacion_candidato : function(){
		var form_valido = Comun.validar_form('#form_registar_modificar_candidato_ec',Comun.reglas_validacion_form());
		if(form_valido){
			
		}
		return form_valido;
	},

	guardar_asignacion_candidato_ec : function(){
		if(EstandarCompetencia.validar_form_asignacion_candidato()){
			Comun.enviar_formulario_post(
				'#form_registar_modificar_candidato_ec',
				base_url + 'EC/nuevo_actualizar_asignacion_candidato_ec',
				function(response){
					if(response.success){
						$('#contenedor_listado_candidatos_asignados_ec').fadeIn();
						$('#contenedor_asignar_modificar_candidato_ec').fadeOut();
						Comun.mensajes_operacion(response.msg,'success');
						$('#btn_buscar_usr_candidatos_asignados').trigger('click');
						//se envia notificacion en caso de que sea una nueva asignación, solo es para cuando se asigna al candidato
						if($('#input_id_usuario_asignar').length != 0){
							EstandarCompetencia.enviar_correo_notificacion_ec_usuario($('#input_id_usuario_asignar').val());
						} 
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

};
