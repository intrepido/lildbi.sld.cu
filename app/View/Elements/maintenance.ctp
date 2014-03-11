<div class="container-document">

	<div class="hero-unit">

		<div class="row-fluid show-grid">

			<div class="span10">
				<blockquote>
					<h2>
						<?php echo __("Web en Mantenimiento"); ?>
					</h2>
					<small><?php echo __("Disculpe las molestias, pronto estaremos en linea nuevamente..."); ?>
					</small>
			
			</div>
			<div class="span2">
				<div class="pull-right">
					<?php echo $this->Html->image('icon_preventative_maintenance.png'); ?>
				</div>
			</div>

		</div>

	</div>
	<!--  -->
	<blockquote>
		<p class="text-center">
			<?php echo __("El sitio web esta provisionalmente solo disponible para los usuarios con rol de administrador. En caso de tener rol de administrador, ") .  $this->Html->link(__('salga del sistema'), array( 'controller' => 'users', 'action' => 'logout')) . __(" y autentiquese como administrador para poder acceder."); ?>
		</p>
	</blockquote>
</div>


