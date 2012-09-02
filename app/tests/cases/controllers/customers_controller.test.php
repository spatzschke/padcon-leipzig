<?php
/* Customers Test cases generated on: 2012-09-01 18:39:02 : 1346524742*/
App::import('Controller', 'Customers');

class TestCustomersController extends CustomersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CustomersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.customer', 'app.user', 'app.offer', 'app.cart', 'app.cart_product', 'app.product', 'app.category', 'app.catalog', 'app.material', 'app.color', 'app.size', 'app.image');

	function startTest() {
		$this->Customers =& new TestCustomersController();
		$this->Customers->constructClasses();
	}

	function endTest() {
		unset($this->Customers);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
