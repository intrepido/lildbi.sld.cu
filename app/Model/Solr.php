<?php
class Solr extends AppModel {
	
	public $useDbConfig = 'solr';
	public $useTable = false;
	
	public function search($params = null){
		return $this->query(array('type' => 'search', 'params' => $params));
	}
	
	public function toIndexBase($nameBD = null, $skip = null, $limit = null,$commit = null){
			App::uses('ConnectionManager', 'Model');
			$dataSource = ConnectionManager::getDataSource('couchdb');
			$host = $dataSource->config['host'];
			$port = $dataSource->config['port'];
				
			return $this->query(array('type' => 'dih' , 'namedih' => 'couchimport' , 'params' => 'command=full-import&commit='.$commit.'&clean=false&host='.$host.'&port='.$port.'&base='.$nameBD.'&skip='.$skip.'&limit='.$limit));
	}
	
	public function unindexBase($nameBD = null){
			$this->query(array('type'=>'deleteByQuery', 'query'=>('v4:'.$nameBD)));	
			return true;
	}
	
	public function unindexAll(){
			$this->query(array('type'=>'deleteAll'));	
			return true;
	}
		
	public function facetByField($q = null, $field = null){		
		return $this->query(array('type' => 'facet', 'query' => $q, 'fields' => array($field)));
	}
	
	public function facetByFields($q = null, $fields = null){		
		return $this->query(array('type' => 'facet', 'query' => $q, 'fields' => $fields));
	}
	
	public function getSuggest($params = null){
		return $this->query(array('type' => 'suggest', 'params' => $params));
	}
	
}
?>
