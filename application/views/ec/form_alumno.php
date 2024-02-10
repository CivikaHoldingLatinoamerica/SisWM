<div class="modal fade" id="modal_form_alumno_ec" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
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
									<div class="form-group row">
										<div class="col-sm-12">
											<div class="input-group">
												<input type="text" id="input_buscar_candidatos_para_asignar_ec" class="form-control form-control-lg" 
													name="busqueda_usr_candidatos" placeholder="Escribe algo para buscar">
												<div class="input-group-append">
													<button type="button" id="btn_buscar_usr_candidatos_para_asignar" class="btn btn-sm btn-default">
														<i class="fa fa-search"></i>
													</button>
												</div>
											</div>
											<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos, correo, telefono o CURP; cuando termines pulsa en el boton del icono de buscar</small>
											<span class="badge badge-danger">Solo apareceran candidatos no asigandos al EC</span>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<div class="input-group">
												<input type="text" id="input_buscar_candidatos_para_asignar_ec" class="form-control form-control-lg" 
													name="busqueda_usr_candidatos" placeholder="Escribe algo para buscar">
												<div class="input-group-append">
													<button type="button" id="btn_buscar_usr_candidatos_para_asignar" class="btn btn-sm btn-default">
														<i class="fa fa-search"></i>
													</button>
												</div>
											</div>
											<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos, correo, telefono o CURP; cuando termines pulsa en el boton del icono de buscar</small>
											<span class="badge badge-danger">Solo apareceran candidatos no asigandos al EC</span>
										</div>
									</div>
								</div>
								<div class="card-footer text-right">
									<button type="button" id="btn_cancelar_asingar_candidato_ec" class="btn btn-sm btn-outline-danger">Cancelar</button>
									<button type="button" id="btn_guardar_asignar_candidato_ec" class="btn btn-sm btn-outline-success">Aceptar</button>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row" id="contenedor_listado_candidatos_asignados_ec">
						<div class="col-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Candidatos asignados</h3>
								</div>
								<div class="card-body">
									<div class="form-group row">
										<div class="col-sm-4">
											<input type="text" id="input_buscar_candidatos_asignados_ec" class="form-control form-control" placeholder="Escribe algo para buscar">
											<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos, correo, telefono o CURP; cuando termines pulsa en el boton del icono de buscar</small>
										</div>
										<div class="col-sm-4">
											<select class="custom-select" id="input_buscar_evaluador_asigando" data-rule-required="true">
												<option value="">--Todos--</option>
												<?php foreach ($instructores_asignados as $ia): ?>
													<option value="<?=$ia->id_usuario?>" ><?=$ia->nombre.' '.$ia->apellido_p.' '.$ia->apellido_m?></option>
												<?php endforeach; ?>
											</select>
											<small class="form-text text-muted">Instructor asignado</small>
										</div>
										<div class="col-sm-4 text-right">
											<button type="button" id="btn_buscar_usr_candidatos_asignados" class="btn btn-sm btn-primary">
												<i class="fa fa-search"></i> Buscar
											</button>
										</div>
									</div>
									<hr>
									<div class="form-group row">
										<div class="col-sm-12">
											<div class="table-responsive p-0">
												<table class="table table-striped">
													<thead>
													<tr>
														<th>Candidato</th>
														<th>Evaluador</th>
														<th>
															<button class="btn btn-sm btn-outline-success" id="btn_asingar_candidato_estandar_competencia"><i class="fas fa-pluss"></i> Nueva asignación</button>
														</th>
													</tr>
													</thead>
													<tbody id="contenedor_resultados_usr_asignados">
														<?php $this->load->view('ec/rows_alumnos_asignados'); ?>
													</tbody>
												</table>
											</div>
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
				<button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal">Cerrar</button>
			</div>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
