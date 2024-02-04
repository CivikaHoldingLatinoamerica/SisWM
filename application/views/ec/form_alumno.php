<div class="modal fade" id="modal_form_alumno_ec" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Candidatos en el EC</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			
			<!-- tablero alumnos registrados -->
			<div class="modal-body">
				<?php if((isset($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0
							&& isset($instructores_asignados) && sizeof($instructores_asignados) != 0)): ?>
					<input type="hidden" id="id_estandar_competencia_asignar" value="<?=$id_estandar_competencia?>">
					<div class="form-group row" id="contenedor_asignar_candidato_ec" style="display: none;">
						<div class="col-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Registrar candidato al EC</h3>
								</div>
								<div class="card-body">

								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Candidatos asignados</h3>
								</div>
								<div class="card-body">
									<div class="form-group row">
										<div class="col-sm-6">
											<div class="input-group">
												<input type="text" id="input_buscar_candidatos_por_asignar_ec" class="form-control form-control-lg" 
													name="busqueda_usr_candidatos" placeholder="Escribe algo para buscar">
												<div class="input-group-append">
													<button type="button" id="btn_buscar_usr_candidatos_asignar" class="btn btn-sm btn-default">
														<i class="fa fa-search"></i>
													</button>
												</div>
											</div>
											<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos, correo, telefono o CURP; cuando termines pulsa en el boton del icono de buscar</small>
										</div>
										<div class="col-sm-6 text-right">
											<button class="btn btn-sm btn-outline-success" ><i class="fas fa-pluss"></i> Nueva asignación</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php else: ?>
					<div class="modal-body">
						<div class="callout callout-danger">
							<h5>Lo siento</h5>
							<p>Para poder asignar los alumnos es necesario que registre:</p>
							<ol>
								<li>Las actividades, tecnicas e instrumentos de evaluación <span class="badge badge-dark"><?=isset($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0 && $evaluacion_instrumento_liberados ? 'OK':'Falta'?></span></li>
								<li>Los requerimientos de evaluación <span class="badge badge-dark"><?=isset($estandar_competencia_has_requerimientos) && sizeof($estandar_competencia_has_requerimientos) != 0 ? 'OK':'Falta'?></span></li>
								<li>La evaluación diagnóstica liberada <span class="badge badge-dark"><?=isset($estandar_competencia_evaluacion) && is_object($estandar_competencia_evaluacion) != 0 ? 'OK':'Falta'?></span></li>
								<li>Asignar por lo menos un evaluador al Estándar de competencia <span class="badge badge-dark"><?=isset($instructores_asignados) && sizeof($instructores_asignados) != 0 ? 'OK':'Falta'?></span></li>
							</ol>
						</div>
					</div>
					
				<?php endif; ?>
			</div>

			<div class="modal-footer text-right">
				<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cerrar</button>
			</div>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
