<?php 

echo $this->Html->css('tablesorter/addons/pager/jquery.tablesorter.pager.css', FALSE);
echo $this->Html->css('tablesorter/theme.bootstrap.css', FALSE);
echo $this->Html->script('tablesorter/jquery.tablesorter.js', FALSE);
echo $this->Html->script('tablesorter/jquery.tablesorter.widgets.min.js', FALSE);
echo $this->Html->script('tablesorter/widgets/widget-columnSelector.js', FALSE);
echo $this->Html->script('tablesorter/addons/pager/jquery.tablesorter.pager.min.js', FALSE);
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

				<div class="accordion show-element" id="accordion-filter" style="display: none">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse"
								data-parent="#accordion-filter" href="#collapseOne"> Filtros de
								columnas </a>
						</div>
						<div id="collapseOne" class="accordion-body collapse">
							<div class="accordion-inner">
								<div id="columns">
									<div id="columnCarousel" style="display: none" class="carousel slide" data-interval="false">
										<!-- Carousel items -->
										<div class="carousel-inner">
											
										</div>
										<!-- Carousel nav -->
										<a class="carousel-control left" href="#columnCarousel"
											data-slide="prev">&lsaquo;</a> <a
											class="carousel-control right" href="#columnCarousel"
											data-slide="next">&rsaquo;</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div style="overflow: auto; padding-right: 13px; padding-left: 13px;">
					<table id='list-source-documents' class="tablesorter show-element"
						style="display: none">
						<thead>
							<tr>
								<th style="width: 0px;"><?php echo __('Acciones'); ?></th>
							</tr>
						</thead>						
						<tbody>
						</tbody>
					</table>					
				</div>
				<div style="padding-right: 13px; padding-left: 13px;">
					<table class="table table-bordered show-element" style="display: none;">
					  <thead>	
					 	 <tr>
							<th class="pager form-horizontal" colspan="87">
								<button class="btn first" type="button">
									<i class="icon-step-backward"></i>
								</button>
								<button class="btn prev" type="button">
									<i class="icon-arrow-left"></i>
								</button> <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
								<button class="btn next" type="button">
									<i class="icon-arrow-right"></i>
								</button>
								<button class="btn last" type="button">
									<i class="icon-step-forward"></i>
								</button> 
								<select title="Select page size" class="pagesize input-mini">
									<option value="3" selected="selected">3</option>
									<option value="5">5</option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option>
								</select> 
								<select title="Select page number" class="pagenum input-mini">
								</select>
							</th>
						</tr>						
					  </thead>						
					</table>
				</div>
				

				<!-- Actions -->
				<div style="display: none" id='actions'>
					<div class="btn-toolbar">
						<div class="btn-group">
							<a href="/lildbi/documents/view/" class="btn"
								data-title="<?php echo __('Ver'); ?>" data-placement="top"
								data-toggle="tooltip"><i class="icon-eye-open"></i> </a> <a
								href="/lildbi/documents/edit/" class="btn"
								data-title="<?php echo __('Editar'); ?>" data-placement="top"
								data-toggle="tooltip"><i class="icon-pencil"></i> </a> <a
								href="#" class="btn" data-title="<?php echo __('Eliminar'); ?>"
								data-placement="top" data-toggle="tooltip" id="delete"><i
								class="icon-remove"></i><input type="hidden" value=""> </a> <a
								href="/lildbi/analitics/add/" class="btn"
								data-title="<?php echo utf8_encode(__('Adicionar analítica')); ?>"
								data-placement="top" data-toggle="tooltip"><i class="icon-plus"></i>
							</a> <a href="#" class="btn" id="total-analitics"
								data-title="<?php echo utf8_encode(__('Ver analíticas')); ?>"
								data-placement="top" data-toggle="tooltip"><span class="badge">0</span>
							</a>
						</div>
					</div>
				</div>

				<div class="alert alert-error fade in"
					id="alert-empty-list-document" style="display: none;">
					<?php echo utf8_encode(__('No tiene documentos en su base de datos')); ?>
				</div>

				<div id="loading" style="text-align: center;"></div>


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

