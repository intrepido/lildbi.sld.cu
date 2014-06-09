<?php

class SolrSource extends DataSource 
{
	
	function connect()
	{
		$this->connected = true;
		return $this->connected;
	}
	function disconnect()
	{
		$this->connected = false;
		return !$this->connected;
	}
	
	
	function query($q = null){
				
		//Consultar
		//ej: query(array('type' => 'search', 'params' => 'select?q=medicina'));
		if($q['type'] == 'search'){						
			if($response = @file_get_contents('http://'.$this->config['host'].':'.$this->config['port'].'/'.$this->config['path'].'/'.$this->config['core'].'/'.$q['params'].'&wt=json')){
				return json_decode($response,true);
			}else{
				return false;	
			}		
		}
		
		//Importar con un DIH
		//ej: query(array('type' => 'dih' , 'namedih' => 'dataimport' , 'params' => 'command=full-import&base=tramed_base'));	
		if($q['type'] == 'dih'){				
			if($response = @file_get_contents('http://'.$this->config['host'].':'.$this->config['port'].'/'.$this->config['path'].'/'.$this->config['core'].'/'.$q['namedih'].'?'.$q['params'])){
				return json_decode($response,true);
			}else{
				return false;	
			}
		}
		
		//Autocompletamiento
		//ej: query(array('type' => 'suggest' , 'params' => 'suggest?q=ac'));	
		if($q['type'] == 'suggest'){	
			if($response = @file_get_contents('http://'.$this->config['host'].':'.$this->config['port'].'/'.$this->config['path'].'/'.$this->config['core'].'/'.$q['params'])){	
				return json_decode($response,true);
			}else{
				return false;	
			}
		}
		
		//Recargar configuracion del nucleo
		//ej: query(array('type' => 'reload');
		if($q['type'] == 'reload'){		
			if($response = @file_get_contents('http://'.$this->config['host'].':'.$this->config['port'].'/'.$this->config['path'].'/admin/cores?action=RELOAD&core='.$this->config['core'].'&wt=json')){
				return json_decode($response,true);
			}else{
				return false;	
			}	
		}
			
		
		//Métodos que utilizan la biblioteca PHPSolr.	
				
		$opciones = array
		(
			'hostname' => $this->config['host'],
			'port'     => $this->config['port'],
			'path'     => '/'.$this->config['path'].'/'.$this->config['core'].'/',
		);
			
		$client = new SolrClient($opciones);
			
		//Facetado
		//ej: query(array('type' => 'facet', 'query' => 'medicina', 'fields' => array('v4' , 'v40')));
		if($q['type'] == 'facet'){

			$consulta = new SolrQuery($q['query']);

			$consulta->setFacet(true);

			foreach($q['fields'] as $field){
				$consulta->addFacetField($field);
			}
				
			$consulta->setFacetMinCount(1);
			
			$response = $client->query($consulta);
			
			$temp = $response->getResponse();
			
			return $temp->facet_counts->facet_fields;

		}
		
		//Añadir documento
		//ej: array('type' => 'add', 'fields' => array('id' => '123', v2 => '123', 'v4' => 'VIMED'));
		if($q['type'] == 'add'){
			$doc = new SolrInputDocument();
			$fields = $q['fields'];
			foreach($fields as $field){
				$doc->addField(key($fields), $field);
				next($fields);
			}
			$response = $client->addDocument($doc);
			$client->request("<commit/>");
			return $response;
		}
		
		//Eliminar todo el indce
		//ej: query(array('type' => 'deleteAll')); 
		if($q['type'] == 'deleteAll'){
			$client->deleteByQuery('*:*');
			$client->request("<commit/>");
			return true;
		}
		
		//Elimina los que coincidan con la consulta
		//ej: query(array('type' => 'deleteByQuery','query' => 'name:edelio'));
		if($q['type'] == 'deleteByQuery'){
			$client->deleteByQuery($q['query']);
			$client->request("<commit/>");
			return true;
		}	
		return false;		
	}
	
}
?>
	
	