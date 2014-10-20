<?php
App::uses('Customer', 'Model');

/**
 * Customer Test Case
 *
 */
class CustomerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.customer',
		'app.customer_address',
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
		$this->Customer = ClassRegistry::init('Customer');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Customer);

		parent::tearDown();
	}

}
