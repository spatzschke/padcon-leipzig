<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $displayField = 'id';
	//The Associations below have been created with all possible keys, those that are not needed can be remove
	
	var $hasOne = array(
		'Confirmation' => array(
			'className' => 'Confirmation',
			'foreignKey' => 'delivery_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
