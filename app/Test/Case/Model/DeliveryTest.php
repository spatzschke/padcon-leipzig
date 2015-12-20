<?php
App::uses('Delivery', 'Model');

/**
 * Delivery Test Case
 *
 */
class DeliveryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.delivery',
		'app.offer',
		'app.cart',
		'app.confirmation',
		'app.customer',
		'app.customer_address',
		'app.address',
		'app.billing',
		'app.cart_product',
		'app.product',
		'app.category',
		'app.catalog',
		'app.material',
		'app.color',
		'app.size',
		'app.image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Delivery = ClassRegistry::init('Delivery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Delivery);

		parent::tearDown();
	}

}
