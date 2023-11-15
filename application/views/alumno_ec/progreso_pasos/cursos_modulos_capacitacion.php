<div class="row form-group" >
	<div class="col-lg-12" >
		<div class="callout callout-success">
			<h5>Información importante</h5>
			<p>
			El Sistema Integral de Información para la Conformación del Portafolios de Evidencias Digital (SII-PED) le permite realizar de forma simultánea la capacitación - alineación o la revisión y envió de la evidencia o evidencias esperadas. La Entidad de Certificación y Evaluación (ECE) Esta generando diversos programas educativos a los que puede acceder.
			</p>
			<hr>
			<p>
				Estimado Alumno/Candidato ponemos a su disposición el siguiente link de Zoom para unirse a las capacitaciones que se llevarán a cabo de forma sincrónica de lunes a viernes en un horario de las 20:00 Hora del Centro de México
				<a href="https://us02web.zoom.us/j/84205305220?pwd=SUsrTGhVUjhZamFNWHhDK2w5MXBJUT09" target="_blank" ></a>
					<button class="btn btn-sm btn-outline-success">Unirse</button>
				</a>
				<br><b>Nota:</b> En caso de pedirle datos el zoom serian los siguientes:
				<br><b>Id de reunión: </b>842 0530 5220
				<br><b>Código de acceso: </b>219375
			</p>
			<?php if(isset($existen_modulos_en_carga) && $existen_modulos_en_carga): ?>
				<hr>
				La capacitación - alineación; está siendo atendida por medios sincrónicos externos a este sistema. La capacitación - alineación asincrónica próximamente...
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-12">
		<div class="card card-primary">

		<div class="card-header">
				<h4 class="card-title"><b>Módulo de capacitación detalles</b></h4>
			</div>
			<div class="card-body">
			<?php if (isset($ec_curso) && $ec_curso !== false): ?>
				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<img src="<?=base_url().$ec_curso->ruta_directorio.$ec_curso->nombre?>" class="img-thumbnail" alt="Curso de Estandar de Competencia">
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label class="col-form-label">Curso: </label> <span><?=$ec_curso->nombre_curso?></span>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12"><i class="fa fa-square"></i><b> Descrición:</b></div>
					<div class="col-sm-12">
						<span><?=$ec_curso->descripcion?></span>
					</div>				
				</div>

				<div class="form-group row">
					
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-book"></i> ¿Que aprenderas?:</label>
							<div><?=$ec_curso->que_aprenderas?></div>
						</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label">Módulos</label>
				</div>

				<?php if (isset($ec_curso_modulo['ec_curso_modulo']) && is_array($ec_curso_modulo['ec_curso_modulo']) && sizeof($ec_curso_modulo['ec_curso_modulo']) != 0): ?>				
					<div class="form-group row">
						<?php foreach ($ec_curso_modulo['ec_curso_modulo'] as $index=>$eccm): ?>
							<?php if($eccm->eliminado == 'no'): ?>
								<div class="col-md-12">
									<div class="card card-<?=$eccm->eliminado == 'si' ? 'light' : 'primary'?> <?= $index == 0 ? "" : "collapsed-card"?>">
										<div class="card-header">
											<h3 class="card-title <?=$eccm->eliminado == 'si' ? 'text-danger' : ''?>">
												<div class="col-lg-12">
													<label> Descripción: <?=isset($eccm->descripcion) ? $eccm->descripcion : "" ?></label>
												</div>
											</h3>
											<div class="card-tools">
												<button type="button" class="btn btn-tool" data-card-widget="collapse">
													<i class="fas fa-<?= $index == 0 ? 'minus' : 'plus'?>"></i>
												</button>
											</div>
										</div>
										<!-- /.card-header -->
										<div class="card-body" style="display: <?= $index == 0 ? 'block' : 'none'?>;">
											<div class="form-group row">
												<label> Objetivo general:</label>					
											</div>
											<div class="form-group row">
												<div class="col-lg-12">
                          <?=isset($eccm->objetivo_general) ? $eccm->objetivo_general : ''?>
												</div>
											</div>
											<div class="form-group row">						
												<label> Objetivos especificos:</label>
											</div>
											<div class="form-group row">
												<div class="col-lg-12">					

													<?=isset($eccm->objetivos_especificos) ? $eccm->objetivos_especificos : ''?>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-sm-12 text-right">	
													<?php if(perfil_permiso_operacion_menu('curso_ec.consultar')): ?>
														<a class="btn btn-sm btn-outline-dark" data-toggle="tooltip"
														title="Evaluación del módulo de capacitación"
														href="<?=base_url().'evaluacion_modulo/'.$eccm->id_ec_curso_modulo.'/'.$eccm->id_evaluacion?>"><i class="fa fa-file-alt"></i> Exámen de evaluación</a>
													<?php endif; ?>
												</div>
											</div>

											<div id="contenedor_ec_curso_modulo_temas_<?=$eccm->id_ec_curso_modulo?>">
											
											<?php if (isset($eccm->ec_curso_modulo_temario) && is_array($eccm->ec_curso_modulo_temario) && sizeof($eccm->ec_curso_modulo_temario) != 0): ?>
												<div class="form-group row">
													<?php foreach ($eccm->ec_curso_modulo_temario as $eccmt): ?>
														<?php if($eccmt->eliminado == 'no'): ?>
															<div class="col-md-12">
																<div class="card card-<?=$eccmt->eliminado == 'si' ? 'light' : 'info'?> collapsed-card">
																	<div class="card-header">
																		<h3 class="card-title <?=$eccmt->eliminado == 'si' ? 'text-danger' : ''?>">
																			<label> Tema: <?=isset($eccmt->tema) ? $eccmt->tema : "" ?><?=$eccmt->eliminado == 'si' ? '- ELIMINADO' : ''?></label>
																		</h3>
																		<div class="card-tools">
																			<button type="button" class="btn btn-tool" data-card-widget="collapse">
																				<i class="fas fa-plus"></i>
																			</button>
																		</div>
																	</div>
																	<!-- /.card-header -->
																	<div class="card-body" style="display: none;">
																		<div class="form-group row">
																			<label> Instrucciones:</label>
																		</div>
																		<div class="form-group row">
																			<div class="col-lg-12">
																				<?=isset($eccmt->instrucciones) ? $eccmt->instrucciones : ''?>
																			</div>
																		</div>
																		<div class="form-group row">						
																			<label> Contenido curso:</label>
																		</div>
																		<div class="form-group row">		
																			<div class="col-lg-12">				
																				<?=isset($eccmt->contenido_curso) ? $eccmt->contenido_curso : ''?>
																			</div>
																		</div>

																		<div class="form-group row">						
																			<label> Archivo del tema:</label>
																		</div>
																		<div class="form-group row">						
																		<p><a href="<?= base_url().$eccmt->ruta_directorio.$eccmt->nombre?>" target="_blank"><?= $eccmt->nombre ?> </a></p>						
																		</div>
																	</div>
																</div>
																<!-- /.card -->
															</div>
														<?php endif; ?>
													<?php endforeach; ?>
												</div>

											<?php else: ?>
												<?php $this->load->view('default/sin_datos_candidato'); ?>
											<?php endif; ?>
											</div>
										</div>
									</div>
									<!-- /.card -->
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>

				<?php else: ?>
					<?php $this->load->view('default/sin_datos_candidato'); ?>
				<?php endif; ?>
			
			<?php else: ?>
				<?php $this->load->view('default/sin_datos_candidato'); ?>
			<?php endif; ?>

			</div>

			<div class="form-group row">

				<div class="col-12 text-right">
					<button type="button"
							data-siguiente_link="#tab_evidencias-tab" data-numero_paso="4" id="btn_siguiente_tab_modulo_capacitacion"
							<?=isset($usuario_has_evaluacion_realizada) && !$usuario_has_evaluacion_realizada ? 'disabled="disabled"':''?>
							class="btn btn-outline-success guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
				</div>
			</div> 
		</div>
	</div>
</div>
