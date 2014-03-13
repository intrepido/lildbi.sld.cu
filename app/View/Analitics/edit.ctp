<?php 
echo $this->Html->script('documents', FALSE);
echo $this->Html->script('assistant', FALSE);
echo $this->Html->script('codifiers', FALSE);

echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
		$this->Html->link( utf8_encode(__('Analíticas')), array('controller' => 'analitics','action' => 'index', $this->Session->check('idDocumentForUrl')? $this->Session->read('idDocumentForUrl') : '' ), array('id' => 'backUrl')),
		__('Editar')
), array('class' => 'breadcrumb row-fluid'));



if (isset($typeEditAnalitic)){


	if ($typeEditAnalitic == 'series_monograficas') {
		echo $this->element('Analitics/series_monograficas');
	}

	if ($typeEditAnalitic == 'monografia_pert_coleccion') {
		echo $this->element('Analitics/monografia_pert_coleccion');
	}

}
?>

