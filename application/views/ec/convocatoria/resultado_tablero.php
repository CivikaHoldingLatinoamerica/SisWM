<?php if($pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
<?php endif; ?>
<?php if(isset($estandar_competencia_convocatoria) && sizeof($estandar_competencia_convocatoria) != 0): ?>
	<?php foreach ($estandar_competencia_convocatoria as $index => $echc): ?>
		<tr>
			<td><?=$index + 1?></td>
			<td><?=$echc->titulo?></td>
			<td>
				<ul>
					<li class="no_list_style"><label>Programa del </label><?=fechaBDToHtml($echc->programacion_inicio)?> al <?=fechaBDToHtml($echc->programacion_fin)?></li>
					<li class="no_list_style"><label>Alineación del </label><?=fechaBDToHtml($echc->alineacion_inicio)?> al <?=fechaBDToHtml($echc->alineacion_fin)?></li>
					<li class="no_list_style"><label>Evaluación del </label><?=fechaBDToHtml($echc->evaluacion_inicio)?> al <?=fechaBDToHtml($echc->evaluacion_fin)?></li>
					<li class="no_list_style"><label>Certificado del </label><?=fechaBDToHtml($echc->certificado_inicio)?> al <?=fechaBDToHtml($echc->certificado_fin)?></li>
				</ul>
			</td>
			<td>
				<ul>
					<li class="no_list_style"><label>Costo alineación: </label>$<?=$echc->costo_alineacion?></li>
					<li class="no_list_style"><label>Costo evaluación: </label>$<?=$echc->costo_evaluacion?></li>
					<li class="no_list_style"><label>Costo certificado: </label>$<?=$echc->costo_certificado?></li>
				</ul>
			</td>
			<td>
				<ul>
					<li class="no_list_style"><label>Proposito: </label><?=$echc->proposito?></li>
					<li class="no_list_style"><label>Descripción: </label><?=$echc->descripcion?></li>
					<!-- <li class="no_list_style"><label>Sector detalle: </label><?=$echc->sector_descripcion?></li>
					<li class="no_list_style"><label>Perfil: </label><?=$echc->perfil?></li>
					<li class="no_list_style"><label>Duración: </label><?=$echc->duracion_descripcion?></li> -->
					
					
				</ul>
			</td>
			<td>
				<?php if($echc->eliminado =='no'): ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.modificar')): ?>
						<button type="button" data-id_estandar_competencia="<?=$echc->id_estandar_competencia?>"
								data-id_estandar_competencia_convocatoria="<?=$echc->id_estandar_competencia_convocatoria?>"
								data-toggle="tooltip" title="Modificar estandar"
								class="btn btn-sm btn-outline-primary modificar_convocatoria_ec"><i class="fa fa-edit"></i> Editar</button>
					<?php endif; ?>

					<?php if(perfil_permiso_operacion_menu('estandar_competencia.eliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
								data-toggle="tooltip" title="Eliminar Estándar"
								data-msg_confirmacion_general="¿Esta seguro de eliminar la convocatoria del estándar de competencia?, esta acción no podrá revertirse"
								data-url_confirmacion_general="<?=base_url()?>ConvocatoriasEC/eliminar/<?=$echc->id_estandar_competencia_convocatoria?>"
								data-btn_trigger="#btn_buscar_convocatoria_ec">
							<i class="fas fa-trash"></i> Eliminar
						</button>
						<hr>
					<?php endif; ?>
				<?php else: ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.deseliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar Convocatoria del estandar"
								data-msg_confirmacion_general="¿Esta seguro de desea que la convocaatoria del estándar de competencia que esta eliminado, vuelva a estar funcional?"
								data-url_confirmacion_general="<?=base_url()?>ConvocatoriasEC/deseliminar/<?=$echc->id_estandar_competencia_convocatoria?>"
								data-btn_trigger="#btn_buscar_convocatoria_ec">
							<i class="fas fa-trash-restore"></i>
						</button>
					<?php endif; ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="6" class="text-center">
			Sin registros encontrados
		</td>
	</tr>
<?php endif; ?>
