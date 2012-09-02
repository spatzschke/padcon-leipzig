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
		'User' => array(
			'className' => 'Customer',
			'foreignKey' => 'custmer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
