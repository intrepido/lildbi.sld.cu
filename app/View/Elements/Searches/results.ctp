<?php 
  $query = $result['responseHeader']['params']['q'];
  $numFound = $result['response']['numFound'];
  $start = $result['response']['start'];
  $rows = $result['responseHeader']['params']['rows'];
  $docs = $result['response']['docs'];
  $format = $result['responseHeader']['params']['format'];
?>

<div class="container-document" >

<!-- Encabezado (inicio)-->

      <p><?php echo $numFound ?> referencias encontradas para: <b><i><?php echo $query ?> </i></b></p>  
      <p>
		<?php
		  if($docs != false){
			if(($start+$rows) < $numFound){
				echo 'Mostrando de la '.($start + 1).' a la '.($start + $rows);
			}else{
				echo 'Mostrando de la '.($start + 1).' a la '.$numFound;
			}
		  }
        ?>
      </p>
      
<!-- Encabezado (fin)-->   

<!-- Resultados (inicio)--> 

      <?php 
      if($numFound == 0){
          echo '<b>No se encontraron resultados para la búsqueda.</b>';
      }elseif(!$docs){
          echo '<b>Ha excedido el rángo de páginas.</b>';
      }else{
          $counter = 0;
          foreach($docs as $doc){ 
		  	$counter++;
	  ?> 
          
          <div class="well well-small docContent" id="doc<?php echo $counter ?>">
          		<input type="checkbox"  onclick="javascript:check(this)" style="margin-bottom: 4px;margin-right: 4px;"/>
                <font  face="Verdana" size="1">
                	
          			Id: <?php echo $doc['v2'];?> / 
          			Base: <?php echo $doc['v4'] ;?> / 
          			Idioma: <?php 
         				 $langs = $this->Solr->language($doc['v40']);
         				 foreach($langs as $l){
							  if(trim($l) != ''){
								  echo $this->Html->image('flags/'.trim($l).'.png').' ';
							  }else{
								  echo '';
							  }
						 }
         			?>  
         	 	</font>
                
                
                              
				<?php  
					if($counter!=1){
						echo '<a id="top" href="#" class="pull-right noprint">'.$this->Html->image('top.gif').'</a>';
						echo '<a id="prev" href="#" class="pull-right noprint">'.$this->Html->image('prev.gif').'</a>';
					} 
					if($counter!=count($docs)){
						echo '<a id="next" href="#" class="pull-right noprint">'.$this->Html->image('next.gif').'</a>';
						echo '<a id="bott" href="#" class="pull-right noprint">'.$this->Html->image('bott.gif').'</a>';
					} 
                ?>
                
                <!-- Afiliacion y Detallado -->
                
                <?php if($format==0 || $format==1 || $format==2){ ?>
              	 <table class='table'>
                    <tbody>
                    
                        <?php if(isset($doc['v12'])){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>T&iacute;tulo:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <b><?php echo $this->Solr->title($doc['v12']); ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v18'])){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>T&iacute;tulo:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <b><?php echo $this->Solr->title($doc['v18']); ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                        
                         <?php if(isset($doc['v25'])){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>T&iacute;tulo:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <b><?php echo $this->Solr->title($doc['v25']); ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v10'])){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>Autor:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <?php 
									if($format == 0){
										echo $this->Solr->author($doc['v10']);
									}
									if($format == 1 || $format == 2){
										echo $this->Solr->authorSAf($doc['v10']);
									}
									?>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v16'])){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>Autor:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <?php 
									if($format == 0){
										echo $this->Solr->author($doc['v16']);
									}
									if($format == 1 || $format == 2){
										echo $this->Solr->authorSAf($doc['v16']);
									}
									?>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v23'])){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>Autor:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <?php 
									if($format == 0){
										echo $this->Solr->author($doc['v23']);
									}
									if($format == 1 || $format == 2){
										echo $this->Solr->authorSAf($doc['v23']);
									}
									?>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v83'])){ ?>
                            <tr>
                                 <td class="span2" style='text-align:right'><b>Resumen:</b></td>
                                 <td class="span10" style='text-align: justify'> <?php echo $this->Solr->summary($doc['v83']);?> </td>
                            </tr>
                        <?php } ?>
                        
                         <?php if(isset($doc['v87']) && $format != 2){ ?>
                            <tr>
                                 <td class="span2" style='text-align:right'><b>Descriptores:</b></td>
                                 <td class="span10" style='text-align: justify'> 
								 	<?php
                                    $arr = $this->Solr->desc($doc['v87']);
									foreach($arr as $a){
										echo $a.'<br/>';	
									}
									?> 
                                 </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v76']) && $format != 2){ ?>
                            <tr>
                                 <td class="span2" style='text-align:right'><b>L&iacute;mites:</b></td>
                                 <td class="span10" style='text-align: justify'> 
								 	<?php
                                    $arr = $this->Solr->limits($doc['v76']);
									foreach($arr as $a){
										echo $a.'<br/>';	
									}
									?> 
                                 </td>
                            </tr>
                        <?php } ?>
                        
                         <?php if(isset($doc['v71']) && $format != 2){ ?>
                            <tr>
                                 <td class="span2" style='text-align:right'><b>Tipo de Publicaci&oacute;n:</b></td>
                                 <td class="span10" style='text-align: justify'> 
								 	<?php
                                    $arr = $this->Solr->typePub($doc['v71']);
									foreach($arr as $a){
										echo $a.'<br/>';	
									}
									?> 
                                 </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v72']) && $format != 2){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>Referencias:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <?php echo $doc['v72']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v85']) && $format != 2){ ?>
                            <tr>
                                 <td class="span2" style='text-align:right'><b>Palabras-llave del Autor:</b></td>
                                 <td class="span10" style='text-align: justify'> 
								 	<?php
                                    $arr = $this->Solr->authKeyWords($doc['v85']);
									foreach($arr as $a){
										echo $a.'<br/>';	
									}
									?> 
                                 </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v3'])){ ?>
                            <tr>
                                 <td class="span2" style='text-align:right'><b>Localizaci&oacute;n:</b></td>
                                 <td class="span10" style='text-align:justify'>
                                    <?php echo $this->Solr->localization($doc['v3']);?>
                                 </td>
                            </tr>
                        <?php } ?>
                            
                        <?php if(isset($doc['v8'])){ ?>
                            <tr>
                                <td class="span2" style='text-align:right' ><b>URL:</b></td>
                                <td class="span10" style='text-align:justify'>
                                    <?php echo '<a href="'.$this->Solr->url($doc['v8']).'" target="new" >'.$this->Solr->url($doc['v8']).'</a>'?>
                                </td>
                            </tr>
                        <?php } ?>
                        
                    </tbody>
                </table> 
                
                <!-- Citacion -->
                
                <?php }elseif($format == 3){?>
                    <table class='table'>
                        <tbody>
                        	
                            <?php
							  $author = null; 
							  $title = null;
							  $serie = '';	
							  $location = null;
							  
							  if($doc['v10']){
								  $author = $doc['v10'];
							  }elseif($doc['v16']){
								  $author = $doc['v16'];	
							  }else{
								  $author = $doc['v23'];
							  }
							  
							  if($doc['v12']){
								  $title = $doc['v12'];
							  }elseif($doc['v18']){
								  $title = $doc['v18'];	
							  }else{
								  $title = $doc['v25'];
							  }
							  
							  if($doc['v30']){
								 $serie =  $doc['v30'];
							  }							
							  
							  $location = null;
							?>
                        
                            <tr>
                                <td class="span10" style='text-align:justify'>
                                    <?php echo $this->Solr->authorSAf($author).'. - '.$this->Solr->title($title).'. '.$serie.'; ' ; ?>
                                </td>
                            </tr>
                             
                        </tbody>
                    </table> 
                    
               <?php }elseif($format == 4){?>
               
               <!-- Título -->
               
                    <table class='table'>
                       <tbody>

                         <?php if(isset($doc['v12'])){ ?>
                            <tr>
                                
                                <td class="span10" style='text-align:justify'>
                                    <b><?php echo $this->Solr->title($doc['v12']); ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <?php if(isset($doc['v18'])){ ?>
                            <tr>
                                
                                <td class="span10" style='text-align:justify'>
                                    <b><?php echo $this->Solr->title($doc['v18']); ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                        
                         <?php if(isset($doc['v25'])){ ?>
                            <tr>
                                
                                <td class="span10" style='text-align:justify'>
                                    <b><?php echo $this->Solr->title($doc['v25']); ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                             
                       </tbody>
                    </table> 
                <?php }?>
                
                
                
				<a id="print" href="" style="font-size: 12px;" class="pull-right noprint" onclick="javascript:void(imprSelec('doc<?php echo $counter ?>'));"> Imprimir Referencia <icon class="icon-print"/></a>
                <?php if(isset($doc['v8'])){ ?>
                	<a  id="go" href="<?php echo $this->Solr->url($doc['v8']);?>" style="margin-right: 12px;font-size: 12px;" class="pull-right noprint" target="new"> Texto Completo <icon class="icon-file"/></a>
               	<?php }?>
                <br/>
          </div>
          
      <?php }} ?>
      
<!-- Resultados (fin)--> 
  
<!-- Paginación (Inicio)-->
      <?php 
          if($docs){
			  
              $pages = ceil($numFound/$rows);
              
              if($pages > 1){
                  echo '<div align="center" class="pagination"><ul>';
                  if(ceil($start/$rows) > 0){
                      echo '<li>'.$this->Html->link('<<', '/searches/index/'.$query.'/'.($start-$rows).'/'.$rows, array()).'</li>';	
                  }
                  for($i = 0; $i<$pages; $i++){    	
                      if(ceil($start/$rows) == $i){
                          echo '<li class="disabled"><a><b>'.($i+1).'</b></a></li>';
                      }else{
                          echo '<li>'.$this->Html->link($i+1, '/searches/index/'.$query.'/'.$i*$rows.'/'.$rows, array()).'</li>'; 
                      }
                  }
                  if(ceil($start/$rows) < $pages-1){
                      echo '<li>'.$this->Html->link('>>', '/searches/index/'.$query.'/'.($start+$rows).'/'.$rows, array()).'</li>';	
                  } 
                  echo '</ul></div>';
              }	
          }
      ?>
<!-- Paginación (Fin)-->
   
</div>

<script type="text/javascript">
	function imprSelec(muestra){
		var ficha=document.getElementById(muestra);
		var ventimp=window.open(' ','popimpr');
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.write('<style type="text/css">.noprint {display:none;}</style>');
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
	}
	
	function imprAllSelec(){
		if(document.getElementsByClassName('selectCHB').length == 0){
			alert('No ha seleccionado documentos para imprimir.');
		}else{
			docs = document.getElementsByClassName('docContent');
			var ventimp=window.open(' ','popimpr');
			ventimp.document.write('<hr/>');
	
			for (var i = 0; i<docs.length;i++){
				if(docs.item(i).getElementsByTagName('input').item(0).className == "selectCHB"){
						ventimp.document.write(docs.item(i).innerHTML+'<hr/>');
				}
					
			}
			ventimp.document.write('<style type="text/css">.noprint {display:none;} .selectCHB{display:none}</style>');
			ventimp.document.close();
			ventimp.print();
			ventimp.close();
		}
	}
	
	function check(input){
		if(	input.className != "selectCHB"){
			input.className = "selectCHB";
		}else{
				input.className = "";
		}
	}

</script>

       
