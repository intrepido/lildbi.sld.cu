<div class="container-initial-search" align="center">
   
	<?php echo $this->Form->create('query',array('onsubmit' => 'return validate();')); ?>
	  <?php echo$this->Html->image('logo.png', array('alt' => 'Logo'))?></br></br> 
      <input id="search"  name="data[query][qText]" type="text" class="span5 search-query" autocomplete="off" placeholder= "<?php echo __('Escriba palabras para buscar libros, revistas, etc.'); ?>" />    
  	  
      <table>
              <tr>
                  <td>
                      <div>
                      	  <?php echo $this->Html->link(__('Búsqueda Avanzada ').$this->Html->tag('icon',null,array('class'=>'icon-cog')), array( 'action'=>'advancedSearch'),array('plugin' => false,'class' => 'btn btn-info','escape' => false)); ?>
                         
                      </div>
                  </td>	
                  <td>
                      &nbsp;&nbsp;&nbsp;
                  </td>
                  <td>
                      <div>
                          <?php echo $this->Form->button(__("Buscar ").$this->Html->tag('icon',null,array('class'=>'icon-search')), array("type" => 'commit' , 'class' => 'btn btn-primary','escape' => false));?>
                      </div>
                  </td>
                      
              </tr>
      </table>
      </br>
      
    <?php $this->Form->end(); ?>
    
    <div align="center" class="alert span6" style="display:none">
      <strong><?php echo __('Atención!'); ?></strong> <?php echo __('Debe introducir términos para buscar.'); ?>
    </div>
  
</div>


