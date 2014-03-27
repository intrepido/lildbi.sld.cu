<?php
echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),	
		__('Indexar Bases'),
	), array('class' => 'breadcrumb row-fluid'));
?>

<div class="container-document">
	<div class="row-fluid">
		<div >
			<div class="container-document-inner">
				<legend>
					<?php echo __('Bases Disponibles'); ?>
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
							<td>
								<?php echo $value['name'] ?>
                            </td>
							<td>
                            	<?php
                            	if($value['countDocs'] != 0){
                       			 echo $value['countDocs'].' documentos indexados.' ;
								}else{
								 echo 'Sin indexar.' ;									
								}
								?>                            
                            </td>
								<td class="span1">
                               	 <div class="btn-group">
                              	  <?php if($value['capacity'] != "success"){ 
								  echo $this->Html->link($this->Html->tag('icon',null,array('class'=>'icon-ok')), array('action' => 'toindex', $value['name']),array('class'=>'btn overDesc','rel'=>'tooltip','data-original-title'=>'Indexar','escape'=>false)); 
								
							 }else{ 
							 echo $this->Html->link($this->Html->tag('icon',null,array('class'=>'icon-refresh')), array('action' => 'toindex', $value['name']),array('class'=>'btn overDesc','rel'=>'tooltip','data-original-title'=>'Reindexar','escape'=>false));
								
								 echo $this->Html->link($this->Html->tag('icon',null,array('class'=>'icon-remove')), array('action' => 'unindex', $value['name']),array('class'=>'btn overDesc','rel'=>'tooltip','data-original-title'=>'Borrar del indice','escape'=>false),'Est&aacute; seguro?') ;
								
							 } ?>
                            </div>
                            </td>
						</tr>
						<?php }?>
					</tbody>
				</table>
		
				<center><p><font face="Verdana" size="1">S&oacute;lo las bases indexadas ser&aacute;n accesibles desde el buscador. Reindexelas peri&oacute;dicamente para actualizar el contenido indexado.</font></p></center>
			</div>
		</div>
	</div>

</div>

<script>
	$('.overDesc').tooltip();
</script>



