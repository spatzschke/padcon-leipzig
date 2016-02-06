<?php
App::uses('AppModel', 'Model');
/**
 * Process Model
 *
 * @property Confirmation $Confirmation
 * @property Delivery $Delivery
 * @property Cart $Cart
 */
class Process extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
	
		'Offer' => array(
			'className' => 'Offer',
			'foreignKey' => 'offer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Confirmation' => array(
			'className' => 'Confirmation',
			'foreignKey' => 'confirmation_id',
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
		'Billing' => array(
			'className' => 'Billing',
			'foreignKey' => 'billing_id',
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
		'Cart' => array(
			'className' => 'Cart',
			'foreignKey' => 'cart_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
