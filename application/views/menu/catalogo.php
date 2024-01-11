<?php if(perfil_permiso_operacion_menu('catalogos.modificar')):?>
	<li class="nav-item <?=isset($sidebar) && in_array($sidebar,array('cat_bienvenida','cat_sectores','cat_empresa','cat_ocupaciones')) ? ' menu-is-opening menu-open':''?>" >
		<a href="<?=base_url()?>usuario" class="nav-link nav-link-wm <?=isset($sidebar) && in_array($sidebar,array('cat_bienvenida','cat_sectores','cat_empresa','cat_ocupaciones')) ? ' active':''?>">
			<i class="nav-icon fas fa-list"></i>
			<p>
				Catalogos
				<i class="right fas fa-angle-left"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="<?=base_url()?>catalogos/msg-bienvenida" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'cat_bienvenida' ? 'active':''?>">
					<i class="nav-icon fas fa-comment"></i>
					<p>Mensaje de bienvenida</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?=base_url()?>catalogos/sectores" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'cat_sectores' ? 'active':''?>">
					<i class="nav-icon fas fa-table"></i>
					<p>Sectores</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?=base_url()?>catalogos/empresa" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'cat_empresa' ? 'active':''?>">
					<i class="nav-icon fas fa-building-user"></i>
					<p>Empresa (por usuarios)</p>
				</a>
			</li>
			<!-- <li class="nav-item">
				<a href="<?=base_url()?>catalogos/ocupaciones" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'cat_ocupaciones' ? 'active':''?>">
					<i class="nav-icon fas fa-book"></i>
					<p>Nacional de ocupaciones</p>
				</a>
			</li> -->
		</ul>
	</li>
<?php endif; ?>
