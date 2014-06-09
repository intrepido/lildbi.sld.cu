<!-- Main hero unit for a primary marketing message or call to action -->		

		<!-- Example row of columns -->
		<div class="row-fluid">
			<div class="hero-unit span6">
				<h2><?php echo utf8_encode( __('Administración')); ?></h2>
                <p><?php echo utf8_encode( __('Administración y gestión de documentos del sistema.')); ?></p>
				<?php echo $this->Html->link('Acceder', array('controller' => 'admin', 'action' => 'index'), array('class' => 'btn btn-primary btn-large')); ?>	</p>
			</div>
			<div class="hero-unit span6">
				<h2><?php echo utf8_encode( __('Búsqueda')); ?></h2>
                <p><?php echo utf8_encode( __('Realizar búsquedas en nuestras bases de datos.')); ?></p>
				<?php echo $this->Html->link(__('Acceder'), array('controller' => 'searches', 'action' => 'index'), array('class' => 'btn btn-primary btn-large')); ?>
				</p>
			</div>
			
		</div>

		
		
