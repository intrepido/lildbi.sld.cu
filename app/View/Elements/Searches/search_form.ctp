<div style="margin-top:50px">
  <center> 
	<?php echo $this->Form->create('query'); ?>
	  <?php echo$this->Html->image('logo.png', array('alt' => 'Logo'))?></br></br>
      <?php echo $this->Form->input('qText', array('label' => '','type' => 'text','class' => 'span5 search-query','placeholder' => 'Inserte una o varias palabras...')); ?>
      
      <div id="options" class="collapse" >
      
          <table >
              <tr>
                  <td>
                      <p style="margin: 0 5px 20px" >Referencias por p&aacute;gina </p>
                  </td>
                  <td>
					  <?php echo $this->Form->input('rows', array('label'=>false, 'class'=>'span12', 'options' => array(
                          '10'=>'10',
                          '20'=>'20',
                          '40'=>'40',
                          '60'=>'60'
                       ))); ?>
                  </td>
                  <td>
                      <p style="margin: 0 5px 20px" > Formato de presentaci&aacute;n  </p>
                  </td>
                  <td>
					   <?php echo $this->Form->input('format', array('label'=>false , 'class'=>'span12', 'options' => array(
                            '0'=>'Afiliación',
                            '1'=>'Detallado',
                            '2'=>'Largo',
                            '3'=>'Citación',
                            '4'=>'Título'
                         ))); ?>
                  </td>			
              </tr>
          </table>
          
      </div>
      
      <table>
              <tr>
                  <td>
                      <div>
                          <?php echo $this->Form->button("Opciones ".$this->Html->tag('icon',null,array('class'=>'icon-cog')), array("type" => 'button','id' => 'button', 'class' => 'btn btn-info' , 'data-toggle' => 'collapse' , 'data-target'  => '#options','escape' => false));?>
                      </div>
                  </td>	
                  <td>
                      &nbsp;&nbsp;&nbsp;
                  </td>
                  <td>
                      <div>
                          <?php echo $this->Form->button("Buscar ".$this->Html->tag('icon',null,array('class'=>'icon-search')), array("type" => 'commit' , 'class' => 'btn btn-primary','escape' => false));?>
                      </div>
                  </td>
                      
              </tr>
      </table></br>
      
    <?php $this->Form->end(); ?>
  </center>
</div>

<script>
   $(".collapse").collapse('hidden');
</script>