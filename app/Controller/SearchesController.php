<?php
class SearchesController extends AppController {
	
	public $name = 'Searches'; 
	public $uses = array('Solr','Document');
	public $helpers = array('Solr');
	public $components = array('RequestHandler');

	//Permisos y control del layout
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();	
		
		$this->layout = 'search_layout'; 
	}
	
	//Redirecciona
	function index(){
		$this->redirect(array('action'=>'search'));
	}
	
	//Busqueda Simple
	function search($params = null) { 	
		if($this->request->is('post')){
			$text = $this->data['query']['qText'];
			if(strlen($text) > 2){
				$q = urlencode($this->data['query']['qText']);		
				if(isset($this->data['query']['rows'])){
					$rows = $this->data['query']['rows'];
				}else{
					$rows = 10;
				}
			
				$this->redirect(array('action'=>'search', 'select?q='.$q.'&rows='.$rows));	
			}
		}
		else{
			if($params != null){
			  $result = $this->Solr->search($params);

			  if( strpos( $params, "&rows=" ) != false ){	
			  		$params = strstr($params, '&rows=', true);
			  }
			  
			  if($result){$result['urlParams'] = $params;}	
			  $this->set(compact('result'));
			}		
		}
	}
	
	//Busqueda Avanzada
	function advancedSearch() { 
		if($this->request->is('post')){	
			$form = $this->data['query'];
			if(trim($form['qText']) != ''){
				$q = $form['field'].':('.$form['qText'].')';
				for($i = 1 ; $i<3 ; $i++){
					if(trim($form['qText'.$i]) != ''){
						$q = $q.' '.$form['op'.$i].' '.$form['field'.$i].':('.$form['qText'.$i].')';
					}
				}
				
				$lang = '';
				$country = '';
				$haveURL = '';
				$formatText = '';
				$date = '';
				$typePub = '';
				
				if($form['lang'] != ''){
					$lang = '&fq=v40%3A'.$form['lang'];
				}
				if($form['country'] != ''){
					$country = '&fq=v67%3A'.$form['country'];
				}
				if(isset($form['url'])){
					$haveURL = '&fq=v8%3A*';
					if($form['formatText'] != ''){
						$formatText = '&fq=v8%3A'.$form['formatText'];
					}
				}
				if($form['from'] != '---' || $form['until'] != '---'){
					if($form['from'] != '---' && $form['until'] != '---'){
						$date = '&fq=v65%3A['.$form['from'].'%20TO%20'.$form['until'].']';
					}
					if($form['from'] == '---' && $form['until'] != '---'){
						$date = '&fq=v65%3A[*%20TO%20'.$form['until'].']';
					}
					if($form['from'] != '---' && $form['until'] == '---'){
						$date = '&fq=v65%3A['.$form['from'].'%20TO%20*]';
					}
				}
				if($form['typePub'] != 'all'){
					$typePub = '&fq=v5%3A'.$form['typePub'];
				}

				$this->redirect(array('action'=>'search', 'select?q='.urlencode($q).$lang.$country.$haveURL.$formatText.$date.$typePub.'&rows=10'));
			}else{
				if(trim($form['qText1']) != '' || trim($form['qText2']) != ''){
					$this->set("result",'Error de sintaxis.');	
				}else{
					$this->set("result",'Debe introducir un texto para la búsqueda.');
				}
			}									
		}
	}
	
	//Visualiza un documento dada la id.
	function view($id = null){
		$document = $this->Solr->search('select?q=id:'.$id);
		$this->set("doc",$document['response']['docs'][0]);
	}
	
	//Agrega o elimina si existe un elemento en la carpeta.
	function updateFolder(){
		$this->autoRender = FALSE;
		if($this->RequestHandler->isAjax()){
				
			if($this->Session->check('folder.'.$this->request->data["docID"])){			
					$this->Session->delete('folder.'.$this->request->data["docID"]);
					$docs = $this->Session->read('folder');
					if(empty($docs)){
						return 'delAll';
					}else{
						return 'del';
					}
			}else{
				$this->Session->write('folder.'.$this->request->data["docID"], $this->request->data["docID"]);
				return 'add';
			}
		}
		
		return false;
	}
	
	//Obtener terminos sugeridos
	function suggestions($param = null){
		$this->autoRender = FALSE;
		if($this->RequestHandler->isAjax()){
			$param = urlencode($param);
			if($param == null || $param == '' || $param == ' '){
				$result = false;
			}else{
				$query = 'suggest?q='.$param;
				$result = $this->Solr->getSuggest($query);
			}
			
			if($result){
				if((count($result['spellcheck']['suggestions'])) > 0){	
					return json_encode($result['spellcheck']['suggestions'],true);	
				}else{
				  return 0;	
				}
			}else{
				return 0;
			}
		}
	}
	
	
	//Visualizar Carpeta
	function viewFolder(){
		$result = '';
		$params = 'select?q=id:(';
		if($this->Session->check('folder')){
			$docs = $this->Session->read('folder');
			if(sizeof($docs)!=0){
				foreach($docs as $doc){
					$params = $params.'+'.$doc;
				}
				$params = $params.')';
				$result = $this->Solr->search($params);
			}
		}
			
		$this->set("result",$result);
	}
	
	//Elimina todos los elementos de la carpeta
	function delFolder(){
		$this->autoRender = FALSE;
		if($this->RequestHandler->isAjax()){
			if($this->Session->check('folder')){
				$this->Session->delete('folder');
			}
			return 'delAll';
		}
	}
	
}

?>