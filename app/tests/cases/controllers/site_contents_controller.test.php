<?php
/* SiteContents Test cases generated on: 2011-12-06 22:21:32 : 1323210092*/
App::import('Controller', 'SiteContents');

class TestSiteContentsController extends SiteContentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SiteContentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.site_content');

	function startTest() {
		$this->SiteContents =& new TestSiteContentsController();
		$this->SiteContents->constructClasses();
	}

	function endTest() {
		unset($this->SiteContents);
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
