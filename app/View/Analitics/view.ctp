<?php echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Analíticas'), array('controller' => 'documents','action' => 'index')), __('Ver')
	), array('class' => 'breadcrumb row-fluid')); ?>

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
			foreach($document as $key => $value):
			if($value['value'] != "" && $value['value'] != "null" && $key!='v98' && $key!='_id'){
					  $tag = substr($key, 1);
					  strlen($tag) == 1 ? $tag = "0".$tag : null;
					  ?>
			<tr>
				<td><?php echo "[". $tag ."]";?></td>
				<td><?php echo $value['name'];?></td>
				<td><strong><?php echo str_replace("\n", "</br>", $value['value']);?>
				</strong>
				</td>
			</tr>
			<?php } ?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<hr>
</div>
