<?php if($pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
<?php endif; ?>
<?php if(isset($datos_empresa) && is_array($datos_empresa) && !empty($datos_empresa)): ?>
	<?php foreach($datos_empresa as $index => $de): ?>
		<tr>
			
			<td><span class="badge badge-primary"><?=$de->usuario?></span></td>
			<td><?=$de->rfc?></td>
			<td><?=$de->nombre_corto?> / <?=$de->nombre?></td>
			<td>
				<ul>
					<li>Domicilio: <?=$de->domicilio_fiscal?></li>
					<li>Teléfono: <?=$de->telefono?></li>
					<li>Correo: <?=$de->correo?></li>
				</ul>
			</td>
			<td>
				<ul>
					<li>Legal: <?=$de->representante_legal?></li>
					<li>Trabajadores: <?=$de->representante_trabajadores?></li>
				</ul>
			</td>
			<td>
				<button type="button" class="btn btn-outline-info btn-sm btn_modificar_empresa" data-id_datos_empresa="<?=$de->id_datos_empresa?>"
						data-id_usuario="<?=$usuario->id_usuario?>"
						data-from_catalogo="si"
						data-toggle="tooltip" title="Modificar empresa">
					<i class="fas fa-edit"></i>
				</button>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="6">Sin registros encontrados</td>
	</tr>
<?php endif ?>
