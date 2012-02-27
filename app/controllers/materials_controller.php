<?php
class MaterialsController extends AppController {

	var $name = 'Materials';
	var $scaffold;
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->deny('*');
			
		}
	}

}
