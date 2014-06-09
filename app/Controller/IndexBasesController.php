<?php

class IndexBasesController extends AppController {
	
	public $name = 'IndexBases'; 
	public $uses = array('Solr','Document');
	public $components = array('RequestHandler');


	//Permisos y control del layout
	public function beforeFilter() {
		parent::beforeFilter();
		// El layout depende del rol que juega el usuario.	
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


	//Redirecciona
	function index(){
		$this->redirect(array('action'=>'viewBases'),null,true);		
	}
	
	//Ver bases disponibles
	function viewBases(){
		$bases = $this->Document->curlGet('_all_dbs');
		$facetResults = $this->Solr->facetByField('*:*','v4');
		$temp = array();
		$status = '';	
	
		foreach ($bases as $base) {							
			if( strpos( $base, "_base" ) != false ){				
				if($facetResults['v4'][strstr($base, '_', true)]){
					$status = "success"; //Indexado
					$countCouch = $this->Document->curlGet($base);
					array_push($temp, array('name' => strstr($base, '_', true), 'capacity' => $status, 'countDocsSolr' => $facetResults['v4'][strstr($base, '_', true)], 'countDocsCouch' => ($countCouch['doc_count']-1)));
				}
				else{
					$status = ""; //No Indexado
					$countCouch = $this->Document->curlGet($base);
					array_push($temp, array('name' => strstr($base, '_', true), 'capacity' => $status, 'countDocsSolr' => 0, 'countDocsCouch' => ($countCouch['doc_count']-1)));
				}
			}				
		}		
		$this->set("bases", $temp);		
	}
	
	//Indexar una base dada
	function toindex($nameBD = null){
		if($this->RequestHandler->isAjax()){
			$this->Solr->toIndexBase($this->request->data["base"].'_base', $this->request->data["skip"],$this->request->data["limit"],$this->request->data["commit"]);
			$this->autoRender = FALSE;
			return true;
		}
		$this->autoRender = FALSE;
		return false;	
	}
	
	//Reindexar una base dada
	function reindex($nameBD = null){
		$this->Solr->unindexBase($nameBD);
		$this->Solr->toIndexBase($nameBD.'_base');
		$this->redirect(array('action'=>'viewBases'),null,true);		
	}
	
	//Eliminar del indice una base dada
	function unindex($nameBD = null){
		$this->Solr->unindexBase($nameBD);			
		$this->redirect(array('action'=>'viewBases'),null,true);	
	}	
	
	//Vaciar Indice
	function unindexAll(){
		$this->Solr->unindexAll();			
		$this->redirect(array('action'=>'viewBases'),null,true);	
	}
	
}

?>