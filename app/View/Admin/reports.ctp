<?php

echo $this->Html->script('highcharts/highcharts', FALSE);
echo $this->Html->script('highcharts/modules/exporting', FALSE);
echo $this->Html->script('reports', FALSE);


echo $this->Html->breadcrumb(array(
		$this->Html->link(__('Inicio'), array('controller' => 'admin','action' => 'index')),
		'Informes',
), array('class' => 'breadcrumb'));
?>

<div class="container-document">
	<div class="row-fluid">
		<div class="container-document-inner" style="margin-bottom: 0px;">
			<div id="loading" style="text-align: center;"></div>
			<div id="report"></div>
		</div>
	</div>
</div>

