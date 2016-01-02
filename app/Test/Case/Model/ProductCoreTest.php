<?php
App::uses('ProductCore', 'Model');

/**
 * ProductCore Test Case
 *
 */
class ProductCoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product_core',
		'app.product',
		'app.category',
		'app.catalog',
		'app.material',
		'app.color',
		'app.image',
		'app.cart',
		'app.offer',
		'app.customer',
		'app.customer_address',
		'app.address',
		'app.address_addresstype',
		'app.addresstype',
		'app.confirmation',
		'app.billing',
		'app.delivery',
		'app.confirmation_delivery',
		'app.cart_product',
		'app.core'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductCore = ClassRegistry::init('ProductCore');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductCore);

		parent::tearDown();
	}

}
