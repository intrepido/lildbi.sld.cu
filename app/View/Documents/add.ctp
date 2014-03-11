<?php
echo $this->Html->script('documents', FALSE);
echo $this->Html->script('assistant', FALSE);
echo $this->Html->script('codifiers', FALSE);
?>

<?php
if (!isset($urlTypeNameDocument)) {
	echo $this->Html->breadcrumb(array(
			$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
			$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')), $this->Session->read('index')
	), array('class' => 'breadcrumb row-fluid'));

	echo $this->Session->flash();
	?>
<div class="container-document">
	<h3>
		<?php echo __('Seleccione el Tipo de Documento'); ?>
	</h3>
	<hr>
	<div class="users form">
		<fieldset>
			<?php
			$urlTypeNameDocuments = array('series_monograficas' => utf8_encode(__('Series Monogr�ficas')),
					'monografia_pert_coleccion' => utf8_encode(__('Monogr�fica Perteneciente a una Colecci�n')),
					'monografia' => utf8_encode(__('Monograf�a')), 'no_convencional' => __('No Convencional'),
					'serie_periodica' => utf8_encode(__('Serie Peri�dica')), 'coleccion_monografias' => utf8_encode(__('Colecci�n de Monograf�as')),
					'tesis_disertacion_pert_serie_monografica' => utf8_encode(__('Tesis, Disertaci�n Perteneciente a una Serie
					Monogr�fica')), 'tesis_disertacion' => utf8_encode(__('Tesis, Disertaci�n')));
			echo $this->Form->input('', array('options' => $urlTypeNameDocuments, 'size' => 8, 'style' =>'width: 385px' ));
			?>
		</fieldset>
		<hr>
		<div class="form-actions">
			<table>
				<tr>
					<td><a id="confirm-type-document" class="btn btn-primary"><?php echo __('Confirmar'); ?>
					</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?php } ?>
<?php
if (isset($urlTypeNameDocument)){

	echo $this->Html->breadcrumb(array(
		  $this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		  $this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
		  $this->Html->link($this->Session->read('index'), array('controller' => 'documents','action' => 'add')),
		  $typeNameDocument
	), array('class' => 'breadcrumb row-fluid'));

	if ($urlTypeNameDocument == 'series_monograficas') {
		echo $this->element('Documents/series_monograficas');
	}

	if ($urlTypeNameDocument == 'monografia_pert_coleccion') {
		echo $this->element('Documents/monografia_pert_coleccion');
	}

}
?>










