<?php echo $this->Html->script('searches', FALSE); ?>
<div>
	<center>
	<?php echo $this->Form->create('query',array('onsubmit' => 'return validateAdv();')); ?>

       	<div name="formSearch" class="container-document">
			<legend><?php echo utf8_encode(__('B�squeda Avanzada')); ?></legend>
			<?php if(isset($result)){ ?>
	            <div class="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
	              <?php echo $result; ?>
	            </div>	
            <?php } ?>
            <table class="table-advanced-search">
				<tr>
					<td align="center"><?php echo utf8_encode(__('Buscar palabras en un campo espec�fico.')); ?></td>
				</tr>
				<tr>
					<td align="center">
						<div class="input-append">
							<input id="advSearch" name="data[query][qText]" type="text"
								autocomplete="off"> 
							<select name="data[query][field]"
								class="add-on">
								<option value="text"><?php echo __('Todos los campos'); ?></option>
								<option value="title"><?php echo utf8_encode(__('T�tulo')); ?></option>
								<option value="authors"><?php echo __('Autor'); ?></option>
								<option value="kw"><?php echo __('Palabras Claves'); ?></option>
								<option value="summary"><?php echo __('Resumen'); ?></option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center">
						<div class="input-prepend input-append">
							<select name="data[query][op1]" class="add-on" autocomplete="off">
								<option value="AND">AND</option>
								<option value="OR">OR</option>
								<option value="AND NOT">AND NOT</option>
							</select> 
							<input name="data[query][qText1]" type="text"> 
							<select
								name="data[query][field1]" class="add-on">
								<option value="text"><?php echo __('Todos los campos'); ?></option>
								<option value="title"><?php echo utf8_encode(__('T�tulo')); ?></option>
								<option value="authors"><?php echo __('Autor'); ?></option>
								<option value="kw"><?php echo __('Palabras Claves'); ?></option>
								<option value="summary"><?php echo __('Resumen'); ?></option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center">
						<div class="input-prepend input-append">
							<select name="data[query][op2]" class="add-on" autocomplete="off">
								<option value="AND">AND</option>
								<option value="OR">OR</option>
								<option value="AND NOT">AND NOT</option>
							</select> <input name="data[query][qText2]" type="text"> <select
								name="data[query][field2]" class="add-on">
								<option value="text"><?php echo __('Todos los campos'); ?></option>
								<option value="title"><?php echo utf8_encode(__('T�tulo')); ?></option>
								<option value="authors"><?php echo __('Autor'); ?></option>
								<option value="kw"><?php echo __('Palabras Claves'); ?></option>
								<option value="summary"><?php echo __('Resumen'); ?></option>
							</select>
						</div>
					</td>
				</tr>
			</table>

			<legend><?php echo utf8_encode(__('Restringir B�squeda')); ?></legend>
			
			<div class="restrict-search row-fluid">	
				<div class="span12">
					<div class="input-prepend">
							<span class="add-on"><?php echo utf8_encode(__('Idioma de la publicaci�n:')); ?></span> 
							<select id="lang" name="data[query][lang]" value='Todos'>
	                             <?php
									$lens = $this->requestAction ( '/Codifiers/getById/lenguaje' );
									$lens = $lens ['Codifier'] ['lenguaje'];
									foreach ( $lens as $l ) {
											echo '<option value="' . key ( $lens ) . '">' . $l . '</option>';
											next ( $lens );
									}
								  ?>                                
	                         </select>
					</div>
					<div class="input-prepend">				
							<span class="add-on"><?php echo utf8_encode(__('Pa�s de publicaci�n:')); ?></span>
							<select id="country" name="data[query][country]">
		                           <?php
									  $paises = $this->requestAction ( '/Codifiers/getById/pais' );
									  $paises = $paises ['Codifier'] ['pais'];
									  foreach ( $paises as $p ) {
											echo '<option value="' . key ( $paises ) . '">' . $p . '</option>';
											next ( $paises );
									  }
									?>
		                    </select>				
					</div>
				</div>
				<div class="span12">
					<div  class="span7"><input name="data[query][url]" id="checkCompletText" type="checkbox"/> <?php echo __('Que tengan
							URL del texto completo.'); ?>
							<div class="input-prepend">
								<span class="add-on"><?php echo __('Formato del Texto Completo:'); ?> </span> 
								<select id="formatText" name="data[query][formatText]" disabled="disabled">
	                                <?php
										$typeRegister = $this->requestAction ( '/Codifiers/getById/extension_archivo' );
										foreach ( $typeRegister ['Codifier'] ['extension_archivo'] as $key => $value ) {?>
									 	 <option value="<?php echo trim($key) ?>"><?php echo trim($value) ?></option>
									<?php }	?>                 
	                            </select>
							</div>
					</div>
					<div class="span5"><label style="margin: 0px 95px -8px 0px;">
							<?php echo utf8_encode(__('Fecha de Publicaci�n:')); ?></label><br />
							<div class="form-inline">
								<label class="control-label"><?php echo __('Desde:'); ?> </label> <select
									name="data[query][from]">
									<option>---</option>
	                                   <?php
											$date = getdate ();
											for($i = 1900; $i <= $date ['year']; $i ++) {
												echo ' <option value="' . $i . '">' . $i . '</option>';
											}
										?>                         
	                              </select> <label><?php echo __('Hasta:'); ?></label> <select
									name="data[query][until]">
									<option>---</option>
	                                   <?php
											$date = getdate ();
											for($i = $date ['year']; $i >= 1900; $i --) {
												echo ' <option>' . $i . '</option>';
											}
										?>                         
	                              </select>
							</div>
					</div>
				</div>
				<div class="span12">
					<div align="center" colspan="2">
						<div class="input-prepend">
							<span class="add-on"><?php echo __('Tipo de Literatura:'); ?> </span> <select
								name="data[query][typePub]">
								<option value="all"><?php echo __('Todos'); ?></option>
								<option value="S"><?php echo utf8_encode(__('Documento publicado en una serie peri�dica')); ?></option>
								<option value="SC"><?php echo utf8_encode(__('Documento de conferencia en una serie
									peri�dica')); ?></option>
								<option value="SCP"><?php echo utf8_encode(__('Documento de proyecto y conferencia en una
									serie peri�dica')); ?></option>
								<option value="SP"><?php echo utf8_encode(__('Documento de proyecto en una serie peri�dica')); ?></option>
								<option value="M"><?php echo utf8_encode(__('Documento publicado en una monograf�a')); ?></option>
								<option value="MC"><?php echo utf8_encode(__('Documento de conferencia en una monograf�a')); ?></option>
								<option value="MCP"><?php echo utf8_encode(__('Documento de proyecto y conferencia en una
									monograf�a')); ?></option>
								<option value="MP"><?php echo utf8_encode(__('Documento de proyecto en una monograf�a')); ?></option>
								<option value="MS"><?php echo utf8_encode(__('Documento publicado en una serie monogr�fica')); ?></option>
								<option value="MSC"><?php echo utf8_encode(__('Documento de conferencia en una serie
									monogr�fica')); ?></option>
								<option value="MSP"><?php echo utf8_encode(__('Documento de proyecto en una serie
									monogr�fica')); ?></option>
								<option value="T"><?php echo utf8_encode(__('Tesis, Disertaci�n')); ?></option>
								<option value="TS"><?php echo utf8_encode(__('Tesis, Disertaci�n que pertenece a una serie
									monogr�fica')); ?></option>
								<option value="N"><?php echo __('Documento no convencional'); ?></option>
								<option value="NC"><?php echo __('Documento de conferencia en forma no
									convencional'); ?></option>
								<option value="NP"><?php echo __('Documento de proyecto en forma no
									convencional'); ?></option>
							</select>
						</div>

					</div>
				</div>
			</div>
			
			
			
			
			
			<div class="form-actions">
				<?php echo $this->Html->link(utf8_encode(__('Volver a B�squeda Simple ')).$this->Html->tag('icon',null,array('class'=>'icon-cog')), array( 'action'=>'search'),array('plugin' => false,'class' => 'btn btn-info','escape' => false)); ?>
                <?php echo $this->Form->button(__("Buscar ").$this->Html->tag('icon',null,array('class'=>'icon-search')), array("type" => 'commit' , 'class' => 'btn btn-primary','escape' => false));?>
        	</div>
		</div> 
    <?php $this->Form->end(); ?>
    </center>
</div>

