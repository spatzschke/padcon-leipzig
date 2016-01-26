<?php
App::uses('AppModel', 'Model');
/**
 * Confirmation Model
 *
 * @property Carts $cart_id
 * @property Customer $Customer
 * @property Billing $Billing
 * @property Delivery $Delivery
 * @property  $
 */
class Confirmation extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'confirmation_number';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
 	public $hasMany = array(
		'ConfirmationDelivery' => array(
			'className' => 'ConfirmationDelivery',
			'foreignKey' => 'confirmation_id',
		)
	);
 
	public $belongsTo = array(
		'Cart' => array(
			'className' => 'Cart',
			'foreignKey' => 'cart_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Billing' => array(
			'className' => 'Billing',
			'foreignKey' => 'billing_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Delivery' => array(
			'className' => 'Delivery',
			'foreignKey' => 'delivery_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
