<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
*/
class UsersController extends AppController {

	public $layout = 'admin_layout';
	var $uses = array('User','Rol');
	public $paginate = array(
			'limit' => 5
	);
	public $components = array('RequestHandler');


	/**
	 * Este metodo se descomenta para poder insertar usuarios cuando las BD de usuarios esta vacia,
	 * una vez insertado un usuario se volver a comentarear, ya que ahora podemos gestionar la aplicacion
	 * con este usuario, siempre y cuando se halla creado con rol de Administrador.
	*/
	/*
	 public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('add');
	}
	*/

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('listRolUser');		
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

	public function login() {

		$this->layout = 'default';
		if ($this->request->is('post')) {
			$rol = $this->Rol->findById($this->request->data['User']['rol']);
			$this->User->recursive = 1;
			$conditions = array('User.username' => $this->request->data['User']['username']);
			$user = $this->User->find('first', compact('conditions'));
			$temp = true;
				
			if (!empty($user)) {
				foreach ($user['Rol'] as $userRol) {
					if (in_array($rol['Rol']['name'], $userRol)) {
						$temp = false;
					}
				}
				if ($temp) {
					$this->Session->setFlash(__("You don't have access as ".$rol['Rol']['name']), 'alert', array(
							'plugin' => 'TwitterBootstrap',
							'class' => 'alert-error'
					));
				}
				else{
					if ($this->Auth->login()) {
						$this->Session->write('userRol', $rol['Rol']['name']);						
						$this->requestAction('/onlineUsers/add/'.$user['User']['id'].'/'.$user['User']['username'].'/'.$rol['Rol']['name']);						
						$this->redirect($this->Auth->redirect());
					} else {
						$this->Session->setFlash(__("Your password was incorrect"), 'alert', array(
								'plugin' => 'TwitterBootstrap',
								'class' => 'alert-error'
						));
					}
				}
			}
			else{
				$this->Session->setFlash(__("Your username/password combination was incorrect"), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
				));
			}

		}
		$rols = $this->Rol->find('list');
		$this->set(compact('rols'));
	}

	public function logout() {
		$this->Session->write('userRol','');
		$onlineUser = $this->Auth->user();
		$this->requestAction('/onlineUsers/delete/'. $onlineUser['username']);
		$this->redirect($this->Auth->logout());
	}
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));	
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
				));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
				));
			}
		}
		$rols = $this->User->Rol->find('list');
		$this->set(compact('rols'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
				));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert', array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
				));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$rols = $this->User->Rol->find('list');
		$this->set(compact('rols'));
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), 'alert', array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
			));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'), 'alert', array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
		));
		$this->redirect(array('controller' => 'admin', 'action' => 'index'));
	}
	
	
	//Devuelve los roles de un usuario especifico. Se le pasa por ajax el username.
	public function listRolUser() {
	
		if($this->RequestHandler->isAjax()){
	
			$this->User->recursive = 1;
			$conditions = array('User.username' => $this->request->data['username']);
			$user = $this->User->find('first', compact('conditions'));
	
			$this->autoRender = FALSE;
			return json_encode($user['Rol']);
		}
	}
}
