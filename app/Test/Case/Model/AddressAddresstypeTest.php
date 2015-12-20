<?php
App::uses('AddressAddresstype', 'Model');

/**
 * AddressAddresstype Test Case
 *
 */
class AddressAddresstypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.address_addresstype',
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
		'app.image',
		'app.type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AddressAddresstype = ClassRegistry::init('AddressAddresstype');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AddressAddresstype);

		parent::tearDown();
	}

}
