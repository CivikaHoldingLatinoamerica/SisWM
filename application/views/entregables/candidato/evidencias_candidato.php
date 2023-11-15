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
<?php else: ?>
	<div class="row">
		<div class="col">
			<?php $this->load->view('default/sin_datos_candidato'); ?>
		</div>
	</div>
<?php endif; ?>
