<?php
 //Import controller
  App::import('Controller', 'Users');

class CartsController extends AppController {

	var $name = 'Carts';
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'Customer', 'User');
	public $components = array('Auth', 'Session', 'Cookie');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->allow('addToCart', 'add', 'reloadFrontendMiniCart','calcSumPriceByCartId','updateCartCount','get_cart_by_id', 'get_cart_by_cookie');
		}
	}
	
	function admin_index() {
		$this->layout = 'admin';
	
		$this->Cart->recursive = 0;
		$this->set('carts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Cart', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('cart', $this->Cart->read(null, $id));
	}

	function add() {
			$this->layout = 'ajax';
			$this->autoRender = false;
	
			$this->Cart->create();
			if ($this->Cart->save($this->data)) {
				//$this->Session->setFlash(__('The Cart has been saved', true));
				$last = $this->Cart->findById($this->Cart->id);
				
				return $last;
				
			} else {
				//$this->Session->setFlash(__('The Cart could not be saved. Please, try again.', true));
			}
	}

	function admin_add() {
		return $this->add();
	}
	
	function get_active_cart() {
	
		$this->autoRender = false;
		
		$cart = $this->Offer->find('first',array('conditions' =>  array('Offer.status' => 'active')));
		
		if(!empty($cart)) {	
			$cart = $this->Cart->findById($cart['Offer']['cart_id']);		
		}
	
		
		return $cart;
		
		
	}
	
	function admin_addToCart($id = null) {
		
		$id = $this->request->data['Product']['id'];
		
		$this->addToCart($id);
	}
	
	function addToCart($id = null) {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$cart = null;
		$cartProduct = null;
		$activeCart = null;
		
		//Cookie setzen wenn Produkt in Warenkorb gelegt wird und noch kein Cookie vorhanden ist
		if(!$this->Cookie->check('pd')) {
			
			$tmpCookieId = explode(" ",$this->Session->read('Config.time'));
			
			// Erstellen eines neuen leeren Warenkorbes
			$activeCart = $this->add();
			
			// Erstellen eines Anonymous-User für den neuen Warenkorb
			$anonymous = null;
			$anonymous['User']['cookies_id'] = $tmpCookieId[0];
			$anonymous['User']['session_id'] = $this->Session->read('Config.userAgent');
			$anonymous['User']['role'] = 'anonymous';
			
			//Instantiieren des Controllers "Users"
			$Users = new UsersController;
			$Users->createAnonymous($anonymous);
			// Cookie setzen mit cookie_id & session_id
			$this->Cookie->write('pd',
			    array(
			    	'id' => $tmpCookieId[0], 
			    	'session' => $this->Session->read('Config.userAgent'),
			    	'cart' => $activeCart['Cart']['id']
				), false
			);
			if($this->Session->check('pd.cart')) {
				$this->Session->delete('pd.cart');
			} else {
				$this->Session->write('pd',
				    array(
				    	'cart' => $activeCart['Cart']['id']
					), false
				);
			}
			
		} else {
			$cookie_id = $this->Cookie->read('pd.id');
			$activeCart = $this->get_cart_by_id($this->Cookie->read('pd.cart'));
			if(!$this->Session->check('pd.cart')) {
				$this->Session->delete('pd.cart');
				$this->Session->write('pd',
				    array(
				    	'cart' => $activeCart['Cart']['id']
					), false
				);
			}
			
		}
		
			
		if($this->get_active_cart() == null) {
			$activeCart = $this->admin_add();
		} else {
			$activeCart = $this->get_active_cart();
		}
		
		 
		
		$cartProduct['CartProduct']['cart_id'] = $activeCart['Cart']['id'];
		$cartProduct['CartProduct']['product_id'] = $id;
		$cartProduct['CartProduct']['color_id'] = $this->request->data['Product']['color'];
		$cartProduct['CartProduct']['amount'] = $this->request->data['Product']['amount'];
				
		$isIn = false;
				
		foreach($activeCart['CartProduct'] as $cartProducts) {

			if(($cartProducts['product_id'] == $id) && ($cartProducts['color_id'] == $this->request->data['Product']['color'])) {
				$amount = $cartProducts['amount'];
				$cartProducts['amount'] = strval(intval($amount) + intval($this->request->data['Product']['amount']));
				$this->CartProduct->save($cartProducts);

				debug($cartProducts);

				$isIn = true;
				break;
			}
			
		}
		
		if(!$isIn) {
			
			$this->CartProduct->create();
			$this->CartProduct->save($cartProduct);
			
		}
		
		$this->calcSumPriceByActiveCart();
		$this->updateCartCount($this->get_active_cart());
		
	}
	
	public function get_cart_by_id($id = null) {
		return $this->Cart->read(null, $id);
	}
	
	public function get_cart_by_cookie() {
		
		$cart_id = $this->Cookie->read('pd.cart');
		
		
		return $this->Cart->read(null, $cart_id);
	}
	
	function updateCartCount($cart = null) {
		
		if($cart == NULL) {
		
			$cart = $this->get_cart_by_id($this->Cookie->read('pd.cart'));
			
		} 
		
		$cart['Cart']['count'] = count($cart['CartProduct']);
		
		debug($cart);
		debug(count($cart['CartProduct']));
		
		$this->Cart->save($cart);
		
	}
	
	function reloadFrontendMiniCart() {
		$this->layout = 'ajax';
		$this->calcSumPriceByActiveCart();
		$this->updateCartCount();
		$this->render('/Elements/miniCart');

	}
	
	function reloadMiniCart() {
		$this->layout = 'ajax';
		$this->calcSumPriceByActiveCart();
		$this->updateCartCount($this->get_active_cart());
		$this->render('/Elements/backend/miniCart');

	}

	function reloadCartSheetProducts() {
		$this->layout = 'ajax';
		$offer = $active = $this->Offer->find('first', array('conditions' => array('Offer.status' => 'active')));
		$this->set('offer', $offer);
		$this->render('/Elements/backend/offer_cheet');
	}

	function reloadCartResult() {
		$this->render('/Elements/backend/portlets/offerCartFooterPortlet');
	}
	
	function calcSumPrice($cart = null) {
		
		if(empty($cart['CartProduct'])) {
			return null;
		}
		
		$sumBasePrice = null;
		$sumRetailPrice = null;
		
		foreach($cart['CartProduct'] as $cartProduct) {
			
			$product = $this->Product->findById($cartProduct['product_id']);
	
			$sumBasePrice += (floatVal($product['Product']['price']) * intVal($cartProduct['amount']));
			$sumRetailPrice += (floatVal($product['Product']['retail_price']) * intVal($cartProduct['amount']));
		}
		
		$cart['Cart']['sum_base_price'] = $sumBasePrice;
		$cart['Cart']['sum_retail_price'] = $sumRetailPrice;
				
		$this->Cart->save($cart);
				
		return $cart;
		
	}

	function calcSumPriceByActiveCart() {
		$cart = $this->get_active_cart();
		$this->calcSumPrice($cart);
	}
	
	function calcSumPriceByCartId($id = null) {
		$cart = $this->get_cart_by_id($id);
		$this->calcSumPrice($cart);
	}
	
	function admin_active_cart($id = null) {
	
		$this->autoRender = false;
	
		$cart = $this->Cart->find('first',array('conditions' =>  array('Cart.id' => $id)));
		$cart['Cart']['active'] = true;
		
	
		if ($this->Cart->save($cart)) {
		
			$last = $this->Cart->findById($this->Cart->id);
			
			return $last;
			
		} else {
		}
	}
	
	function admin_disable_cart($id = null) {
		
		$this->autoRender = false;
		
		if(empty($id)){
			$con = array('Cart.active' => '1');
		} else {
			$con = array('Cart.active' => '1', 'Cart.id' => $id);
		}
		
		$carts = $this->Cart->find('all',array('conditions' =>  $con));
		
		foreach($carts as $cart) {
			
			$cart['Cart']['active'] = 0;
			$this->Cart->save($cart);
			
		}
	} 

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Cart', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Cart->save($this->data)) {
				$this->Session->setFlash(__('The Cart has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Cart could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Cart->read(null, $id);
		}
		$carts = $this->Cart->Cart->find('list');
		$users = $this->Cart->User->find('list');
		$this->set(compact('carts', 'users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Cart', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Cart->delete($id)) {
			$this->Session->setFlash(__('Cart deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Cart was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}


}
