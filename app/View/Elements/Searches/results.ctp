<?php  

if($result){
  $header = $result['responseHeader'];
  $body = $result['response'];
  $query = $header['params']['q'];
  $numFound = $body['numFound'];
  $start = $body['start'];
  $rows = $header['params']['rows'];
  $docs = $body['docs'];
  if(isset($result['highlighting'])){
	  $hl = $result['highlighting'];
  }
  $url = $result['urlParams'];
}else{
  $query = '';
  $numFound = 0;
  $start = 0;
  $url = '';
  $rows = 10;
  $docs = null;
  $error = true;
}
?>


<div class="container-document" >    
    
    <!-- Encabezado (inicio)-->
    
         <?php if(!isset($error)){ ?>
          <p><?php echo $numFound.' '.__("referencias encontradas para:") ?> <b><i><?php echo $query ?> </i></b>
          &nbsp;&nbsp;   
			  <?php if(isset($header['params']['fq'])){
				  		echo __("Filtros aplicados a la búsqueda: ");
                        $filters = $header['params']['fq'];
						$terms = array("v40:" => __("Idioma: "), 
									   "v65:" => __("Fecha: ") ,
									   "TO *]" => "" ,
									   "TO" => __("hasta") , 
									   "v8:*" => __("Solo con texto completo"),
									   "[*" => "" , 
									   "[" => __("desde ") ,
									   "]" => "",
									   "v67:" => __("País: ") , 
									   "v5:" => __("Tipo: ")
									   );
						if(is_array($filters)){
							foreach($filters as $f){
								echo " <span class='label label-info'>".strtr($f, $terms)."</span> ";
							}
						}else{
							echo " <span class='label label-info'>".strtr($filters, $terms)."</span> ";
						}
						
                    }   
              ?>
          </p>  
          <p>
            <?php  
              if($docs != false){
                if(($start+$rows) < $numFound){
                    echo __('Mostrando de la ').($start + 1).__(' a la ').($start + $rows);
                }else{
                    echo __('Mostrando de la ').($start + 1).__(' a la ').$numFound;
                }
              }
            ?>
          </p>
         <?php } ?>
         
          
    <!-- Encabezado (fin)--> 
      
    <!-- Resultados (inicio)-->   
          <?php 
          if($numFound == 0){
              echo '<b>'. __("No se encontraron resultados para la búsqueda.").'</b>';
          }elseif(!$docs){
              echo '<b>'.__("Búsqueda incorrecta.").'</b>';
          }else{
              $counter = 0;
              foreach($docs as $doc){ 
                $counter++;
          ?> 
              
              <div class="well well-small" id="doc<?php echo $counter ?>">
                    <div class="result-search-identification">         	
                        Id: <?php echo $doc['v2'];?> / 
                        Base: <?php 
                            foreach($doc['v4'] as $b){
                                echo $b.' ';
                            }
                        if(isset($doc['v40'])){
						?> / 
                        Idioma: <?php ;
                             foreach($doc['v40'] as $l){
                                echo $this->Html->image('flags/'.trim($l).'.png').' ';
                             }
						}
                        ?>  
                        
                        
                        <?php if($this->Session->check('folder.'.$doc['id'])){ ?>
                        	<a id="<?php echo $doc['id'] ?>" class="btn btn-mini updateFolder overDesc" rel='tooltip' data-original-title='Remover de carpeta'><icon class="icon-minus" /></a>
                    	<?php }else{ ?>
                        	<a id="<?php echo $doc['id'] ?>" class="btn btn-mini updateFolder overDesc" rel='tooltip' data-original-title='Agregar a carpeta'><icon class="icon-plus" /></a>
                        <?php } ?>
                        
                        <a id="<?php echo $doc['id'] ?>" rel='tooltip' data-original-title='Ver todos los detalles' href="#modalSearchResult" role="button" class="btn btn-mini viewDocBtn overDesc" data-toggle="modal"><icon class='icon-search' /></a>
                        <!--<a href="/lildbi/searches/view/<?php //echo strtolower($doc['v4'][0]).'/'.$doc['id'] ?>" style="float:right;margin-left:10px" rel='tooltip' data-original-title='Visualizar documento' class="btn btn-mini overDesc"><icon class='icon-search' /></a> -->
                    	
                        <?php 
							if(isset($doc['v8'][0])){
								echo '<a href="'.$this->Solr->url($doc['v8'][0]).'" rel="tooltip" data-original-title="Ir al texto completo" class="btn btn-mini overDesc"><icon class="icon-share" /></a>';
							}
						?>
                    </div>                    
                    
                  
                     <table class='table table-condensed table-result-search'>
                        <tbody>
                           <tr> 
                              <td class="span10">
                                  <a id="<?php echo $doc['id'] ?>" class="viewDocLink"  href="#modalSearchResult" role="button" data-toggle="modal">
                                   <?php 
                                   if(isset($doc['v12'][0])){ 
								   		if(isset($hl[$doc['id']]['v12'])){ 
                                            echo '<b>'.$this->Solr->title($hl[$doc['id']]['v12'][0]).'</b>';  
										}else{
											echo '<b>'.$this->Solr->title($doc['v12'][0]).'</b>';
										}
                                   }elseif(isset($doc['v18'][0])){ 
                                            if(isset($hl[$doc['id']]['v18'])){ 
                                            echo '<b>'.$this->Solr->title($hl[$doc['id']]['v18'][0]).'</b>';  
											}else{
												echo '<b>'.$this->Solr->title($doc['v18'][0]).'</b>';
											} 
                                   }elseif(isset($doc['v25'][0])){ 
                                            if(isset($hl[$doc['id']]['v25'])){ 
                                            echo '<b>'.$this->Solr->title($hl[$doc['id']]['v25'][0]).'</b>';  
											}else{
												echo '<b>'.$this->Solr->title($doc['v25'][0]).'</b>';
											}
                                   }elseif(isset($doc['v30'][0])){ 
                                            if(isset($hl[$doc['id']]['v30'])){ 
                                            echo '<b>'.$this->Solr->title($hl[$doc['id']]['v30'][0]).'</b>';  
											}else{
												echo '<b>'.$this->Solr->title($doc['v30'][0]).'</b>';
											}
                                   }elseif(isset($doc['v53'][0])){ 
                                            if(isset($hl[$doc['id']]['v53'])){ 
                                            echo '<b>'.$this->Solr->title($hl[$doc['id']]['v53'][0]).'</b>';  
											}else{
												echo '<b>'.$this->Solr->title($doc['v53'][0]).'</b>';
											}
                                   }elseif(isset($doc['v59'][0])){
                                            if(isset($hl[$doc['id']]['v59'])){ 
                                            echo '<b>'.$this->Solr->title($hl[$doc['id']]['v59'][0]).'</b>';  
											}else{
												echo '<b>'.$this->Solr->title($doc['v59'][0]).'</b>';
											}
                                   } 
                                   ?>
                                  </a>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="span10">
                                	<p class="result-search-description">
										<?php 
										if(isset($doc['v10'])){ 
                                             echo '<b>Por: </b>'.$this->Solr->author($doc['v10']);
                                        }elseif(isset($doc['v16'])){ 
                                             echo '<b>Por: </b>'.$this->Solr->author($doc['v16']);
                                        }elseif(isset($doc['v23'])){ 
                                             echo '<b>Por: </b>'.$this->Solr->author($doc['v23']);
                                        } 
                                        
										if(isset($doc['v65'])){ 
                                             echo ' ; '.substr($doc['v65'],0,4);
                                        } 
                                        if(isset($doc['v67'])){ 
                                             echo ' ; '.$doc['v67'];
                                        } ?>
                                    </p>
                                    
                                    
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
                                        <p class="result-search-description">
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
              
          <?php }} ?>
          
    <!-- Resultados (fin)--> 
      
    <!-- PaginaciÃ³n (Inicio)-->
          <?php 
              if($docs){
                  
                  $pages = ceil($numFound/$rows);
				  $page = ceil($start/$rows);
                  
                  if($pages > 1){
                      echo '<div align="center" class="pagination"><ul>';
                      
					  if($page > 0){
                          echo '<li>'.$this->Html->link('<<', array( 'action'=>'search', $url.'&rows='.$rows.'&start='.($start-$rows))).'</li>';	
                      }
					  
					  if(($page-5) <= 0){
						for($i = 0; $i < $pages && $i<10; $i++){    	
                          if($page == $i){
                              echo '<li class="disabled"><a><b>'.($i+1).'</b></a></li>';
                          }else{
                              echo '<li>'.$this->Html->link($i+1,array( 'action'=>'search', $url.'&rows='.$rows.'&start='.$i*$rows)).'</li>'; 
                          }		
						  if($i==9){
						  	  echo '<li class="disabled"><a><b>...</b></a></li>';
						  }
						}  
					  }
					  if(($page-5)>0 && ($page+5)<$pages){
						for($i = ($page-5); $i < $pages && $i<($page+5); $i++){    	
                          if($i==($page-5)){
						  	  echo '<li class="disabled"><a><b>...</b></a></li>';
						  }
						  if($page == $i){
                              echo '<li class="disabled"><a><b>'.($i+1).'</b></a></li>';
                          }else{
                              echo '<li>'.$this->Html->link($i+1,array( 'action'=>'search', $url.'&rows='.$rows.'&start='.$i*$rows)).'</li>'; 
                          }		
						  if($i==($page+4)){
						  	  echo '<li class="disabled"><a><b>...</b></a></li>';
						  }
						}  
					  }			  
					  if(($page-5)>0 && ($page+5)>=$pages){
						for($i = ($page-5); $i < $pages && $i<($page+5); $i++){    	
                          if($i==($page-5)){
						  	  echo '<li class="disabled"><a><b>...</b></a></li>';
						  }
						  if($page == $i){
                              echo '<li class="disabled"><a><b>'.($i+1).'</b></a></li>';
                          }else{
                              echo '<li>'.$this->Html->link($i+1,array( 'action'=>'search',$url.'&rows='.$rows.'&start='.$i*$rows)).'</li>'; 
                          }	
						}  
					  }

                      if($page < $pages-1){
                          echo '<li>'.$this->Html->link('>>', array( 'action'=>'search', $url.'&rows='.$rows.'&start='.($start+$rows))).'</li>';	
                      } 
                      echo '</ul></div>';
                  }	
              }
          ?>
    <!-- PaginaciÃ³n (Fin)-->

</div>


<!-- Modal para visualizar Detalles de los Documentos-->
<div id="modalSearchResult" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!-- Contenido obtenido por AJAX -->                    	   
</div>

   