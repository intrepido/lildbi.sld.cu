<?php

class Solr extends AppModel {
	public $name = 'Solr'; 
	public $useDbConfig = 'solr';
	public $useTable = false;
	
	public function toIndexBase($nameBD = null){
			App::uses('ConnectionManager', 'Model');
			$dataSource = ConnectionManager::getDataSource('couchdb');
			$host = $dataSource->config['host'];
			$port = $dataSource->config['port'];
			
			$this->query(array('type' => 'dih' , 'namedih' => 'couchimport' , 'params' => 'command=full-import&commit=true&clean=false&host='.$host.'&port='.$port.'&base='.$nameBD));
			return true;
	}
	
	public function unindexBase($nameBD = null){
			$this->query(array('type'=>'deleteByQuery', 'query'=>('v4:'.$nameBD)));	
			return true;
	}
	
	public function makeSearch($terms = null, $start = null, $rows = null, $format = null){
		return $this->query(array('type' => 'query', 'query' => $terms, 'start' => $start, 'rows' => $rows));
	}
	
	public function facetByField($field = null){		
		return $this->query(array('type' => 'facet', 'query' => '*:*', 'fields' => array($field)));
	}
}

?>
