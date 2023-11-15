<?php if (isset($entregables) && sizeof($entregables) != 0): ?>
	<label class="col-form-label">Instrumentos de evaluación</label>
	<div class="callout callout-success">
		<h5>Información importante</h5>
		<p>
			A continuación carga tus evidencias conforme a las instrucciones correspondientes, para poder pasar al paso de "Juicio de Competencia", es necesario entragar todas las evidencias y esten en estatus de "FINALIZADA"
		</p>
		<?php if(isset($entregables_por_liberar) && $entregables_por_liberar): ?>
			<hr>
			<p>
				Se detectó en el sistema, que el evaluador sigue cargando evidencias esperadas al Estándar de Competencia; espere un tiempo más para que queden liberadas al 100% y poder pasar al siguente apartado
			</p>
		<?php endif; ?>
	</div>
	<section class="content" id="tablero-evidencias_candidato">
		<div class="card">
			<div class="card-body">
				<div id="contenedor_candidato_entregable" class="row">
					<div class="col">
						<?php $this->load->view('entregables/candidato/tablero_evidencias_candidato'); ?>
					</div>
				</div>
			</div>
		</div>

	</section>
<?php else: ?>
	<div class="row">
		<div class="col">
			<?php $this->load->view('default/sin_datos_candidato'); ?>
		</div>
	</div>
<?php endif; ?>
