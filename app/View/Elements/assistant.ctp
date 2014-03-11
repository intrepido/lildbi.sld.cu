<a href="<?php echo '#modal'.$numberField;?>" role="button"
	class="btn assistant" data-toggle="modal"><?php echo __('Asistente'); ?>
</a>
<!-- Modal -->
<div id="<?php echo 'modal'.$numberField;?>" class="modal hide fade"
	tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">			
			<?php echo __('Campo'). " ".$numberField." ";?>
			-
			<?php echo " ".$nameField;?>
		</h3>
	</div>
	<div class="modal-body" style="margin-bottom: 25px; padding-top: 30px;">
		<div class="row-fluid">
			<div class="span2" style="position: fixed;">
				<fieldset>
					<legend>
						<?php echo __('Acciones'); ?>
					</legend>
					<a class="btn add-field"><i class="icon-plus"></i> <?php echo __('Adicionar Campo'); ?>
					</a>
				</fieldset>
			</div>
			<div class="span8" style="margin-left: 180px;">
				<div class="alert alert-error fade in" id="obligatory-fields-error"
					style="display: none;">
					<button type="button" class="close">&times;</button>
					<h6 style="line-height: 20px; font-size: 14px; font-weight: normal;">
						<?php echo __('Llene los campos obligatorios'); ?>
					</h6>
				</div>

				<div id="container-field" class="container-document"
					style="padding: 8px 8px 5px; border-left-width: 0px; background-color: #E5E5E5; overflow: auto; margin: 5px 5px 5px 0px; padding: 5px; position: relative; width: 340px; height: 370px;">
					<div id="<?php echo 'repeating-field-v'.$numberField;?>"
						class="row-fluid">

						</br>
						<div class="container-document"
							style="padding: 10px 8px 5px 5px; border-left-width: 0px; background-color: rgb(255, 255, 255); margin-left: 0px; margin-top: 8px; margin-bottom: 0px;">

							<div class="row-fluid">
								<?php if($nameField == utf8_encode(__("Localizaci�n del Documento"))){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top" title="<?php echo utf8_encode(__('C�digo del Centro')); ?>">*</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('C�digo del Centro')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('N�mero de Clasificaci�n')); ?>">a</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('N�mero de Clasificaci�n')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top" title="<?php echo utf8_encode(__('N�mero de Autor')); ?>">b</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('N�mero de Autor')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top" title="<?php echo __('Volumen, Tomo, Parte'); ?>">c</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo __('Volumen, Tomo, Parte'); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top" title="<?php echo utf8_encode(__('Sistema de Empr�stito')); ?>">t</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Sistema de Empr�stito')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($nameField == utf8_encode(__("Direcci�n Electr�nica"))){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo __('Localizador de Fuente (URL)'); ?>">u</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo __('Localizador de Fuente (URL)'); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('C�digo del Idioma')); ?>">i</span>
											<select name="codeLenguage" class="span11 required"
												id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/lenguaje');
												foreach ($typeRegister['Codifier']['lenguaje'] as $key => $value) {
													?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Extensi�n del Archivo')); ?>">q</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo utf8_encode(__('Extensi�n del Archivo')); ?>"
												id="prependedInput"
												style="overflow: hidden; height: 20px; display: none;"></textarea>
											<select id="conditional-select" name="tipoArchivo"
												class="span11 required" id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/extension_archivo');
												array_splice($typeRegister['Codifier']['extension_archivo'], 1, 0, "Otro");
												foreach ($typeRegister['Codifier']['extension_archivo'] as $key => $value) {
												?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo __('Tipo de Archivo'); ?>">y</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo __('Tipo de Archivo'); ?>"
												id="prependedInput"
												style="overflow: hidden; height: 20px; display: none;"></textarea>
											<select id="conditional-select" name="tipoArchivo"
												class="span11 required" id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/tipo_archivo');
												array_splice($typeRegister['Codifier']['tipo_archivo'], 1, 0, "Otro");
												foreach ($typeRegister['Codifier']['tipo_archivo'] as $key => $value) {
												?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend" style="margin-bottom: 15px;">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo __('Texto Completo'); ?>">g</span>
											<div
												style="background-color: rgb(255, 255, 255); height: 20px; width: 265px; text-align: left;"
												class="add-on">
												<input type="checkbox"
													value="<?php echo __('Texto Completo'); ?>"
													style="margin-left: 5px; margin-right: 3px;">
												<?php echo __('Texto Completo'); ?>
												</input>
											</div>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Nota P�blica')); ?>">z</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Nota P�blica')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Nota no P�blica')); ?>">x</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Nota no P�blica')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Tama�o de Archivo')); ?>">s</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Tama�o de Archivo')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Se�a')); ?>">k</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Se�a')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top" title="<?php echo __('Logo'); ?>">l</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo __('Logo'); ?>" id="prependedInput"
												style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
								</div>

								<?php } ?>
								<?php if($nameField == __('Autor Personal')){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Autor Personal')); ?>">*</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo utf8_encode(__('Autor Personal')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Afiliaci�n')); ?>">1</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Afiliaci�n')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Afiliaci�n')); ?>">2</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Afiliaci�n')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Afiliaci�n')); ?>">3</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Afiliaci�n')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top" title="<?php echo __('Ciudad'); ?>">c</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo __('Ciudad'); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top" title="<?php echo utf8_encode(__('Pa�s')); ?>">p</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Pa�s')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Grado de responsabilidad')); ?>">r</span>
											<select name="levelResponsibility" class="span11"
												id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/relators');
												foreach ($typeRegister['Codifier']['relators'] as $key => $value) {
													?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($nameField == __('Autor Institucional')){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo __('Autor Institucional'); ?>">*</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo __('Autor Institucional'); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Grado de responsabilidad')); ?>">r</span>
											<select name="levelResponsibility" class="span11"
												id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/relators');
												foreach ($typeRegister['Codifier']['relators'] as $key => $value) {
													?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($nameField == utf8_encode(__('T�tulo'))){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('T�tulo')); ?>">*</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo utf8_encode(__('T�tulo')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('C�digo del Idioma')); ?>">i</span>
											<select name="codeLenguage" class="span11 required"
												id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/lenguaje');
												foreach ($typeRegister['Codifier']['lenguaje'] as $key => $value) {
													?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($nameField == utf8_encode(__('P�ginas'))){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Paginaci�n irregular o inexistente')); ?>">*</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo utf8_encode(__('Paginaci�n irregular o inexistente')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('N�mero inicial')); ?>">f</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('N�mero inicial')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('N�mero final')); ?>">l</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('N�mero final')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($nameField == utf8_encode(__('Informaci�n Descriptiva'))){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Otros detalles f�sicos')); ?>">b</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Otros detalles f�sicos')); ?>"
												id="prependedInput"
												style="overflow: hidden; height: 20px; display: none;"></textarea>
											<select id="conditional-select" name="infDescr"
												class="span11" id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/infdescr');
												array_splice($typeRegister['Codifier']['infdescr'], 1, 0, "Otro");
												foreach ($typeRegister['Codifier']['infdescr'] as $key => $value) {
												?>
												<option value="<?php echo $key ?>">
													<?php 	
													if(!is_numeric($key)){
														$key == "ilus" ? $value = __('Ilustraciones'): null;
														$key == "mapas" ? $value = __('Mapas'): null;
														$key == "tab" ? $value = __('Tablas'): null;
														$key == "graf" ? $value = utf8_encode(__('Gr�ficos')): null;
													}
													echo $value;
													?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Extensi�n de art�culo')); ?>">a</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Extensi�n de art�culo')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Dimensi�n')); ?>">c</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Dimensi�n')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('Material acompa�ante')); ?>">e</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo utf8_encode(__('Material acompa�ante')); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
								</div>

								<?php } ?>
								<?php if($nameField == __('Palabras Llaves del Autor')){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo __('Palabra Clave'); ?>">*</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo __('Palabra Clave'); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo __('Calificador'); ?>">s</span>
											<textarea class="input-xlarge"
												placeholder="<?php echo __('Calificador'); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('C�digo del Idioma')); ?>">i</span>
											<select name="codeLenguage" class="span11"
												id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/lenguaje');
												foreach ($typeRegister['Codifier']['lenguaje'] as $key => $value) {
													?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php if($nameField == __('Resumen')){?>
								<div id="v<?php echo $numberField;?>">
									<div class="span12" style="margin-left: 6px;">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top" title="<?php echo __('Resumen'); ?>">*</span>
											<textarea class="input-xlarge required"
												placeholder="<?php echo __('Resumen'); ?>"
												id="prependedInput" style="overflow: hidden; height: 20px;"></textarea>
										</div>
									</div>
									<div class="span12">
										<div class="input-prepend">
											<span class="add-on mandatory" data-toggle="tooltip"
												data-placement="top"
												title="<?php echo utf8_encode(__('C�digo del Idioma')); ?>">i</span>
											<select name="codeLenguage" class="span11 required"
												id="prependedInput"
												style="overflow: hidden; height: 20px; padding-bottom: 4px; margin-bottom: 8px;">
												<?php 
												$typeRegister = $this->requestAction('/Codifiers/getById/lenguaje');
												foreach ($typeRegister['Codifier']['lenguaje'] as $key => $value) {
													?>
												<option value="<?php echo $key ?>">
													<?php echo $value ?>
												</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>

							<div class="span12" style="margin-top: 15px;">
								<a class="btn btn-small pull-right remove-field"><i
									class="icon-trash"></i> <?php echo __(' Eliminar'); ?> </a>
							</div>
						</div>

					</div>
				</div>


			</div>

		</div>
	</div>
	<div class="modal-footer" style="margin-top: 20px;">
		<button class="btn cancel-field" data-dismiss="modal"
			aria-hidden="true">
			<?php echo __('Cerrar'); ?>
		</button>
		<button class="btn btn-primary save-field">
			<?php echo __('Guardar'); ?>
		</button>
	</div>
</div>
