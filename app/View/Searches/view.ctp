
  <!--Encabezado-->
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <font style="text-align:justify">
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
    </font>
    </br>
     <div class="result-search-identification">Base: 
        <?php 
          foreach($doc['v4'] as $b){
              echo $b.' ';
          }
        ?>
        / <?php echo __('ID:').$doc['v2']; ?>
    </div>
  </div>
    
    
  <!--Cuerpo -->
  <div class="modal-body">
      <div  class="row-fluid">
		<!--Autor-->
		<?php
			if(isset($doc['v10'])){ 
				echo '<dt>'.__('Autor(es)').'</dt><dd>'.$this->Solr->author($doc['v10']).'</dd>';
        	}elseif(isset($doc['v16'])){
				echo '<dt>'.__('Autor(es)').'</dt><dd>'.$this->Solr->author($doc['v16']).'</dd>';
			}elseif(isset($doc['v23'])){
				echo '<dt>'.__('Autor(es)').'/dt><dd>'.$this->Solr->author($doc['v23']).'</dd>';
			}
		?>
        
        <!-- Año -->
        <?php
			if(isset($doc['v65'])){ 
				echo '<dt>'.utf8_encode(__('Año de Publicación')).'</dt><dd>'.substr($doc['v65'],0,4).'</dd>';
        	}
		?>
        
        <!--Localizacion-->
        <?php
			if(isset($doc['v3'])){ 
			
				echo '<dt>'.utf8_encode(__('Localización')).'</dt><dd>';
				foreach($this->Solr->localization($doc['v3']) as $item){
					echo $item.'<br/>';
				}
				echo '</dd>';
        	}
		?>
        
        <!-- Descriptores primarios-->
        <?php
			if(isset($doc['v87'])){ 
				echo '<dt>'.__('Descriptores').'</dt><dd>';
				$desc = $this->Solr->desc($doc['v87']);
				foreach($desc as $item){
					echo $item.'<br/>';
				}
				echo '</dd>';
        	}
		?>
        
       	<!-- Palabras claves del autor -->
        <?php
			if(isset($doc['v85'])){ 
				echo '<dt>'.__('Palabras claves del autor').'</dt><dd>';
				$kws = $this->Solr->authKeyWords($doc['v85']);
				foreach($kws as $item){
					echo $item.'<br/>';
				}
				echo '</dd>';
        	}
		?>
        
        <!--Tipo Pub-->
        <?php
			if(isset($doc['v71'])){ 
				echo '<dt>'.utf8_encode(__('Tipo de publicación')).'</dt><dd>';
				foreach($doc['v71'] as $b){
                   echo $b.'</br>';
                }
				echo '</dd>';
        	}
		?>
        
        <!--Tipo Lit-->
        <?php
			if(isset($doc['v5'])){ 
				echo '<dt>'.__('Tipo de Literatura').'</dt><dd>'.$this->Solr->typeDoc($doc['v5']).'</dd>';
        	}
		?>
        
        <!--Vol-->
        <?php
			if(isset($doc['v31'])){ 
				echo '<dt>'.utf8_encode(__('Volúmen')).'</dt><dd>'.$doc['v31'].'</dd>';
        	}
		?>
        
        <!--NÃºmero del fascÃ­culo-->
        <?php
			if(isset($doc['v32'])){ 
				echo '<dt>'.utf8_encode(__('Número del fasículo')).'</dt><dd>'.$doc['v32'].'</dd>';
        	}
		?>
        
        <!--ISSN-->
        <?php
			if(isset($doc['v35'])){ 
				echo '<dt>'.__('ISSN').'</dt><dd>'.$doc['v35'].'</dd>';
        	}
		?>
        
        <!--ISBN-->
        <?php
			if(isset($doc['v69'])){ 
				echo '<dt>'.__('ISBN').'</dt><dd>'.$doc['v69'].'</dd>';
        	}
		?>
        
        <!--Editora-->
        <?php
			if(isset($doc['v62'])){ 
				echo '<dt>'.__('Editora').'</dt><dd>';
				foreach($doc['v62'] as $b){
                   echo $b.'</br>';
                }
				echo '</dd>';
        	}
		?>
        
        <!--EdiciÃ³n-->
        <?php
			if(isset($doc['v63'])){ 
				echo '<dt>'.utf8_encode(__('Edición')).'</dt><dd>'.$doc['v63'].'</dd>';
        	}
		?>
        
        <!--Ciudad de publicaciÃ³n-->
        <?php
			if(isset($doc['v66'])){ 
				echo '<dt>'.utf8_encode(__('Ciudad de publicación')).'</dt><dd>'.$doc['v66'].'</dd>';
        	}
		?>
      
      	<!--PaÃ­s de publicaciÃ³n-->
        <?php
			if(isset($doc['v67'])){ 
				echo '<dt>'.utf8_encode(__('País de publicación')).'</dt><dd>'.$doc['v67'].'</dd>';
        	}
		?>
        
		<!--Resumen-->
		<?php
			if(isset($doc['v83'])){ 
				echo '<dt>'.__('Resumen').'</dt><dd style="text-align:justify">'.$this->Solr->summary($doc['v83']).'</dd>';
        	}
		?>
        
        <!--Referencias-->
        <?php
			if(isset($doc['v72'])){ 
				echo '<dt>'.utf8_encode(__('Número total de citas')).'</dt><dd>'.$doc['v72'].'</dd>';
        	}
		?>
        
        <!--Idioma-->
        <?php
			if(isset($doc['v40'])){ 
				echo '<dt>'.__('Idioma del Texto').'</dt><dd>';
				foreach($doc['v40'] as $b){
                   echo $b.'</br>';
                }
				echo '</dd>';
        	}
		?>
        
        <?php
			if(isset($doc['v8'][0])){
				echo '<dt>'.utf8_encode(__('Dirección electrónica')).'</dt><dd>';
				echo '<a href="'.$this->Solr->url($doc['v8'][0]).'">'.$this->Solr->url($doc['v8'][0]).'</a>';
				echo '</dd>';
			}
		?>
        
        
        
      </div>
  </div>
  
  <!--Acciones disponibles-->  
  <div class="modal-footer">
      <?php 
		if(isset($doc['v8'][0])){
			echo '<a href="'.$this->Solr->url($doc['v8'][0]).'"  class="btn">'.__('Texto Completo').'<icon class="icon-share" /></a>';
		}
	  ?>
      <button id="btn-close-modal" class="btn cancel-field" data-dismiss="modal"  aria-hidden="true">
          <?php echo __('Cerrar'); ?>
      </button>
  </div>







