<?php
$temp;
if ($this->Session->read('index')) {
	$temp = 'Con Indezacion';
}
else {
	$temp = 'Sin Indezacion';
}

echo $this->Html->breadcrumb(array(
		$this->Html->link('Documentos', array('controller' => 'admin','action' => 'index')),
		$this->Html->link($temp, array('controller' => 'documents','action' => 'add')),
		'Monografia Perteneciente a una Coleccion'
));

echo "Monografia Perteneciente a una Coleccion";