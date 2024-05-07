<div class="modal fade" id="modal_proceso_certificacion_ec_candidato" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Certificación del estandar de competencia</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<?php if(isset($usuario_has_estandar_competencia->id_cat_calibracion_desempeno) && (int)$usuario_has_estandar_competencia->id_cat_calibracion_desempeno < JUICIO_CALIFICADO): ?>
						<div class="col-lg-12">
							<div class="alert alert-danger">Candidato aun no calificado</div>
						</div>
					<?php else: ?>
						<!-- apartado para calificaciones de wm -->
						<div class="col-lg-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Calificaciones de entregables WM</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<div class="card">
												<div class="card-body table-responsive p-0">
													<table class="table table-striped">
														<thead>
														<tr>
															<th>#</th>
															<th>Entregable WM</th>
															<th>Descripción</th>
															<th>Calificación</th>
														</tr>
														</thead>
														<tbody >
															<?php if(isset($entregables) && is_array($entregables) && sizeof($entregables)>0): ?>
																<?php $total = 0; ?>
																<?php foreach($entregables as $index => $e): ?>
																	<?php $total += (float)$e->calificacion_entregable; ?>
																	<tr>
																		<td><?=$index+1?></td>
																		<td><?=$e->nombre_entregable?></td>
																		<td><?=$e->descripcion?></td>
																		<td><span><?=$e->calificacion_entregable?></span></td>
																	</tr>
																<?php endforeach; ?>
																<tr>
																	<td colspan="3" class="text-right">Total:</td>
																	<td><?=number_format($total,2)?></td>
																</tr>
															<?php endif; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- apartado para el ped destinado de walmart -->
						<div class="col-lg-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Portafolio de evidencias Wal-mart</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>

								<div class="card-body">								
									<iframe src="<?=base_url().$portafolio_evidencias_wm->ruta_directorio.$portafolio_evidencias_wm->nombre?>" style="width: 100%; min-height: 300px; max-height: 600px"></iframe>
								</div>
							</div>
						</div>
					<?php endif; ?>
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
