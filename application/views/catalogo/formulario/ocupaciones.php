<div class="modal fade" id="modal_form_ocupacion" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= isset($sector) ? 'Modificar ocupación especifica' : 'Agregar ocupación especifica' ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<form id="form_agregar_modificar_ocupacion">
				
				<div class="modal-body">
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Nombre</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_nombre" data-rule-required="true"
								   name="nombre" placeholder="Nombre la ocupación especifica"
								   value="">
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_ocupacion" class="btn btn-sm btn-outline-primary">Guardar
					</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
