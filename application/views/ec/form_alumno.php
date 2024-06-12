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
					<div class="form-group row" id="contenedor_asignar_modificar_candidato_ec" style="display: none;"></div>
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
											<small class="form-text text-muted">Evaluador asignado</small>
										</div>
										<div class="col-sm-4">
											<select class="custom-select" id="numero_registros_candidatos" data-rule-required="true">
												<option value="5">5</option>
												<option value="15">15</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
											<small class="form-text text-muted">Número de registros</small>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12 text-right">
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
														<th>#</th>
														<th>ID</th>
														<th>Candidato</th>
														<th>Evaluador</th>
														<th>Grupo</th>
														<th>
															<button class="btn btn-sm btn-outline-success" id="btn_asignar_candidato_estandar_competencia"><i class="fas fa-pluss"></i> Nueva asignación</button>
														</th>
													</tr>
													</thead>
													<tbody id="contenedor_resultados_usr_asignados">
														<?php $this->load->view('ec/rows_alumnos_asignados'); ?>
													</tbody>
													<tfoot >
														<tr id="contenedor_footer_usuarios_asignados" <?=$pagina_select == 1 && $paginas > 1 ? '':'style="display:none"' ?>>
															<td colspan="6" class="text-center">
																<button id="btn_buscar_mas_usr_candidatos_asignados" type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-arrow-down"></i>Mostrar Más</button>
																<i id="spinner_buscar_candidatos_asignados" class="fas fa-sync-alt fa-spin" style="display:none"></i>
															</td>
														</tr>
														<tr>
															<td colspan="6" class="text-center">
																<span>Total de registros: </span><span id="numero_registros_candidatos_registrados" class="badge badge-success"><?=$total_registros?></span>
															</td>
														</tr>
													</tfoot>

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
								<li>Las actividades, tecnicas e instrumentos de evaluación <span class="badge badge-dark"><?=isset($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0 && $estandar_competencia_instrumento ? 'OK':'Falta'?></span></li>
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
