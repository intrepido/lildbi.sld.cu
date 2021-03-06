<?php
echo $this->Html->script('documents', FALSE);

if(!$this->Session->check('idEditDocument')){ //Si estoy adicionando un documento

	echo $this->Html->breadcrumb(array(
			$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
			$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
			$this->Html->link($this->Session->read('index'), array('controller' => 'documents','action' => 'add')),
			$this->Html->link($typeNameDocument, "#", array('id' => 'backBreadcrumb')),
			utf8_encode(__('Visualización'))
	), array('class' => 'breadcrumb row-fluid'));

}else{ //Si estoy editando un documento
	echo $this->Html->breadcrumb(array(
			$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
			$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
			$this->Html->link(__('Editar'), "#", array('id' => 'backBreadcrumb')),
			utf8_encode(__('Visualización'))
	), array('class' => 'breadcrumb row-fluid'));
}
?>



<div class="container-document">
	<div class="page-header">
		<h3>
			<?php echo $typeNameDocument; ?>
		</h3>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr style="background-color: #8B979D; font-size: 18px;">
				<th class="insetType"><?php echo __('Tag');?></th>
				<th class="insetType"><?php echo __('Campo');?></th>
				<th class="span4 insetType"><?php echo __('Valor');?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach($data as $key => $value):
			$arrayKey = array_keys($value);
			$field = $arrayKey[0];
			$val = $value[$arrayKey[0]];
			if($val != "" && $val != "null"){
					  $tag = substr($key, 1);
					  strlen($tag) == 1 ? $tag = "0".$tag : null;
					  ?>
			<tr>
				<td><?php echo "[". $tag ."]";?></td>
				<td><?php echo $field;?></td>
				<?php if(!is_array($val)){?>
				<td><strong><?php echo str_replace("\n", "</br>", $val);?> </strong>
				</td>
				<?php }else{?>
				<td><strong> <?php foreach($val as $item):
				echo $item;?> </br> <?php endforeach; ?>
				</strong></td>
				<?php }?>
			</tr>
			<?php } ?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<hr>
	<div class="form-actions">
		<table>
			<tr>
				<td>
					<form accept-charset="utf-8" method="post"
						id="DocumentVisualizationForm"
						action="/lildbi/documents/<?php echo $this->Session->check('idEditDocument') ? 'edit' : 'add';?>/<?php echo $urlTypeNameDocument;?><?php echo $this->Session->check('idEditDocument') ? '/'.$this->Session->read('idEditDocument') : '';?>">
						<div style="display: none;">
							<input type="hidden" value="POST" name="_method">
						</div>
						<input type="hidden" id="DocumentData"
							value="<?php echo str_replace("\"", "&quot;", serialize($data));?>"
							name="data[Document][Back]">
						<div class="control-group">
							<?php echo $this->Form->button(__('Atras'), array('id' => 'backAction', 'type' => 'submit', 'class' => 'btn'));?>
							<?php echo $this->Form->button(__('Confirmar'), array('id' => 'confirmAction', 'type' => 'submit', 'class' => 'btn btn-primary'));?>
						</div>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>


