<?php if($pagina_select == 1 && $paginas > 1): ?>
	<input type="hidden" id="paginacion_usuario_candidatos_asignados" data-pagina_select="<?=$pagina_select?>" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
	<input type="hidden" id="total_registros_candidatos_asignados" value="<?=$total_registros?>">
<?php endif; ?>
<?php if(isset($usuario_has_estandar_competencia) && is_array($usuario_has_estandar_competencia) && !empty($usuario_has_estandar_competencia)): ?>
	<?php foreach ($usuario_has_estandar_competencia as $index => $candidato): ?>
		<tr>
			<td><?=$candidato->id_usuario?> - </td>
			<td><?=$candidato->usuario.' - '.$candidato->nombre.' '.$candidato->apellido_p.' '.$candidato->apellido_m?></td>
			<td><?=$candidato->nombre_evaluador.' '.$candidato->apellido_p_evaluador.' '.$candidato->apellido_m_evaluador?></td>
			<td>
				<button class="btn btn-sm btn-outline-warning btn_modificar_candidato_asignado"><i class="fa fa-edit"></i></button>
				<button id="btn_eliminar_asignacion_<?=$candidato->id_usuario?>" type="button" class="btn btn-sm btn-danger iniciar_confirmacion_operacion" 
						data-toggle="tooltip" title="Eliminar Candidato" 
						data-msg_confirmacion_general="¿Esta seguro de eliminar el usuario seleccionado del EC?, esta acción no podrá revertirse" 
						data-url_confirmacion_general="<?=base_url()?>EC/eliminar_instructor_alumno_ec/<?=$id_estandar_competencia?>/<?=$candidato->id_usuario?>" data-btn_trigger="#btn_buscar_usr_candidatos_asignados"
						data-btn_trigger="#btn_buscar_estandar_competencia">
					<i class="fas fa-trash"></i>
				</button>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="4" class="text-center">
			Sin registros encontrados
		</td>
	</tr>
<?php endif; ?>
