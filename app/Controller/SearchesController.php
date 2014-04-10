<?php

class SearchesController extends AppController {
	public $name = 'Searches'; 
	var $uses = array('Solr','Document');
	var $helpers = array('Solr');
	public $recursive = 1;

	public function beforeFilter() {
		parent::beforeFilter();
		// La accion index que lleva a la interfaz de busqueda es la unica accesible sin autenticarse.
		$this->Auth->allow('index');
		$this->Auth->allow('indexBoard');
		$this->Auth->allow('test');
		
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
	
	function index($q = '', $start = 0, $rows = 10, $format = 0) { 	
		if(($q != '' && $q != '0') || $this->request->is('post')){
			if($this->request->is('post')){
					$this->redirect(array('action'=>'index', $this->data['query']['qText'], 0,$this->data['query']['rows'], $this->data['query']['format']));									
			}
			else{
					$result = $this->Solr->makeSearch($q,$start,$rows);
					$result['responseHeader']['params']['format'] = $format;	
					$this->set(compact('result'));
			}
		}
	}
	
/*	function index($q = null, $start = 0, $rows = 10) { 	
		if($this->request->is('post')){
				if($this->data['query']['qText'] == ''){
					$result = null;
				}else{
					$result = $this->Solr->makeSearch($this->data['query']['qText'],$start,$this->data['query']['rows']);
				}
				$this->set(compact('result'));									
		}else{
			if(isset($q)){
				$result = $this->Solr->makeSearch($q,$start,$rows);
				$this->set(compact('result'));
			}
		}	
	}*/
	
	function indexBoard(){
		$this->layout = 'admin_layout';
		$bases = $this->Document->curlGet('_all_dbs');
		$temp = array();
		$status = '';	
		$facetResults = $this->Solr->facetByField('v4');
		
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
		$this->Solr->toIndexBase($nameBD.'_base');
		$this->redirect(array('action'=>'indexBoard'),null,true);		
	}
	
	function unindex($nameBD = null){
		$this->Solr->unindexBase($nameBD);			
		$this->redirect(array('action'=>'indexBoard'),null,true);	
	}
	
	function test(){
		
	}
	
}

?>