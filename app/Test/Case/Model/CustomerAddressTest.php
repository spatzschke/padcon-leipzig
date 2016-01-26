<?php
App::uses('CustomerAddress', 'Model');

/**
 * CustomerAddress Test Case
 *
 */
class CustomerAddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		'app.delivery',
		'app.address'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CustomerAddress = ClassRegistry::init('CustomerAddress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CustomerAddress);

		parent::tearDown();
	}

}
