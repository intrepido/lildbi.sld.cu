
<?php if(isset($backValues) || $this->Session->check('document')){ //Si vengo desde la pagina de Visualizacion, recivo los datos en "$backValues" 
$escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
$replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
?>

<script type="text/javascript">
	//<![CDATA[
		   <?php $document = str_replace($escapers, $replacements, json_encode($this->Session->read('document')));?>
           window.arrayDataDocument = JSON.parse('<?php echo $document; ?>');	
           
           <?php if(isset($backValues)) {
 			  $backEscapedValues = str_replace($escapers, $replacements, json_encode($backValues));
 		   ?>
 		 	  window.arrayData = JSON.parse('<?php echo $backEscapedValues; ?>');
 		 <?php } ?>
    //]]>
</script>

<?php } ?>

<div class="container-document">
	<div class="page-header">
		<h3>
			<?php echo utf8_encode(__('Serie Monogr�fica')); ?>
		</h3>
	</div>

	<form accept-charset="utf-8" method="post" id="DocumentAddForm"
		action="/analitics/<?php echo isset($typeEditAnalitic) ? 'edit' : 'add';?>/series_monograficas/<?php echo isset($typeEditAnalitic) ? $this->Session->read('idEdit').'/' : $this->Session->read('idDocument').'/';?>visualization">
		<div style="display: none;">
			<input type="hidden" value="POST" name="_method">
		</div>
		<table class="table table-bordered table-hover inset-type">
			<thead>
				<tr>
					<th><?php echo __('Campo'); ?></th>
					<th><?php echo utf8_encode(__('Descripci�n Bibliogr�fica')); ?></th>
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
					<td><?php echo utf8_encode(__('N�mero de Identificaci�n')); ?></td>
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
								'name'  => 'data[Document][v2]['. utf8_encode(__('N�mero de Identificaci�n')) .']',
								'required' => 'true'
				)); ?>
					</td>
					<td class="mandatory">[02]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Localizaci�n del Documento')); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__('Localizaci�n del Documento')), "numberField" => 3));
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
							'name'  => 'data[Document][v3]['. utf8_encode(__('Localizaci�n del Documento')) .']'

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
					<td><?php echo utf8_encode(__('N�mero del Registro')); ?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v7]['. utf8_encode(__('N�mero del Registro')) .']'
					)); ?></td>
					<td>[07]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Direcci�n Electr�nica')); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__('Direcci�n Electr�nica')), "numberField" => 8));
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
							'name'  => 'data[Document][v8]['. utf8_encode(__('Direcci�n Electr�nica')) .']'
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
					</a>
					</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('T�tulo')); ?></td>
					<td></td>
					<td>[30]</td>
				</tr>
				<tr class="success">
					<td><?php echo __('Volumen'); ?></td>
					<td></td>
					<td>[31]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('N�mero del Fasc�culo')); ?></td>
					<td></td>
					<td>[32]</td>
				</tr>
				<tr class="success">
					<td><?php echo __('ISSN'); ?></td>
					<td></td>
					<td>[35]</td>
				</tr>
				<tr class="info">
					<td colspan="12" style="border-left-width: 0px; padding-left: 6px;"><div
							class="span5"></div> <b><?php echo utf8_encode(__('Nivel Monogr�fico')) ?>
					</b><a id="next" href="#" class="pull-right"><?php  echo $this->Html->image('next.gif'); ?>
					</a><a id="prev" href="#" class="pull-right"><?php  echo $this->Html->image('prev.gif'); ?>
					</a><a id="bott" href="#" class="pull-right"><?php  echo $this->Html->image('bott.gif'); ?>
					</a><a id="top" href="#" class="pull-right"><?php  echo $this->Html->image('top.gif'); ?>
					</a>
					</td>
				</tr>
				<tr class="success">
					<td><?php echo __('Autor Personal'); ?>
					</td>
					<td></td>
					<td>[16]</td>
				</tr>
				<tr class="success">
					<td><?php echo __('Autor Institucional'); ?>
					</td>
					<td></td>
					<td>[17]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('T�tulo')); ?>
					</td>
					<td></td>
					<td>[18]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('T�tulo Traducido al Ingl�s')); ?></td>
					<td></td>
					<td>[19]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('P�ginas')); ?></td>
					<td></td>
					<td>[20]</td>
				</tr>
				<tr class="info">
					<td colspan="12" style="border-left-width: 0px; padding-left: 6px;"><div
							class="span5"></div> <b><?php echo utf8_encode(__('Nivel Anal�tico')) ?>
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
								echo $this->element('assistant',array("nameField" => __('Autor Personal'), "numberField" => 10));
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
							'name'  => 'data[Document][v10]['.__('Autor Personal').']'
					)); ?></td>
					<td>[10]</td>
				</tr>
				<tr>
					<td><?php echo __('Autor Institucional'); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => __('Autor Institucional'), "numberField" => 11));
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
								'name'  => 'data[Document][v11]['.__('Autor Institucional').']',
								'required' => 'true'
				)); ?>
					</td>
					<td class="mandatory">[11]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('T�tulo')); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__('T�tulo')), "numberField" => 12));
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
								'name'  => 'data[Document][v12]['. utf8_encode(__('T�tulo')) .']',
								'required' => 'true'
				)); ?>
					</td>
					<td class="mandatory">[12]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('T�tulo Traducido al Ingl�s')); ?></td>
					<td><?php echo $this->Form->input('', array(				
							'type' => 'text',
							'class' => 'span6',
							'value'=> '',
							'name'  => 'data[Document][v13]['. utf8_encode(__('T�tulo Traducido al Ingl�s')) .']'
					)); ?></td>
					<td>[13]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('P�ginas')); ?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__('P�ginas')), "numberField" => 14));
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
								'name'  => 'data[Document][v14]['. utf8_encode(__('P�ginas')) .']',
								'required' => 'true'
				)); ?>
					</td>
					<td class="mandatory">[14]</td>
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
					<td><?php echo utf8_encode(__('Informaci�n Descriptiva'));?>
						<div class="btn-toolbar">
							<div class="btn-group">
								<?php
								echo $this->element('assistant',array("nameField" => utf8_encode(__("Informaci�n Descriptiva")), "numberField" => 38));
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
							'name'  => 'data[Document][v38]['. utf8_encode(__('Informaci�n Descriptiva')) .']'
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
					<td><?php echo utf8_encode(__('Nota de Disponibilidad de Forma F�sica Adicional'));?>
					</td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v530]['. utf8_encode(__('Nota de Disponibilidad de Forma F�sica Adicional')) .']'
					)); ?></td>
					<td>[530]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Nota de Reproducci�n'))?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v533]['. utf8_encode(__('Nota de Reproducci�n')) .']'
					)); ?></td>
					<td>[533]</td>
				</tr>
				<tr>
					<td><?php echo utf8_encode(__('Nota de Versi�n Original'))?></td>
					<td><?php echo $this->Form->textarea('', array(				
							'type' => 'text',
							'class' => 'span6',
							'rows' => 4,
							'value'=> '',
							'name'  => 'data[Document][v534]['. utf8_encode(__('Nota de Versi�n Original')) .']'
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
				<tr class="success">
					<td><?php echo __('Editora')?></td>
					<td></td>
					<td>[62]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('Edici�n'))?></td>
					<td></td>
					<td>[63]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('Fecha de Publicaci�n'))?></td>
					<td></td>
					<td>[64]</td>
				</tr>
				<tr class="success">
					<td><?php echo __('Fecha Normalizada')?></td>
					<td></td>
					<td>[65]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('Ciudad de Publicaci�n'))?></td>
					<td></td>
					<td>[66]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('Pa�s de Publicaci�n')); ?></td>
					<td></td>
					<td>[67]</td>
				</tr>
				<tr class="success">
					<td><?php echo utf8_encode(__('S�mbolo'))?></td>
					<td></td>
					<td>[68]</td>
				</tr>
				<tr class="success">
					<td><?php echo __('ISBN')?></td>
					<td></td>
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
											<td><?php echo utf8_encode(__('Instituci�n Patrocinadora')) ?>
											</td>
											<td><?php echo $this->Form->textarea('', array(				
													'type' => 'text',
													'class' => 'span6',
													'rows' => 4,
													'value'=> '',
													'name'  => 'data[Document][v52]['. utf8_encode(__('Evento - Instituci�n Patrocinadora')) .']'
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
											<td><?php echo utf8_encode(__('Pa�s')) ?></td>
											<td><?php
											$paises = $this->requestAction('/Codifiers/getById/pais');
											echo $this->Form->input('', array('options' => $paises['Codifier']['pais'], 'class' => 'span6', 'value'=> '', 'name'  => 'data[Document][v57]['. utf8_encode(__('Evento - Pa�s')) .']' ));
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
											<td><?php echo utf8_encode(__('Instituci�n Patrocinadora')) ?>
											</td>
											<td><?php echo $this->Form->textarea('', array(				
													'type' => 'text',
													'class' => 'span6',
													'rows' => 4,
													'value'=> '',
													'name'  => 'data[Document][v58]['. utf8_encode(__('Proyecto - Instituci�n Patrocinadora')) .']'
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
											<td><?php echo utf8_encode(__('N�mero')) ?></td>
											<td><?php echo $this->Form->input('', array(				
													'type' => 'text',
													'class' => 'span6',
													'value'=> '',
													'name'  => 'data[Document][v60]['. utf8_encode(__('Proyecto - N�mero')) .']'
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
						<div id="documentCancelButton" style="padding-bottom: 11px;">
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


