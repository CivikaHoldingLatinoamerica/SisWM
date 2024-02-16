<div class="col-12">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Registrar candidato al EC</h3>
		</div>
		<div class="card-body">
			<form id="registar_modificar_candidato_ec">
				<div class="form-group row">
					<div class="col-lg-4">
						<label>Candidato:</label>
					</div>
					<div class="col-lg-8">
						<select name="id_usuario" class="select2" data-placeholder="--Seleccione candidato--" data-rule-required="true" style="width: 100%; ">
							<option value="">--Seleccione Candidato--</option>
							<?php foreach ($candidatos_disponible as $u): ?>
								<option value="<?=$u->id_usuario?>"><?=$u->curp. ' - '.$u->nombre.' '.$u->apellido_p.' '.$u->apellido_m?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-4">
						<label>Evaluador:</label>
					</div>
					<div class="col-lg-8">
						<select name="id_usuario_evaluador" class="select2" data-placeholder="--Seleccione evaluador--" data-rule-required="true" style="width: 100%;">
							<option value="">--Seleccione evaluador--</option>
							<?php foreach ($instructores_asignados as $u): ?>
								<option value="<?=$u->id_usuario?>"><?=$u->nombre.' '.$u->apellido_p.' '.$u->apellido_m?></option>
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
