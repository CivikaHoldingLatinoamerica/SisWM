<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header'); ?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia">

		<div class="container-fluid mb-3">
			<div class="row mb-03">
				<div class="col-md-6">
					<button hidden type="button" id="btn_buscar_entregables"></button>
				</div>
				<div class="col-md-6 text-right">
					<button type="button" id="btn_nuevo_entregable" class="btn btn-sm btn-outline-success"><i
							class="fa fa-plus-square"></i> Nuevo
					</button>
				</div>
			</div>

		</div>

		<div class="card">
			<div class="card-body">
				<?php if (isset($entregables) && sizeof($entregables) != 0): ?>
					<div id="contenedor_candidato_entregable" class="row">
						<div class="col">
							<div id="accordion">
								<div class="card w-100">
									<div class="card-header sidebar-dark-primary white" id="headingOne">
										<h5 class="mb-0">
											<button class="btn btn-link" style="color: white" data-toggle="collapse"
													data-target="#collapseOne" aria-expanded="true"
													aria-controls="collapseOne">
												Lista de cotejo
											</button>
										</h5>
									</div>

									<div id="collapseOne" class="collapse p-3" aria-labelledby="headingOne"
										 data-parent="#accordion">
										<div class="row">
											<div class="col-3">
												<div class="card ">
													<div class="card-body evidencia-card">
														<div class="row">
															<div class="col-12">
																<h5 class="card-title text-bold">

																	<em style="color: var(--blue)"
																		class="fa fa-file mr-1"></em>


																	Entregable1</h5>

																<em style="color: var(--yellow)"
																	class="fa fa-exclamation-circle ml-1"></em>
															</div>
														</div>
														<div class="row">
															<div class="col">
																<p class=" small" style="color: darkgray">
																	Anim pariatur cliche reprehenderit, enim eiusmod
																	high life
																	accusamus terry richardson ad squid. 3 wolf moon
																	officia
																	aute, non cupidatat skateboard dolor brunch. Food
																	truck
																	quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon
																	tempor,
																	sunt aliqua put a bird on it squid single-origin
																	coffee
																	nulla assumenda shoreditch et. Nihil anim keffiyeh
																	helvetica, craft beer labore wes anderson cred
																	nesciunt
																	sapiente ea proident. Ad vegan excepteur butcher
																	vice lomo.
																	Leggings occaecat craft beer farm-to-table, raw
																	denim
																	aesthetic synth nesciunt you probably haven't heard
																	of them
																	accusamus labore sustainable VHS.
																</p>
															</div>
														</div>
													</div>
													<div class="card-footer">
														<button class="btn btn-primary">Subir entregable <em class="fa fa-file-upload"></em></button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingTwo">
										<h5 class="mb-0">
											<button class="btn btn-link collapsed" data-toggle="collapse"
													data-target="#collapseTwo" aria-expanded="false"
													aria-controls="collapseTwo">
												Cuestionario
											</button>
										</h5>
									</div>
									<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
										 data-parent="#accordion">
										<div class="card-body">

										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingThree">
										<h5 class="mb-0">
											<button class="btn btn-link collapsed" data-toggle="collapse"
													data-target="#collapseThree" aria-expanded="false"
													aria-controls="collapseThree">
												Formulario
											</button>
										</h5>
									</div>
									<div id="collapseThree" class="collapse" aria-labelledby="headingThree"
										 data-parent="#accordion">
										<div class="card-body">

										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				<?php else: ?>
					<div class="row">
						<div class="col">
							<div class="callout callout-warning">
								<h5>Lo siento</h5>
								<p>No se encontro registros de búsqueda</p>
							</div>
						</div>
					</div>
				<?php endif; ?>


			</div>
		</div>

	</section>
	<!-- /.content -->

	<div id="contenedor_modal_entregable">
		<div class="modal fade" id="modal_form_entregable_candidato" aria-modal="true" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<h4 class="modal-title"> Entregable</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>


						<div class="modal-body">
							<div class="row">
								<div class="col">
									<p class=" small" style="color: darkgray">
										Anim pariatur cliche reprehenderit, enim eiusmod
										high life
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col ">
									<label>Intrucciones</label>
									<p class=" small" style="color: darkgray">
										Leggings occaecat craft beer farm-to-table, raw
										denim
										aesthetic synth nesciunt you probably haven't heard
										of them
										accusamus labore sustainable VHS.
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col ">
									<label>Instrumentos </label><span class=" small" style="color: darkgray">(a los que aplica este entregable)</span>
									<ul>
										<li>Intrumento 1</li>
										<li>Intrumento 2</li>
										<li>Intrumento 3</li>
									</ul>
								</div>
							</div>


							<div class="row">
								<div class="col">
									<label>Materiales de apoyo</label>
									<table class="table table-striped">
										<thead>
										<tr>
											<th scope="col">Archivo</th>
											<th scope="col">Descarga</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td>investigacion.pdf</td>
											<td>
												<button class="btn btn-secondary"><em class="fa fa-download"></em></button>
											</td>
										</tr>
										<tr>
											<td>Presentacion.ppt</td>
											<td>
												<button class="btn btn-secondary" ><em class="fa fa-download"></em></button>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
							<a href="#" class="btn btn-sm btn-outline-primary">Responder
							</a>
						</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
	</div>

</div>


<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>




