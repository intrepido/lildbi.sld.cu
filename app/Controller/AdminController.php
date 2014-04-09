<?php
App::import('Plugin/WebSocket/Lib/Network/Http', 'WebSocket', array('file'=>'WebSocket.php'));

class AdminController extends AppController {
	public $components = array('RequestHandler');
	public $layout = 'admin_layout';
	public $name = 'Admin';
	
	public function beforeFilter() {
		parent::beforeFilter();
	
		if($this->Session->read('Auth.User') == null){
			//Si la session expiró, entonces desconectarlo del servidor de Node JS
			$websocket = new WebSocket(array('port' => 3000, 'scheme'=>'http'));
			
			if($websocket->connect()) {
				$onlineUser = $this->Auth->user();
				$data = array('username' => $onlineUser['username']);
				$websocket->emit('disconnectUser', $data);	
			}	
		}
	}
	
	
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