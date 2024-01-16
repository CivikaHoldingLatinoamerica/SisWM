<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_datos_empresa">

		<div class="container-fluid mb-3">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
						<input type="text" id="input_buscar_datos_empresa" class="form-control form-control-lg" name="busqueda" placeholder="Escribe algo para buscar">
						<div class="input-group-append">
							<button type="button" id="btn_buscar_datos_empresa" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre de la empresa, RFC, domicilio, teléfono o correo; cuando termines pulsa en el boton del icono de buscar</small>
				</div>
			</div>
		</div>


		<div class="card card-solid">
			<div class="card-body pb-0">
				<div class="row">
					<div class="col-12">
						<div class="callout callout-info">
							<h5>Información importante</h5>
							<p>Los datos mostrados en el siguiente tablero fueron registrados por los candidatos, razón por la cual únicamente podrá actualizar la información</p>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-12">
						<div class="card">
							<div class="card-body table-responsive p-0">
								<table class="table table-striped">
									<thead>
									<tr>
										<th>¿Quien registro?</th>
										<th>RFC</th>
										<th>Nombre corto/largo</th>
										<th>Contacto</th>
										<th>Representantes</th>
										<th></th>
									</tr>
									</thead>
									<tbody id="contenedor_resultados_datos_empresa">
										<?php $this->load->view('catalogo/empresa/resultado_tablero'); ?>
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
