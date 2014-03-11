<?php echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Usuarios'), array('controller' => 'users','action' => 'index')),
		__('Roles'),
	), array('class' => 'breadcrumb row-fluid')); ?>

<?php echo $this->Session->flash(); ?>
<div class="container-document">
	<div class="row-fluid">
		<div class="span3">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Acciones'); ?>
				</legend>
				<ul class="nav nav-pills">
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
					<?php echo __('Roles'); ?>
				</legend>
				<table cellpadding="0" cellspacing="0"
					class="table table-striped table-bordered table-hover inset-type">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('id'); ?>
							</th>
							<th><?php echo $this->Paginator->sort('name'); ?>
							</th>
							<th><?php echo $this->Paginator->sort('created'); ?>
							</th>
							<th><?php echo $this->Paginator->sort('modified'); ?>
							</th>
							<th><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php	foreach ($rols as $rol): ?>
						<tr>
							<td><?php echo h($rol['Rol']['id']); ?>&nbsp;</td>
							<td><?php echo h($rol['Rol']['name']); ?>&nbsp;</td>
							<td><?php echo h($rol['Rol']['created']); ?>&nbsp;</td>
							<td><?php echo h($rol['Rol']['modified']); ?>&nbsp;</td>
							<td class="actions"><?php echo $this->Html->link(__('Ver'), array('action' => 'view', $rol['Rol']['id'])); ?><br>
								<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $rol['Rol']['id'])); ?><br>
								<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $rol['Rol']['id']), null, __('Esta seguro que desea eliminar el # %s?', $rol['Rol']['id'])); ?>
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

