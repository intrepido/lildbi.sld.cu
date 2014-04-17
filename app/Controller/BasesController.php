<?php
App::uses('Xml', 'Utility');
App::uses('Utils', 'Lib');
set_time_limit(00);


class BasesController extends AppController {
	public $components = array('RequestHandler');
	public $layout = 'admin_layout';
	public $name = 'Bases';
	var $uses = array('Document');

	public function isAuthorized($user) {
		/**
		 * Solo los administradores pueden entrar al controlador de bases
		 */
		if ($this->Session->read('userRol') == 'Administrador') {
			return true;
		}

		return false;
	}


	function index() {

		$bases = $this->Document->curlGet('_all_dbs');
		$temp = array();
		$capacity = '';


		foreach ($bases as $value) {
				
			if( strpos( $value, "_base" ) !== false ){

				$documents = $this->Document->curlGet($value.'/_all_docs');
				if($documents['total_rows'] > 0){
					$capacity = "success"; //LLeno
				}
				else{
					$capacity = ""; //Vacio
				}

				array_push($temp, array('name' => strstr($value, '_', true), 'capacity' => $capacity));
			}
				
		}

		$this->set("bases", $temp);

	}

	function add() {

		if($this->RequestHandler->isAjax()){
			
			//Se crea la BD a importar
			$this->Document->curlPut($this->request->data["value"]."_base");
			
			//Se cargan y se insertan en la BD las vistas.
			$jsonFunctions = file_get_contents(ROOT."/app/Plugin/CouchDB/Actions/functions.json");
			$jsonSolr = file_get_contents(ROOT."/app/Plugin/CouchDB/Actions/solr.json");				
			$this->Document->curlPut($this->request->data["value"]."_base"."/_design/functions", json_decode($jsonFunctions), false, true);
			$this->Document->curlPut($this->request->data["value"]."_base"."/_design/solr", json_decode($jsonSolr), false, true);
			
			$this->autoRender = FALSE;
		}

	}

	function delete() {

		if($this->RequestHandler->isAjax()){
			$this->Document->curlDelete($this->request->data["value"]."_base");
			$this->autoRender = FALSE;
		}

	}

	function import(){ //Importar Bases

		if($this->RequestHandler->isAjax()){

			$totalArray = array();
			$temp = true;
				
				
			foreach ($this->request->data["value"] as $dataBase) {

				if($this->Session->check($dataBase)){
					//Verifico si la cantidad a insertar es mayor o igual al total de registros de la base, de
					//ser asi pongo la variable $temp=false para que no llame al servicio
					if($this->request->data["count"] >= $this->Session->read($dataBase)){
						$temp = false;
					}
				}

				if($temp){
					$xmlOAI = Utils::file_get_contents_curl('http://isis.oai.sld.cu/?verb=ListRecords&resumptionToken=-_--_-isis-_-'. $dataBase .'-_-'. $this->request->data["count"] );
					$xml = Xml::build($xmlOAI);

					//Almaceno el total de registros de la base en session
					if(!$this->Session->check($dataBase)){
						$tempArray = explode(":",(string)$xml->ListRecords[0]->record[0]->header[0]->setSpec);
						$this->Session->write($dataBase, $tempArray[1]);
					}
						
					if ($xml->ListRecords[0]->record[0]->metadata[0]->isis[0] != null) {
							
						$test_array = $xml->ListRecords[0];
							
						$dom = Xml::build($test_array->asXML(), array('return' => 'domdocument'));
						$xsl = Xml::build(ROOT.'/app/Lib/xslISIS.xsl', array('return' => 'domdocument'));
							
						$proc = new XSLTProcessor();
						$proc->importStyleSheet($xsl);
							
						$xmlFinal = Xml::build($proc->transformToXML($dom), array('return' => 'domdocument'));
							
						$json = json_encode(new SimpleXMLElement($xmlFinal->saveXML(), LIBXML_NOCDATA));
						$json = substr_replace($json, 'docs', 2, 3);
							
						$this->Document->curlPost($dataBase ."_base/_bulk_docs", json_decode($json), true, false);
							
					}
					else
					{
						//$this->Document->curlDelete($dataBase."_base");
						$this->autoRender = FALSE;
						return  false;
					}
				}

				$temp = true;

				//LLeno en $totalArray los totales de las bases
				array_push($totalArray, $this->Session->read($dataBase));

			}
				
			$this->autoRender = FALSE;
			return json_encode($totalArray);
		}

	}

	function exist(){
		if($this->RequestHandler->isAjax()){
				
			$xmlOAI = Utils::file_get_contents_curl('http://isis.oai.sld.cu/?verb=ListRecords&resumptionToken=-_--_-isis-_-'. $this->request->data["value"] .'-_-20' );
			$xml = Xml::build($xmlOAI);

			if ($xml->ListRecords[0]->record[0]->metadata[0]->isis[0] == null){
				$this->autoRender = FALSE;
				return false;
			}
			else{
				$this->autoRender = FALSE;
				return true;
			}
				
		}
	}

	function cleanSession(){
		if($this->RequestHandler->isAjax()){
			foreach ($this->request->data["value"] as $dataBase) {
				$this->Session->delete($dataBase);
			}
				
		 $this->autoRender = FALSE;
		}
	}

	//NOTA: Ya arregle el cambiar perfil ahora si se puede debugear el metodo
	function getTotalDocsBases() {
	
		if($this->RequestHandler->isAjax()){
			
			$bases = $this->Document->curlGet('_all_dbs');
			$temp = array();
			$capacity = '';

			foreach ($bases as $value) {
					
				if( strpos( $value, "_base" ) !== false ){

					$documents = $this->Document->curlGet($value.'/_all_docs');
					array_push($temp, array('name' => strstr($value, '_', true), 'total' => $documents['total_rows']));
				}
					
			}
			$this->autoRender = FALSE;
			return json_encode($temp);
		}

	}

}
?>