<div class="card-body pb-0">
	<div class="row">
		<div class="form-group col-lg-12" >
			<div class="alert alert-primary" >
				<ul>
					<li>El siguiente tablero solo mostrará los ultimos 20 registros del reporte ordenados por empresa registrada y de forma descendente, para obtenerlo completo de click en el boton de descargar </li>
					<li>Si realizaste el reporte con un filtro con el campo anterior, se generará con dicho filtro</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-lg-12 text-right" >
			<button type="button" id="btn_empresa_excel" class="btn btn-sm btn-outline-success" ><i class="fas fa-file-excel"></i> Descargar</button>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body table-responsive p-0">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>RFC</th>
							<th>Razón social</th>
							<th>Certificación</th>
							<th>Candidatos</th>
						</tr>
						</thead>
						<tbody >
						<?php if(isset($reporte_empresa) && is_array($reporte_empresa) && !empty($reporte_empresa)): ?>
							<?php foreach($reporte_empresa as $index => $re): ?>
								<tr>
									<td><?=$re->rfc_empresa?></td>
									<td><?=$re->nombre_empresa?></td>
									<td><span class="badge badge-primary" ><?=$re->proceso_evaluacion?></span></td>
									<td>
										<ul>
											<li>Candidatos registrados: <span class="badge badge-primary" ><?=$re->candidatos_registrados_empresa?></span></li>
											<li>Candidatos en proceso: <span class="badge badge-warning" ><?=$re->candidatos_preceso_certificacion?></span></li>
											<li>Candidatos certificados: <span class="badge badge-success" ><?=$re->candidatos_certificados?></span></li>
										</ul>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="4" class="text-center">Sin registros por mostrar</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
