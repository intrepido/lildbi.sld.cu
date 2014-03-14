
<?php if(isset($backValues)){ //Si vengo desde la pagina de Visualizacion, recivo los datos en "$backValues"
$escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
$replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
$backEscapedValues = str_replace($escapers, $replacements, json_encode($backValues));
?>
<script> 
	$(document).ready( 
		function() {	
					
			var arrayData = $.parseJSON('<?php echo $backEscapedValues; ?>');
			for (var key2 in arrayData["v9"])
			{
				$.post('/lildbi/Codifiers/getById', {
					value : arrayData["v9"][key2]
				}, showOtherCombos); //Llama a la funcion "showOtherCombos" del "codifiers.js"
			}
			
			$(document).one('ajaxComplete', function() { //La funcion "one" es para que se ejecute solo una vez cuando se carga la pagina								
				$.each(arrayData, function(key1, value) {						
					for (var key2 in value) {
						if(arrayData[key1][key2] != ""){					
							var element = $("[name = 'data[Document][" + key1 + "][" + key2 + "]']");
							if(element.is('input')){
								openAccordion(element);
								if(element.attr('type') == 'hidden'){							
									$.each(arrayData[key1][key2], function(key3, value2) {								
										element.next().children().find("option[value='" + arrayData[key1][key2][key3] + "']").attr('selected', 'selected');				
									});
								}
								else{
									element.attr('value', arrayData[key1][key2]);
								}												
							}
							if(element.is('textarea')){
								openAccordion(element);
								element.attr('value', arrayData[key1][key2]);
							}
							if(element.is('select')){								
								openAccordion(element);
								element.find("option[value='" + arrayData[key1][key2] + "']").attr('selected', 'selected');														
							}
						}					
					}	
				});
			});	
			
			function openAccordion(element){
				if(element.closest('div .accordion').length > 0){	
					element.closest('div .accordion').children().next().collapse('show');
					element.closest('div .accordion').children().children().attr('checked', true);
				}
			}
	});
</script>
<?php } ?>

