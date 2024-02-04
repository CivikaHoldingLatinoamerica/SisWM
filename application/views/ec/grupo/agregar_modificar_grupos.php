<div class="modal fade" id="modal_form_grupo_ec" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($estandar_competencia_grupo) ? 'Actualizar':'Nuevo'?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			
				<div class="modal-body">
					
					<!-- seccion para el formulario de registro de grupos -->
					<form id="form_agregar_modificar_ec_grupo">
						<input type="hidden" name="id_estandar_competencia" value="<?=$id_estandar_competencia?>">
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
							<label for="input_duracion" class="col-sm-3 col-form-label">Duración (hrs)</label>
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
							<label for="input_cat_area_tematica" class="col-sm-3 col-form-label">Área temática</label>
							<div class="col-sm-9">
								<select id="input_cat_area_tematica" class="custom-select form-control-border"
										name="id_cat_area_tematica">
									<option value="">--Seleccione--</option>
									<?php foreach($cat_area_tematica as $cat): ?>
										<option value="<?=$cat->id_cat_area_tematica?>" <?=isset($estandar_competencia_grupo) && $estandar_competencia_grupo->id_cat_area_tematica == $cat->id_cat_area_tematica ? 'selected="selected"' : ''?>><?=$cat->area_tematica?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-sm-12 text-right">
								
							</div>
						</div>
					</form>
					
					<!-- end seccion form registro grupo -->
					
				</div>

				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button id="btn_guardar_ec_grupo" 
						data-id_estandar_competencia_grupo="<?=isset($estandar_competencia_grupo) ? $estandar_competencia_grupo->id_estandar_competencia_grupo : ''?>" 
						class="btn btn-sm btn-outline-success" type="button">Guardar</button>
				</div>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
