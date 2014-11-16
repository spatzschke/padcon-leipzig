<?php
class Billing extends AppModel {
	var $name = 'Billing';
	var $displayField = 'id';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasOne = array(
		'Confirmation' => array(
			'className' => 'Confirmation',
			'foreignKey' => 'billing_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
