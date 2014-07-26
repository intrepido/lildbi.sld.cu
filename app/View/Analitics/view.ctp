<?php 
echo $this->Html->script('analitics', FALSE);

echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
		$this->Html->link( __('Analíticas'), array('controller' => 'analitics','action' => 'index', $this->Session->check('idDocumentForUrl')? $this->Session->read('idDocumentForUrl') : '' ), array('id' => 'backUrl')),
		__('Ver')
	), array('class' => 'breadcrumb')); ?>

<div class="container-document">
	<div class="page-header">
		<h3>
			<?php echo $type; ?>
		</h3>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr style="background-color: #8B979D; font-size: 18px;">
				<th class="insetType">Tag</th>
				<th class="insetType">Campo</th>
				<th class="span4 insetType">Valor</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach($analitics as $key => $val):
			$value = Set::extract('{s}', $val);
			$name = array_keys($val);
			if($value[0] != "" && $value[0] != "null" && $key!='v98' && $key!='_id'){
						  $tag = substr($key, 1);
						  strlen($tag) == 1 ? $tag = "0".$tag : null;
						  ?>
			<tr>
				<td><?php echo "[". $tag ."]";?></td>
				<td><?php echo $name[0];?></td>
				<?php if(!is_array($value[0])){?>
				<td><strong><?php echo $value[0];?> </strong>
				</td>
				<?php }else{?>
				<td><strong> <?php foreach($value[0] as $item):
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
			<?php echo $this->Form->button(__('Atras'), array('type' => 'button', 'class' => 'btn', 'id'=>'backView'));?>
	</div>
</div>
