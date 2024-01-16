<div class="modal fade" id="modal_form_empresa" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($datos_empresa) ? 'Actualizar':'Nueva'?> empresa</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_empresa">
				<div class="modal-body">
					<div class="form-group row" id="contenedor_mensaje_empresa_encontrada" style="display: none;" >
						<div class="col-lg-12" >
							<div class="callout callout-success">
								<h5>Mensaje del sistema</h5>
								<p>Detectamos en el sistema, que ya existe un registro de una empresa con el RFC proprocionado, se precargará en el formulario los datos y de clic en el botón de guardar</p>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="input_rfc" class="col-sm-3 col-form-label">RFC</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_rfc" data-rule-required="true" name="rfc" placeholder="RFC (YYY010101123)" value="<?=isset($datos_empresa) ? $datos_empresa->rfc : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Nombre</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_nombre" data-rule-required="true"
								   name="nombre" placeholder="Nombre de la la empresa" value="<?=isset($datos_empresa) ? $datos_empresa->nombre : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre_corto" class="col-sm-3 col-form-label">Nombre corto</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_nombre_corto" data-rule-required="true"
								   name="nombre_corto" placeholder="Nombre corto de la la empresa" value="<?=isset($datos_empresa) ? $datos_empresa->nombre_corto : ''?>">
						</div>
						
					</div>
					<div class="form-group row">
						<label for="input_telefono" class="col-sm-3 col-form-label">Teléfono</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="input_telefono" data-rule-required="true" 
								   name="telefono" placeholder="Teléfono de la la empresa" value="<?=isset($datos_empresa) ? $datos_empresa->telefono : ''?>">
						</div>
						<label for="input_correo" class="col-sm-3 col-form-label">Correo</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="input_correo" data-rule-required="true" name="correo" placeholder="Correo" value="<?=isset($datos_empresa) ? $datos_empresa->correo : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_representante_legal" class="col-sm-3 col-form-label">Representante legal</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="input_representante_legal" data-rule-required="true" 
								   name="representante_legal" placeholder="Representante legal de la la empresa" value="<?=isset($datos_empresa) ? $datos_empresa->representante_legal : ''?>">
						</div>
						<label for="input_representante_trabajadores" class="col-sm-3 col-form-label">Representante de trabajadores</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="input_representante_trabajadores" data-rule-required="true" name="representante_trabajadores" placeholder="Representante de trabajadores" value="<?=isset($datos_empresa) ? $datos_empresa->representante_trabajadores : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_domicilio" class="col-sm-3 col-form-label">Domicilio</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_domicilio" data-rule-required="true"
								   name="domicilio_fiscal" placeholder="Domicilio de la empresa" value="<?=isset($datos_empresa) ? $datos_empresa->domicilio_fiscal : ''?>">
						</div>
					</div>

					<div class="form-group row" id="contenedor_puesto_empresa">
						<label for="input_cargo" class="col-sm-3 col-form-label">Puesto</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_cargo" data-rule-required="true"
								   name="cargo" placeholder="Puesto que desempeña" value="<?=isset($datos_empresa) ? $datos_empresa->cargo : ''?>">
						</div>
					</div>

					<div class="form-group row">
						<label for="input_vigente_si" class="col-sm-3 col-form-label input_empresa_actual_usuario">¿La empresa es de su trabajo actual?</label>
						<div class="col-sm-3 input_empresa_actual_usuario">
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" data-rule-required="true" id="input_vigente_si" name="vigente"
									   value="si" <?=isset($datos_empresa) && $datos_empresa->vigente == 'si' ? 'checked="checked"':''?>>
								<label for="input_vigente_si" class="custom-control-label">Si</label>
							</div>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" id="input_vigente_no" name="vigente" value="no" <?=isset($datos_empresa) && $datos_empresa->vigente == 'no' ? 'checked="checked"':''?>>
								<label for="input_vigente_no" class="custom-control-label">No</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="img_logotipo_emp" class="col-sm-3 col-form-label">Logotipo:</label>
								<input type="hidden" id="input_id_archivo_logotipo" name="id_archivo_logotipo" value="<?=isset($datos_empresa) ? $datos_empresa->id_archivo_logotipo : ''?>">
								<input type="file" id="img_logotipo_emp" name="img_logotipo_emp" class="col-sm-3" accept="image/*" >
								<div id="procesando_img_logotipo_emp" class="col-sm-6">
									<?php if(isset($archivo_logotipo) && !is_null($archivo_logotipo)): ?>
										<img src="<?=base_url().$archivo_logotipo->ruta_directorio.$archivo_logotipo->nombre?>" alt="Imágen logotipo empresa" style="max-width: 120px" class="img-fluid img-thumbnail">
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row" id="contenedor_empresa_categoria_admin" style="display: none;" >
						<label for="input_id_cat_categoria_empresa" class="col-sm-3 col-form-label">¿Categoria o especialidad?</label>
						<div class="col-sm-9">
							<select class="custom-select" id="input_id_cat_categoria_empresa" data-rule-required="true" name="id_cat_categoria_empresa">
								<option value="">--Seleccione--</option>
								<?php foreach ($cat_categoria_empresa as $cce): ?>
									<option value="<?=$cce->id_cat_categoria_empresa?>" <?=isset($datos_empresa->id_cat_categoria_empresa) && $datos_empresa->id_cat_categoria_empresa == $cce->id_cat_categoria_empresa ? 'selected="selected"':'' ?> ><?=$cce->nombre?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_empresa" data-id_usuario="<?=$id_usuario?>"
							data-id_datos_empresa="<?=isset($datos_empresa) ? $datos_empresa->id_datos_empresa : ''?>" class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
