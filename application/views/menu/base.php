<aside class="main-sidebar sidebar-dark-primary elevation-4" id="menu_lateral_izquierdo">
	<!-- Brand Logo -->
	<a href="<?=base_url()?>" class="brand-link">
		<img src="<?=base_url()?>assets/imgs/logos/icono_ckv.png" alt="Civika PED Logo" class="brand-image img-circle elevation-3">
		<span class="brand-text font-weight-light">SII PED</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<?php if(isset($usuario)): ?>

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<!-- menu admin -->
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<!-- opciones del menu para los usuarios -->
					<?php $this->load->view('menu/catalogo'); ?>
					<?php $this->load->view('menu/reportes'); ?>
					<?php $this->load->view('menu/configuracion'); ?>
					<?php $this->load->view('menu/usuario'); ?>
					<?php $this->load->view('menu/estandar_competencia'); ?>
				</ul>
			</nav>
			<!-- /.sidebar-menu -->
		<?php else: ?>
		<?php endif; ?>
	</div>
	<!-- /.sidebar -->

</aside>
