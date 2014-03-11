<?php
/**
 * Codifiers Datasource
 *
 * PHP version 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       datasources
 * @subpackage    datasources.models.datasources
 * @since         CakePHP Datasources v 0.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');
App::uses('Set', 'Utility');

/**
 * Codifiers Datasource
 *
 * @package datasources
 * @subpackage datasources.models.datasources
 */
class CodifiersSource extends DataSource {

	/**
	 * Constructor.
	 *
	 * @param array $config Connection setup for CouchDB.
	 * @param integer $autoConnect Autoconnect.
	 * @return boolean
	 */
	public function __construct($config = null, $autoConnect = true) {
		parent::__construct($config);
	}
	
	/**
	 * List of databases.
	 *
	 * @return array Databases.
	 */
	public function listSources($data = null) {
		return null;
	}
	
	/**
	 * Returns a description of the model (metadata).
	 *
	 * @param Model $model
	 * @return array Schema.
	 */
	public function describe($model) {
		return $model->schema;
	}
	
	/**
	 * Reads data from a document.
	 *
	 * @param Model $model
	 * @param array $queryData An array of information containing $queryData keys, similar to Model::find().
	 * @param integer $recursive Level number of associations.
	 * @return mixed False if an error occurred, otherwise an array of results.
	 */


	//$model, $queryData = array(), $recursive = null
	public function read(Model $model, $queryData = array(), $recursive = null) {

		//read
		if ($queryData['conditions']['Codifier.id']) {
			$xml = Xml::build('../Plugin/Codifiers/Bases/'. $queryData['conditions']['Codifier.id'] . '.xml');
			$result = array(0 => array($model->alias => array($queryData['conditions']['Codifier.id'] => array())));
	
			$xmlArray = Xml::toArray($xml);
			foreach ($xmlArray['add']['doc'] as $value) {
				array_push($result[0][$model->alias][$queryData['conditions']['Codifier.id']], $value['field']);
			}
		}
		else //all
		{
			//$result = array(0 => array($model->alias => array()));
			$temp = array();

			$arrayPais = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/pais.xml'));
			$arrayPais['name'] = "pais";
			$arrayPaisll = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/paisesll.xml'));
			$arrayPaisll['name'] = "paisesll";
			$arrayLenguaje = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/lenguaje.xml'));
			$arrayLenguaje['name'] = "lenguaje";
			$arrayTipoArchivoComputador = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/tipo_archivo_computador.xml'));
			$arrayTipoArchivoComputador['name'] = "tipo_archivo_computador";
			$arrayTipoMaterialCartografico =Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/tipo_material_cartografico.xml'));
			$arrayTipoMaterialCartografico['name'] = "tipo_material_cartografico";
			$arrayTipoMaterialVisual = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/tipo_material_visual.xml'));
			$arrayTipoMaterialVisual['name'] = "tipo_material_visual";
			$arrayTipoRegistro = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/tipo_registro.xml'));
			$arrayTipoRegistro['name'] = "tipo_registro";
			$arrayFormaItem = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/forma_item.xml'));
			$arrayFormaItem['name'] = "forma_item";
			$arrayDesignacionEspecificaMaterial = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/designacion_especifica_material.xml'));
			$arrayDesignacionEspecificaMaterial['name'] = "designacion_especifica_material";
			$arrayTipoArchivo = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/tipo_archivo.xml'));
			$arrayTipoArchivo['name'] = "tipo_archivo";
			$arrayExtensionArchivo = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/extension_archivo.xml'));
			$arrayExtensionArchivo['name'] = "extension_archivo";
			$arrayInfDescr = Xml::toArray(Xml::build('../Plugin/Codifiers/Bases/infdescr.xml'));
			$arrayInfDescr['name'] = "infdescr";

			array_push($temp, $arrayFormaItem, $arrayTipoMaterialCartografico, $arrayTipoMaterialVisual, $arrayDesignacionEspecificaMaterial, $arrayTipoArchivoComputador, $arrayPais, $arrayPaisll, $arrayLenguaje, $arrayTipoRegistro, $arrayTipoArchivo, $arrayExtensionArchivo, $arrayInfDescr);
			
			$i = 0;
			foreach ($temp as $v1) {				
				$result[$i][$model->alias][$v1['name']]= array();				
				foreach ($v1['add']['doc'] as $v2) {
					array_push($result[$i][$model->alias][$v1['name']], $v2['field']);
				}				
				$i++;
			}
		}
		
		return $result;
	}

	/**
	 * Returns an instruction to count data. (SQL, i.e. COUNT() or MAX()).
	 *
	 * @param model $model
	 * @param string $func Lowercase name of SQL function, i.e. 'count' or 'max'.
	 * @param array $params Function parameters (any values must be quoted manually).
	 * @return string An SQL calculation function.
	 */
	public function calculate($model, $func, $params = array()) {
		return true;
	}

	/**
	 * Perform any function in Codifiers.
	 * The method can be performed by a Model of the following ways:
	 *
	 * 		$this->Model->generate();
	 */

	public function query($method, $params = array(), Model &$model = null) {

		//Metodo generate
		if(isset($params[0]) && $params[0] == 'generate'){
			
			$pathToBases = str_replace('\\','\\\\',ROOT."\app\Plugin\Codifiers\Bases"). "\\\\";
			
			if ($pathToBases != ""){
				exec('cd '. $pathToBases .' && mx lang "prolog=@prolog.pft" "pft=@lang.pft" "epilog=@epilog.pft" lw=999 -all now >lenguaje.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx paismarc "prolog=@prolog.pft" "pft=@paismarc.pft" "epilog=@epilog.pft" lw=999 -all now >pais.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx paisesll "prolog=@prolog.pft" "pft=@paisesll.pft" "epilog=@epilog.pft" lw=999 -all now >paisesll.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx codes9 "prolog=@prolog.pft" "pft=@codes9.pft" "epilog=@epilog.pft" lw=999 -all now >tipo_registro.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx codes14 "prolog=@prolog.pft" "pft=@codes14.pft" "epilog=@epilog.pft" lw=999 -all now >tipo_material_visual.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx codes12 "prolog=@prolog.pft" "pft=@codes12.pft" "epilog=@epilog.pft" lw=999 -all now >tipo_material_cartografico.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx codes15 "prolog=@prolog.pft" "pft=@codes15.pft" "epilog=@epilog.pft" lw=999 -all now >designacion_especifica_material.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx codes10 "prolog=@prolog.pft" "pft=@codes10.pft" "epilog=@epilog.pft" lw=999 -all now >forma_item.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx codes11 "prolog=@prolog.pft" "pft=@codes11.pft" "epilog=@epilog.pft" lw=999 -all now >tipo_archivo_computador.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx codes13 "prolog=@prolog.pft" "pft=@codes13.pft" "epilog=@epilog.pft" lw=999 -all now >tipo_serial.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx relators "prolog=@prolog.pft" "pft=@relators.pft" "epilog=@epilog.pft" lw=999 -all now >relators.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx tipoarq "prolog=@prolog.pft" "pft=@tipoarq.pft" "epilog=@epilog.pft" lw=999 -all now >tipo_archivo.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx extensarq "prolog=@prolog.pft" "pft=@extensarq.pft" "epilog=@epilog.pft" lw=999 -all now >extension_archivo.xml', $valor1, $valor2);
				exec('cd '. $pathToBases .' && mx infdescr "prolog=@prolog.pft" "pft=@infdescr.pft" "epilog=@epilog.pft" lw=999 -all now >infdescr.xml', $valor1, $valor2);
					
			} else {
				return false;
			}

			return true;
		}				
	}











}
?>