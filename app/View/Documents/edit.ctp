<?php 
echo $this->Html->script('documents', FALSE);
echo $this->Html->script('assistant', FALSE);
echo $this->Html->script('codifiers', FALSE);

echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		$this->Html->link(__('Documentos'), array('controller' => 'documents','action' => 'index')),
		__('Editar')
), array('class' => 'breadcrumb row-fluid'));



if (isset($typeEditDocument)){


	if ($typeEditDocument == 'series_monograficas') {
		echo $this->element('Documents/series_monograficas');
	}

	if ($typeEditDocument == 'monografia_pert_coleccion') {
		echo $this->element('Documents/monografia_pert_coleccion');
	}

}
?>

