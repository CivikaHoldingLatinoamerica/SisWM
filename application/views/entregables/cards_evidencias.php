<?php if (isset($entregables) && sizeof($entregables) != 0): ?>
		<?php foreach ($entregables as $index => $item): ?>
			<div class="col-2">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-10">
								<h5 class="card-title text-bold">
									<em style="color: red" class="fa fa-file mr-1"></em>
									<?= $item->nombre ?></h5>
							</div>
							<div class="col-2">
								<div class="dropdown">
									<button id="edit" class="btn btn-sm btn-light dropdown-toggle" type="button"
											data-toggle="dropdown" aria-expanded="fal|">
										<em class="fa fa-ellipsis-v"></em>
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item modificar_entregable" data_id="<?= $index ?>" href="#">Editar</a>
										<a class="dropdown-item iniciar_confirmacion_operacion"
										   data-msg_confirmacion_general="¿Esta seguro de eliminar el entregable?, esta acción no podrá revertirse"
										   data-url_confirmacion_general="<?=base_url()?>Entregable/eliminar/<?=$index?>"
										   data-btn_trigger="#btn_buscar_sectores"
										   href="#">Eliminar</a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<?php foreach ($item->instrumentos as $i => $instrumento): ?>
								<div class="lines-2">
									<em style="font-size: xx-small" class="fa fa-circle"></em>
									<span
										title="La carta descriptiva elaborada."> <?= $instrumento ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
<?php endif;?>
