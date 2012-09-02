<?php
/* Customer Test cases generated on: 2012-09-01 18:30:31 : 1346524231*/
App::import('Model', 'Customer');

class CustomerTestCase extends CakeTestCase {
	var $fixtures = array('app.customer', 'app.user', 'app.offer', 'app.cart', 'app.cart_product', 'app.product', 'app.category', 'app.catalog', 'app.material', 'app.color', 'app.size', 'app.image');

	function startTest() {
		$this->Customer =& ClassRegistry::init('Customer');
	}

	function endTest() {
		unset($this->Customer);
		ClassRegistry::flush();
	}

}
