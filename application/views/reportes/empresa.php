<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content" id="tablero_reporte_empresa">

			<div class="form-group row">
				<div class="col-md-6">
					<div class="input-group">
						<input type="text" id="input_buscar_reporte_empresa" class="form-control form-control-lg" name="busqueda" placeholder="Escribe algo para buscar">
						<div class="input-group-append">
							<button type="button" id="btn_buscar_reporte_empresa" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre de la empresa o RFC; cuando termines pulsa en el boton del icono de buscar</small>
				</div>
			</div>

			<div class="card card-solid mt-3">
				<div class="card-body pb-0">
					<div class="row">
						<div class="form-group col-lg-12" >
							<div class="alert alert-primary" >
								El siguiente tablero solo mostrará los ultimos 10 registros del reporte, para obtenerlo completo de click en el boton de descargar 
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-lg-12 text-right" >
							<button type="button" class="btn btn-sm btn-outline-success" ><i class="fas fa-file-excel"></i> Descargar</button>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body table-responsive p-0">
									<table class="table table-striped">
										<thead>
										<tr>
											<th>RFC</th>
											<th>Razón social</th>
											<th>Certificación</th>
											<th>Candidatos</th>
										</tr>
										</thead>
										<tbody id="contenedor_resultados_reporte_empresa">
										</tbody>
									</table>
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
