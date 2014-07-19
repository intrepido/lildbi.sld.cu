<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	/**
	 * Search Model
	 *
	 * @var Search
	 */
	//var $Search;
	
	/**
	 * Post Model
	 *
	 * @var Post
	 */
	//var $Post;
	
	var $uses = array('Configuration.Configuration');
	
	
	public $components = array(
			'Session',
			'Cookie',
			'Auth'=>array(
					'loginRedirect'=>array('controller'=>'admin', 'action'=>'index'),
					'logoutRedirect'=>array('controller'=>'pages', 'action'=>'display', 'home'),
					'authError'=>"You can't access that page",
					'authorize'=>array('Controller')
			),
			'DebugKit.Toolbar'
	);
	
	public $helpers = array(			
			'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
			'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
			'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
	);
	
	public function isAuthorized($user) {
		return true;
	}
	
	/*public function beforeFilter() {
		$this->Auth->allow('display', 'logout');
		  if($this->Auth->user('roles') == 'admin') {
			$this->Auth->allow('index', 'add', 'edit', 'delete');
		}
		$this->set('logged_in', $this->Auth->loggedIn());
		$this->set('current_user', $this->Auth->user());
	}*/
	
	public function beforeFilter() {
		
		//Load Configurations
		$this->Configuration->load('CFG'); //$prefix is 'CFG' by default		
		
		if (Configure::read('CFG.Maintenance') && ($this->Session->read('userRol') != null) && ($this->Session->read('userRol') != 'Administrador')){
			//Interfaz de mantenimiento, solo pueden acceder al sitio los Administradores
			$this->Auth->allow('display', 'login', 'logout');
			$this->layout = 'maintenance';
			$this->set('title_for_layout', __('Sitio web en mantenimiento', true));
			$this->set('current_user', $this->Auth->user());
			$this->render('../Elements/maintenance');
		}
		else{
			$this->Auth->allow('display', 'logout', 'login', 'verifySessionUser');			
			$this->set('logged_in', $this->Auth->loggedIn());
			$this->set('current_user', $this->Auth->user());
			
		}
	}
}
