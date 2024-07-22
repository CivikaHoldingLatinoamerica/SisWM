<div class="modal fade" id="modal_expediente_candidato" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Expediente digial del candidato</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="id_estandar_competencia" value="<?=$id_estandar_compentencia?>">
				<input type="hidden" id="id_usuario_alumno" value="<?=$id_usuario_alumno?>">
				<div class="form-group row">
					<label class="col-lg-3">Alumno:</label>
					<span class="col-lg-3"><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?></span>
					<label class="col-lg-3">CURP:</label>
					<span class="col-lg-3"><?=$usuario_alumno->curp?></span>
				</div>
				<div class="form-group row">
					<div class="col-lg-12">
						<div class="alert alert-light">
							Cargue el archivo PDF correspondiente a cada unos de los archivos, si cargó uno y no corresponde puede adjuntar otro nuevamente y se actualizará de forma automática en el sistema
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-3">Ficha de registro</label>
					<div class="col-lg-9" id="contenedor_ficha_registro">
						<div class="form-group row">
							<div class="col-md-4 contenedor_file_input_pdf">
								<input type="file" id="doc_ficha_registro_pdf" name="doc_ficha_registro_pdf"
									   data-div_procesando="#procesando_doc_ficha_registro_pdf" accept="application/pdf" class="doc_ficha_registro_pdf">
								<div id="procesando_doc_ficha_registro_pdf"></div>
							</div>
							<div class="col-md-8" id="contenedor_doc_ficha_registro_pdf">
								<?php if(isset($ficha_registro_pdf) && is_object($ficha_registro_pdf)): ?>
									<ul>
										<li>Expediente PDF: <?=$ficha_registro_pdf->nombre?></li>
										<li>Fecha de carga: <?=fechaHoraBDToHTML($ficha_registro_pdf->fecha)?></li>

										<li>
											<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
											   href="<?=base_url().$ficha_registro_pdf->ruta_directorio.$ficha_registro_pdf->nombre?>">
												<i class="fa fa-eye"></i> Ver archivo
											</a>
										</li>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<label class="col-lg-3">Instrumento de evaluación de competencia</label>
					<div class="col-lg-9" id="contenedor_instrumento_evaluacion">
						<div class="form-group row">
							<div class="col-md-4 contenedor_file_input_pdf">
								<input type="file" id="doc_instrumento_evaluacion_pdf" name="doc_instrumento_evaluacion_pdf"
									   data-div_procesando="#procesando_doc_instrumento_evaluacion_pdf" accept="application/pdf" class="doc_instrumento_evaluacion_pdf">
								<div id="procesando_doc_instrumento_evaluacion_pdf"></div>
							</div>
							<div class="col-md-8" id="contenedor_doc_instrumento_evaluacion_pdf">
								<?php if(isset($instrumento_evaluacion_pdf) && is_object($instrumento_evaluacion_pdf)): ?>
									<ul>
										<li>Expediente PDF: <?=$instrumento_evaluacion_pdf->nombre?></li>
										<li>Fecha de carga: <?=fechaHoraBDToHTML($instrumento_evaluacion_pdf->fecha)?></li>

										<li>
											<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
											   href="<?=base_url().$instrumento_evaluacion_pdf->ruta_directorio.$instrumento_evaluacion_pdf->nombre?>">
												<i class="fa fa-eye"></i> Ver archivo
											</a>
										</li>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<label class="col-lg-3">Certificado de competencia laboral en la EC</label>
					<div class="col-lg-9" id="contenedor_certificado_laboral">
						<div class="form-group row">
							<div class="col-md-4 contenedor_file_input_pdf">
								<input type="file" id="doc_certificado_laboral_pdf" name="doc_certificado_laboral_pdf"
									   data-div_procesando="#procesando_doc_certificado_laboral_pdf" accept="application/pdf" class="doc_certificado_laboral_pdf">
								<div id="procesando_doc_certificado_laboral_pdf"></div>
							</div>
							<div class="col-md-8" id="contenedor_doc_certificado_laboral_pdf">
								<?php if(isset($certificado_laboral_pdf) && is_object($certificado_laboral_pdf)): ?>
									<ul>
										<li>Expediente PDF: <?=$certificado_laboral_pdf->nombre?></li>
										<li>Fecha de carga: <?=fechaHoraBDToHTML($certificado_laboral_pdf->fecha)?></li>

										<li>
											<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
											   href="<?=base_url().$certificado_laboral_pdf->ruta_directorio.$certificado_laboral_pdf->nombre?>">
												<i class="fa fa-eye"></i> Ver archivo
											</a>
										</li>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Certificado DC3</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group row">
								<?php if(isset($constancia_dc3) && !is_null($constancia_dc3)): ?>
									<div class="col-lg-12" id="contenedor_mensaje_actualizar_dc3">
										<span>La constancia presente se generó con los datos a la fecha de <?=fechaBDToHtml($constancia_dc3->fecha)?>;</span>
										<label>¿Desea generarla nuevamente con los datos a la fecha de hoy, recuerdo que esto no es reversible?</label>
										<button type="button" id="btn_actualizar_dc3" data-id_usuario_has_estandar_competencia="<?=$usuario_has_ec->id_usuario_has_estandar_competencia?>"
											class="btn btn-sm btn-outline-success">Actualizar constancia DC3</button>
									</div>
									<div class="col-lg-12" id="contenedor_iframe_dc3">
										<iframe src="<?=base_url().$constancia_dc3->ruta_directorio.$constancia_dc3->nombre?>" style="width: 100%; min-height: 300px; max-height: 600px"></iframe>
									</div>
								<?php else: ?>
									<div class="col-lg-12">
										<iframe src="<?=base_url().'constancia_dc3/'.$usuario_has_ec->id_usuario_has_estandar_competencia?>" style="width: 100%; min-height: 300px; max-height: 600px"></iframe>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>

				</div>

				<div class="col-lg-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Gafete Wal-Mart</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>

						<div class="card-body">


							<div class="form-group row">
								<iframe src="<?=base_url().'gafete_sewm/'.$usuario_has_ec->id_usuario_has_estandar_competencia?>" style="width: 100%; min-height: 300px; max-height: 600px"></iframe>
							</div>

						</div>
					</div>

				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
