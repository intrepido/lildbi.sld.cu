<?php
echo $this->Html->script('indexBoard', FALSE);

echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),	
		__('Indexar Bases'),
	), array('class' => 'breadcrumb'));
?>

<div class="container-document">
  <div class="row-fluid">
    <div>
      <div class="container-document-inner">
        
        <legend>
            <?php 
			echo __('Bases Disponibles para Indexar'); 
			echo $this->Html->link('Borrar todo el Indice '.$this->Html->tag('icon',null,array('class'=>'icon-trash icon-white')), array('action' => 'unindexAll'),array('class'=>'btn btn-inverse','style'=>'float:right','escape'=>false),'Est&aacute; seguro?');

			?>     	
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
      
        <table id="list-bases" style="display: <?php echo $displayTable ?>;" cellspacing="0" cellpadding="0" class="table table-bordered table-hover">
            <thead>
              <tr style="background-color: black; color: lightgray;" >
                <th>Nombre</th>
                <th>Estado</th>
                <th style="width:8%">Acciones</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach ($bases as $value) {							
                    $temp = "";
                    if($value['capacity'] == "success"){
                    $temp = "style='background-color: rgb(223, 240, 216);'";
                }
                ?>
                
                  <tr class="<?php echo $value['capacity'] ?>" <?php echo $temp ?>>
                      <td>
                          <?php echo $value['name'] ?>
                      </td>
                      <td class="info">
                          <?php
                          if($value['countDocsSolr'] != 0){
                           echo $value['countDocsSolr'].' documentos indexados de <font class="count-docs">'.$value['countDocsCouch'].'</font>.' ;
                          }else{
                           echo 'Sin indexar. <font class="count-docs">'.$value['countDocsCouch'].'</font> documentos disponibles.' ;									
                          }
                          ?>                            
                      </td>
                      <td class="span1 actions">
                        <div class="btn-group">
						  <?php 
						  if($value['capacity'] != "success"){ 
                            if($value['countDocsCouch']>0){
							  echo '<a data-original-title="Indexar" rel="tooltip" class="btn overDesc index-btn" escape=false><icon class="icon-ok"></icon></a>';
                              //echo $this->Html->link($this->Html->tag('icon',null,array('class'=>'icon-ok')), array('action' => 'toindex', $value['name']),array('class'=>'btn overDesc','rel'=>'tooltip','data-original-title'=>'Indexar','escape'=>false)); 		
                            }
                          }else{ 
						  	  echo '<a data-original-title="Reindexar" rel="tooltip" class="btn overDesc index-btn" escape=false><icon class="icon-refresh"></icon></a>';
                              echo $this->Html->link($this->Html->tag('icon',null,array('class'=>'icon-remove')), array('action' => 'unindex', $value['name']),array('class'=>'btn overDesc','rel'=>'tooltip','data-original-title'=>'Borrar del indice','escape'=>false),'Est&aacute; seguro?');		
                          } 
						  ?>
						</div>
                      </td>
                  </tr>
                
                <?php }?>
           	 </tbody>
          </table>
      
          <center>
            <p>
              <font face="Verdana" size="1">
                S&oacute;lo el contenido de las bases indexadas ser&aacute;n accesibles desde el buscador. Reindexelas peri&oacute;dicamente para actualizar el contenido indexado. </br>
                <?php 
                    App::uses('ConnectionManager', 'Model');
                    $dataSource = ConnectionManager::getDataSource('solr');
                    $host = $dataSource->config['host'];
                    $port = $dataSource->config['port'];
                    $path = $dataSource->config['path'];
                	echo '<a href="http://'.$host.':'.$port.'/'.$path.'" target="new">Administrar Solr</a>';
                ?>
              </font>
            </p>
          </center>
          
      </div>
    </div>
  </div>
</div>

<script>
$('.overDesc').tooltip();
</script>