<div class="container-document">
	<div class="page-header">
		<h3>
			<?php echo utf8_encode(__('Serie Monográfica')); ?>
		</h3>
	</div>

	<form accept-charset="utf-8" method="post" id="DocumentAddForm"
		action="/lildbi/documents/<?php echo isset($typeEditDocument) ? 'edit' : 'add';?>/series_monograficas/<?php echo isset($typeEditDocument) ? $this->Session->read('idEdit').'/' : '';?>visualization">
		<div style="display: none;">
			<input type="hidden" value="POST" name="_method">
		</div>
		<table class="table table-bordered table-hover inset-type">
			<thead>
				<tr>
					<th><?php echo __('Campo'); ?></th>
					<th><?php echo utf8_encode(__('Descripción Bibliográfica')); ?></th>
					<th class="span2"><?php echo __('Tag'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr class="info">
					<td style="align: center" colspan="12">
						<div class="span5" style="margin-left: 0px;"></div> <b><?php echo __('Informaciones	Generales'); ?>
					</b> <a id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a> <a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a>
					</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Número de Identificación')); ?></td>
					<td>
						<div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->input('', array(				
								'type' => 'text',
								'class' => 'span6',
								'value'=> '',
								'name'  => 'data[Document][v2]['. utf8_encode(__('Número de Identificación')) .']',
								'required' => 'true'
				)); ?>
					</td>
					<td class="mandatory">[02]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Localización del Documento')); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__('Localización del Documento')), "numberField" => 3));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'disabled' => true,
							'value'=> '',
							'name'  => 'data[Document][v3]['. utf8_encode(__('Localización del Documento')) .']'

					)); ?></td>
					<td>[03]</td>
				</tr>
				<tr>
					<td><?php echo __('Base de Datos'); ?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> 'LILACS',
							'name'  => 'data[Document][v4]['. __('Base de Datos')  .']'
					)); ?></td>
					<td>[04]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Número del Registro')); ?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v7]['. utf8_encode(__('Número del Registro')) .']'
					)); ?></td>
					<td>[07]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Dirección Electrónica')); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__('Dirección Electrónica')), "numberField" => 8));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'disabled' => true,
							'value'=> '',
							'name'  => 'data[Document][v8]['. utf8_encode(__('Dirección Electrónica')) .']'
					)); ?></td>
					<td>[08]</td>
				</tr>
				<tr>
					<td><?php echo __('Tipo de Registro'); ?></td>
					<td>
						<div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php 
						$typeRegister = $this->requestAction('/Codifiers/getById/tipo_registro');
						$resultArray = Hash::combine($typeRegister, 'Codifier.tipo_registro.{s}', 'Codifier.tipo_registro.{s}');
						echo $this->Form->input(' ', array('options' => $resultArray, 'class' => 'span6', 'value'=> '',
							'name'  => 'data[Document][v9]['. __('Tipo de Registro') .']', 'id' => 'tipo_registro', 'required' => 'true'));
					?>
					</td>
					<td class="mandatory">[09]</td>
				</tr>
				<tr class="info">
					<td style="align: center" colspan="12">
						<div class="span5"></div> <b><?php echo __('Nivel Serie') ?> </b><a
						id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a></td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Título')); ?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->textarea('', array(				
								'type' => 'text',
								'class' => 'span6',
								'rows' => 4,
								'value'=> '',
								'name'  => 'data[Document][v30]['. utf8_encode(__('Título')) .']',
								'required' => 'true'
						)); ?>
					</td>
					<td class="mandatory">[30]</td>
				</tr>
				<tr>
					<td><?php echo __('Volumen'); ?></td>
					<td><?php echo $this->Form->input('', array(				
							'type' => 'text',
							'class' => 'span6',
							'value'=> '',
							'name'  => 'data[Document][v31]['.__('Volumen').']'
					)); ?></td>
					<td>[31]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Número del Fascículo')); ?></td>
					<td><?php echo $this->Form->input('', array(				
							'type' => 'text',
							'class' => 'span6',
							'value'=> '',
							'name'  => 'data[Document][v32]['. utf8_encode(__('Número del Fascículo')) .']'
					)); ?></td>
					<td>[32]</td>
				</tr>
				<tr>
					<td><?php echo __('ISSN'); ?></td>
					<td><?php echo $this->Form->input('', array(				
							'type' => 'text',
							'class' => 'span6',
							'value'=> '',
							'name'  => 'data[Document][v35]['.__('ISSN').']'
					)); ?></td>
					<td>[35]</td>
				</tr>
				<tr class="info">
					<td colspan="12" style="border-left-width: 0px; padding-left: 6px;"><div
							class="span5"></div> <b><?php echo utf8_encode(__('Nivel Monográfico')) ?>
					</b><a id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a>
					</td>
				</tr>
				<tr>
					<td><?php echo __('Autor Personal'); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => __('Autor Personal'), "numberField" => 16));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'disabled' => true,
							'value'=> '',
							'name'  => 'data[Document][v16]['.__('Autor Personal').']'
					)); ?></td>
					<td>[16]</td>
				</tr>
				<tr>
					<td><?php echo __('Autor Institucional'); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => __('Autor Institucional'), "numberField" => 17));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td>
						<div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->textarea('', array(				
								'type' => 'text',
								'class' => 'span6',
								'rows' => 4,
								'disabled' => true,
								'value'=> '',
								'name'  => 'data[Document][v17]['.__('Autor Institucional').']',
								'required' => 'true'
				)); ?>
					</td>
					<td class="mandatory">[17]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Título')); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__('Título')), "numberField" => 18));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td>
						<div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->textarea('', array(				
								'type' => 'text',
								'class' => 'span6',
								'rows' => 4,
								'disabled' => true,
								'value'=> '',
								'name'  => 'data[Document][v18]['. utf8_encode(__('Título')) .']',
								'required' => 'true'
				)); ?>
					</td>
					<td class="mandatory">[18]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Título Traducido al Inglés')); ?></td>
					<td><?php echo $this->Form->input('', array(				
							'type' => 'text',
							'class' => 'span6',
							'value'=> '',
							'name'  => 'data[Document][v19]['. utf8_encode(__('Título Traducido al Inglés')) .']'
					)); ?></td>
					<td>[19]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Páginas')); ?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->input('', array(				
								'type' => 'text',
								'class' => 'span6',
								'value'=> '',
								'name'  => 'data[Document][v20]['. utf8_encode(__('Páginas')) .']',
								'required' => 'true'
						)); ?>
					</td>
					<td class="mandatory">[20]</td>
				</tr>
				<tr class="info">
					<td style="border-left-width: 0px; padding-left: 30px;"
						colspan="12"><div class="span4"></div> <b><?php echo __('Informaciones Complementarias')?>
					</b><a id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a></td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Información Descriptiva'));?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__("Información Descriptiva")), "numberField" => 38));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'disabled' => true,
							'value'=> '',
							'name'  => 'data[Document][v38]['. utf8_encode(__('Información Descriptiva')) .']'
					)); ?></td>
					<td>[38]</td>
				</tr>
				<tr>
					<td><?php echo __('Idioma del Texto');?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php
						$lenguaje = $this->requestAction('/Codifiers/getById/lenguaje');
						echo $this->Form->input('', array('options' => $lenguaje['Codifier']['lenguaje'], 'size' => 4, 'multiple' => 'multiple', 'style' =>'width: 385px', 'required' => 'true', 'value'=> '', 'name'  => 'data[Document][v40]['. _('Idioma del Texto') .']' ));
						?>
					</td>
					<td class="mandatory">[40]</td>
				</tr>
				<tr class="info">
					<td style="align: center" colspan="12"><div class="span5"></div> <b><?php echo __('Otras Notas');?>
					</b><a id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a></td>
				</tr>
				<tr>
					<td><?php echo __('Nota General');?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v500]['. _('Nota General') .']'
					)); ?></td>
					<td>[500]</td>
				</tr>
				<tr>
					<td><?php echo __('Nota Formateada de Contenido');?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v505]['. __('Nota Formateada de Contenido') .']'
					)); ?></td>
					<td>[505]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Nota de Disponibilidad de Forma Física Adicional'));?>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v530]['. utf8_encode(__('Nota de Disponibilidad de Forma Física Adicional')) .']'
					)); ?></td>
					<td>[530]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Nota de Reproducción'))?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v533]['. utf8_encode(__('Nota de Reproducción')) .']'
					)); ?></td>
					<td>[533]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Nota de Versión Original'))?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v534]['. utf8_encode(__('Nota de Versión Original')) .']'
					)); ?></td>
					<td>[534]</td>
				</tr>
				<tr>
					<td><?php echo __('Nota Interna')?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v61]['. __('Nota Interna') .']'
					)); ?></td>
					<td>[61]</td>
				</tr>
				<tr class="info">
					<td colspan="12" style="padding-left: 20px;"><div class="span5"></div>
						<b>Imprenta</b><a id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a></td>
				</tr>
				<tr>
					<td><?php echo __('Editora')?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->textarea('', array(				
								'type' => 'text',
								'class' => 'span6',
								'rows' => 4,
								'value'=> '',
								'name'  => 'data[Document][v62]['. __('Editora') .']',
								'required' => 'true'
						)); ?>
					</td>
					<td class="mandatory">[62]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Edición'))?></td>
					<td><?php echo $this->Form->input('', array(				
							'type' => 'text',
							'class' => 'span6',
							'value'=> '',
							'name'  => 'data[Document][v63]['. utf8_encode(__('Edición')) .']'
					)); ?></td>
					<td>[63]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Fecha de Publicación'))?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->input('', array(				
								'type' => 'text',
								'class' => 'span6',
								'value'=> '',
								'name'  => 'data[Document][v64]['. utf8_encode(__('Fecha de Publicación')) .']',
								'required' => 'true'
						)); ?>
					</td>
					<td class="mandatory">[64]</td>
				</tr>
				<tr>
					<td><?php echo __('Fecha Normalizada')?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->input('', array(				
								'type' => 'text',
								'class' => 'span6',
								'value'=> '',
								'name'  => 'data[Document][v65]['. __('Fecha Normalizada').']',
								'required' => 'true'
						)); ?>
					</td>
					<td class="mandatory">[65]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Ciudad de Publicación'))?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php echo $this->Form->input('', array(				
								'type' => 'text',
								'class' => 'span6',
								'value'=> '',
								'name'  => 'data[Document][v66]['. utf8_encode(__('Ciudad de Publicación')) .']',
								'required' => 'true'
						)); ?>
					</td>
					<td class="mandatory">[66]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('País de Publicación')); ?></td>
					<td><div class='alert alert-error lil' style="display: none;">
							<button type='button' class='close'>&times;</button>
							<p>
								<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
							</p>
						</div> <?php
						$paises = $this->requestAction('/Codifiers/getById/paisesll');
						$firstKey = str_replace('-','',Hash::get($paises, 'Codifier.paisesll.------'));
						$secondKey = str_replace('-','',Hash::get($paises, 'Codifier.paisesll.-----'));
						$resultArray = array();
						$tempKey;
							
						foreach ($paises['Codifier']['paisesll'] as $key => $value) {
						if($key == '------'){
							$tempKey = $firstKey;
						};
						if($key == '-----'){
							$tempKey = $secondKey;
						};
						if($key == ''){
						    $resultArray = Hash::insert($resultArray, $key, $value);
						}elseif($key != '------' && $key != '-----'){
							$resultArray = Hash::insert($resultArray, $tempKey.".".$key, $value);
						}
					}

					echo $this->Form->input('', array('options' => $resultArray, 'size' => 4, 'style' =>'width: 385px','value'=> '', 'required' => 'true',	'name'  => 'data[Document][v67]['. utf8_encode(__('País de Publicación')) .']' ));
					?></td>
					<td class="mandatory">[67]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Símbolo'))?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v68]['. utf8_encode(__('Símbolo')) .']'
					)); ?></td>
					<td>[68]</td>
				</tr>
				<tr>
					<td><?php echo __('ISBN')?></td>
					<td><?php echo $this->Form->input('', array(				
							'type' => 'text',
							'class' => 'span6',
							'value'=> '',
							'name'  => 'data[Document][v69]['. __('ISBN').']'
					)); ?></td>
					<td>[69]</td>
				</tr>
				<tr class="info">
					<td colspan="12" style="padding-left: 5px;"><div class="span5"></div>
						<b><?php echo __('Datos de Contenido')?> </b><a id="next" href="#"
						class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a></td>
				</tr>
				<tr>
					<td><?php echo __('Palabras Llaves del Autor')?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => __('Palabras Llaves del Autor'), "numberField" => 85));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'disabled' => true,
							'value'=> '',
							'name'  => 'data[Document][v85]['. __('Palabras Llaves del Autor').']'
					)); ?></td>
					<td>[85]</td>
				</tr>
				<tr class="info">
					<td colspan="12" style="padding-left: 25px;"><div class="span5"></div>
						<b>Resumen</b><a id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a></td>
				</tr>
				<tr>
					<td><?php echo __('Resumen')?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => __('Resumen'), "numberField" => 83));
								?>
								<a id='cleanField' class="btn" style="padding: 6px 5px 7px;"
									href="#"><i class="icon-remove"></i> </a>
							</div>
						</div>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 19,
							'disabled' => 'true',
							'value'=> '',
							'name'  => 'data[Document][v83]['. __('Resumen').']'
					)); ?>
					</td>
					<td>[83]</td>
				</tr>
				<tr id="complementos" class="info">
					<td colspan="12" style="align: center"><div class="span5"></div> <b><?php  echo __('Complementos') ?>
					</b><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a>
					</td>
				</tr>
				<tr>
					<td colspan="12">
						<div id="accordion1" class="accordion">
							<label class="checkbox"> <input id="eventNotes" type="checkbox">
								<?php echo __('Notas de Evento') ?>
							</label>
							<div id="collapseOne" class="accordion-body collapse">
								<div class="accordion-inner">
									<table class="table table-bordered">
										<tr>
											<td><?php echo utf8_encode(__('Institución Patrocinadora')) ?>
											</td>
											<td><?php echo $this->Form->textarea('', array(				
													'type' => 'text',
													'class' => 'span6',
													'rows' => 4,
													'value'=> '',
													'name'  => 'data[Document][v52]['. utf8_encode(__('Evento - Institución Patrocinadora')) .']'
											)); ?>
											</td>
											<td class='span1'>[52]</td>
										</tr>
										<tr>
											<td><?php echo __('Nombre') ?></td>
											<td><div class='alert alert-error lil' style="display: none;">
													<button type='button' class='close'>&times;</button>
													<p>
														<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
													</p>
												</div> <?php echo $this->Form->textarea('', array(				
														'type' => 'text',
														'class' => 'span6',
														'rows' => 4,
														'value'=> '',
														'name'  => 'data[Document][v53]['. __('Evento - Nombre').']'
												)); ?></td>
											<td class="mandatory">[53]</td>
										</tr>
										<tr>
											<td><?php echo __('Fecha') ?></td>
											<td><div class='alert alert-error lil' style="display: none;">
													<button type='button' class='close'>&times;</button>
													<p>
														<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
													</p>
												</div> <?php echo $this->Form->input('', array(				
														'type' => 'text',
														'class' => 'span6',
														'value'=> '',
														'name'  => 'data[Document][v54]['. __('Evento - Fecha').']'
												)); ?></td>
											<td class="mandatory">[54]</td>
										</tr>
										<tr>
											<td><?php echo __('Fecha Normalizada') ?></td>
											<td><?php echo $this->Form->input('', array(				
													'type' => 'text',
													'class' => 'span6',
													'value'=> '',
													'name'  => 'data[Document][v55]['. __('Evento - Fecha Normalizada').']'
											)); ?></td>
											<td>[55]</td>
										</tr>
										<tr>
											<td><?php echo __('Ciudad') ?></td>
											<td><div class='alert alert-error lil' style="display: none;">
													<button type='button' class='close'>&times;</button>
													<p>
														<?php echo __('Este campo es obligatorio, por favor debe llenarlo'); ?>
													</p>
												</div> <?php echo $this->Form->input('', array(				
														'type' => 'text',
														'class' => 'span6',
														'value'=> '',
														'name'  => 'data[Document][v56]['. __('Evento - Ciudad') .']'
												)); ?>
											</td>
											<td class="mandatory">[56]</td>
										</tr>
										<tr>
											<td><?php echo utf8_encode(__('País')) ?></td>
											<td><?php
											$paises = $this->requestAction('/Codifiers/getById/pais');
											echo $this->Form->input('', array('options' => $paises['Codifier']['pais'], 'class' => 'span6', 'value'=> '', 'name'  => 'data[Document][v57]['. utf8_encode(__('Evento - País')) .']' ));
											?>
											</td>
											<td>[57]</td>
										</tr>
									</table>
								</div>
							</div>

						</div>
					</td>
				</tr>
				<tr>
					<td colspan="12">
						<div id="accordion2" class="accordion">
							<label class="checkbox"> <input id="proyectNotes" type="checkbox">
								<?php echo __('Notas de Proyecto') ?>
							</label>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
									<table class="table table-bordered">
										<tr>
											<td><?php echo utf8_encode(__('Institución Patrocinadora')) ?>
											</td>
											<td><?php echo $this->Form->textarea('', array(				
													'type' => 'text',
													'class' => 'span6',
													'rows' => 4,
													'value'=> '',
													'name'  => 'data[Document][v58]['. utf8_encode(__('Proyecto - Institución Patrocinadora')) .']'
											)); ?>
											</td>
											<td class='span1'>[58]</td>
										</tr>
										<tr>
											<td><?php echo __('Nombre') ?></td>
											<td><?php echo $this->Form->input('', array(				
													'type' => 'text',
													'class' => 'span6',
													'value'=> '',
													'name'  => 'data[Document][v59]['. __('Proyecto - Nombre') .']'
											)); ?></td>
											<td>[59]</td>
										</tr>
										<tr>
											<td><?php echo utf8_encode(__('Número')) ?></td>
											<td><?php echo $this->Form->input('', array(				
													'type' => 'text',
													'class' => 'span6',
													'value'=> '',
													'name'  => 'data[Document][v60]['. utf8_encode(__('Proyecto - Número')) .']'
											)); ?></td>
											<td>[60]</td>
										</tr>
									</table>
								</div>
							</div>

						</div>
					</td>
				</tr>

			</tbody>
		</table>
		<hr>
		<div class="form-actions">
			<table>
				<tr>
					<td>
						<div id="documentCancelButton" style = "padding-bottom: 11px;">
							<?php echo $this->Form->button(__('Cancelar'), array('type' => 'button', 'class' => 'btn'));?>
						</div>
					</td>
					<td>
						<div id="documentPreviewButton">
							<?php echo $this->Form->postButton(__('Vista Previa'), array('action' => 'add'), array('class' => 'btn btn-primary', "style" => "margin-bottom: 10px;")); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>

</div>


