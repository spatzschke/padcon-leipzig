<?php
/* Catalogs Test cases generated on: 2011-12-01 22:11:45 : 1322777505*/
App::import('Controller', 'Catalogs');

class TestCatalogsController extends CatalogsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CatalogsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.catalog', 'app.category', 'app.product', 'app.material', 'app.color', 'app.size', 'app.image', 'app.cart', 'app.offer', 'app.user', 'app.cart_product');

	function startTest() {
		$this->Catalogs =& new TestCatalogsController();
		$this->Catalogs->constructClasses();
	}

	function endTest() {
		unset($this->Catalogs);
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
