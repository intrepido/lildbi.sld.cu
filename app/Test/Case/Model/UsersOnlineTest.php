<?php
App::uses('UsersOnline', 'Model');

/**
 * UsersOnline Test Case
 *
 */
class UsersOnlineTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.users_online'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UsersOnline = ClassRegistry::init('UsersOnline');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UsersOnline);

		parent::tearDown();
	}

}
