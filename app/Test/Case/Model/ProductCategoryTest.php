<?php
App::uses('ProductCategory', 'Model');

/**
 * ProductCategory Test Case
 *
 */
class ProductCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product_category',
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
		'app.cart_product'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductCategory = ClassRegistry::init('ProductCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductCategory);

		parent::tearDown();
	}

}
