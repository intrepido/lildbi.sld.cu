<?php
App::uses('OnlineUser', 'Model');

/**
 * OnlineUser Test Case
 *
 */
class OnlineUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.online_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OnlineUser = ClassRegistry::init('OnlineUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OnlineUser);

		parent::tearDown();
	}

}
