<div class="card-body pb-0">
	<div class="row">
		<div class="form-group col-lg-12" >
			<div class="alert alert-primary" >
				<ul>
					<li>El siguiente tablero solo mostrará los ultimos 20 registros del reporte ordenados por identificador del usuario y de forma descendente, para obtenerlo completo de click en el boton de descargar </li>
					<li>Si realizaste el reporte con un filtro con el campo anterior, se generará con dicho filtro</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-lg-12 text-right" >
			<button type="button" id="btn_candidato_excel" class="btn btn-sm btn-outline-success" ><i class="fas fa-file-excel"></i> Descargar</button>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body table-responsive p-0">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Estandar de competencia</th>
							<th>Datos del candidato</th>
							<th>Datos de la empresa</th>
							<th>Juicio</th>
							<th>Progreso</th>
						</tr>
						</thead>
						<tbody>
						<?php if(isset($reporte_candidato) && is_array($reporte_candidato) && !empty($reporte_candidato)): ?>
							<?php foreach($reporte_candidato as $index => $r): ?>
								<tr>
									<td>
										Código: <?=$r->codigo_ec?>
										<br>Estándar: <?=$r->titulo_ec?>
									</td>
									<td>
										Nombre: <?=$r->nombre.' '.$r->apellido_p.' '.$r->apellido_m?>
										<br>CURP: <?=$r->curp?>
										<br>Ocupación específica: <?=$r->ocupacion_especifica?>
										<br>Teléfono: <?=$r->celular?>
									</td>
									<td>
										Razón social: <?=$r->nombre_empresa?>
										<br>Nombre corto: <?=$r->nombre_empresa_corto?>
										<br>RFC: <?=$r->rfc_empresa?>
										<br>Categoria: <?=$r->categoria_empresa?>
									</td>
									<td><span class="badge badge-primary" ><?=$r->juicio_evaluacion?></span></td>
									<td>
										<?php 
											if($r->progreso < 30)
												$class = "danger"; 
											elseif($r->progreso >= 31 && $r->progreso < 50)
												$class = "warning";
											elseif($r->progreso >= 51 && $r->progreso < 75)
												$class = "info";
											elseif($r->progreso >= 75 && $r->progreso < 100)
												$class = "primary";
											else
											$class = "success";
										?>
										<span class="badge badge-<?=$class?>" ><?=number_format($r->progreso,2)?></span>
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
