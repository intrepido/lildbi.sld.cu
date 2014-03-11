<?php
App::uses('CakeTime', 'Utility');
App::uses('Utils', 'Lib');

class AnaliticsController extends AppController {
	public $layout = 'documentalista_layout';
	public $components = array('RequestHandler', 'DocumentDatas');
	public $name = 'Analitics';
	var $uses = array('Document');


	public function isAuthorized($user) {
		/**
		 * Solo los documentalistas pueden entrar al controlador de analitics
		 */
		if ($this->Session->read('userRol') == 'Documentalista') {
			return true;
		}

		return false;
	}


	function index() {

		//All Documents
		//$db = $this->Document->curlGet($this->Auth->user('username').'/_all_docs');
		//http://127.0.0.1:5984/fsantana/_design/functions/_view/getAllDocuments?startkey=[%2241d35488f5ec8f2368c98af75d007bf3%22,%223%22]&limit=1

		if($this->RequestHandler->isAjax()){
			$db = $this->Document->curlGet($this->Auth->user('username').'/_design/functions/_view/getAllAnalitics');
			$this->autoRender = FALSE;
			if(!isset($db['error']) && $db['total_rows']!=0){
				return json_encode($db);
			}
			else{
				return false;
			}
		}
	}


	function view($id = null) { //FUNCIONA el leer un documento
		$document = $this->Document->curlGet($this->Auth->user('username').'/'.$id);
		//$this->set('type', $this->requestAction('/documents/getTypeDocument/'.$document));
	}


	function add($id = null) {

		if ($this->request->is('post')) {
			if(isset($this->request->data['Document']['Back'])) //Boton "Atras" de la pagina "visualization"
			{
				$this->set('urlTypeNameDocument', $this->params['typeName']);
				$this->set('typeNameDocument', $this->DocumentDatas->convertUrlNameToTypeName($this->params['typeName']));
				$this->set('backValues', unserialize($this->request->data['Document']['Back']));

			}elseif(isset($this->request->data['Document']['Confirm'])){ //Boton "Confirmar" de la pagina "visualization"

				$dataArray = unserialize($this->request->data['Document']['Confirm']);
				$dataFormatArray = $this->DocumentDatas->prepareDataForDB($dataArray, $this->params['typeName']);

				/** Insertando el Analitica en CouchDB **/
				$this->Document->curlPost($this->Auth->user('username'), $dataFormatArray, false);
				$this->Session->delete('initialTimeCreation');
				$this->DocumentDatas->deleteSessions();
				
				//redireccionando luego de insertar
				$this->redirect(array('controller' => 'documents','action' => 'index'));
			}
		}
		else{
			$document = $this->Document->curlGet($this->Auth->user('username').'/'.$id);
			$document = $this->DocumentDatas->prepareDataForForm($document);
			$this->Session->write('document', $this->DocumentDatas->getNameFieldsDocument($document));
			$this->Session->write('idDocument', $document['_id']);
			$this->set('urlTypeNameDocument', $this->params['typeName']);
		}

	}



	function edit($id = null) {  //FUNCIONA el editar

		if ($this->request->is('post')) {

			if(isset($this->request->data['Document']['Back'])) //Boton "Atras" de la pagina "visualization"
			{
				$this->set('typeEditDocument', $this->request->params['typeName']);
				$this->set('backValues', unserialize($this->request->data['Document']['Back']));

			}elseif(isset($this->request->data['Document']['Confirm'])){ //Boton "Confirmar" de la pagina "visualization"

				$dataArray = unserialize($this->request->data['Document']['Confirm']);
				$dataFormatArray = $this->DocumentDatas->prepareDataForDB($dataArray, $this->params['typeName']);

				//Poniendo la rev
				$dataFormatArray = array_merge(array('_rev' => $this->Session->read('revEditDocument')), $dataFormatArray);

				/** Modificando el Documento en CouchDB **/
				$this->Document->curlPut($this->Auth->user('username').'/'.$this->Session->read('idEditDocument'), $dataFormatArray, false);
				//$this->Document->curlPut($this->Auth->user('username').'/72fc1e696025b11d23240372bf0092d9', array('_rev' => '5-c7a4d9ba3af06d0378d9ec5f726273df', 'v2' => 'caballo', 'v4' => 'Pendenciero'));
					
				//redireccionando luego de insertar
				$this->redirect(array('controller' => 'documents','action' => 'index'));
			}
		}
		else{
			$document = $this->Document->curlGet($this->Auth->user('username').'/'.$id);
			$this->Session->write('idEditDocument', $document['_id']);
			$this->Session->write('revEditDocument', $document['_rev']);
			$this->Session->write('dateCreationEditDocument', $document['v91']);
			$this->Session->write('dateTransferDBEditDocument', $document['v84']);

			$document = $this->DocumentDatas->prepareDataForForm($document);
			$this->set('typeEditDocument', $this->request->params['typeName']);
			$this->set('backValues', $this->DocumentDatas->getNameFieldsDocument($document));
		}
	}


	function delete($id) {  //FUNCIONA el eliminar un documento
		if ($this->RequestHandler->isAjax()) {
			$id_rev = explode("_", $this->request->data["value"]);
			$this->Document->curlDelete($this->Auth->user('username').'/'.$id_rev[0].'/?rev='.$id_rev[1]);
			$this->autoRender = FALSE;
		}
		//Elimina la BD
		//$this->Document->curlDelete($this->Auth->user('username'));
	}


	function visualization(){ //Boton "Vista Previa" de la pagina "series_monograficas"

		$urlTypeNameDocument = $this->request->params['typeName'];
		$typeNameDocument= $this->DocumentDatas->convertUrlNameToTypeName($urlTypeNameDocument);

		$user = $this->Auth->user();
		$arrayData = array();
		$arrayData = array_merge(array('v92' => array(__('Documentalista') => $user['initials'])), $this->params['data']['Document']);
		$arrayData = array_merge(array('v93' => array(utf8_encode(__('Fecha de ultima modificación')) => CakeTime::format('Ymd', time()))), $arrayData);
			
		if($this->Session->check('dateCreationEditDocument')){//si se esta modificando
			$arrayData = array_merge(array('v91' => array(utf8_encode(__('Fecha de Creación del Registro')) => $this->Session->read('dateCreationEditDocument'))), $arrayData);
		}else{//si se esta insertando
			$arrayData = array_merge(array('v91' => array(utf8_encode(__('Fecha de Creación del Registro')) => CakeTime::format('Ymd', time()))), $arrayData);
		}
			
		$arrayData = array_merge(array('v899' => array(utf8_encode(__('Versión del Software')) => 'LILDBI-WEB 1.8')), $arrayData);
		$arrayData = array_merge(array('v1' => array(utf8_encode(__('Código del Centro')) => 'CU1.1')), $arrayData);
			
		$this->DocumentDatas->orderFieldsDocument(&$arrayData);

		$this->set('data', $arrayData);
		$this->set('urlTypeNameDocument', $urlTypeNameDocument);
		$this->set('typeNameDocument', $typeNameDocument);

	}
	
	function listDocumentAnalitics($id = null) {
		$document = $this->Document->curlGet($this->Auth->user('username').'/'.$id);
		$totalAnalitics = $this->Document->curlGet($this->Auth->user('username').'/_design/functions/_view/getDocumentAnalitics?key="' . $document['rows']['value']['v1'].'-'.$document['rows']['value']['v2'] . '"');
	}



}
?>