<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content" id="tablero_formulario_preguntas_abiertas">
		<div class="form-group row">
					<div class="col-sm-6">
						<button type="button" style="display: none" id="btn_buscar_preguntas_abiertas">buscar</button>
					</div>
				</div>
			<div class="form-group row">
				
			</div>
			<div class="card card-solid mt-3">
			
				<div class="card-body pb-0">
					<div id="contenedor_respuestas_abiertas_entregable_<?=$id_entregable_evidencia?>">
					<?php foreach ($catalogoPreguntaFormAbiertoModel['preguntas_abiertas'] as $index => $pa): ?>

						<div class="form-group row">
							<label class="col-form-label col-sm-12" for="txt_pregunta_abierta"><?=$pa->pregunta_formulario_abierto?></label>
						</div>
						<div class="form-group row">
							<div class="col-sm-12">
								<textarea id="txt_pregunta_abierta_<?= $index ?>" class="form-control txt_pregunta_abierta_rich" placeholder="Escriba su respuesta aquí" data-rule-required="true"
										name="pregunta_formulario_abierto"><?=isset($respuesta_pregunta_abierta) ? $respuesta_pregunta_abierta->respuesta_pregunta_abierta : ''?></textarea>
							</div>
						</div>
					<?php endforeach; ?>
				
					</div>
				</div>

				<div class="col-sm-12 text-right">

				<input type="hidden" id="input_id_entregable_evidencia" value="<?=isset($id_entregable_evidencia) ? $id_entregable_evidencia : ''?>">
				<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.agregar')):?>
					<button id="enviar_respuetas_preguntas_abiertas"
							class="btn btn-outline-info btn-lg align" data-toggle="tooltip"
							title="Guardas respuestas"
							data-id_entregable_evidencia="<?=$id_entregable_evidencia?>"
							type="button" ><i class="fa fa-list-alt"></i> Enviar respuestas
					</button>
				<?php endif; ?>
				</div>
			</div>

		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
