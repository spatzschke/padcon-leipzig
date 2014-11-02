<?php
class Offer extends AppModel {
	var $name = 'Offer';
	var $displayField = 'id';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
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
		'Confirmation' => array(
			'className' => 'Confirmation',
			'foreignKey' => 'confirmation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
