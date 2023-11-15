<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_cat_ocupaciones_especificas">

	<div id="accordion">
		<?php foreach ($cat_ocupacion_especifica as $index => $cot): ?>
			<div class="card card-primary">
				<!-- <div class="card-header" id="heading_<?=$index?>">
					<h5 class="mb-0 card-title">
						<button type="button" class="btn btn-link"  data-toggle="collapse" data-target="#collapse_<?=$index?>"
							aria-expanded="true" aria-controls="collapse_<?=$index?>">
							<?=$cot->clave_area_subarea.' '.$cot->denominacion?>
						</button>
						<button class="btn btn-link btn-sm modificar_ocupacion_especificia_area"
							data-id_cat_ocupacion_especifica="<?=$cot->id_cat_ocupacion_especifica?>" data-tipo_ocupacion_especifica="area">
							<i class="fa fa-pencil"></i>
						</button>
					</h5>
				</div> -->
				<div class="card-header" id="heading_<?=$index?>">
					<h3 class="card-title" data-toggle="collapse" data-target="#collapse_<?=$index?>"
						aria-expanded="true" aria-controls="collapse_<?=$index?>">
						<?=$cot->clave_area_subarea.' '.$cot->denominacion?>
					</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool btn-sm modificar_ocupacion_especificia_area" 
							data-id_cat_ocupacion_especifica="<?=$cot->id_cat_ocupacion_especifica?>" data-tipo_ocupacion_especifica="area">
							<i class="fas fa-pen"></i>
						</button>
					</div>
				</div>

				<div id="collapse_<?=$index?>" class="collapse <?=$index == 0 ? 'show': ''?>" aria-labelledby="heading_<?=$index?>" data-parent="#accordion">
					<div class="card-body">
						<ul>
						<?php foreach ($cot->subAreas as $sa): ?>
							<li>
								<?=$sa->clave_area_subarea.' '.$sa->denominacion?>
								<button class="btn btn-link btn-sm modificar_ocupacion_especificia_subarea"
										data-id_cat_ocupacion_especifica="<?=$sa->id_cat_ocupacion_especifica?>" data-tipo_ocupacion_especifica="subarea">
									<i class="fas fa-pen"></i>
								</button>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		<?php endforeach;?>
	</div>

	</section>
	<!-- /.content -->

	<div id="contenedor_modal_ocupaciones">
		<?php $this->load->view('catalogo/formulario/ocupaciones'); ?>
	</div>

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
