<?php echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Usuarios'), array('controller' => 'users','action' => 'index')),
		__('Nuevo Usuario'),
	), array('class' => 'breadcrumb')); ?>
<div class="container-document">
	<div class="row-fluid">
		<div class="span3">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Acciones'); ?>
				</legend>
				<ul  class="nav nav-pills">

					<li><?php echo $this->Html->link(__('Listar Usuarios'), array('action' => 'index')); ?>
					</li>
					<li><?php echo $this->Html->link(__('Listar Roles'), array('controller' => 'rols', 'action' => 'index')); ?>
					</li>
					<li><?php echo $this->Html->link(__('Nuevo Rol'), array('controller' => 'rols', 'action' => 'add')); ?>
					</li>
				</ul>
			</div>
		</div>
		<div class="span9">
			<div class="container-document-inner">
				<?php echo $this->Form->create('User'); ?>
				<fieldset>
					<legend>
						<?php echo utf8_encode(__('A�adir Usuario')); ?>
					</legend>
					<?php
					echo $this->Form->input('name');
					echo $this->Form->input('username');
					echo $this->Form->input('initials');
					echo $this->Form->input('center_code');
					echo $this->Form->input('email');
					echo $this->Form->input('password');
					echo $this->Form->input('password_confirmation', array('type'=>'password'));
					echo $this->Form->input('Rol');
					?>
				</fieldset>
				<?php echo $this->Form->end(__('Confirmar')); ?>
			</div>
		</div>
	</div>

</div>
