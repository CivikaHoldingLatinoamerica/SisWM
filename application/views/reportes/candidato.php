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
						<input type="text" id="input_buscar_reporte_candidato" class="form-control form-control-lg" name="busqueda" placeholder="Escribe algo para buscar">
						<div class="input-group-append">
							<button type="button" id="btn_buscar_reporte_candidato" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos del candidato, código o nombre del EC , empresa o RFC; cuando termines pulsa en el boton del icono de buscar</small>
				</div>
			</div>

			<div class="card card-solid mt-3" id="contenedor_resultados_reporte_candidato">
				
			</div>

		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
