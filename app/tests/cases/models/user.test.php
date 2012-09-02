<?php
/* User Test cases generated on: 2012-09-01 18:33:39 : 1346524419*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.customer', 'app.offer', 'app.cart', 'app.cart_product', 'app.product', 'app.category', 'app.catalog', 'app.material', 'app.color', 'app.size', 'app.image');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

}
