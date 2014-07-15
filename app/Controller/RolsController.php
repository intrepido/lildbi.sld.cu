<?php
App::uses('AppController', 'Controller');
App::import('Plugin/WebSocket/Lib/Network/Http', 'WebSocket', array('file'=>'WebSocket.php'));
/**
 * Rols Controller
 *
 * @property Rol $Rol
 */
class RolsController extends AppController {
	
	public $name = 'Rols';
	public $layout = 'admin_layout';	
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('changeRol');
		/*if($this->Session->read('userRol') == 'Administrador' || $this->Session->read('userRol') == 'Editor' || $this->Session->read('userRol') == 'Documentalista'){
			$this->Auth->allow('changeRol');
		}*/
	}
	
	public function isAuthorized($user) {
		/**
		 * Solo los administradores pueden entrar al controlador de usuarios
		 */
		if ($this->Session->read('userRol') == 'Administrador') {
			return true;
		}
		return false;
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Rol->recursive = 0;
		$this->set('rols', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Rol->id = $id;
		if (!$this->Rol->exists()) {
			throw new NotFoundException(__('Invalid rol'));
		}
		$this->set('rol', $this->Rol->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Rol->create();
			if ($this->Rol->save($this->request->data)) {
				$this->Session->setFlash(__('The rol has been saved'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
				));				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rol could not be saved. Please, try again.'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
				));				
			}
		}
		$users = $this->Rol->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Rol->id = $id;
		if (!$this->Rol->exists()) {
			throw new NotFoundException(__('Invalid rol'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rol->save($this->request->data)) {
				$this->Session->setFlash(__('The rol has been saved'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
				));				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rol could not be saved. Please, try again.'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
				));				
			}
		} else {
			$this->request->data = $this->Rol->read(null, $id);
		}
		$users = $this->Rol->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Rol->id = $id;
		if (!$this->Rol->exists()) {
			throw new NotFoundException(__('Invalid rol'));
		}
		if ($this->Rol->delete()) {
			$this->Session->setFlash(__('Rol deleted'), 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
			));			
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rol was not deleted'), 'alert', array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
		));		
		$this->redirect(array('action' => 'index'));
	}
	
	//Cambia el perfil de un usuario. Se le pasa el nombre del Rol por get y se cambia en la Session
	public function changeRol(){
	
		//Modificar rol del usuario usando socket I/O		
		$connectionNode = Configure::read('Node'); //Datos de la conexion de nodejs
		$websocket = new WebSocket(array('host' => $connectionNode['host'], 'port' => $connectionNode['port'], 'scheme'=>'http'));
		
		if($websocket->connect()) {
			$onlineUser = $this->Auth->user();
			$data = array('username' => $onlineUser['username'], 'current_rol' => $this->request->params['pass'][0]);
			$websocket->emit('updateCurrentRolUser', $data);			
		}
		
	    $this->Session->write('userRol',$this->request->params['pass'][0]);		
		$this->redirect($this->Auth->redirect());
	}
}
