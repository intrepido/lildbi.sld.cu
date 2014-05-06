<?php
echo $this->Html->script('bases', FALSE);

echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),	
		__('Importar Bases'),
	), array('class' => 'breadcrumb'));
?>





<div class="container-document">
	<div class="row-fluid">
		<div class="span4">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Nombre de la Base'); ?>
				</legend>
				<div class="alert alert-error fade in" id="alert-name-base"
					style="display: none;">
					<button data-dismiss="alert" class="close" type="button">&times;</button>
					<?php echo __('Ya existe una base con ese nombre.'); ?>
				</div>
				<div class="alert alert-error fade in" id="alert-empty-base"
					style="display: none;">
					<button data-dismiss="alert" class="close" type="button">&times;</button>
					<?php echo utf8_encode(__('La base no puede importarse ya que esta no existe o esta vacía en el proveedor')); ?>
				</div>				
				<input id="name-base" type="text" class="input-small">
				<button id="add-base" class="btn" style="margin-bottom: 10px;">
					<?php echo __('Adicionar'); ?>
				</button>
			</div>
		</div>
		<div class="span8">
			<div class="container-document-inner">
				<legend>
					<?php echo __('Seleccione las Bases a Importar'); ?>
				</legend>

				<?php 
				$displayTable = "none";
				$displayAlert = "";

				if(!empty($bases)){
					$displayTable = "";
					$displayAlert = "none";
				}
				?>

				<div class="alert alert-error fade in" id="alert-base-exist"
					style="display: <?php echo $displayAlert ?>;">
					<?php echo __('No existe Bases creadas para importar.'); ?>
				</div>

				<table id="list-bases" style="display: <?php echo $displayTable ?>;" cellspacing="0" cellpadding="0"
					class="table table-bordered table-hover">
					<tbody>
						<?php foreach ($bases as $value) {							
							$temp = "";
							if($value['capacity'] == "success"){
							$temp = "style='background-color: rgb(223, 240, 216);'";
						}
						?>
						<tr class="<?php echo $value['capacity'] ?>" <?php echo $temp ?>>
							<td class="span1"><input type="checkbox"></td>
							<td><?php echo $value['name'] ?></td>
							<td class="load" style='display: none; width: 100%;'></td>
							<td class="span1"><a id="delete-alert" class="btn">X</a></td>
						</tr>
						<?php }?>
					</tbody>
				</table>

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
							<?php echo utf8_encode(__('Si elimina la base perderá todo los registros que esta contenga. Esta seguro que desea eliminarla?')); ?>
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">
							<?php echo __('Close'); ?>
						</button>
						<button id="delete-base" class="btn btn-primary">
							<?php echo __('Eliminar'); ?>
						</button>
					</div>
				</div>
				

				<button id="importar" type="submit" class="btn btn-primary">
					<?php echo __('Importar'); ?>
				</button>
			</div>
		</div>
	</div>

</div>





