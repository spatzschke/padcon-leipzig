<?php
App::uses('Address', 'Model');

/**
 * Address Test Case
 *
 */
class AddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.address',
		'app.customer_address',
		'app.customer',
		'app.offer',
		'app.cart',
		'app.cart_product',
		'app.product',
		'app.category',
		'app.catalog',
		'app.material',
		'app.color',
		'app.size',
		'app.image',
		'app.billing',
		'app.delivery'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Address = ClassRegistry::init('Address');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Address);

		parent::tearDown();
	}

}
