<?php
App::uses('CakeTime', 'Utility');
App::uses('Utils', 'Lib');

//Controladora de la BD de CouchDB
class DocumentsController extends AppController {
	public $layout = 'documentalista_layout';
	public $components = array('RequestHandler', 'DocumentDatas');
	public $name = 'Documents'; //Hace referencia al nombre de la BD de CouchDB


	public function isAuthorized($user) {
		/**
		 * Solo los documentalistas pueden entrar al controlador de documents
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
		$this->DocumentDatas->deleteSessions();
		
		if($this->RequestHandler->isAjax()){
			$db = $this->Document->curlGet($this->Auth->user('username').'/_design/functions/_view/getAllDocuments ');
			$this->autoRender = FALSE;
			if(!isset($db['error']) && $db['total_rows']!=0){
				foreach ($db['rows'] as $key => $value) { //Poniendo el tipo a cada documento					
					$totalAnalitics = $this->Document->curlGet($this->Auth->user('username').'/_design/functions/_view/getDocumentAnalitics?key="' . $value['value']['v1'].'-'.$value['value']['v2'] . '"');
					$urlTypeNameDocument = $this->DocumentDatas->getTypeDocument($value['value']);
					$typeUrl = $this->DocumentDatas->convertTypeNameToUrlName($urlTypeNameDocument);
					$value= array_merge(array('type' => $typeUrl), $value);
					$db['rows'][$key] = array_merge(array('totalAnalitics' => sizeof($totalAnalitics['rows'])), $value);
					$db['rows'][$key]['value'] = $this->DocumentDatas->setNameFieldsDocument($db['rows'][$key]['value']);
					$this->DocumentDatas->orderFieldsDocument(&$db['rows'][$key]['value']);
				}
								
				$db = array_merge(array('nameFields' => $this->DocumentDatas->getNameFieldsDocument()), $db);
				if(isset($this->data['id'])){ //Si viene del Ver fuente de la lista de analiticas
				  $db = array_merge(array('filter' => $this->data['id']), $db); //Pone el v2 a filtrar en la lista de documents
				}	
							
				return json_encode($db);
			}
			else{
				return false;
			}
		}
	}


	function view($id = null) { //FUNCIONA el leer un documento
		$document = $this->Document->curlGet($this->Auth->user('username').'/'.$id);
		$this->set('type', $this->DocumentDatas->getTypeDocument($document));
		$this->set('document', $this->DocumentDatas->setNameFieldsDocument($document));
		$result = explode('analitics/index/', $this->referer());
		if(isset($result[1])){
			$this->Session->write('idDocumentForUrl', $result[1]);				
		}
	}


	function add() { //FUNCIONA el adicionar un documento (Hay que especificar un squema en el modelo)

		//$this->DocumentDatas->deleteSessions();

		if ($this->request->is('post')) {

			if(isset($this->request->data['Document']['Back'])) //Boton "Atras" de la pagina "visualization"
			{
				$this->set('urlTypeNameDocument', $this->params['typeName']);
				$this->set('typeNameDocument', $this->DocumentDatas->convertUrlNameToTypeName($this->params['typeName']));
				$this->set('backValues', unserialize($this->request->data['Document']['Back']));

			}elseif(isset($this->request->data['Document']['Confirm'])){ //Boton "Confirmar" de la pagina "visualization"

				if(!in_array($this->Auth->user('username'), $this->Document->curlGet('_all_dbs')))  //Si no existe la BD se crea
				{
					$this->Document->curlPut($this->Auth->user('username')); //Crea la BD del usuario
					//Se cargan y se insertan en la BD las vistas.
					$json = file_get_contents(ROOT."/app/Plugin/CouchDB/Actions/functions.json");
					$this->Document->curlPut($this->Auth->user('username')."/_design/functions", json_decode($json), false, true);
				}

				$dataArray = unserialize($this->request->data['Document']['Confirm']);
				$dataFormatArray = $this->DocumentDatas->prepareDataForDB($dataArray, $this->params['typeName']);

				/** Insertando el Documento en CouchDB **/
				$this->Document->curlPost($this->Auth->user('username'), $dataFormatArray, false);
				$this->Session->delete('initialTimeCreation');				
			}
		}
		elseif (isset($this->params['pass'][0])){
			if ($this->params['pass'][0] == 'sin_indizacion') {
				$this->Session->write('index', utf8_encode(__('Sin Indezación')));
			}
			else
			{
				$this->Session->write('index', utf8_encode(__('Con Indezación')));
			}			
		}
		elseif (isset($this->params['typeName']))
		{
			$this->set('urlTypeNameDocument', $this->params['typeName']);
			$this->set('typeNameDocument', $this->DocumentDatas->convertUrlNameToTypeName($this->params['typeName']));			
			$this->Session->write('initialTimeCreation', CakeTime::format('H:i:s', time()));
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
				$dataFormatArray = array_merge(array('_rev' => $this->Session->read('revEdit')), $dataFormatArray);

				/** Modificando el Documento en CouchDB **/
				$this->Document->curlPut($this->Auth->user('username').'/'.$this->Session->read('idEdit'), $dataFormatArray, false);
				//$this->Document->curlPut($this->Auth->user('username').'/72fc1e696025b11d23240372bf0092d9', array('_rev' => '5-c7a4d9ba3af06d0378d9ec5f726273df', 'v2' => 'caballo', 'v4' => 'Pendenciero'));
					
				//redireccionando luego de insertar
				$this->redirect(array('controller' => 'documents','action' => 'index'));				
			}
		}
		else{
			$document = $this->Document->curlGet($this->Auth->user('username').'/'.$id);
			$this->Session->write('idEdit', $document['_id']);
			$this->Session->write('revEdit', $document['_rev']);
			$this->Session->write('dateCreationEdit', $document['v91']);
			$this->Session->write('dateTransferDBEdit', $document['v84']);
			
			$document = $this->DocumentDatas->prepareDataForForm($document);			
			$this->set('typeEditDocument', $this->request->params['typeName']);
			$this->set('backValues', $this->DocumentDatas->setNameFieldsDocument($document));
		}
	}


	function delete($id) {  //FUNCIONA el eliminar un documento
		if ($this->RequestHandler->isAjax()) {

			$id_rev = explode("_", $this->request->data["value"]);
			
			//eliminar analiticas
			$document = $this->Document->curlGet($this->Auth->user('username').'/'.$id_rev[0]);
			$analitics = $this->Document->curlGet($this->Auth->user('username').'/_design/functions/_view/getDocumentAnalitics?key="' . $document['v1'].'-'.$document['v2'] . '"');			
			foreach ($analitics['rows'] as $value) {
				$this->Document->curlDelete($this->Auth->user('username').'/'.$value['value']['_id'].'/?rev='.$value['value']['_rev']);
			}	
			
			//eliminar documento			
			$this->Document->curlDelete($this->Auth->user('username').'/'.$id_rev[0].'/?rev='.$id_rev[1]);
			
			$this->autoRender = FALSE;
		}	
	}


	function visualization(){ //Boton "Vista Previa" de la pagina "series_monograficas"
		
			$urlTypeNameDocument = $this->request->params['typeName'];
			$typeNameDocument= $this->DocumentDatas->convertUrlNameToTypeName($urlTypeNameDocument);

			$user = $this->Auth->user();
			$arrayData = array();
			$arrayData = array_merge(array('v92' => array(__('Documentalista') => $user['initials'])), $this->params['data']['Document']);
			$arrayData = array_merge(array('v93' => array(utf8_encode(__('Fecha de ultima modificación')) => CakeTime::format('Ymd', time()))), $arrayData);
			
			if($this->Session->check('dateCreationEdit')){//si se esta modificando
				$arrayData = array_merge(array('v91' => array(utf8_encode(__('Fecha de Creación del Registro')) => $this->Session->read('dateCreationEdit'))), $arrayData);
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




	//Metodos del Editor

	function indexCertificates() { //FUNCIONA el buscar

		//$conditions = array('Document.id' =>'6b4a9cc97cc6521f7edf2a55b3005496'); //Analogia en Solr: Filter Query (fq)
		//$result = $this->Document->find('first', compact('conditions'));
		$result = $this->Document->find('all');
		$vedfsdfsr = 'fdfsd';
	}

	function viewCertificate($id = null) { //FUNCIONA el leer un documento
		$this->Document->id = '6b4a9cc97cc6521f7edf2a55b30024e4';
		$result =$this->Document->read();
		//$this->set('Document', $this->Document->read());
	}

	public function addCertificate(){
		$data = array(

				'title' => 'Esto esuna prueba',
				'description' => 'jajajaja'
		);

		$saveResult = $this->Document->save($data);

		// Id
		$this->Document->id;

		// Revision
		$this->Document->rev;
	}

	public function addAllCertificates() { //FUNCIONA el adicionar varios documentos

		$data[0]['Document'] = array(
				'title' => 'ccccccccccccccccuu',
				'description' => 'cucucucuu'
		);

		$data[1]['Document'] = array(
				'title' => 'hhhhhhhhhhhhhhhhhhhhhh',
				'description' => 'holaaaaaaaaaaaaaaaaaaa'
		);

		$saveResult = $this->Document->saveAll($data);

		$stopAqui = 'fdfsd';
	}

	function editCertificate($id = null) {  //FUNCIONA el editar

		/*** Tienen que ponerse todos los campos del documento, aunque solo se quiera actualizar un campo ***/
		$data = array(
				'id' => '64580c1a3ba5eb7b8271287e4c005db2', //Se tiene que pasar el id (debe existir)
				'title' => 'My sixt Document',
				'description' => 'dfgdsfdsfdsft'
		);

		$saveResult = $this->Document->save($data);

		$stopAqui = 'fdfsd';
	}

	function deleteCertificate($id) {  //FUNCIONA el eliminar un documento
		$this->Document->id = '64580c1a3ba5eb7b8271287e4c001039';
		$this->Document->rev = '1-27876c1306c1b43ac974182e8725bb32'; //opcional (es para cuando hay varias revisiones)
		$this->Document->delete();

		$stopAqui = 'fdfsd';

	}
}
?>