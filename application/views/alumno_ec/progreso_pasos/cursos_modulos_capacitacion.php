<div class="form-group">
	<div class="col-12">
		<div class="card">

		<div class="card-header">
				<h4 class="card-title"><b>Módulo de capacitación detalles</b></h4>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<img src="<?=base_url().$ec_curso->ruta_directorio.$ec_curso->nombre?>" class="img-thumbnail" alt="Curso de Estandar de Competencia">
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label class="col-form-label">Curso: </label> <span><?=$ec_curso->nombre_curso?></span>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12"><i class="fa fa-square"></i><b> Descrición:</b></div>
					<div class="col-sm-12">
						<span><?=$ec_curso->descripcion?></span>
					</div>				
				</div>

				<div class="form-group row">
					
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-book"></i> ¿Que aprenderas?:</label>
							<div><?=$ec_curso->que_aprenderas?></div>
						</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label">Módulos</label>
				</div>

				<?php if (isset($ec_curso_modulo['ec_curso_modulo']) && is_array($ec_curso_modulo['ec_curso_modulo']) && sizeof($ec_curso_modulo['ec_curso_modulo']) != 0): ?>				
					<div class="form-group row">
						<?php foreach ($ec_curso_modulo['ec_curso_modulo'] as $index=>$eccm): ?>
							<?php if($eccm->eliminado == 'no'): ?>
								<div class="col-md-12">
									<div class="card card-<?=$eccm->eliminado == 'si' ? 'light' : 'primary'?> <?= $index == 0 ? "" : "collapsed-card"?>">
										<div class="card-header">
											<h3 class="card-title <?=$eccm->eliminado == 'si' ? 'text-danger' : ''?>">
												<label> Descripción: <?=isset($eccm->descripcion) ? $eccm->descripcion : "" ?></label>
											</h3>
											<div class="card-tools">
												<button type="button" class="btn btn-tool" data-card-widget="collapse">
													<i class="fas fa-<?= $index == 0 ? 'minus' : 'plus'?>"></i>
												</button>
											</div>
										</div>
										<!-- /.card-header -->
										<div class="card-body" style="display: <?= $index == 0 ? 'block' : 'none'?>;">
											<div class="form-group row">
												<label> Objetvo general:</label>					
											</div>
											<div class="form-group row">
												<?=isset($eccm->objetivo_general) ? $eccm->objetivo_general : ''?>						
											</div>
											<div class="form-group row">						
												<label> Objetivos especificos:</label>
											</div>
											<div class="form-group row">						
												<?=isset($eccm->objetivos_especificos) ? $eccm->objetivos_especificos : ''?></span>							
											</div>
											<div class="form-group row">
												<div class="col-sm-12 text-right">	
													<?php if(perfil_permiso_operacion_menu('ec_curso.consultar')): ?>
														<a class="btn btn-sm btn-outline-dark" data-toggle="tooltip"
														title="Evaluación al Estándar de competencia"
														href="#"><i class="fa fa-file-alt"></i> Exámen de evaluación</a>
													<?php endif; ?>
												</div>
											</div>

											<div id="contenedor_ec_curso_modulo_temas_<?=$eccm->id_ec_curso_modulo?>">
											
											<?php if (isset($eccm->ec_curso_modulo_temario) && is_array($eccm->ec_curso_modulo_temario) && sizeof($eccm->ec_curso_modulo_temario) != 0): ?>
												<div class="form-group row">
													<?php foreach ($eccm->ec_curso_modulo_temario as $eccmt): ?>
														<?php if($eccmt->eliminado == 'no'): ?>
															<div class="col-md-12">
																<div class="card card-<?=$eccmt->eliminado == 'si' ? 'light' : 'info'?> collapsed-card">
																	<div class="card-header">
																		<h3 class="card-title <?=$eccmt->eliminado == 'si' ? 'text-danger' : ''?>">
																			<label> Tema: <?=isset($eccmt->tema) ? $eccmt->tema : "" ?><?=$eccmt->eliminado == 'si' ? '- ELIMINADO' : ''?></label>
																		</h3>
																		<div class="card-tools">
																			<button type="button" class="btn btn-tool" data-card-widget="collapse">
																				<i class="fas fa-plus"></i>
																			</button>
																		</div>
																	</div>
																	<!-- /.card-header -->
																	<div class="card-body" style="display: none;">
																		<div class="form-group row">
																			<label> Innstrucciones:</label>
																		</div>
																		<div class="form-group row">
																			<?=isset($eccmt->instrucciones) ? $eccmt->instrucciones : ''?>						
																		</div>
																		<div class="form-group row">						
																			<label> Contenido curso:</label>
																		</div>
																		<div class="form-group row">						
																			<?=isset($eccmt->contenido_curso) ? $eccmt->contenido_curso : ''?></span>							
																		</div>

																		<div class="form-group row">						
																			<label> Archivo del tema:</label>
																		</div>
																		<div class="form-group row">						
																		<p><a href="<?= base_url().$eccmt->ruta_directorio.$eccmt->nombre?>" target="_blank"><?= $eccmt->nombre ?> </a></p>						
																		</div>
																	</div>
																</div>
																<!-- /.card -->
															</div>
														<?php endif; ?>
													<?php endforeach; ?>
												</div>

											<?php else: ?>
												<?php $this->load->view('default/sin_datos'); ?>
											<?php endif; ?>
											</div>
										</div>
									</div>
									<!-- /.card -->
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>

				<?php else: ?>
					<?php $this->load->view('default/sin_datos'); ?>
				<?php endif; ?>
				

			</div>

			<div class="form-group row">
				<div class="col-12 text-right">
					<button type="button"
							data-siguiente_link="#tab_evidencias-tab" data-numero_paso="1"
							class="btn btn-outline-success guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
				</div>
			</div> 
		</div>
	</div>
