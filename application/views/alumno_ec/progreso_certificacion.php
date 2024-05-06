<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_administradores">

		<div class="container-fluid mb-3">
			<div class="card">
				<div class="card-body">
					<div class="row mt-3">
						<div class="col-lg-12 col-md-12 col-sm-12 text-center">
							<div class="card card-primary card-outline">
								<div class="card-body">
									<label>Plataforma de Desarrollo y Certificación de Estandares de Competencia</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
							<!-- Profile Image -->
							<div class="card card-primary card-outline">
								<div class="card-body box-profile">
									<div class="text-center">
									<img class="profile-user-img img-fluid img-circle img_foto_perfil"
										src="<?=base_url()?>assets/imgs/demos/person.png"
										alt="Foto de perfil">
									</div>
									<ul class="list-group list-group-unbordered mb-3">
									<li class="list-group-item">
										<b>CURP</b> <a class="float-right"><?=$datos_usuario->curp?></a>
									</li>
									<li class="list-group-item">
										<b>RFC de Empresa</b> <a class="float-right"><?=$datos_empresa->rfc?></a>
									</li>
									<li class="list-group-item">
										<b>Empresa</b> <a class="float-right"><?=$datos_empresa->nombre?></a>
									</li>
									<li class="list-group-item">
										<b>Puesto</b> <a class="float-right"><?=$datos_empresa->cargo?></a>
									</li>
									</ul>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
						</div>

						<div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
							<div class="card card-success card-outline">
								<div class="card-body">
									<?php if(isset($certificacion_candidato) && is_array($certificacion_candidato) && sizeof($certificacion_candidato) != 0): ?>
										<?php foreach($certificacion_candidato as $index => $cc): ?>
											<div class="row">
												<div class="col-5 text-right">
													<?=$cc->codigo_ec.' '.$cc->titulo_ec?>
													<br>
													<button clasS="btn btn-sm btn-outline-dark ver_detalle_certificacion_candidato" 
														data-id_usuario_has_estandar_competencia="<?=$cc->id_usuario_has_estandar_competencia?>">
														<i class="fa fa-eye"></i> Ver detalle
													</button>
													<br>
													<?php if($cc->juicio_evaluacion == 'COMPETENTE'): ?>
														<span class="badge badge-success">COMPETENTE</span>
													<?php else: ?>
														<span class="badge badge-info">AUN NO COMPETENTE</span>
													<?php endif; ?>
												</div>
												<div class="col-7">
													<div class="progress mb-3">
														<?php switch($cc->id_cat_calibracion_desempeno){
															case JUICIO_AUN_NO_CALIFICADO: $class="bg-danger"; break;
															case JUICIO_CALIFICADO: $class="bd-info"; break;
															case JUICIO_OPTIMO: $class="bg-primary"; break;
															case JUICIO_ALTO_POTENCIAL: $class="bg-warning";break;
															case JUICIO_ALTO_DESEMPENO: $class="bg-success";break;
														} ?>
														<div class="progress-bar <?=$class?> progress-bar-striped" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: <?=$cc->progreso?>%">
															<span>Progreso certificación <?=$cc->progreso?>%</span>
														</div>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									<?php else: ?>
									<?php endif; ?>
								</div><!-- /.card-body -->
							</div>
							<!-- /.card -->
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-1"></div>
										<div class="col-2">
											<div class="progress mb-3">
												<div class="progress-bar bg-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
													<span>Aun no calificado</span>
												</div>
											</div>
										</div>
										<div class="col-2">
											<div class="progress mb-3">
												<div class="progress-bar bg-info progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
													<span>Calificado</span>
												</div>
											</div>
										</div>
										<div class="col-2">
											<div class="progress mb-3">
												<div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
													<span>Optimo</span>
												</div>
											</div>
										</div>
										<div class="col-2">
											<div class="progress mb-3">
												<div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
													<span>Alto Potencial</span>
												</div>
											</div>
										</div>
										<div class="col-2">
											<div class="progress mb-3">
												<div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
													<span>Alto Desempeño</span>
												</div>
											</div>
										</div>
										<div class="col-1"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
