<?php
App::uses('ConfirmationDelivery', 'Model');

/**
 * ConfirmationDelivery Test Case
 *
 */
class ConfirmationDeliveryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.confirmation_delivery',
		'app.confirmation',
		'app.cart',
		'app.offer',
		'app.customer',
		'app.customer_address',
		'app.address',
		'app.address_addresstype',
		'app.addresstype',
		'app.cart_product',
		'app.product',
		'app.category',
		'app.catalog',
		'app.material',
		'app.color',
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
		$this->ConfirmationDelivery = ClassRegistry::init('ConfirmationDelivery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ConfirmationDelivery);

		parent::tearDown();
	}

}
