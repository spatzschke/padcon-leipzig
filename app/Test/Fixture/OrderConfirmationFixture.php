<?php
/**
 * OrderConfirmationFixture
 *
 */
class OrderConfirmationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'customer_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'order_confirmation_number' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'agent' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'order_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'order_number' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'vat' => array('type' => 'integer', 'null' => false, 'default' => '19', 'length' => 3),
		'discount' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3),
		'delivery_cost' => array('type' => 'float', 'null' => false, 'default' => null),
		'order_confirmation_price' => array('type' => 'float', 'null' => false, 'default' => null),
		'additional_text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'billing_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'delivery_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'status' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'modified' => array('type' => 'date', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'customer_id' => 1,
			'order_confirmation_number' => 'Lorem ipsum dolor sit amet',
			'agent' => 'Lorem ipsum dolor sit amet',
			'order_date' => '2014-10-27',
			'order_number' => 'Lorem ipsum dolor sit amet',
			'vat' => 1,
			'discount' => 1,
			'delivery_cost' => 1,
			'order_confirmation_price' => 1,
			'additional_text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'billing_id' => 1,
			'delivery_id' => 1,
			'status' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-10-27',
			'modified' => '2014-10-27'
		),
	);

}
