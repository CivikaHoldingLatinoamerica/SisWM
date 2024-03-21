<?php if (isset($entregables) && sizeof($entregables) != 0): ?>

	<div id="accordion_evidencias">
		<?php foreach ($entregables as $entregable): ?>
			<div class="card w-100">
				<div class="card-header sidebar-dark-primary white " id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link" style="color: white" data-toggle="collapse"
								data-target="#collapse-evidencia<?= old($entregable, 'id_entregable') ?>"
								aria-expanded="true"
								aria-controls="collapseOne">
							<?php if ($entregable->tipo_entregable == "prod") : ?>
								<em class="fa fa-file mr-1"></em>
							<?php endif; ?>

							<?php if ($entregable->tipo_entregable == "form") : ?>
								<em style="color: var(--dark)" class="fa fa-list mr-1"></em>
							<?php endif; ?>

							<?php if ($entregable->tipo_entregable == "cuest") : ?>
								<em style="color: var(--green)" class="fa fa-question mr-1"></em>
							<?php endif; ?>
							<?= old($entregable, 'nombre_entregable') ?>
							<?=isset($entregable->entregable_wm) && $entregable->entregable_wm == 'si' ? '<span class="badge badge-dark">Entregable WM</span>' :''?>
						</button>


						<?php if ($entregable->id_estatus == 1) : ?>
							<span class="float-right badge badge-pill badge-info estatus_entregable">En proceso</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == 2) : ?>
							<span class="float-right badge badge-pill badge-light estatus_entregable">Enviada</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == 3) : ?>
							<span class="float-right badge badge-pill badge-warning estatus_entregable">Con Observaciones</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == 4) : ?>
							<span class="float-right badge badge-pill badge-success estatus_entregable">Liberada</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == null) : ?>
							<span class="float-right badge badge-pill badge-dark estatus_entregable">Pendiente</span>
						<?php endif; ?>
					</h5>


				</div>
				<div id="collapse-evidencia<?= old($entregable, 'id_entregable') ?>" class="collapse p-3"
					 aria-labelledby="headingOne"
					 data-parent="#accordion_evidencias">
					<div class="row">
						<div class="col">
							<p style="color: darkgray">
								<?= old($entregable, 'descripcion') ?>
							</p>
						</div>
					</div>

					<div class="row">
						<div class="col ">
							<label>Instrucciones</label>
							<p class=" small" style="color: darkgray">
								<?= old($entregable, 'instrucciones') ?>
							</p>
						</div>
					</div>
					<?php if (isset($entregable->instrumentos) && sizeof($entregable->instrumentos) != 0): ?>
						<div class="row">
							<div class="col ">
								<label>Instrumentos </label><span class=" small" style="color: darkgray">(a los que aplica este entregable)</span>
								<ul>
									<?php foreach ($entregable->instrumentos as $instrumento): ?>
										<li><?= old($instrumento, 'actividad') ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($entregable->tipo_entregable == "prod") : ?>
						<div class="row">
							<div class="col-12">
								<label>Evidecias del candidato</label>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<?php if (!empty($entregable->archivos)): ?>
									<ul>
										<?php foreach ($entregable->archivos as $index_ae => $archivo): ?>
											<?php if (is_null($archivo->id_archivo_instrumento)): ?>
												<li><a href="<?= $archivo->url_video ?>"
													   target="_blank"><?= $archivo->url_video ?></a></li>
											<?php else: ?>
												<li>
													<a href="<?= base_url() . $archivo->ruta_directorio . $archivo->nombre ?>"
													   target="_blank"><?= $archivo->nombre ?></a></li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>


					<?php endif; ?>

					<div class="row">
						<div class="col-12">
							<label>Calificación Entregable</label>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<?php if ($entregable->id_estatus == ESTATUS_ENVIADA) :?>
								<div class="input-group mb-3">
									<input class="form-control input_calificacion <?=isset($entregable->entregable_wm) && $entregable->entregable_wm == 'si' ? 'input_calificacion_wm' :'input_calificacion_conocer'?>" type="number"
										id="input_calificacion_<?= $entregable->id_entregable ?>"
										placeholder="Agrega una calificación" aria-label="Calificación"
										aria-describedby="button-addon2" value="<?=isset($entregable->calificacion_entregable) ? $entregable->calificacion_entregable : ''?>" />
									<div class="input-group-append">
										<button type="button"
											class="btn btn-outline-success <?=isset($entregable->entregable_wm) && $entregable->entregable_wm == 'si' ? 'btn_calificacion_wm' :'btn_calificacion_conocer'?>"
											data-id_entregable="<?= $entregable->id_entregable ?>">
												<em class="fa fa-save"></em>
										</button>
									</div>
								</div>
							<?php else: ?>
								<input type="hidden" class="<?=isset($entregable->entregable_wm) && $entregable->entregable_wm == 'si' ? 'input_calificacion_wm' :'input_calificacion_conocer'?>" 
									value="<?=isset($entregable->calificacion_entregable) ? $entregable->calificacion_entregable : ''?>">
								<span><?=isset($entregable->calificacion_entregable) ? $entregable->calificacion_entregable : ''?></span>
							<?php endif; ?>
						</div>
					</div>

					<div class="row">
						<div id="contenedor_formulario_<?= $entregable->id_entregable ?>" class="col">

						</div>
					</div>

					<?php if ($entregable->id_estatus == ESTATUS_ENVIADA) :?>
						<div class="row">
							<div class="col-12">
								<div class="input-group mb-3">
									<textarea class="form-control"
									  	id="txt_comentarios_candidato_<?= $entregable->id_entregable ?>"
									  	placeholder="Agrega un comentario" aria-label="Comentario"
									  	aria-describedby="button-addon2"></textarea>
									<div class="input-group-append">
										<button
											class="btn btn-outline-success txt_guardar_comentario_instructor"
											type="button"
											data-id_body_comentarios="#tbody_comentario_candidato<?= $entregable->id_entregable ?>"
											data-id_entregable="<?= $entregable->id_entregable ?>"
											id="guardar_comentario"><em class="fa fa-save"></em></button>
									</div>
								</div>

							</div>
						</div>
					<?php endif;?>

					<div class="row">
						<div class="col-12">
							<table class="table table-striped">
								<thead>
								<tr>
									<th colspan="3">Comentario</th>
								</tr>
								</thead>
								<tbody id="tbody_comentario_candidato<?= $entregable->id_entregable ?>">
								<?php if (!empty($entregable->comentarios)): ?>
									<?php foreach ($entregable->comentarios as $comentario): ?>
										<td><?= old($comentario, 'quien') == 'instructor' ? 'Evaluador' : 'Candidato' ?></td>
										<td><?= old($comentario, 'comentario') ?></td>
										<td><?= old($comentario, 'fecha') ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>


					<div class="row form-group">
						<?php if ($entregable->tipo_entregable != "prod") : ?>
							<div class="col-12 mb-2 text-right">
								<?php if ($entregable->tipo_entregable == "form") : ?>
									<button class="btn btn-sm btn-primary mostrar_formulario"
											data-id_entregable="<?=$entregable->id_entregable?>"
											data-id_entregable_formulario="<?= $entregable->id_entregable_formulario?>"
											data-id_usuario="<?=$entregable->id_usuario?>"
									><em class="fa fa-eye"></em> Revisar respuestas</button>
								<?php endif; ?>
							</div>
							<?php if($entregable->tipo_entregable == 'cuest'): ?>
								<hr>
								<div class="col-12 table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>Inicio</th>
												<th>Fin</th>
												<th>Calificacion</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php if(isset($entregable->evaluacion) && is_array($entregable->evaluacion) && !empty($entregable->evaluacion)): ?>
												<?php foreach($entregable->evaluacion as $index => $eva): ?>
													<tr>
														<td><?=$index + 1?></td>
														<td><span><?=fechaHoraBDToHTML($eva->fecha_iniciada)?></span></td>
														<td><span><?=fechaHoraBDToHTML($eva->fecha_enviada)?></span></td>
														<td>
														<span class="span_calificacion_evidencia" data-calificacion="<?=$eva->calificacion?>"><?=$eva->calificacion?></span>
														</td>
														<td>
															<button class="btn btn-success btn-sm ver_evaluacion_respuestas_candidato"
																data-id_usuario_has_evaluacion_realizada="<?=$eva->id_usuario_has_evaluacion_realizada?>" >
																<i class="fa fa-clipboard-list"></i>Ver evaluación
															</button>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr >
													<td class="text-center" colspan="5">Sin evaluaciones registradas</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == 2) : ?>
							<div class="col-12" >
								<div class="callout callout-success">
									<h5>Aviso importante</h5>
									<p>Recuerde que puede realizar un comentario al candidato antes de liberar/rechazar su entregable</p>
								</div>
							</div>
							<div class="col-6 text-left">
								<button class="btn btn-sm btn-danger rechazar-entregable"
										data-id_entregable="<?= $entregable->id_entregable ?>"
										data-id_entregable_formulario="<?= $entregable->id_entregable_formulario ?>">
										<em class="fa fa-exclamation-circle"></em> Rechazar
								</button>
							</div>
							<div class="col-6 text-right">
								<button class="btn btn-sm btn-success liberar-entregable"
										data-id_entregable_formulario="<?= $entregable->id_entregable_formulario ?>"
										data-id_entregable="<?= $entregable->id_entregable ?>"><em
										class="fa fa-check-circle"></em> Liberar
								</button>
							</div>
						<?php endif; ?>

						<?php if ($entregable->id_estatus == ESTATUS_FINALIZADA) : ?>
							<div class="col-8" >
								<div class="callout callout-danger">
									<h5>Aviso importante</h5>
									<p>Recuerde que el entregable ya esta liberado, pero si encuentra una inconsistencia y debe volverla a revisar con el candidato, puede revertir este proceso y se marcará como enviada para que lo revise el evaluador</p>
								</div>
							</div>
							<div class="col-4 text-right">
								<button class="btn btn-sm btn-danger desliberar-entregable"
										data-id_entregable_formulario="<?= $entregable->id_entregable_formulario ?>"
										data-id_entregable="<?= $entregable->id_entregable ?>"><em
										class="fa fa-check-circle"></em> Volver a revisar
								</button>
							</div>
						<?php endif; ?>
					</div>

				</div>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
