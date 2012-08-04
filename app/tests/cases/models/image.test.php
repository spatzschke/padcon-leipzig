<?php
/* Image Test cases generated on: 2011-12-07 21:35:23 : 1323293723*/
App::import('Model', 'Image');

class ImageTestCase extends CakeTestCase {
	var $fixtures = array('app.image', 'app.product', 'app.category', 'app.catalog', 'app.material', 'app.color', 'app.size', 'app.cart', 'app.offer', 'app.user', 'app.cart_product');

	function startTest() {
		$this->Image =& ClassRegistry::init('Image');
	}

	function endTest() {
		unset($this->Image);
		ClassRegistry::flush();
	}

}