</div>
			<!-- <div class="card-body table-responsive p-0">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>ID</th>
						<th>Titulo</th>
						<th>
							Tiempo
							<small class="form-text text-muted">En minutos</small>
						</th>
						<th>
							Calificación
							<small class="form-text text-muted">Se tomará la más alta</small>
						</th>
						<th>Evaluación</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php if(isset($ec_has_evaluacion)): ?>
						<?php foreach ($ec_has_evaluacion as $index => $ecc):?>
							<?php $calificaciones[$index] = array(); ?>
							<tr>
								<td><?=$index + 1?></td>
								<td><?=$ecc->titulo?></td>
								<td><?=$ecc->tiempo != 0 && $ecc->tiempo != '' ? $ecc->tiempo : 'N/A'?></td>
								<td>
									<span id="span_calificacion_alta_<?=$index?>"></span>
								</td>
								<td><?=$ecc->tipo_evaluacion?></td>
								<td>
									<?php if(isset($usuario) && in_array($usuario->perfil,array('instructor','admin'))): ?>
										<button type="button" class="btn btn-sm btn-outline-success buscar_preguntas_evaluacion"
												data-id_evaluacion="<?=$ecc->id_evaluacion?>">
											<i class="fa fa-clipboard-list"></i> Ver preguntas
										</button>
									<?php endif; ?>
									<?php if(isset($usuario) && $usuario->perfil == 'alumno'): ?>
										<?php if(sizeof($ecc->evaluaciones_realizadas) < $ecc->intentos): ?>
											<a href="<?=base_url()?>evaluacion/<?=$ecc->id_estandar_competencia.'/'.$ecc->id_evaluacion?>" class="btn btn-sm btn-outline-danger" >
												<i class="fa fa-check"></i> Realizar examen
											</a>
										<?php endif; ?>
									<?php endif; ?>
									<button class="btn btn-sm btn-outline-info btn_ver_intentos_evaluacion btn_info_oculta" data-mostrar_instentos=".evaluaciones_candidato_<?=$index?>" type="button">
										<i class="fa fa-eye"></i> Ver evaluaciones
									</button>
								</td>
								<td></td>
							</tr>
							<?php if(isset($ecc->evaluaciones_realizadas) && is_array($ecc->evaluaciones_realizadas) && sizeof($ecc->evaluaciones_realizadas) != 0): ?>
								<?php foreach ($ecc->evaluaciones_realizadas as $index_er => $er): ?>
									<?php $calificaciones[$index][] = $er->calificacion ?>
									<tr class="evaluaciones_candidato_<?=$index?>" style="display: none;">
										<td ></td>
										<td><?=$index_er+1?></td>
										<td>Inicio: <?=fechaHoraBDToHTML($er->fecha_iniciada)?></td>
										<td>Finalizo: <?=fechaHoraBDToHTML($er->fecha_enviada)?></td>
										<td>Calificacion: <span class="span_calificacion_evidencia" data-calificacion="<?=$er->calificacion?>"><?=$er->calificacion?></span></td>
										<td>Decisión tomada:
											<i>
												<?php switch ($er->decision_candidato){
													case 'tomar_capacitacion':
														echo 'Tomar capacitación previo a la Evaluación';
														break;
													case 'tomar_alineacion':
														echo 'Tomar alineación previo a la Evaluación';
														break;
													case 'tomar_proceso':
														echo 'Iniciar el proceso de Evaluación';
														break;
													default:
														echo 'Otro: '.$er->descripcion_candidato_otro;
														break;
												}?>
											</i>
										</td>
										<td>
											<button data-id_usuario_has_evaluacion_realizada="<?=$er->id_usuario_has_evaluacion_realizada?>" class="btn btn-success btn-sm ver_evaluacion_respuestas_candidato">
												<i class="fa fa-clipboard-list"></i>Ver evaluación
											</button>
										</td>
									</tr>
								<?php endforeach; ?>
								<input type="hidden" class="calificacion_alta" data-id_index="<?=$index?>" id="calificacion_alta_<?=$index?>" value="<?=max($calificaciones[$index])?>">
							<?php else: ?>
								<tr class="evaluaciones_candidato_<?=$index?>" style="display: none;">
									<td colspan="6">Sin evaluaciones realizadas</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="form-group row">
	<div class="col-12 text-right">
		<button type="button" <?=sizeof($ecc->evaluaciones_realizadas) != 0 ? '':'disabled="disabled"'?>
				data-siguiente_link="#tab_derechos_obligaciones-tab" data-numero_paso="1"
				class="btn btn-outline-success guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
	</div>
</div> -->
