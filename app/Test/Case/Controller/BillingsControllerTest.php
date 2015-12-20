<?php
App::uses('BillingsController', 'Controller');

/**
 * BillingsController Test Case
 *
 */
class BillingsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.billing',
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
		'app.customer',
		'app.customer_address',
		'app.address',
		'app.delivery'
	);

}
