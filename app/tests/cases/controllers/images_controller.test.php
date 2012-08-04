<?php
/* Images Test cases generated on: 2011-12-07 21:44:01 : 1323294241*/
App::import('Controller', 'Images');

class TestImagesController extends ImagesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ImagesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.image', 'app.product', 'app.category', 'app.catalog', 'app.material', 'app.color', 'app.size', 'app.cart', 'app.offer', 'app.user', 'app.cart_product');

	function startTest() {
		$this->Images =& new TestImagesController();
		$this->Images->constructClasses();
	}

	function endTest() {
		unset($this->Images);
		ClassRegistry::flush();
	}

}
