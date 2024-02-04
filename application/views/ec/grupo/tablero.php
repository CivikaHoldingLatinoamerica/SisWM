<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia_grupos">

		<div class="card card-solid">
			<div class="card-body pb-0">
				<div class="form-group row">
					<input type="hidden" id="input_id_estandar_competencia" value="<?= $estandar_competencia->id_estandar_competencia?>">
					<label class="col-sm-2 col-form-label">Estándar de competencia: </label><span
							class="col-sm-10 col-form-label"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></span>
				</div>
			</div>		
		</div>
		

		<div class="container-fluid mb-3">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group" >
						<input type="text" id="input_buscar_ec_grupo" class="form-control form-control-lg" name="busqueda" placeholder="Escribe algo para buscar">
						<div class="input-group-append">
							<button type="button" id="btn_buscar_estandar_competencia_grupo" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar clave del grupo o nombre; cuando termines pulsa en el boton del icono de buscar</small>
				</div>
				<?php if(perfil_permiso_operacion_menu('estandar_competencia.agregar')): ?>
					<div class="col-md-6 text-right">
						<button type="button" id="btn_agregar_ec_grupo" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nuevo</button>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="card card-solid">
			<div class="card-body pb-0">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body table-responsive p-0">
								<table class="table table-striped">
									<thead>
									<tr>
										<th>ID</th>
										<th>Grupo</th>
										<th>Periodo</th>
										<th>Agente Capacitador</th>
										<th>Área Tematica</th>
										<th></th>
									</tr>
									</thead>
									<tbody id="contenedor_resultados_ec_grupo">
										<?php $this->load->view('ec/grupo/resultado_tablero'); ?>
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
