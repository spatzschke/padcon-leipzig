<?php
App::uses('Addresstype', 'Model');

/**
 * Addresstype Test Case
 *
 */
class AddresstypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.addresstype',
		'app.address',
		'app.customer_address',
		'app.customer',
		'app.offer',
		'app.cart',
		'app.confirmation',
		'app.billing',
		'app.delivery',
		'app.cart_product',
		'app.product',
		'app.category',
		'app.catalog',
		'app.material',
		'app.color',
		'app.image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Addresstype = ClassRegistry::init('Addresstype');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Addresstype);

		parent::tearDown();
	}

}
