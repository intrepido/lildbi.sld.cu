<?php
echo $this->Html->script('documents', FALSE);
echo $this->Html->script('codifiers', FALSE);
echo $this->Html->script('assistant', FALSE);

if (isset($urlTypeNameDocument)){

	echo $this->Html->breadcrumb(array(
			$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
			$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
			$this->Html->link(utf8_encode(__('Analíticas')), array('controller' => 'analitics','action' => 'index')),
			utf8_encode(__('Nueva Analítica'))
	), array('class' => 'breadcrumb row-fluid'));
	
	if ($urlTypeNameDocument == 'series_monograficas') {
		echo $this->element('Analitics/series_monograficas');
	}

	if ($urlTypeNameDocument == 'monografia_pert_coleccion') {
		echo $this->element('Analitics/monografia_pert_coleccion');
	}

}
?>






