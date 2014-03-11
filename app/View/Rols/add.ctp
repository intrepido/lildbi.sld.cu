<?php echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Usuarios'), array('controller' => 'users','action' => 'index')),
		$this->Html->link(__('Roles'), array('controller' => 'rols','action' => 'index')),
		'Nuevo Rol',
	), array('class' => 'breadcrumb row-fluid')); ?>
	
<div class="container-document">
	<div class="row-fluid">
		<div class="span3">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Acciones'); ?>
				</legend>
				<ul class="nav nav-pills">
					<li><?php echo $this->Html->link(__('Listar Roles'), array('action' => 'index')); ?>
					</li>
					<li><?php echo $this->Html->link(__('Listar Usuarios'), array('controller' => 'users', 'action' => 'index')); ?>
					</li>
					<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'users', 'action' => 'add')); ?>
					</li>
				</ul>
			</div>
		</div>
		<div class="span9">
			<div class="container-document-inner">
				<?php echo $this->Form->create('Rol'); ?>
				<fieldset>
					<legend>
						<?php echo __('Adicionar Rol'); ?>
					</legend>
					<?php
					echo $this->Form->input('name');
					echo $this->Form->input('User');
					?>
				</fieldset>
				<?php echo $this->Form->end(__('Confirmar')); ?>
			</div>
		</div>
	</div>
</div>
