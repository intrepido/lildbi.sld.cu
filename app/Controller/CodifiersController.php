<?php
App::uses('AppController', 'Controller');

/**
 * Codifiers Controller
 *
 * @property Codifier $Codifier
 */
class CodifiersController extends AppController {

	public $name = 'Codifiers';
	public $components = array('RequestHandler');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('getById');	
		
	}

	public function getAll() {

		$result = Cache::read('all_codifiers', 'default');
		if (!$result[0]['Codifier']) {
			$result = $this->Codifier->find('all');
			for ($i = 0; $i < count($result); $i++) {
				$arrayKey = array_keys($result[$i]['Codifier']);
				array_unshift($result[$i]['Codifier'][$arrayKey[0]], "");
				$this->_organizeArrayCodifiers($result[$i]);				
			}
			Cache::write('all_codifiers', $result, 'default');
		}

		return $result;

	}

	public function getById($id = null) {

		if ($this->RequestHandler->isAjax()) {

			$codifiers = $this->getAll();
			$result = array();			
			
			if ($this->request->data['value'] != "Archivo de computador" ) {

				if (($this->request->data['value'] == utf8_encode("Material cartográfico")) || ($this->request->data['value'] == utf8_encode("Manuscritos de material cartográfico"))) {
					$codifier = Set::extract('*/Codifier/tipo_material_cartografico', $codifiers);					
					array_push($result, array('Codifier' => $codifier[0]));
					$codifier = Set::extract('*/Codifier/forma_item', $codifiers);
					array_push($result, array('Codifier' => $codifier[0]));						
				}
				else if(($this->request->data['value'] == "Material proyectable") || ($this->request->data['value'] == "Kit") || ($this->request->data['value'] == "Material tridimensional, artefacto, objeto")) {
					$codifier = Set::extract('*/Codifier/tipo_material_visual', $codifiers);
					array_push($result, array('Codifier' => $codifier[0]));
					$codifier = Set::extract('*/Codifier/forma_item', $codifiers);
					array_push($result, array('Codifier' => $codifier[0]));						
				}
				else if ($this->request->data['value'] == utf8_encode("Gráficos bidimensionales no proyectables")) {
					$codifier = Set::extract('*/Codifier/designacion_especifica_material', $codifiers);
					array_push($result, array('Codifier' => $codifier[0]));
					$codifier = Set::extract('*/Codifier/tipo_material_visual', $codifiers);
					array_push($result, array('Codifier' => $codifier[0]));
					$codifier = Set::extract('*/Codifier/forma_item', $codifiers);
					array_push($result, array('Codifier' => $codifier[0]));					
				}
				else{
					$codifier = Set::extract('*/Codifier/forma_item', $codifiers);
					array_push($result, array('Codifier' => $codifier[0]));	
				}
			}
			else {
				$codifier = Set::extract('*/Codifier/tipo_archivo_computador', $codifiers);
				array_push($result, array('Codifier' => $codifier[0]));	
			}

			$this->autoRender = FALSE;
			return json_encode($result);
		}
		else {
			$this->Codifier->id = $id;
			$result = $this->Codifier->read();
			array_unshift($result['Codifier'][$id], "");
			$this->_organizeArrayCodifiers($result);
		}

		return $result;
	}

	public function _organizeArrayCodifiers(&$result){

		if(array_key_exists('paisesll', $result['Codifier'])){
			$result['Codifier']['paisesll'][1][1]= '------';
		}
		
		foreach ($result['Codifier'] as $key => $value) {			
			$arrayTemp = Set::combine($result, 'Codifier.' .$key. '.{n}.1', 'Codifier.' .$key. '.{n}.3');
			$result = Set::remove($result, 'Codifier.'.$key);
			$result = Set::insert($result, 'Codifier.'.$key, $arrayTemp);
		}
	}

	public function generate(){

		if(!$this->Codifier->generate($this->action))
		{
			$this->Session->setFlash(__('you do not have properly set the environment variable "BASES"'), 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
			));
		}
		else
		{
			$this->Session->setFlash(__('Codifiers were successfully imported'), 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
			));
		}

		$this->redirect(array('controller' => 'admin', 'action' => 'index'));
	}




}
