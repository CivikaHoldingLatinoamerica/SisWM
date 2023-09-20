<?php if(isset($estandar_competencia_convocatoria) && is_array($estandar_competencia_convocatoria) && !empty($estandar_competencia_convocatoria)): ?>
	<?php foreach($estandar_competencia_convocatoria as $index => $convocatoria): ?>
		<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
			<div class="card" style="width: 18rem;">
				<img src="<?=base_url().$convocatoria->ruta_directorio.$convocatoria->nombre?>" class="card-img-top" alt="...">
				<div class="card-body">
					<h5 class="card-title"><?=$convocatoria->codigo?> </h5>
					<p class="card-text"><?=$convocatoria->titulo?> </p>
				</div>
				<div class="card-footer text-right">
					<button type="button" class="btn btn-sm btn-outline-secondary ver_detalle_convocatoria"><i class="fa fa-eye"></i> Ver detalle</button>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="card card-solid" id="card_resultados_convocatoria_ec">
		<div class="card-body pb-0">
			<div class="form-group row">
				<div class="callout callout-warning col-md-12">
					<h5>Aviso IMPORTANTE</h5>
					<p>
						En este momento no contamos con convocatorias vigentes o se está cargando la información 
						de los Estándares de Competencia por parte de la entidad certificadora y/o el evaluador
					</p>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>
