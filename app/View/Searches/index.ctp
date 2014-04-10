<?php 	
	echo $this->Html->script('searches', FALSE);
	
	if(!isset($result)){ 
	 	echo $this->element('Searches/search_form');
	}else{
		echo $this->element('Searches/small_search_form');
		echo $this->element('Searches/results');
	}	
?>

