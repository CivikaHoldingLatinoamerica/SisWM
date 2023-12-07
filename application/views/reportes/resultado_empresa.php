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
