<script type="text/javascript">
	//<![CDATA[
	       //Se procesa en 'searches.js'
           window.urlLastSearch = "<?php echo urlencode($result['urlParams'].'&rows=');?>";	
    //]]>
</script>

<?php echo $this->Form->create('query',array('onsubmit' => 'return validate();')); ?>
<div class="well container-search">
	<div class="span9">
		<div class="input-append">
			<input id="search" class="span4" name="data[query][qText]"
				type="text"
				value="<?php echo $result['responseHeader']['params']['q']; ?>"
				autocomplete="off" placeholder='Buscar libros, revistas, etc.'>
			<button type="submit" class="btn btn-primary">
				Buscar
				<icon class="icon-search"></icon>
			</button>
		</div>
		<?php echo $this->Html->link(utf8_encode(__('Búsqueda Avanzada ')).$this->Html->tag('icon',null,array('class'=>'icon-cog')), array( 'action'=>'advancedSearch'),array('class' => 'btn btn-info','escape' => false)); ?>
		
	</div>
	<div class="span3">
		<div class="input-prepend">
			<span class="add-on"><?php echo utf8_encode(__('Resultados por página')); ?></span> <select
				name="data[query][rows]" id="queryRows"
				class="span4">
				<option
					<?php if($result['responseHeader']['params']['rows'] == 10){echo 'selected="selected"';}?>
					value="10">10</option>
				<option
					<?php if($result['responseHeader']['params']['rows'] == 20){echo 'selected="selected"';}?>
					value="20">20</option>
				<option
					<?php if($result['responseHeader']['params']['rows'] == 40){echo 'selected="selected"';}?>
					value="40">40</option>
				<option
					<?php if($result['responseHeader']['params']['rows'] == 60){echo 'selected="selected"';}?>
					value="60">60</option>
			</select>
		</div>
	</div>
</div>
<?php $this->Form->end(); ?>


<!-- highlight -->
<style>
	em{background: lemonchiffon;}
</style>
