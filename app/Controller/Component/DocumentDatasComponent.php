<?php
App::uses('Component', 'Controller');
App::uses('CakeTime', 'Utility');

class DocumentDatasComponent extends Component {
	public $components = array('Session');
		
	function getRepetitiveFields() {
		return array("v3", "v8", "v16", "v17", "v18", "v38", "v85", "v83");
	}
	
	function setTypeDocument(&$document, $urlTypeNameDocument) {	
		
		$arrayV5V6 = array();
	
		if($urlTypeNameDocument == 'series_monograficas'){
			if(!$this->Session->check('document')){
				$arrayV5V6['v5'] = 'MS';
				$arrayV5V6['v6'] = 'ms';
			}
			else{ //Si es una analitica
				$arrayV5V6['v5'] = 'MS';
				$arrayV5V6['v6'] = 'ams';
			}						
		}
	
		$document = array_merge(array('v5' => $arrayV5V6['v5']), $document);
		$document = array_merge(array('v6' => $arrayV5V6['v6']), $document);
	}
	
	function getTypeDocument($document = null) {	
		
		$v5Value = Set::extract('v5', $document);
		$type='';
	
		if($v5Value == 'MS'){
			$type = __('Serie Monográfica');
		}
	
		return $type;
	}
	
	function convertTypeNameToUrlName($typeName) {
	
		if ($typeName == __('Serie Monográfica')) {
			$urlName = 'series_monograficas';
		}
	
		return $urlName;
	}
	
	function convertUrlNameToTypeName($urlName) {
	
		if ($urlName == 'series_monograficas') {
			$typeName = __('Serie Monográfica');
		}
	
		return $typeName;
	}
	
	function prepareDataForDB($dataArray, $urlTypeNameDocument){
	
		$dataFormatArray = array();
		$fieldsRepetitive = $this->getRepetitiveFields();
	
		foreach ($dataArray as $key => $value) {
			$arrayKey = array_keys($value);
			if($value[$arrayKey[0]] != "" && $value[$arrayKey[0]] != "null"){
				if(in_array($key, $fieldsRepetitive)) //Si es un field repetitivo lo convierto de String a Array
				{
					$repeatValue = str_replace("\n", "#PH#", $value[$arrayKey[0]]);
					if(strpos($repeatValue, '#PH#') !== false){
						$dataFormatArray[$key] = explode('#PH#', $repeatValue);
					}
					else{
						$dataFormatArray[$key] = $value[$arrayKey[0]];
					}
				}else{ //Campos que se modifican en el momento que se inserta.
					if($key == 'v91' && !$this->Session->check('dateCreationEdit')){ //Fecha de Creación del Registro si se esta insertando
						$interval1 = $this->Session->read('initialTimeCreation');
						$interval2 = CakeTime::format("H:i:s", time());
						$value[$arrayKey[0]] = CakeTime::format("Ymd", time())."^i".$this->Session->read('initialTimeCreation')."^f".CakeTime::format("H:i:s", time())."^t". Utils::subtractHours($interval1, $interval2);
					}
	
					$dataFormatArray[$key] = $value[$arrayKey[0]];
				}
			}
		}
	
		/** Insertando los Campos Ocultos **/
		
		if($this->Session->check('document')){
			//Este campo es el que verifica si es un registro fuente o analitica, si no es fuente entonces muestra la relacion de la analitica con su respectivo registro fuente
			$document = $this->Session->read('document');
			$v1 = Set::extract($document['v1'], '{s}');
			$v2 = Set::extract($document['v2'], '{s}');
			$dataFormatArray = array_merge(array('v98' => $v1[0].'-'.$v2[0]), $dataFormatArray);
		}
		else{
			//Este campo es el que verifica si es un registro fuente o analitica, si no es fuente entonces muestra la relacion de la analitica con su respectivo registro fuente
			$dataFormatArray = array_merge(array('v98' => 'FONTE'), $dataFormatArray);
		}
		
		//Se ponen los campos que identifican el tipo de documento
		$this->setTypeDocument($dataFormatArray, $urlTypeNameDocument);		
	
		//Este campo es la fecha en que se transfirio el documento en la BD (CouchDB)
		if($this->Session->check('dateTransferDBEdit')){ //Si se esta editando
			$dataFormatArray = array_merge(array('v84' => $this->Session->read('dateTransferDBEdit')), $dataFormatArray);
		}
		else{//Si se esta insertando
			$dataFormatArray = array_merge(array('v84' => CakeTime::format("Ymd", time())), $dataFormatArray);
		}
	
		//Ordenando campos
		$this->orderFieldsDocument($dataFormatArray);
	
		return $dataFormatArray;
	}
	
	function prepareDataForForm($dataArray){
		
		$temp = '';		
		$fieldsRepetitive = $this->getRepetitiveFields($dataArray);
		
		//Convirtiendo los campos repetitivos de arreglos a string.
		foreach ($fieldsRepetitive as $key => $value) {
			if(Set::check($dataArray, $value)){
				if(is_array($dataArray[$value])){
					$ait = new ArrayIterator($dataArray[$value]);
					$cit = new CachingIterator($ait);
					foreach ($cit as $v) {
						if ($cit->hasNext()){
							$temp = $temp.$v."\n";
						}
						else{
							$temp = $temp.$v;
						}
					}
					$dataArray[$value] = $temp;
					$temp = '';
				}
			}
		}
		
		return $dataArray; 
	}
	
