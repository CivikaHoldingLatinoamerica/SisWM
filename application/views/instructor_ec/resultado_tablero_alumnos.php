<?php if(isset($pagina_select) && $pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
<?php endif; ?>
<?php if(isset($alumnos_ec) && sizeof($alumnos_ec) != 0): ?>
	<?php foreach ($alumnos_ec as $index => $aec): ?>
		<tr>
			<td><?=$aec->id_usuario?></td>
			<td><?=$aec->nombre.' '.$aec->apellido_p.' '.$aec->apellido_m?></td>
			<td><?=$aec->curp?></td>
			<td>
				<ul>
					<li><label>Correo: </label><?=$aec->correo?></li>
					<li><label>Celular: </label><?=$aec->celular != '' ? $aec->celular : ' Sin dato'?></li>
					<li><label>Telefono: </label><?=$aec->telefono != '' ? $aec->telefono : ' Sin dato'?></li>
				</ul>
			</td>
			<td>
				<?php if($aec->activo == 'si' && $aec->eliminado == 'no'): ?>
					<?php if(perfil_permiso_operacion_menu('evaluacion.consultar')): ?>
						<div class="btn-group">
							<button type="button" class="btn btn-outline-dark btn-sm"><i class="fa fa-question"></i> Cuestionarios</button>
							<button type="button" class="btn btn-outline-dark dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu" style="">
								<a role="button" class="dropdown-item btn_evaluaciones_alumno" href="#"
								data-id_estandar_competencia="<?=$id_estandar_competencia?>"
								data-id_usuario="<?=$aec->id_usuario?>"
								data-es_evaluacion="si"
								data-toggle="tooltip" title="Evaluacion(es) diagnoósticas del candidato">
									Evaluación diagnóstica
								</a>
								<a role="button" class="dropdown-item btn_evaluaciones_modulo_alumno" href="#"
								data-id_estandar_competencia="<?=$id_estandar_competencia?>"
								data-id_usuario="<?=$aec->id_usuario?>"
								data-es_evaluacion="si"
								data-toggle="tooltip" title="Evaluacion(es) módulo de capacitación del candidato">
									Evaluación módulo de capacitación
								</a>
								<a role="button" class="dropdown-item btn_encuesta_satisfaccion_lectura" data-toggle="tooltip" title="Ver encuesta de satisfacción"
								data-id_estandar_competencia="<?=$id_estandar_competencia?>"
								data-id_usuario="<?=$aec->id_usuario?>" href="#">
									Encuesta de satisfacción
								</a>
							</div>
						</div>
						<br>
						<button class="btn btn-sm btn-outline-warning btn_evaluaciones_alumno mt-1" data-toggle="tooltip"
								data-id_estandar_competencia="<?=$id_estandar_competencia?>"
								data-id_usuario="<?=$aec->id_usuario?>" data-es_evaluacion="no"
								title="Cédula de evaluación"><i class="fa fa-check-circle"></i> Cédula de evaluación</button>
					<?php endif; ?>
					<?php if(perfil_permiso_operacion_menu('tecnicas_instrumentos.consultar')): ?>
						<br>
						<button class="btn btn-sm btn-outline-info btn_evidencia_ati_alumno mt-1" data-toggle="tooltip"
								data-id_estandar_competencia="<?=$id_estandar_competencia?>"
								data-id_usuario="<?=$aec->id_usuario?>"
								title="Evidencia de trabajo por parte del candidato"><i class="fa fa-clipboard-list"></i> Evidencia de trabajo</button>
						<br>
						<button class="btn btn-sm btn-outline-danger btn_cargar_expediente_alumno mt-1" data-toggle="tooltip"
								data-id_estandar_competencia="<?=$id_estandar_competencia?>"
								data-id_usuario="<?=$aec->id_usuario?>"
								data-id_usuario_instructor="<?=$aec->id_usuario_evaluador?>"
								title="Carga del expediente del candidato"><i class="fa fa-upload"></i> Expediente digital</button>
						<br>
						<button class="btn btn-sm btn-outline-success generar_portafolio_evidencia mt-1" data-toggle="tooltip"
								data-id_estandar_competencia="<?=$id_estandar_competencia?>"
								data-id_usuario_alumno="<?=$aec->id_usuario?>"
								data-id_usuario_instructor="<?=$aec->id_usuario_evaluador?>"
								title="Generación del Portafolio de evidencias"><i class="fa fa-file-alt"></i> Generar PED</button>
					<?php endif; ?>
				<?php else: ?>
					<?php if($aec->activo == 'no'): ?>
						<span class="badge badge-warning">Candidato desactivado</span>
					<?php elseif($aec->eliminado == 'si'): ?>
						<span class="badge badge-dark">Candidato eliminado</span>
					<?php endif; ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<?php if($pagina_select == 1): ?>
		<tr>
			<td colspan="5" class="text-center">
				Sin registros encontrados
			</td>
		</tr>
	<?php endif; ?>
<?php endif; ?>
