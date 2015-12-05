<?php
App::uses('AddresstypesController', 'Controller');

/**
 * AddresstypesController Test Case
 *
 */
class AddresstypesControllerTest extends ControllerTestCase {

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

}
