<div class="modal fade" id="modal_evidencia_evaluacion_modulo" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="titulo_modal_evidencia">Evaluación de(los) módulos de capacitación</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="col-12" id="modal_tablero_evaluacion_diagnostica">
					<div class="card">
						<div class="card-body table-responsive p-0">
							<table class="table table-striped">
								<thead>
								<tr>
									<th>Curso - Módulo</th>
									<th>Titulo evaluación</th>
									<th>
										Tiempo
										<small class="form-text text-muted">En minutos</small>
									</th>
									<th>Fecha</th>
									<th>
										Calificación
										<small class="form-text text-muted">Se tomará la más alta</small>
									</th>
									<th>Evaluación</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
								<?php if(isset($evaluacion_modulo_usuario)): ?>
									<?php foreach ($evaluacion_modulo_usuario as $index => $emu):?>
										<tr>
											<td>
												<?=$emu->nombre_curso?> - <?=$emu->descripcion_modulo?>
											</td>
											<td><?=$emu->titulo?></td>
											<td><?=$emu->tiempo != 0 && $emu->tiempo != '' ? $emu->tiempo : 'N/A'?></td>
											<td>
												Inicio: <span><?=fechaHoraBDToHTML($emu->fecha_iniciada)?></span><br>
												Fin: <span><?=fechaHoraBDToHTML($emu->fecha_enviada)?></span>
											</td>
											<td>
											<span class="span_calificacion_evidencia" data-calificacion="<?=$emu->calificacion?>"><?=$emu->calificacion?></span>
											</td>
											<td style="max-width: 150px">
												<?php if(isset($usuario) && in_array($usuario->perfil,array('instructor','admin'))): ?>
													<button type="button" class="btn btn-sm btn-success buscar_preguntas_evaluacion"
															data-id_evaluacion="<?=$emu->id_evaluacion?>">
														<i class="fa fa-clipboard-list"></i> Ver preguntas
													</button>
												<?php endif; ?>
												
												<button data-id_usuario_has_evaluacion_realizada="<?=$emu->id_usuario_has_evaluacion_realizada?>" class="btn btn-success btn-sm ver_evaluacion_respuestas_candidato">
													<i class="fa fa-clipboard-list"></i>Ver evaluación
												</button>
											</td>
											<td></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div id="contenedor_preguntas_preview" class="form-group row" style="display: none">
					<div class="col-md-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Preguntas/Respuestas de la EC</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="form-group row" id="card_body_preguntas_preview">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
