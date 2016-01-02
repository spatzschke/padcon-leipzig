<?php
App::uses('Core', 'Model');

/**
 * Core Test Case
 *
 */
class CoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.core'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Core = ClassRegistry::init('Core');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Core);

		parent::tearDown();
	}

}
