<?php 
echo $this->Html->script('paginate', FALSE);

echo $this->Html->breadcrumb(array(
					$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
					$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
					utf8_encode(__('Analíticas'))
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
							<li role="presentation"><?php echo $this->Html->link(utf8_encode(__('Con Indezación')), array('controller' => 'documents', 'action' => 'add', 'con_indizacion'), array('role' => 'menuitem')); ?>
							</li>
							<li role="presentation"><?php echo $this->Html->link(utf8_encode(__('Sin Indezación')), array('controller' => 'documents', 'action' => 'add', 'sin_indizacion'), array('role' => 'menuitem')); ?>
							</li>
						</ul>
					</li>
					<li><?php echo $this->Html->link(__('Listar Documentos'), array('controller' => 'documents', 'action' => 'index')); ?>
					</li>
				</ul>
			</div>
		</div>

		<div class="span9">
			<div class="container-document-inner">
				<legend>
					<?php 	
					if(isset($documentTitle)){
						$documentTitle = __(" del documento - ").$this->Html->link($documentTitle, array('controller' => 'documents', 'action' => 'view', $idDocument ));
					}
					else{
						$documentTitle = "";
					}
					
					
					
					echo utf8_encode(__('Analíticas')).$documentTitle;
					?>
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
					
					<!-- Actions -->
					<div style="display: none" id='actions'>
						<div class="btn-toolbar">
							<div class="btn-group">
								<a href="/lildbi/analitics/view/" class="btn"
									data-title="<?php echo __('Ver'); ?>" data-placement="top"
									data-toggle="tooltip"><i class="icon-eye-open"></i> </a> <a
									href="/lildbi/analitics/edit/" class="btn"
									data-title="<?php echo __('Editar'); ?>" data-placement="top"
									data-toggle="tooltip"><i class="icon-pencil"></i> </a> <a
									href="#" class="btn" data-title="<?php echo __('Eliminar'); ?>"
									data-placement="top" data-toggle="tooltip" id="delete"><i
									class="icon-remove"></i><input type="hidden" value=""> </a> <a
									href="/lildbi/analitics/index" class="btn"
									data-title="<?php echo __('Ver fuente'); ?>"
									data-placement="top" data-toggle="tooltip"><i
									class="icon-tasks"></i> </a>
							</div>
						</div>
					</div>
				</table>

				<div class="alert alert-error fade in"
					id="alert-empty-list-analitics" style="display: none;">					
					<?php echo utf8_encode(__('No tiene analiticas en su base de datos')); ?>
				</div>
				
				<div class="alert alert-error fade in"
					id="alert-empty-list-document-analitics" style="display: none;">					
					<?php echo utf8_encode(__('Este documento no tiene analíticas')); ?>
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
							<?php echo utf8_encode(__('Esta seguro que desea eliminar esta analítica?')); ?>
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

