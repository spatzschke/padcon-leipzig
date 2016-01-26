<?php
/**
 * ProductCategoryFixture
 *
 */
class ProductCategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'product_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'product_id' => 1,
			'category_id' => 1,
			'created' => '2016-01-02 20:36:32',
			'modified' => '2016-01-02 20:36:32'
		),
	);

}
