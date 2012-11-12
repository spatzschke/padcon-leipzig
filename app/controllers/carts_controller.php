<?php
class CartsController extends AppController {

	var $name = 'Carts';
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'Customer');
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
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

	function admin_add() {
		$this->layout = 'admin';
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
	
	function get_active_cart() {
	
		$this->autoRender = false;
		
		$cart = $this->Offer->find('first',array('conditions' =>  array('Offer.status' => 'active')));
		
		$cart = $this->Cart->findById($cart['Offer']['cart_id']);
		
		return $cart;
		
		
	}
	
	function admin_addToCart($id = null) {
		$this->layout = 'admin';
		$this->autoRender = false;
		$cart = null;
		$cartProduct = null;
		$activeCart = null;
	
		if($this->get_active_cart() == null) {
			$activeCart = $this->admin_add();
		} else {
			$activeCart = $this->get_active_cart();
		}
		
		
		
		
		$cartProduct['CartProduct']['cart_id'] = $activeCart['Cart']['id'];
		$cartProduct['CartProduct']['product_id'] = $id;
		
		$isIn = false;
				
		foreach($activeCart['CartProduct'] as $cartProducts) {
			
			
			if($cartProducts['product_id'] == $id) {
				$amount = $cartProducts['amount'];
				$cartProducts['amount'] = intval($amount) + 1;
				$this->CartProduct->save($cartProducts);

				$isIn = true;
				break;
			}
			
		}
		
		if(!$isIn) {
			$this->CartProduct->create();
			$this->CartProduct->save($cartProduct);
			
		}
		
		$this->calcSumPrice();
		$this->updateCartCount($activeCart);
		
		
	
	}
	
	function updateCartCount($cart = null) {
		
		if($cart) {
		
			$cart['Cart']['count'] = count($cart['CartProduct']);
			$this->Cart->save($cart);
			
		}
		
	}
	
	function reloadMiniCart() {
		
		$this->calcSumPrice();
		$this->updateCartCount($this->get_active_cart());
		$this->render('/elements/backend/miniCart');

	}

	function reloadCartSheetProducts() {
		$this->render('/elements/backend/portlets/offerCartPortlet');
	}

	function reloadCartResult() {
		$this->render('/elements/backend/portlets/offerCartFooterPortlet');
	}
	
	function calcSumPrice() {
		
		$cart = $this->get_active_cart();
		
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
