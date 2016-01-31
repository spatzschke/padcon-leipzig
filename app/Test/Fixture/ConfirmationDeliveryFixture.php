<?php
/**
 * ProcessFixture
 *
 */
class ProcessFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'confirmation_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'delivery_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'cart_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'confirmation_id' => 1,
			'delivery_id' => 1,
			'cart_id' => 1,
			'type' => 'Lor',
			'created' => '2015-12-20 15:44:05',
			'modified' => '2015-12-20 15:44:05'
		),
	);

}
