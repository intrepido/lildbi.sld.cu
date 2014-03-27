<!-- Formulario inicial -->
<?php 	if(!isset($result)){ ?>
    <div style="margin-top:50px">
    <center> 
    <?php echo $this->Form->create('query'); ?>
    <?php echo$this->Html->image('logo.png', array('alt' => 'Logo'))?></br></br>
    <?php echo $this->Form->input('qText', array('label' => '','type' => 'text','class' => 'span5 search-query','placeholder' => 'Buscar...')); ?>
    
    <div id="options" class="collapse" align="center">
        <table >
                <tr>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp; Opcion 1 &nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td>
                        <div>
                           &nbsp;&nbsp;&nbsp; Opcion 2 &nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td>
                        <div>
                           &nbsp;&nbsp;&nbsp; Opcion 3 &nbsp;&nbsp;&nbsp;
                        </div>
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
                        <?php //echo $this->Form->end("Buscar ".$this->Html->tag('icon',null,array('class'=>'icon-search')),array('class' => 'btn','style'=>'border-radius:10px;', 'escape' => false));?>
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
<?php } ?>    


<!-- Formulario avanzado -->
<?php if(isset($result)){ ?>
	<?php echo $this->Form->create('query'); ?>
	<div class="well well-small" style="margin-bottom: auto;">	
 	<table style="width:100%">
    	<tr>
     		<td style="width:25%">    
    			<?php echo $this->Form->input('qText', array('label' => false,'type' => 'text','style' => 'width:90%;margin-bottom: auto;')); ?>	
            </td>
            <td style="width:10%">
    			 <?php echo $this->Form->button("Buscar ".$this->Html->tag('icon',null,array('class'=>'icon-search')), array("type" => 'submit' ,'style' => 'margin:10px;margin-top: auto;margin-left: auto;', 'class' => 'btn btn-primary','escape' => false));?>
            </td>
            <td style="width:65%">
    		</td>
        </tr>
     </table>
     </div>
     <?php $this->Form->end(); ?>
<?php } ?>  

<!-- Resultados -->
<?php 
	if(isset($result)){
		$responseHeader = $result['responseHeader'];
		$response = $result['response'];
		$docs = $response['docs'];
?>
<div class="container-document" >
		<p><?php echo $response['numFound'];?> resultados encontrados para: <i><?php echo $responseHeader['params']['q']; ?> </i><p>

		<?php foreach($docs as $doc){?> 
		<div class="well well-small">
			<font  face="Verdana" size="1">Id: <?php echo $doc['v2'];?> / Base: <?php echo $doc['v4'];?>   </font>
			<table class='table table-hover'>
				<tbody>
				<?php if(isset($doc['v12'])){ ?>
					<tr>
						<td class="span2" style='text-align:right' ><b>T&iacute;tulo: &nbsp;&nbsp;&nbsp;</b></td>
						<td class="span10" style='text-align:justify'>
							<b><?php echo strstr($doc['v12'],'<',true);?></b>
						</td>
					</tr>
				<?php } ?>
				<?php if(isset($doc['v18'])){ ?>
					<tr>
						<td class="span2" style='text-align:right' ><b>T&iacute;tulo: &nbsp;&nbsp;&nbsp;</b></td>
						<td class="span10" style='text-align:justify'>
							<b><?php echo strstr($doc['v12'],'<',true);?></b>
						</td>
					</tr>
				<?php } ?>
				<?php if(isset($doc['v25'])){ ?>
					<tr>
						<td class="span2" style='text-align:right' ><b>T&iacute;tulo: &nbsp;&nbsp;&nbsp;</b></td>
						<td class="span10" style='text-align:justify'>
							<b><?php echo strstr($doc['v12'],'<',true);?></b>
						</td>
					</tr>
				<?php } ?>
				<?php if(isset($doc['v30'])){ ?>
					<tr>
						<td class="span2" style='text-align:right' ><b>T&iacute;tulo: &nbsp;&nbsp;&nbsp;</b></td>
						<td class="span10" style='text-align:justify'>
							<b><?php echo strstr($doc['v12'],'<',true);?></b>
						</td>
					</tr>
				<?php } ?>
				 <?php if(isset($doc['v83'])){ ?>
					 <tr>
						 <td class="span2" style='text-align:right'><b>Resumen: <?php echo "( ".strstr($doc['v83'],'<',false).")";?> </b>&nbsp;&nbsp;&nbsp;</td>
						 <td class="span10" style='text-align: justify'> <?php echo strstr($doc['v83'],'<',true);?> </td>
					 </tr>
				 <?php } ?>
				 </tbody>
			</table>		
		</div>
        
<?php } ?>

            <div align="center" class="pagination">
              <ul>
                <li><a href="#">Prev</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">Next</a></li>
              </ul>
            </div>
		</div>
       
<?php } ?>


