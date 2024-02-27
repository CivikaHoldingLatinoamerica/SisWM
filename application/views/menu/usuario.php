<?php if(perfil_permiso_operacion_menu('usuarios.consultar')): ?>
	<?php $sidebarArray = ['usuarios','perfil_permisos','administradores','administradoresrrhh','instructores','candidatos']; ?>
	<li class="nav-item <?=isset($sidebar) && in_array($sidebar,$sidebarArray) ? ' menu-is-opening menu-open':''?>" >
		<a href="<?=base_url()?>usuario" class="nav-link nav-link-wm <?=isset($sidebar) && in_array($sidebar,$sidebarArray) ? ' active':''?>">
			<i class="nav-icon fas fa-user"></i>
			<p>
				Usuarios
				<i class="right fas fa-angle-left"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<?php if(perfil_permiso_operacion_menu('todos.todos')):?>
				<li class="nav-item">
					<a href="<?=base_url()?>perfil_permisos" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'perfil_permisos' ? 'active':''?>">
						<i class="nav-icon fas fa-user-tag"></i>
						<p>Perfiles y permisos</p>
					</a>
				</li>
			<?php endif; ?>
			<?php if(perfil_permiso_operacion_menu('usuarios.admin')):?>
				<li class="nav-item">
					<a href="<?=base_url()?>usuario/administradores" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'administradores' ? 'active':''?>">
						<i class="nav-icon fas fa-user-cog"></i>
						<p>Administradores</p>
					</a>
				</li>
			<?php endif; ?>
			<?php if(perfil_permiso_operacion_menu('usuarios.admin')):?>
				<li class="nav-item">
					<a href="<?=base_url()?>usuario/admin-rrhh" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'administradoresrrhh' ? 'active':''?>">
						<i class="nav-icon fas fa-users"></i>
						<p>Admin. de Empresa</p>
					</a>
				</li>
			<?php endif; ?>
			<?php if(perfil_permiso_operacion_menu('usuarios.instructor')):?>
				<li class="nav-item">
					<a href="<?=base_url()?>usuario/evaluadores" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'instructores' ? 'active':''?>">
						<i class="nav-icon fas fa-user-tie"></i>
						<p>Evaluadores</p>
					</a>
				</li>
			<?php endif; ?>
			<?php if(perfil_permiso_operacion_menu('usuarios.alumno')):?>
				<li class="nav-item">
					<a href="<?=base_url()?>usuario/candidatos" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'candidatos' ? 'active':''?>">
						<i class="nav-icon fas fa-user-graduate"></i>
						<p>Candidatos</p>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</li>
<?php endif; ?>
