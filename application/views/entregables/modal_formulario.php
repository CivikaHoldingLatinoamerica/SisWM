<div class="modal fade" id="modal_form_entregable" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= isset($entregable) ? 'Modificar Entregable' : 'Agregar Entregable' ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<form id="form_agregar_modificar_entregable">
				<input hidden name="id_cat_sector_ec" value="<?= isset($entregable) ? $entregable->id : '' ?>">
				<div class="modal-body">
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Nombre</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_nombre" data-rule-required="true"
								   name="nombre" placeholder="Nombre del entregable"
								   value="<?= isset($entregable) ? $entregable->nombre : '' ?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Descripción</label>
						<div class="col-sm-9">
							<textarea type="text" class="form-control" id="descripcion" data-rule-required="true"
								   name="descripcion" placeholder="Descripción del entregable"
									  value="<?= isset($entregable) ? $entregable->descripcion : '' ?>"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Tipo de entregable</label>
						<div class="col-sm-9">
							<select type="text" class="form-control" id="tipo_entregable" data-rule-required="true"
								   name="tipo_entregable"
									value="<?= isset($entregable) ? $entregable->tipo_entregable : '' ?>">
								<option>Seleccione una opción</option>
								<option>Producto (archivo)</option>
								<option>Formulario</option>
								<option>Cuestionario</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Intrumentos</label>
						<div class="col-sm-9">
							<label for="instrumentos"></label>
							<select multiple="multiple" class="form-control" id="instrumentos" name="instrumentos[]">
								<option>Orden. Guía de observación</option>
								<option> La carta descriptiva elaborada</option>
								<option> El objetivo general del curso redactado</option>
								<option> Los objetivos particulares y/o específicos elaborados</option>
								<option> Los temas y subtemas definidos</option>
								<option> Las técnicas de instrucción seleccionadas</option>
								<option> Las técnicas grupales seleccionadas</option>
								<option> Las actividades del proceso de instrucción aprendizaje definidas</option>
							</select>
							<small id="emailHelp" class="form-text text-muted">Precione la tecla CTRL para seleccionar más de una opción</small>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_entregable"
							data-modificacion_from_perfil="<?= isset($modificacion_from_perfil) ? $modificacion_from_perfil : 'no' ?>"
							class="btn btn-sm btn-outline-primary">Guardar
					</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
