<div class="modal fade" id="modal_form_grupo_ec" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($estandar_competencia_grupo_grupo) ? 'Actualizar':'Nuevo'?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			
				<div class="modal-body">
					
					<!-- seccion para el formulario de registro de grupos -->
					<div class="form-group row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<label class="modal-title">Formulario del grupo</label>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-plus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<form id="form_agregar_modificar_ec_grupo">
										<input type="hidden" name="id_estandar_competencia" value="<?=$id_estandar_compentencia?>">
										<div class="form-group row">
											<label for="input_clave_grupo" class="col-sm-3 col-form-label">Clave del grupo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="input_clave_grupo" data-rule-required="true"
													name="clave_grupo" placeholder="Clave del grupo" value="<?=isset($estandar_competencia_grupo) ? $estandar_competencia_grupo->clave_grupo : ''?>">
											</div>
										</div>

										<div class="form-group row">
											<label for="input_nombre_grupo" class="col-sm-3 col-form-label">Nombre del grupo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="input_nombre_grupo" data-rule-required="true"
													name="nombre_grupo" placeholder="Nombre del grupo" value="<?=isset($estandar_competencia_grupo) ? $estandar_competencia_grupo->nombre_grupo : ''?>">
											</div>
										</div>

										<div class="form-group row">
											<label for="input_duracion" class="col-sm-3 col-form-label">Duración</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="input_duracion" data-rule-required="true"
													name="duracion" placeholder="Duración del curso de certificación del EC" value="<?=isset($estandar_competencia_grupo) ? $estandar_competencia_grupo->duracion : ''?>">
											</div>
										</div>
										
										<div class="form-group row">
											<label for="input_periodo_inicio" class="col-sm-3 col-form-label">Inicio</label>
											<div class="col-sm-9">
												<input type="date" class="form-control" id="input_periodo_inicio" data-rule-required="true"
													name="periodo_inicio" placeholder="Inicio del periodo del EC" value="<?=isset($estandar_competencia_grupo) ? $estandar_competencia_grupo->periodo_inicio : ''?>">
											</div>
										</div>
										
										<div class="form-group row">
											<label for="input_periodo_fin" class="col-sm-3 col-form-label">Fin</label>
											<div class="col-sm-9">
												<input type="date" class="form-control" id="input_periodo_fin" data-rule-required="true"
													name="periodo_fin" placeholder="Fin del periodo del EC" value="<?=isset($estandar_competencia_grupo) ? $estandar_competencia_grupo->periodo_fin : ''?>">
											</div>
										</div>

										<div class="form-group row">
											<label for="input_agente_capacitador" class="col-sm-3 col-form-label">Agente capacidator</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="input_agente_capacitador" data-rule-required="true"
													name="agente_capacitador" placeholder="Nombre del agente capacitador" value="<?=isset($estandar_competencia_grupo) ? $estandar_competencia_grupo->agente_capacitador : 'Civika Holding Latinoamérica S.A. de C.V. (CHL111213MX1-0013)'?>">
											</div>
										</div>

										<div class="form-group row">
											<label for="input_duracion" class="col-sm-3 col-form-label">Área temática</label>
											<div class="col-sm-9">
												<select id="instructores_alumnos_disponibles" multiple class="custom-select form-control-border slt_instructor_alumno_ec"
														data-tipo="<?=$tipo?>"
														name="instructor_alumno_id_usuario">
													<option value="">--Seleccione--</option>
													<?php foreach($cat_area_tematica as $cat): ?>
														<option value="<?=$cat->id_cat_area_tematica?>"><?=$cat->area_tematica?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										
										<div class="form-group row">
											<div class="col-sm-12 text-right">
												<button id="btn_guardar_ec_grupo" class="btn btn-sm btn-outline-success" type="button">Guardar</button>
											</div>
										</div>
									</form>
									
								</div>
							</div>
						</div>
					</div>
					
					<!-- end seccion form registro grupo -->

					<!-- seccion grupos agregados -->
					<div class="form-group row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<label class="modal-title">Formulario del grupo</label>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-plus"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<div class="form-group row">
										<div class="card col-sm-12">
											<div class="card-body table-responsive p-0">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>Grupo</th>
															<th>Periodo</th>
															<th>Agente</th>
															<th>Área Temática</th>
															<th></th>
														</tr>
													</thead>
													<tbody id="contenedor_tbody_grupos_ec"></tbody>
													<?php if(isset($estandar_competencia_grupo) && is_array($estandar_competencia_grupo) && sizeof($estandar_competencia_grupo) != 0): ?>
														<?php foreach($estandar_competencia_grupo as $index=> $ecg): ?>
															<tr>
																<td>
																	<?=$ecg->clave_grupo.' - '.$ecg->nombre_grupo?>
																</td>
																<td>
																	<?=$ecg->duracion?>
																</td>
																<td>
																	Del <?=fechaBDToHtml($ecg->periodo_inicio)?> al <?=fechaBDToHtml($ecg->periodo_fin)?>
																</td>
																<td>
																	<?=$ecg->cat_area_tematica?>
																</td>
																<td>
																	<button type="button"
																		data-obj_ec_grupo="<?=base64_encode(json_encode($ecg))?>"
																		data-toggle="tooltip" title="Modificar estandar"
																		class="btn btn-sm btn-outline-primary modificar_estandar_competencia_grupo"><i class="fa fa-edit"></i> Editar</button>
																	<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
																			data-toggle="tooltip" title="Eliminar Estándar Competencia Grupo"
																			data-msg_confirmacion_general="¿Esta seguro de eliminar el grupo estándar de competencia?, esta acción no podrá revertirse"
																			data-url_confirmacion_general="<?=base_url()?>ec_grupo_eliminar/<?=$ecg->id_estandar_competencia_grupos?>"
																			data-btn_trigger="#btn_buscar_estandar_competencia_grupos">
																		<i class="fas fa-trash"></i> Eliminar
																	</button>
																</td>
															</tr>
														<?php endforeach;?>
													<?php else: ?>
														<tr>
															<td colspan="5" class="text-center">
																Sin registros encontrados
															</td>
														</tr>
													<?php endif; ?>
												</table>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END seccion grupos agregados -->
					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
					
				</div>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
