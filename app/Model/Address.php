<?php
App::uses('AppModel', 'Model');
/**
 * Address Model
 *
 * @property CustomerAddress $CustomerAddress
 */
class Address extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	
	public function getAddressTypes() {
        return array(
            1 => 'Angebotsadresse',
            2 => 'Auftragsbestätigungsadresse',
            3 => 'Lierferadresse',
            4 => 'Rechnungsadresse',
        );
	}
	
	public function getAddressTypesReverse() {
        
        return array_flip($this->getAddressTypes());
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CustomerAddress' => array(
			'className' => 'CustomerAddress',
			'foreignKey' => 'address_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AddressAddresstype' => array(
			'className' => 'AddressAddresstype',
			'foreignKey' => 'address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
