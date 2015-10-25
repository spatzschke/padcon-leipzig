<?php
App::uses('AppModel', 'Model');
/**
 * AddressAddresstype Model
 *
 * @property Address $Address
 * @property Type $Type
 */
class AddressAddresstype extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'type_id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Type' => array(
			'className' => 'Type',
			'foreignKey' => 'type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
