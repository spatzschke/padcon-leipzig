<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $displayField = 'id';
	//The Associations below have been created with all possible keys, those that are not needed can be remove
	
	var $hasOne = array(
		'Process' => array(
			'className' => 'Process',
			'foreignKey' => 'delivery_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
