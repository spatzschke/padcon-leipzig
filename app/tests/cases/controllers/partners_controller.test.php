<?php
/* Partners Test cases generated on: 2012-01-26 14:43:18 : 1327588998*/
App::import('Controller', 'Partners');

class TestPartnersController extends PartnersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PartnersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.partner', 'app.partner_category');

	function startTest() {
		$this->Partners =& new TestPartnersController();
		$this->Partners->constructClasses();
	}

	function endTest() {
		unset($this->Partners);
		ClassRegistry::flush();
	}

}
