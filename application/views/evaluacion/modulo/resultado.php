
<div class="form-group row">
	<label class="col-form-label">Evaluación al módulo del Estándar de competencia</label>
	<span></span>
</div>

<?php if (isset($evaluacion) && is_object($evaluacion)): ?>
	<div class="form-group row">
		<div class="col-md-12">
			<div class="card card-<?=$evaluacion->eliminado == 'si' ? 'light' : 'info'?>" >
				<div class="card-header">
					<h3 class="card-title <?=$evaluacion->eliminado == 'si' ? 'text-danger' : ''?>">
						<?=isset($evaluacion->titulo) ? $evaluacion->titulo : 'Evaluacion de la EC - '.$estandar_competencia->codigo?> -
						<?=isset($evaluacion->tiempo) && $evaluacion->tiempo != 0 ? 'Tiempo: '.$evaluacion->tiempo.' minutos - ': ''?>
						<?=isset($evaluacion->intentos) && $evaluacion->tiempo != 0 && $evaluacion->intentos != '' ? 'Intentos: '.$evaluacion->intentos. ' - ': ''?>
						<?=isset($evaluacion->cat_evaluacion) ? 'Evaluación: '.$evaluacion->cat_evaluacion : ''?>
					</h3>
					
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<div class="form-group row">
						<div class="col-sm-12 text-right">
							<button id="btn_buscar_pregunta_<?=$evaluacion->id_evaluacion?>" class="btn btn-info btn-sm buscar_preguntas_evaluacion" data-toggle="tooltip"
									title="Cargar pregunta de la evaluación" style="display: none"
									data-id_evaluacion="<?=$evaluacion->id_evaluacion?>"
									type="button" ><i class="fa fa-search"></i> Buscar preguntas
							</button>
							<?php if($evaluacion->eliminado == 'si'): ?>
								<?php if(perfil_permiso_operacion_menu('evaluacion.deseliminar')):?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar evaluacion de la EC"
											data-msg_confirmacion_general="¿Esta seguro de deseliminar la evaluación de la EC?, esto volverá a estar activa la evaluación"
											data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/deseliminar/<?=$evaluacion->id_evaluacion?>"
											data-btn_trigger="#btn_buscar_ec_evaluacion">
										<i class="fas fa-trash-restore"></i> Deseliminar
									</button>
								<?php endif; ?>
							<?php else: ?>
									<?php if(perfil_permiso_operacion_menu('evaluacion.modificar')): ?>
										<button class="btn btn-outline-primary btn-sm modificar_evaluacion_ec" data-toggle="tooltip"
												title="Editar la evaluación de la EC"
												data-id_evaluacion="<?=$evaluacion->id_evaluacion?>"
												type="button" ><i class="fa fa-edit"></i> Editar
										</button>
									<?php endif; ?>
									<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.agregar')):?>
										<button class="btn btn-outline-info btn-sm agregar_pregunta_evaluacion" data-toggle="tooltip"
												title="Agregar pregunta al cuestionario de evaluación"
												data-id_evaluacion="<?=$evaluacion->id_evaluacion?>"
												type="button" ><i class="fa fa-list-alt"></i> Agregar pregunta
										</button>
									<?php endif; ?>
								<?php if($ec_curso->publicado == 'no'): ?>
									<?php if(perfil_permiso_operacion_menu('evaluacion.eliminar')):?>
										<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar evaluacion de la EC"
												data-msg_confirmacion_general="¿Esta seguro de eliminar la evaluación de la EC?, esta acción no podrá revertirse"
												data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/eliminar/<?=$evaluacion->id_evaluacion?>"
												data-btn_trigger="#btn_buscar_ec_evaluacion">
											<i class="fas fa-trash"></i> Eliminar
										</button>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<div id="contenedor_preguntas_evaluacion_<?=$evaluacion->id_evaluacion?>"></div>
				</div>
				<!-- /.card-body -->
				<?php if($evaluacion->eliminado == 'no'): ?>
					<div class="card-footer text-right">
						<?php if($ec_curso->publicado == 'no'): ?>
							<?php if(perfil_permiso_operacion_menu('evaluacion.modificar')): ?>
								<button class="btn btn-outline-primary btn-sm modificar_evaluacion_ec" data-toggle="tooltip"
										title="Editar la evaluación de la EC"
										data-id_evaluacion="<?=$evaluacion->id_evaluacion?>"
										type="button" ><i class="fa fa-edit"></i> Editar
								</button>
							<?php endif; ?>
							<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.agregar')):?>
								<button class="btn btn-outline-info btn-sm agregar_pregunta_evaluacion" data-toggle="tooltip"
										title="Agregar pregunta al cuestionario de evaluación"
										data-id_evaluacion="<?=$evaluacion->id_evaluacion?>"
										type="button" ><i class="fa fa-list-alt"></i> Agregar pregunta
								</button>
							<?php endif; ?>
							<?php if(perfil_permiso_operacion_menu('evaluacion.eliminar')):?>
								<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar evaluacion de la EC"
										data-msg_confirmacion_general="¿Esta seguro de eliminar la evaluación de la EC?, esta acción no podrá revertirse"
										data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/eliminar/<?=$evaluacion->id_evaluacion?>"
										data-btn_trigger="#btn_buscar_ec_evaluacion">
									<i class="fas fa-trash"></i> Eliminar
								</button>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<!-- /.card -->
		</div>
	</div>

<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif; ?>
