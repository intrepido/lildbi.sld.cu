<!-- Main hero unit for a primary marketing message or call to action -->		

		<!-- Example row of columns -->
		<div class="row-fluid">
			<div class="hero-unit span6">
				<h2><?php echo utf8_encode( __('Administraci�n')); ?></h2>
                <p><?php echo utf8_encode( __('Administraci�n y gesti�n de documentos del sistema.')); ?></p>
				<?php echo $this->Html->link('Acceder', array('controller' => 'admin', 'action' => 'index'), array('class' => 'btn btn-primary btn-large')); ?>	</p>
			</div>
			<div class="hero-unit span6">
				<h2><?php echo utf8_encode( __('B�squeda')); ?></h2>
                <p><?php echo utf8_encode( __('Realizar b�squedas en nuestras bases de datos.')); ?></p>
				<?php echo $this->Html->link(__('Acceder'), array('controller' => 'searches', 'action' => 'index'), array('class' => 'btn btn-primary btn-large')); ?>
				</p>
			</div>
			
		</div>

		
		
