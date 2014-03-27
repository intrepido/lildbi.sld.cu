<?php

class SearchesController extends AppController {
	public $name = 'Searches'; 
	var $uses = array('Search','Document');
	public $recursive = 1;

	public function beforeFilter() {
		parent::beforeFilter();
		// La accón index que lleva a la interfaz de búsqueda es la única accesible sin autenticarse.
		$this->Auth->allow('index');
		
		// El layout depende del rol que juega el usuario.
		$this->layout = 'search_layout'; //Usuario sin autenticarse
		
		if ($this->Session->read('userRol') == 'Administrador'){ //Administrador
			$this->layout = 'admin_layout';
		}

		if ($this->Session->read('userRol') == 'Documentalista'){ //Documentalista
			$this->layout = 'documentalista_layout';
		}

		if ($this->Session->read('userRol') == 'Editor'){ //Editor
			$this->layout = 'editor_layout';
		}
	}

	public function isAuthorized($user) {
		// Solo los administradores pueden utilizar el resto de las acciones.
		if ($this->Session->read('userRol') == 'Administrador') {
			return true;
		}
		return false;
	}
	
	
	function index() { 	
		if ($this->request->is('post')) {	
			if($this->data['query']['qText'] == ''){
				$result = null;
			}else{
				$result = $this->Search->makeSearch($this->data['query']['qText'],0,20);
			}
			$this->set(compact('result'));									
		}	
	}
	
	function indexBoard(){
		$this->layout = 'admin_layout';
		$bases = $this->Document->curlGet('_all_dbs');
		$temp = array();
		$status = '';	
		$facetResults = $this->Search->facetByField('v4');
		
		foreach ($bases as $base) {							
			if( strpos( $base, "_base" ) !== false ){				
				if($facetResults['v4'][strstr($base, '_', true)]){
					$status = "success"; //Indexado
					array_push($temp, array('name' => strstr($base, '_', true), 'capacity' => $status, 'countDocs' => $facetResults['v4'][strstr($base, '_', true)]));
				}
				else{
					$status = ""; //No Indexado
					array_push($temp, array('name' => strstr($base, '_', true), 'capacity' => $status, 'countDocs' => 0));
				}
			}				
		}		
		$this->set("bases", $temp);		
	}
	
	function toindex($nameBD = null){
		$this->Search->toIndexBase($nameBD.'_base');
		$this->redirect(array('action'=>'indexBoard'),null,true);		
	}
	
	function unindex($nameBD = null){
		$this->Search->unindexBase($nameBD);			
		$this->redirect(array('action'=>'indexBoard'),null,true);	
	}
	
}

?>