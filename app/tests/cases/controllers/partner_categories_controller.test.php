<?php
/* PartnerCategories Test cases generated on: 2011-12-01 01:01:29 : 1322701289*/
App::import('Controller', 'PartnerCategories');

class TestPartnerCategoriesController extends PartnerCategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PartnerCategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.partner_category', 'app.partner');

	function startTest() {
		$this->PartnerCategories =& new TestPartnerCategoriesController();
		$this->PartnerCategories->constructClasses();
	}

	function endTest() {
		unset($this->PartnerCategories);
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
