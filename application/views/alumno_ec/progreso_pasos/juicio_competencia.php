<?php if(isset($usuario_has_ec->mejores_practicas) && !is_null($usuario_has_ec->mejores_practicas)
	&& isset($usuario_has_ec->jucio_evaluacion) && !is_null($usuario_has_ec->jucio_evaluacion)): ?>
	<div class="col-lg-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Resultados de la evaluación</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>

			<div class="card-body">

				<div class="form-group row">
					<div class="callout callout-success">
						<h5>Aviso importante</h5>
						<p>Le pedimos de favor colocar las observaciones que tengas de tu proceso de evaluacion y da click en siguiente que se encuentra al final de esta pantalla para continuar al siguiente apartado</p>
					</div>

				</div>

				<div class="form-group row">
					<label class="col-sm-3">Mejores practicas:</label>
					<span class="col-sm-9"><?=$usuario_has_ec->mejores_practicas?></span>
					<label class="col-sm-3">Áreas de oportunidad</label>
					<span class="col-sm-9"><?=$usuario_has_ec->areas_oportunidad?></span>
					<label class="col-sm-3">Criterios de evaluación no cubiertos</label>
					<span class="col-sm-9"><?=$usuario_has_ec->criterio_no_cubiertos?></span>
					<label class="col-sm-3">Recomendaciones</label>
					<span class="col-sm-9"><?=$usuario_has_ec->recomendaciones?></span>
					<label class="col-sm-3">Juicio de evaluación:</label>
					<span class="col-sm-9"><?=$usuario_has_ec->jucio_evaluacion == 'competente' ? 'Competente':'No competente'?></span>
					<label class="col-sm-3">Observaciones:</label>
					<div class="col-sm-9">
						<?php if(isset($usuario) && in_array($usuario->perfil,array('alumno'))): ?>
							<textarea class="form-control" placeholder="Describa las observaciones respecto al proceso de evaluación"
									data-campo_actualizar="observaciones_candidato"
									data-tabla_actualizar="usuario_has_estandar_competencia"
									data-id_actualizar="id_usuario_has_estandar_competencia"
									data-id_actualizar_valor="<?=$usuario_has_ec->id_usuario_has_estandar_competencia?>"
									id="txt_observaciones_candidato" ><?=$usuario_has_ec->observaciones_candidato?></textarea>
							<small class="form-text text-muted">Solo describa sus observaciones, salga del recuadro de texto con un clik fuera de él para guardar su información</small>
						<?php else: ?>
							<span class="col-sm-9"><?=$usuario_has_ec->observaciones_candidato?></span>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>

		<div class="card card-primary">
			<div class="card-header">
				<label class="modal-title">Cédula de evaluación</label>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<iframe src="<?=base_url()?>DocsPDF/generar_pdf_resultados_evaluacion/<?=$id_usuario_alumno?>/<?=$id_usuario_evaluador?>/<?=$id_estandar_competencia?>" style="width: 100%; min-height: 300px; max-height: 600px"></iframe>
			</div>
		</div>

	</div>

	<?php if(isset($usuario_has_ec->jucio_evaluacion) && $usuario_has_ec->jucio_evaluacion == 'competente'): ?>
		<div class="form-group row" >
			<div class="col-lg-12" >
				<div class="callout callout-info">
					<h5>Mensaje del sistema</h5>
					<p>Para poder pasar al siguiente apartado es necesario que registe las observaciones relacionadas a su proceso de certificación</p>
					<hr>
					<p>Su proceso de evaluación se encuentra como <span class="badge badge-success" >Competente</span>, esperé las indicaciones que le realice su evaluador para su proceso de certificación</p>
				</div>
			</div>
		</div>
		<div class="form-group row justify-content-between">
			<div class="col-lg-6 text-left">
				<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_evidencias-tab">
					<i class="fa fa-backward"></i> Anterior
				</button>
			</div>
			<div class="col-lg-6 text-right">
				<button type="button" data-siguiente_link="#tab_certificado-tab" data-numero_paso="6" <?=isset($usuario_has_ec->observaciones_candidato) && $usuario_has_ec->observaciones_candidato != '' ? '' : 'disabled="disabled"'?>
						class="btn btn-outline-success btn-sm guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
			</div>
		</div>
	<?php else: ?>
		<div class="form-group row" >
			<div class="col-lg-12" >
				<div class="callout callout-info">
					<h5>Mensaje del sistema</h5>
					<p>Su proceso de evaluación se encuentra como <span class="badge badge-danger" >No competente</span>, esperé las indicaciones que le realice su evaluador para su proceso de certificación</p>
				</div>
			</div>
		</div>
	<?php endif; ?>

	
<?php else: ?>
	<div class="form-group row">
		<div class="col-lg-12" >
			<div class="callout callout-warning">
				<h5>Mensaje del sistema</h5>
				<p>Se encontró en el sistema que el evaluador se encuentra analizando el juicio de competencia, en cuanto lo realice podra el resultado</p>
			</div>
		</div>
	</div>
<?php endif; ?>
