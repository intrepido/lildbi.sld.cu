<?php
App::import('Plugin/WebSocket/Lib/Network/Http', 'WebSocket', array('file'=>'WebSocket.php'));

class AdminController extends AppController {
	public $components = array('RequestHandler');
	public $layout = 'admin_layout';
	public $name = 'Admin';
	
	
	
	function index() {

		$currentUser = $this->Auth->user();

		//$this->Session->read('Auth.User.name')

		if ($this->Session->read('userRol') == 'Administrador'){
			$this->layout = 'admin_layout';
			$this->set('rol','Administrador');
		}

		if ($this->Session->read('userRol') == 'Documentalista'){
			$this->layout = 'documentalista_layout';
			$this->set('rol','Documentalista');
		}

		if ($this->Session->read('userRol') == 'Editor'){
			$this->layout = 'editor_layout';
			$this->set('rol','Editor');
		}

	}

	function documentalista() { //FUNCIONA el buscar

		$this->layout = 'documentalista_layout';

	}
	
	function reports() { 	
	
	}
	
	function maintenance() { 		
		if($this->RequestHandler->isAjax()){
			$this->autoRender = FALSE;
			if(Configure::read('CFG.Maintenance')){
				$this->Configuration->saveConfig('Maintenance', 0);				
			}
			else{
				$this->Configuration->saveConfig('Maintenance', 1);	
			}
			
		}
	}
	
}
?>