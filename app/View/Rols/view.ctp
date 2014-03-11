<?php echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Usuarios'), array('controller' => 'users','action' => 'index')),
		$this->Html->link(__('Roles'), array('controller' => 'rols','action' => 'index')),
		'Ver',
	), array('class' => 'breadcrumb row-fluid')); ?>

<div class="container-document">
	<div class="row-fluid">
		<div class="span3">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Acciones'); ?>
				</legend>
				<ul class="nav nav-pills">
					<li><?php echo $this->Html->link(__('Editar Rol'), array('action' => 'edit', $rol['Rol']['id'])); ?>
					</li>
					<li><?php echo $this->Form->postLink(__('Eliminar Rol'), array('action' => 'delete', $rol['Rol']['id']), null, __('Esta seguro que desea eliminar el # %s?', $rol['Rol']['id'])); ?>
					</li>
					<li><?php echo $this->Html->link(__('Listar Roles'), array('action' => 'index')); ?>
					</li>
					<li><?php echo $this->Html->link(__('Nuevo Rol'), array('action' => 'add')); ?>
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
				<legend>
					<?php echo __('Rol'); ?>
				</legend>
				<dl class="dl-horizontal">
					<dt>
						<?php echo __('Id') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($rol['Rol']['id']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Nombre') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($rol['Rol']['name']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Creado') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($rol['Rol']['created']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Modificado') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($rol['Rol']['modified']); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
		</div>
		<div class="span12" style="margin-left: 0px;">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Usuarios Relacionados'); ?>
				</legend>
				<?php if (!empty($rol['User'])): ?>
				<table cellpadding="0" cellspacing="0"
					class="table table-striped table-bordered table-hover inset-type">
					<thead>
						<tr>
							<th><?php echo __('Id'); ?></th>
							<th><?php echo __('Nombre'); ?></th>
							<th><?php echo __('Nombre de Usuario'); ?></th>
							<th><?php echo __('Email'); ?></th>
							<th><?php echo __('Creado'); ?></th>
							<th><?php echo __('Modificado'); ?></th>
							<th class="actions"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<?php
					$i = 0;
				foreach ($rol['User'] as $user): ?>
					<tbody>
						<tr>
							<td><?php echo $user['id']; ?></td>
							<td><?php echo $user['name']; ?></td>
							<td><?php echo $user['username']; ?></td>
							<td><?php echo $user['email']; ?></td>
							<td><?php echo $user['created']; ?></td>
							<td><?php echo $user['modified']; ?></td>
							<td class="actions"><?php echo $this->Html->link(__('Ver'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?><br>
								<?php echo $this->Html->link(__('Editar'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?><br>
								<?php echo $this->Form->postLink(__('Eliminar'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Esta seguro que desea eliminar el # %s?', $user['id'])); ?>
							</td>
						</tr>
					</tbody>
					<?php endforeach; ?>
				</table>
				<?php endif; ?>
				<div class="span2">
					<div class="actions">
						<ul class="nav">
							<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'users', 'action' => 'add')); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
