<?php echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Usuarios'), array('controller' => 'users','action' => 'index')),
		'View',
	), array('class' => 'breadcrumb')); ?>

<div class="container-document">
	<div class="row-fluid">
		<div class="span3">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Acciones'); ?>
				</legend>
				<ul class="nav nav-pills">
					<li><?php echo $this->Html->link(__('Editar Usuario'), array('action' => 'edit', $user['User']['id'])); ?>
					</li>
					<li><?php echo $this->Form->postLink(__('Eliminar Usuario'), array('action' => 'delete', $user['User']['id']), null, __('Esta seguro que desea eliminar el # %s?', $user['User']['id'])); ?>
					</li>
					<li><?php echo $this->Html->link(__('Listar Usuarios'), array('action' => 'index')); ?>
					</li>
					<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('action' => 'add')); ?>
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
				<legend>
					<?php echo __('Usuario'); ?>
				</legend>
				<dl class="dl-horizontal">
					<dt>
						<?php echo __('Id') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($user['User']['id']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Nombre') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($user['User']['name']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Nombre de Usuario'); ?>
					</dt>
					<dd>
						<?php echo h($user['User']['username']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Inicial') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($user['User']['initials']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Código del Centro') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($user['User']['center_code']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Email') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($user['User']['email']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Creado') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($user['User']['created']); ?>
						&nbsp;
					</dd>
					<dt>
						<?php echo __('Modificado') . ":"; ?>
					</dt>
					<dd>
						<?php echo h($user['User']['modified']); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
		</div>
		<div class="span12" style="margin-left: 0px;">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Roles Relacionados'); ?>
				</legend>
				<?php if (!empty($user['Rol'])): ?>
				<table cellpadding="0" cellspacing="0"
					class="table table-striped table-bordered table-hover inset-type">
					<thead>
						<tr>
							<th><?php echo __('Id'); ?></th>
							<th><?php echo __('Nombre'); ?></th>
							<th><?php echo __('Creado'); ?></th>
							<th><?php echo __('Modificado'); ?></th>
							<th class="actions"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<?php
					$i = 0;
		foreach ($user['Rol'] as $rol): ?>
					<tbody>
						<tr>
							<td><?php echo $rol['id']; ?></td>
							<td><?php echo $rol['name']; ?></td>
							<td><?php echo $rol['created']; ?></td>
							<td><?php echo $rol['modified']; ?></td>
							<td class="actions"><?php echo $this->Html->link(__('Ver'), array('controller' => 'rols', 'action' => 'view', $rol['id'])); ?><br>
								<?php echo $this->Html->link(__('Editar'), array('controller' => 'rols', 'action' => 'edit', $rol['id'])); ?><br>
								<?php echo $this->Form->postLink(__('Eliminar'), array('controller' => 'rols', 'action' => 'delete', $rol['id']), null, __('Are you sure you want to delete # %s?', $rol['id'])); ?>
							</td>
						</tr>
					</tbody>
					<?php endforeach; ?>
				</table>
				<?php endif; ?>
				<div class="span2">
					<div class="actions">
						<ul class="nav">
							<li><?php echo $this->Html->link(__('Nuevo Rol'), array('controller' => 'rols', 'action' => 'add')); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