	function orderFieldsDocument(&$data){
		uksort($data, function($a, $b) {
			$aTemp = substr($a, 1);
			$bTemp = substr($b, 1);
			if ($aTemp==$bTemp) return 0;
			return ($aTemp<$bTemp)?-1:1;
		});
	}
	
	function getNameFieldsDocument() {
		$arrayData = array(
							'v1' => __('Código del Centro'),
							'v2' => __('Número de Identificación'),
							'v3' => __('Localización del Documento'),
							'v4' => __('Base de Datos'),
							'v5' => __('Tipo de Literatura'),
							'v6' => __('Nivel de Tratamiento'),
							'v7' => __('Número del Registro'),
							'v8' => __('Dirección Electrónica'),
							'v9' => __('Tipo de Registro'),
							'v10' => __('Autor Personal'),
							'v11' => __('Autor Institucional'),
							'v12' => __('Título'),
							'v13' => __('Título Traducido al Ingés'),
							'v14' => __('Páginas'),
							'v16' => __('Autor Personal'),
							'v17' => __('Autor Institucional'),
							'v18' => __('Título'),
							'v19' => __('Título Traducido al Inglés'),
							'v20' => __('Páginas'),
							'v21' => __('Volumen'),
							'v23' => __('Autor Personal'),
							'v24' => __('Autor Institucional'),
							'v25' => __('Título'),
							'v26' => __('Título Traducido para el Inglés'),
							'v27' => __('Número total de Volúmenes'),
							'v30' => __('Título'),
							'v31' => __('Volumen'),
							'v32' => __('Número del Fascículo'),
							'v35' => __('ISSN'),
							'v38' => __('Información Descriptiva'),
							'v40' => __('Idioma del Texto'),
							'v49' => __('Tesis, Disertación - Orientador'),
							'v50' => __('Tesis, Disertación - Institución a la cual se Presenta'),
							'v51' => __('Tesis, Disertación - Título Académico'),
							'v52' => __('Evento - Institución Patrocinadora'),
							'v53' => __('Evento - Nombre'),
							'v54' => __('Evento - Fecha'),
							'v55' => __('Evento - Fecha Normalizada'),
							'v56' => __('Evento - Ciudad'),
							'v57' => __('Evento - País'),
							'v58' => __('Proyecto - Institución Patrocinadora'),
							'v59' => __('Proyecto - Nombre'),
							'v60' => __('Proyecto - Número'),
							'v61' => __('Nota Interna'),
							'v62' => __('Editora'),
							'v63' => __('Edición'),
							'v64' => __('Fecha de Publicación'),
							'v65' => __('Fecha Normalizada'),
							'v66' => __('Ciudad de Publicación'),
							'v67' => __('País de Publicación'),
							'v68' => __('Símbolo'),
							'v69' => __('ISBN'),
							'v71' => __('Tipo de Publicación'),
							'v72' => __('Número total de referencias'),
							'v74' => __('Alcance Temporal'),
							'v75' => __('Alcance Temporal'),
							'v76' => __('Descriptor Precodificado'),
							'v78' => __('Individuo como Tema'),
							'v82' => __('Región no DECS'),
							'v83' => __('Resumen'),
							'v84' => __('Fecha de Transferencia para la Base de Datos'),
							'v85' => __('Palabras Llaves del Autor'),
							'v87' => __('Descriptor Primario'),
							'v88' => __('Descriptor Secundario'),
							'v91' => __('Fecha de Creación del Registro'),
							'v92' => __('Documentalista'),
							'v93' => __('Fecha de Ultima Modificación'),
							'v98' => __('Registro Complementario'),
							'v101' => __('Registro Complementario'),
							'v102' => __('Registro Complementario'),
							'v110' => __('Forma del Item'),
							'v111' => __('Tipo de Archivo de Computador'),
							'v112' => __('Tipo de Material Cartográfico'),
							'v113' => __('Tipo de Periódico'),
							'v114' => __('Tipo de Material Visual'),
							'v115' => __('Designación Específica del Material (Material No Proyectable)'),
							'v500' => __('Nota General'),
							'v505' => __('Nota Formateada de Contenido'),
							'v530' => __('Nota de Disponibilidad de Forma Física Adicional'),
							'v533' => __('Nota de Reproducción'),
							'v534' => __('Nota de Versión Original'),
							'v610' => __('Institución como Tema'),
							'v653' => __('Descriptores Locales'),
							'v700' => __('Nombre del Registro de Ensayo Clínico'),
							'v724' => __('Número DOI'),
							'v899' => __('Versión del Software')
		);
			
		return $arrayData;
	}
	
	function setNameFieldsDocument($document) { //Pone el nombre literal a los campos que se obtienen de couchDB
		
		$arrayData = $this->getNameFieldsDocument();
		$arrayDataTemp = array();
		foreach ($document as $key => $value) {
			if(Set::check($arrayData, $key)){
				$arrayDataTemp = Set::insert($arrayDataTemp, $key, array(Set::extract($key, $arrayData) => $value));
			}
		}
			
		return $arrayDataTemp;
	}
	
	function deleteSessions() {
		$this->Session->delete('idEdit');
		$this->Session->delete('revEdit');
		$this->Session->delete('dateCreationEdit');
		$this->Session->delete('dateTransferDBEdit');			
		$this->Session->delete('document');
		$this->Session->delete('idDocument');
		$this->Session->delete('idDocumentForUrl');	
		$this->Session->delete('initialTimeCreation');
	}
	
	
}