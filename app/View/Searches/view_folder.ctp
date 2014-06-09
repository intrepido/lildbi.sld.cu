<?php  
echo $this->Html->script('searches', FALSE);
  if($result != ''){
	  $numFound = $result['response']['numFound'];
	  $docs = $result['response']['docs']; 
  }else{
  	  $docs = array();
  }
?>


<div class="container-document">
	<legend>Carpeta de Usuario <a class="btn btn-inverse" style="float:right" onclick="printAll()">Imprimir <icon class="icon-print icon-white"/></a></legend>
    
    <!-- Resultados (inicio)-->   
          <?php 
              if(empty($docs)){
				echo '<div class="well well-small docContent"><h5 id="msg-empty" style="margin-left:20px">La carpeta está vacía.</h5></div>'; 
			  }
              $counter = 0;
              foreach($docs as $doc){ 
                $counter++;
          ?> 
              
              <div class="well well-small docContent" id="doc<?php echo $counter ?>">
                    <font  face="Verdana" style="margin-left:5px" size="1">         	
                        
                        Id: <?php echo $doc['v2'];?> / 
                        Base: <?php 
                            foreach($doc['v4'] as $b){
                                echo $b.' ';
                            }
                        if(isset($doc['v40'])){
						?> / 
                        Idioma: <?php ;
                             foreach($doc['v40'] as $l){
                                echo $this->Html->image('flags/'.trim($l).'.png',array('style'=>'margin-bottom:3px')).' ';
                             }
						}
                        ?>  
    
						<!--Opciones-->
                        <?php if($this->Session->check('folder.'.$doc['id'])){ ?>
                        	<a id="<?php echo $doc['id'] ?>" rel='tooltip' data-original-title='Remover de carpeta' class="btn btn-mini removeDoc overDesc" style="float:right;margin-left:10px"><icon class="icon-minus" /></a>
                    	<?php }else{ ?>
                        	<a id="<?php echo $doc['id'] ?>" class="btn btn-mini updateFolder overDesc" rel='tooltip' data-original-title='Agregar a carpeta' style="float:right;margin-left:10px"><icon class="icon-plus" /></a>
                        <?php } ?>
                        
                        <a id="<?php echo $doc['id'] ?>" rel='tooltip' data-original-title='Ver todos los detalles' href="#modalView" role="button" class="btn btn-mini viewDocBtn overDesc" data-toggle="modal" style="float:right;margin-left:10px"><icon class='icon-search' /></a>
                    	
                        <?php 
							if(isset($doc['v8'][0])){
								echo '<a href="'.$this->Solr->url($doc['v8'][0]).'" style="float:right;margin-left:10px" rel="tooltip" data-original-title="Ir al texto completo" class="btn btn-mini overDesc"><icon class="icon-share" /></a>';
							}
						?>
                    
                    </font>
                    
                    
                  
                     <table class='table table-condensed' style="margin-bottom: -5px;">
                        <tbody>
                            <tr> 
                              <td class="span10" style='text-align:justify'>
                                  <a id="<?php echo $doc['id'] ?>" class="viewDocLink"  href="#modalView" role="button" data-toggle="modal">
                                   <?php 
                                   if(isset($doc['v12'][0])){ 
                                            echo '<b>'.$this->Solr->title($doc['v12'][0]).'</b>';    
                                   }elseif(isset($doc['v18'][0])){ 
                                            echo '<b>'.$this->Solr->title($doc['v18'][0]).'</b>'; 
                                   }elseif(isset($doc['v25'][0])){ 
                                            echo '<b>'.$this->Solr->title($doc['v25'][0]).'</b>'; 
                                   }elseif(isset($doc['v30'][0])){ 
                                            echo '<b>'.$this->Solr->title($doc['v30'][0]).'</b>';
                                   }elseif(isset($doc['v53'][0])){ 
                                            echo '<b>'.$this->Solr->title($doc['v53'][0]).'</b>'; 
                                   }elseif(isset($doc['v59'][0])){
                                            echo '<b>'.$this->Solr->title($doc['v59'][0]).'</b>'; 
                                   } 
                                   ?>
                                  </a>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="span10" style='text-align:justify;'>
									<?php if(isset($doc['v10'])){ ?>
                                        <p style="font:small-caption;"><b>Por:</b> 
                                            <?php 
                                                echo $this->Solr->author($doc['v10']);
                                            ?>
                                        </p>
                                    <?php }elseif(isset($doc['v16'])){ ?>
                                        <p style="font:small-caption;"><b>Por:</b> 
                                            <?php 
                                                echo $this->Solr->author($doc['v16']);
                                            ?>
                                        </p>
                                    <?php }elseif(isset($doc['v23'])){ ?>
                                        <p style="font:small-caption;"><b>Por:</b> 
                                            <?php 
                                                echo $this->Solr->author($doc['v23']);
                                            ?>
                                        </p>
                                    <?php } ?>
                                    
                                    
                                    <?php if(isset($doc['v83'])){ ?>
                                        <?php if(isset($hl[$doc['id']]['v83'])){ ?>
                                        <p>
                                              <?php echo $this->Solr->summary($hl[$doc['id']]['v83'][0]);?> 
                                        </p>
                                        <?php }else{ ?> 
                                        <p>
                                              <?php echo $this->Solr->summary($doc['v83']);?> 
                                        </p>
                                        <?php } ?> 
                                    <?php } ?> 
                                    
                                    <?php if(isset($doc['v87'])){ ?>
                                        <p style="font:small-caption;">
                                        	<b>Descriptores: </b>
                                            <?php 
												$desc = $this->Solr->desc($doc['v87']);
												foreach($desc as $item){
                                               		echo '['.$item.'] ';
												}
                                            ?>
                                        </p>
                                    <?php } ?> 
                               </td>
                            </tr>      
                        </tbody>
                    </table> 
                    
                    
              </div>
              
          <?php }?>
          
    <!-- Resultados (fin)--> 
    <?php echo $this->Html->link('<i class="icon-arrow-left icon-white"></i> Volver a Buscar ', array('plugin' => false, 'controller' => 'searches', 'action' => 'index'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
      
    </div>
</div>


<!-- Modal -->
<div id="modalView" style="margin-top:-40px" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <!-- Contenido obtenido por AJAX -->                       	   
</div>


<script type="text/javascript">

	$('.overDesc').tooltip();
	
	function printAll(){
			if(!document.getElementById('msg-empty')){
				docs = document.getElementsByClassName('docContent');
				var ventimp=window.open(' ','popimpr');
				ventimp.document.write('<hr/>');
		
				for (var i = 0; i<docs.length;i++){
					if(docs.item(i).style.display != 'none'){
						ventimp.document.write(docs.item(i).innerHTML+'<hr/>');
					}
				}
				
				ventimp.document.write('<style type="text/css">.overDesc {display:none;} </style>');
				ventimp.document.close();
				ventimp.print();
				ventimp.close();
			}else{
				alert('No hay documentos en la carpeta.');	
			}		
	}
	
	
</script>



       
