<?php echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		__('Usuarios'),
	), array('class' => 'breadcrumb')); ?>

<?php echo $this->Session->flash(); ?>
<div class="container-document">
	<div class="row-fluid">
		<div class="span3">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Acciones'); ?>
				</legend>
				<ul class="nav nav-pills">
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
					<?php echo __('Usuarios'); ?>
				</legend>
				<table class="table table-striped table-bordered table-hover inset-type">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('username'); ?></th>							
							<th><?php echo $this->Paginator->sort('email'); ?></th>
							<th><?php echo $this->Paginator->sort('created'); ?></th>
							<th><?php echo $this->Paginator->sort('modified'); ?></th>
							<th class="actions"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($users as $user): ?>
						<tr>
							<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
							<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
							<td><?php echo h($user['User']['username']); ?>&nbsp;</td>							
							<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
							<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
							<td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
							<td class="actions"><?php echo $this->Html->link(__('Ver'), array('action' => 'view', $user['User']['id'])); ?><br>
								<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $user['User']['id'])); ?><br>
								<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $user['User']['id']), null, __('Esta seguro que desea eliminar el # %s?', $user['User']['id'])); ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<p>
					<?php
					echo $this->Paginator->counter(array(
							'format' => __('Pagina {:page} de {:pages}, mostrando {:current} filas de {:count} total, comenzando en fila {:start}, terminando en {:end}')
					));
					?>
				</p>

				<?php echo $this->Paginator->pagination(); ?>
			</div>
		</div>
	</div>
</div>

