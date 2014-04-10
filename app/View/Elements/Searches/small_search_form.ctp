<?php echo $this->Form->create('query'); ?>
  <div class="well well-small" style="margin-bottom: auto;">	
    <table align="center" style="width:100%;margin: 3px 5% -8px;">
      <tr>
      
          <td style="width:25%">    
            	<?php echo $this->Form->input('qText', array('label' => false,'type' => 'text' , 'value' => $result['responseHeader']['params']['q'] , 'style' => 'width:90%;margin-bottom: auto;')); ?>	
          </td>
          
          <td style="width:10%">
             	<?php echo $this->Form->button("Buscar ".$this->Html->tag('icon',null,array('class'=>'icon-search')), array("type" => 'submit' ,'style' => 'margin:10px;margin-top: auto;margin-left: auto;', 'class' => 'btn btn-primary','escape' => false));?>
          </td>
          
          <td style="width:5%">
          </td>
          
          <td style="width:13%">
             	<p style="margin: 0 0 10px" >Referencias por página:</p>
          </td>
          
          <td style="width:6%">
				<?php echo $this->Form->input('rows', array('label'=>false, 'style' => 'width:90%;margin-bottom: auto;', 'value' => $result['responseHeader']['params']['rows'],'options' => array(
                    '10'=>'10',
                    '20'=>'20',
                    '40'=>'40',
                    '60'=>'60'
                 ))); ?>
          </td>
          
          <td style="width:14%">
             <p style="margin: 0 0 10px" >Formato de presentación:</p>
          </td>
          
          <td style="width:9%">
             <?php echo $this->Form->input('format', array('label'=>false, 'style' => 'width:90%;margin-bottom: auto;', 'value' => $result['responseHeader']['params']['format'],'options' => array(
                  '0'=>'Afiliación',
                  '1'=>'Detallado',
                  '2'=>'Largo',
                  '3'=>'Citación',
                  '4'=>'Título'
               ))); ?>
          </td>
          
          <td style="width:4%">
          </td>
          
          <td>
          	<?php echo $this->Form->button("Imprimir ".$this->Html->tag('icon',null,array('class'=>'icon-print icon-white')), array("type" => 'button', 'onclick'=>'javascript:imprAllSelec();' ,'style' => 'margin:10px;margin-top: auto;margin-left: auto;', 'class' => 'btn btn-inverse','escape' => false));?>
          </td>
          
      </tr>
    </table>
  </div>
<?php $this->Form->end(); ?>

<script type="text/javascript">
	$('#container-fluid').css('margin-top', '43px');
</script>