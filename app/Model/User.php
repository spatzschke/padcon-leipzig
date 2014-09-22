<?php
// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $validate = array(
      /*  'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),*/
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'customer','anonymous')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasOne = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $passwordHasher = new SimplePasswordHasher();
	        $this->data[$this->alias]['password'] = $passwordHasher->hash(
	            $this->data[$this->alias]['password']
	        );
	    }
	    return true;
	}
}
?>