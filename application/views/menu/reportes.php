<?php if(perfil_permiso_operacion_menu('reportes_ped.consultar')):?>
	<li class="nav-item <?=isset($sidebar) && in_array($sidebar,array('reporte_empresa','reporte_candidato')) ? ' menu-is-opening menu-open':''?>" >
		<a href="<?=base_url()?>usuario" class="nav-link nav-link-wm <?=isset($sidebar) && in_array($sidebar,array('reporte_empresa','reporte_candidato')) ? ' active':''?>">
			<i class="nav-icon fas fa-database"></i>
			<p>
				Reportes
				<i class="right fas fa-angle-left"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="<?=base_url()?>reportes/empresa" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'reporte_empresa' ? 'active':''?>">
					<i class="nav-icon fas fa-building"></i>
					<p>Reporte por empresa</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?=base_url()?>reportes/candidato" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'reporte_candidato' ? 'active':''?>">
					<i class="nav-icon fas fa-user-tag"></i>
					<p>Reporte por candidatos</p>
				</a>
			</li>
		</ul>
	</li>
<?php endif; ?>
