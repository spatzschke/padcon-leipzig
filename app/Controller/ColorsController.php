<?php
class ColorsController extends AppController {

	var $name = 'Colors';
	var $scaffold;
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->deny('*');
			
		}
	}
	
	function getColor($id = null){
		
		if($id) {
			return $this->Color->findById($id);
		} else {
			
			$c['Color']['code'] = '00';
			$c['Color']['name'] = 'Farblos';
			
			return $c;
			
		}
		
	} 

}
