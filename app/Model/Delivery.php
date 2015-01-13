<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $displayField = 'delivery_number';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	
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
