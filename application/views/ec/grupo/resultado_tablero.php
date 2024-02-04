<?php if($pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
<?php endif; ?>
<?php if(isset($estandar_competencia_grupo) && sizeof($estandar_competencia_grupo) != 0): ?>
	<?php foreach ($estandar_competencia_grupo as $index => $ecg): ?>
		<tr class="<?=$ecg->eliminado =='si' ? 'text-danger':''?>">
			<td><?=$ecg->id_estandar_competencia_grupo?></td>
			<td><?=$ecg->clave_grupo.'/'.$ecg->nombre_grupo?></td>
			<td>
				<?=fechaBDToHtml($ecg->periodo_inicio).' al '.fechaBDToHtml($ecg->periodo_fin)?>
				<br> y duración de: <?=$ecg->duracion?> hrs
			</td>
			<td><?=$ecg->agente_capacitador?></td>
			<td><?=$ecg->clave.'-'.$ecg->area_tematica?></td>
			<td>
				<?php if($ecg->eliminado =='no'): ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.modificar')): ?>
						<button type="button" data-id_estandar_competencia_grupo="<?=$ecg->id_estandar_competencia_grupo?>"
								data-toggle="tooltip" title="Modificar grupo del EC"
								class="btn btn-sm btn-outline-primary modificar_ec_grupo"><i class="fa fa-edit"></i> Editar</button>
					<?php endif; ?>

					<?php if(perfil_permiso_operacion_menu('estandar_competencia.eliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
								data-toggle="tooltip" title="Eliminar Grupo del EC"
								data-msg_confirmacion_general="¿Esta seguro de eliminar el grupo del estándar de competencia?, esta acción no podrá revertirse"
								data-url_confirmacion_general="<?=base_url()?>ECGrupos/eliminar/<?=$ecg->id_estandar_competencia_grupo?>"
								data-btn_trigger="#btn_buscar_estandar_competencia_grupo">
							<i class="fas fa-trash"></i> Eliminar
						</button>
						<hr>
					<?php endif; ?>	
				<?php else: ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.deseliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar Grupo del EC"
								data-msg_confirmacion_general="¿Esta seguro de desea que el grupo del estándar de competencia que esta eliminado, vuelva a estar funcional?"
								data-url_confirmacion_general="<?=base_url()?>ECGrupos/deseliminar/<?=$ecg->id_estandar_competencia_grupo?>"
								data-btn_trigger="#btn_buscar_estandar_competencia_grupo">
							<i class="fas fa-trash-restore"></i>
						</button>
					<?php endif; ?>		
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<?php if($pagina_select == 1): ?>
		<tr>
			<td colspan="6" class="text-center">
				Sin registros encontrados
			</td>
		</tr>
	<?php endif; ?>
<?php endif; ?>
