<div class="col-12">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Registrar candidato al EC</h3>
		</div>
		<div class="card-body">
			<form id="form_registar_modificar_candidato_ec">
				<input type="hidden" name="id_estandar_competencia" value="<?=$id_estandar_competencia?>">
				<?php if(isset($usuario_has_estandar_competencia)): ?>
					<input type="hidden" name="id_usuario_has_estandar_competencia" value="<?=$usuario_has_estandar_competencia->id_usuario_has_estandar_competencia?>">
					<div class="form-group row">
						<div class="col-lg-4">
							<label>Candidato:</label>
						</div>
						<div class="col-lg-8">
							<span id="span_usuario_candidato"></span>
						</div>
					</div>
				<?php else: ?>
					<div class="form-group row">
						<div class="col-lg-4">
							<label>Candidato:</label>
						</div>
						<div class="col-lg-8">
							<select id="input_id_usuario_asignar" name="id_usuario" class="select2" data-placeholder="--Seleccione candidato--" data-rule-required="true" style="width: 100%; ">
								<option value="">--Seleccione Candidato--</option>
								<?php foreach ($candidatos_disponible as $u): ?>
									<option value="<?=$u->id_usuario?>"><?=$u->curp. ' - '.$u->nombre.' '.$u->apellido_p.' '.$u->apellido_m?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				<?php endif; ?>
				<div class="form-group row">
					<div class="col-lg-4">
						<label>Evaluador:</label>
					</div>
					<div class="col-lg-8">
						<select name="id_usuario_evaluador" class="custom-select" data-placeholder="--Seleccione evaluador--" data-rule-required="true" style="width: 100%;">
							<option value="">--Seleccione evaluador--</option>
							<?php foreach ($instructores_asignados as $u): ?>
								<option value="<?=$u->id_usuario?>" <?=isset($usuario_has_estandar_competencia) && $usuario_has_estandar_competencia->id_usuario_evaluador == $u->id_usuario ? 'selected="selected"':''?>><?=$u->nombre.' '.$u->apellido_p.' '.$u->apellido_m?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-4">
						<label>Grupo:</label>
					</div>
					<div class="col-lg-8">
						<select name="id_estandar_competencia_grupo" class="custom-select" data-rule-required="true" style="width: 100%;">
							<option value="">--Selecciona grupo--</option>
							<?php foreach ($estandar_competencia_grupo as $ecg): ?>
								<option value="<?=$ecg->id_estandar_competencia_grupo?>" <?=isset($usuario_has_estandar_competencia) && $usuario_has_estandar_competencia->id_estandar_competencia_grupo == $ecg->id_estandar_competencia_grupo ? 'selected="selected"':''?>><?=$ecg->clave_grupo.' - '.$ecg->nombre_grupo?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</form>
			<div class="form-group row">
				
			</div>
		</div>
		<div class="card-footer text-right">
			<button type="button" id="btn_cancelar_asingar_candidato_ec" class="btn btn-sm btn-outline-danger">Cancelar</button>
			<button type="button" id="btn_guardar_asignar_candidato_ec" class="btn btn-sm btn-outline-success">Aceptar</button>
		</div>
	</div>
</div>
