<?php
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
/**
 * OnlineUsers Controller
 *
 * @property OnlineUser $OnlineUser
*/
class OnlineUsersController extends AppController {
	public $components = array(
			'RequestHandler'
	);
	

	public function beforeFilter() {
		parent::beforeFilter();
		
		if($this->Session->read('Auth.User') == null){
			$onlineUser = $this->Auth->user();	
			$conditions = array('OnlineUser.username' => "fsantana");
			$onlineUser = $this->OnlineUser->find('first', compact('conditions'));
			$this->OnlineUser->delete($onlineUser['OnlineUser']['id']);	
		}
	}

	/**
	 * index method
	 *
	 * @return void
	*/
	public function index() {
		if($this->RequestHandler->isAjax()){			
			$this->autoRender = FALSE;
			return json_encode($this->OnlineUser->find('all'));
		}				
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	
	public function view($id = null) {
		if($this->RequestHandler->isAjax()){
			$userOnline = $this->OnlineUser->read(null, $this->request->data["id"]);			
			$this->autoRender = FALSE;
			return json_encode($userOnline);
		}
	}
	
	
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($user_id, $username, $currentRol) {
		if ($this->request->is('post')) {
			$this->OnlineUser->create();
			$data = array('ip' => $this->request->clientIp(), 'user_id' => $user_id, 'username' => $username, 'current_rol' => $currentRol, 'date' => CakeTime::format("Y-m-d H:i:s", time()));
			$this->OnlineUser->save($data);			
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->OnlineUser->id = $id;
		if (!$this->OnlineUser->exists()) {
			throw new NotFoundException(__('Invalid online user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OnlineUser->save($this->request->data)) {
				$this->Session->setFlash(__('The online user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The online user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->OnlineUser->read(null, $id);
		}
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($username) {
		
		if ($this->request->is('get')) {
			$conditions = array('OnlineUser.username' => $username);
			$onlineUser = $this->OnlineUser->find('first', compact('conditions'));
			$this->OnlineUser->delete($onlineUser['OnlineUser']['id']);
		}		
	}
	
	public function setTimeOnline() {
		if($this->RequestHandler->isAjax()){
			$userForSetTime = $this->request->data["user"];			
			$this->autoRender = FALSE;
			return CakeTime::timeAgoInWords($userForSetTime['OnlineUser']['date'], array('format' => 'F jS, Y', 'end' => '+1 year'));
		}		
	}
}
