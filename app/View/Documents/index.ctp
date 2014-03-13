<?php 
echo $this->Html->script('paginate', FALSE);

echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		__('Documentos')
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
					<li class="dropdown"><a href="#" data-toggle="dropdown"
						role="button" id="drop4" class="dropdown-toggle"><?php echo __('Nuevo Documento'); ?>
							<b class="caret"></b> </a>
						<ul aria-labelledby="drop4" role="menu" class="dropdown-menu"
							id="menu1">
							<li role="presentation"><?php echo $this->Html->link(utf8_encode(__('Con Indezación')), array('action' => 'add', 'con_indizacion'), array('role' => 'menuitem')); ?>
							</li>
							<li role="presentation"><?php echo $this->Html->link(utf8_encode(__('Sin Indezación')), array('action' => 'add', 'sin_indizacion'), array('role' => 'menuitem')); ?>
							</li>
						</ul>
					</li>
					<li><?php echo $this->Html->link(utf8_encode(__('Listar Analíticas')), array('controller' => 'analitics', 'action' => 'index')); ?>
					</li>
			
			</div>
		</div>

		<div class="span9">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Documentos'); ?>
				</legend>

				<table id='list-source-documents'
					class="table table-striped table-bordered table-hover inset-type"
					style="display: none">
					<thead>
						<tr>
							<th><?php echo utf8_encode(__('Id')); ?></th>
							<th><?php echo utf8_encode(__('Título')); ?></th>
							<th><?php echo utf8_encode(__('Documentalista')); ?></th>
							<th><?php echo utf8_encode(__('Fecha de Publicación')); ?></th>
							<th style="width: 0px;"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<tbody>
					</tbody>					
				</table>
				
				<!-- Actions -->
					<div style="display: none" id='actions'>					
							<div class="btn-toolbar">
								<div class="btn-group">
									<a href="documents/view/" class="btn"
										data-title="<?php echo __('Ver'); ?>" data-placement="top"
										data-toggle="tooltip"><i
										class="icon-eye-open"></i> </a>
									<a href="documents/edit/"
										class="btn" data-title="<?php echo __('Editar'); ?>"
										data-placement="top" data-toggle="tooltip"><i
										class="icon-pencil"></i> </a>
									<a href="#" class="btn"
										data-title="<?php echo __('Eliminar'); ?>"
										data-placement="top" data-toggle="tooltip" id="delete"><i
										class="icon-remove"></i><input type="hidden" value=""> </a>
									<a href="analitics/add/" class="btn"
										data-title="<?php echo utf8_encode(__('Adicionar analítica')); ?>"
										data-placement="top" data-toggle="tooltip"><i
										class="icon-plus"></i> </a>
									<a href="analitics/index/"
										class="btn" id="total-analitics"
										data-title="<?php echo utf8_encode(__('Ver analíticas')); ?>"
										data-placement="top" data-toggle="tooltip"><span
										class="badge">0</span> </a>
								</div>
							</div>						
					</div>

				<div class="alert alert-error fade in"
					id="alert-empty-list-document" style="display: none;">					
					<?php echo utf8_encode(__('No tiene documentos en su base de datos')); ?>
				</div>

				<div id="loading" style="text-align: center;"></div>
				<div id="paginator" style="display: none"></div>


				<!-- Modal Delete-->
				<div id="modal-confirmation-delete" class="modal hide fade"
					tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
					aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true">&times;</button>
						<h3 id="myModalLabel">
							<?php echo utf8_encode(__('Confirmación')); ?>
						</h3>
					</div>
					<div class="modal-body">
						<p>
							<?php echo utf8_encode(__('Esta seguro que desea eliminar el documento y todas sus analíticas?')); ?>
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">
							<?php echo __('Cerrar'); ?>
						</button>
						<button id="delete-document" class="btn btn-primary">
							<?php echo __('Eliminar'); ?>
						</button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

