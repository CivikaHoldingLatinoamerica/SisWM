<?php if (isset($entregables) && sizeof($entregables) != 0): ?>
	<label class="col-form-label">Instrumentos de evaluación</label>
	<div class="callout callout-success">
		<h5>Información importante</h5>
		<p>
			A continuación, cargue sus evidencias conforme a las instrucciones correspondientes.
		</p>
		<p>
			Importante es necesario entregar cada una de las evidencias solicitadas en este apartado ya que no podrán ser modificadas posterior al envió.
		</p>
		<p>
			La evaluación de las evidencias se hace de forma conjunta al Finalizar el envió; te solicitamos no contactar al evaluador, ya que su papel es EVALUAR y no asesorar la conformación del portafolio de evidencias; utiliza los medios sincrónicos externos a este sistema para aclarar todas tus dudas. 
		</p>
		<p>
			Los cuestionarios; conforman la evidencia de conocimientos.
		</p>
		<p>
			Las guías de observación y listas de cotejo; conforman la evidencia de desempeños y productos.
		</p>
		<p>
			Al finalizar la conformación de las evidencias serán evaluadas por el Evaluador.
		</p>
		<p>
			El Grupo de Dictamen; dictaminará el portafolio de evidencias y ratificará el juicio emitido por el Evaluador; llegará una notificación de Juicio de Competencia, mismo que podrás observar en el apartado con el mismo nombre cuando esta haya sido emitida y ratificada.
		</p>
		<?php if(isset($entregables_por_liberar) && $entregables_por_liberar): ?>
			<hr>
			<p>
			La capacitación - alineación; está siendo atendida por medios sincrónicos externos a este sistema. La capacitación - alineación asincrónica próximamente...
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

	<?php if(isset($entregables_por_liberar) && $entregables_por_liberar): ?>
		<div class="row">
			<div class="col">
				<div class="callout callout-danger">
					<h5>Información importante</h5>
					Como la capacitación se esta llevando por medios sincrónicos externos al sistema, existen entregables por ser liberados por el evaluador; en el momento que todas las evidencias esperadas esten revisadas y liberadas, podrá pasar al siguiente paso
				</div>
			</div>
		</div>
	<?php else: ?>
		<div id="seccion_aviso_paso_juicio_competencia" class="form-group row" style="display: none;" >
			<div class="col-12">
				<div class="callout callout-danger">
					<h5>Información importante</h5>
					Para poder continuar al siguiente paso es necesario que se finalice y libere los entregables esperados
				</div>
			</div>
		</div>
		<div class="form-group row justify-content-between">
			<div class="col-lg-6 text-left">
				<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_modulo_capacitacion-tab">
					<i class="fa fa-backward"></i> Anterior
				</button>
			</div>
			<div class="col-lg-6 text-right">
			<button type="button"
						data-siguiente_link="#tab_jucio_competencia-tab" data-numero_paso="5" id="btn_siguiente_tab_modulo_juicio_competencia"
						class="btn btn-outline-success guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
			</div>
		</div>
	<?php endif; ?>
<?php else: ?>
	<div class="row">
		<div class="col">
			<div class="callout callout-success">
				<h5>Información importante</h5>
				La capacitación - alineación; está siendo atendida por medios sincrónicos externos a este sistema. La capacitación - alineación asincrónica próximamente...
			</div>
		</div>
	</div>
<?php endif; ?>
