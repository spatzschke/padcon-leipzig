<?php
/* Sizes Test cases generated on: 2011-11-04 16:57:40 : 1320425860*/
App::import('Controller', 'Sizes');

class TestSizesController extends SizesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SizesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.size', 'app.product', 'app.category', 'app.catalog', 'app.material', 'app.color', 'app.image', 'app.cart', 'app.offer', 'app.user', 'app.cart_product');

	function startTest() {
		$this->Sizes =& new TestSizesController();
		$this->Sizes->constructClasses();
	}

	function endTest() {
		unset($this->Sizes);
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

}
