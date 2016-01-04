<?php
 //Import controller
  App::import('Controller', 'Users');
  App::import('Controller', 'Products');

class CartsController extends AppController {

	var $name = 'Carts';
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'Customer', 'User');
	public $components = array('Auth', 'Session', 'Cookie');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			parent::beforeFilter();
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
	
	function admin_addToCart($cart_id = null) {
		
		$id = $this->request->data['Product']['id'];
		
		$this->addToCart($id, $cart_id);
	}
	
	function addToCart($id = null, $cart_id = null) {
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
	
		if(!$cart_id) {
			$activeCart = $this->admin_add();
		} else {
			$options = array('conditions' => array('Cart.id' => $cart_id));
			$activeCart = $this->Cart->find("first", array("conditions" => array("Cart.id" => $cart_id)));
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

				$isIn = true;
				break;
			}
			
		}
		
		if(!$isIn) {
			
			$this->CartProduct->create();
			$this->CartProduct->save($cartProduct);
			
		}
		
		$activeCart = $this->calcSumPriceByActiveCart($activeCart['Cart']['id']);
		
		$this->updateCartCount($activeCart);
		
	}
	
	public function get_cart_by_id($id = null) {
		$cart = $this->Cart->read(null, $id);
		//$cart['CartProduct'] = $this->CartProduct->find('all', array('CartProduct.cart_id' => $id));	
		return $cart;
	}
	
	public function get_cart_by_cookie() {
		
		$cart_id = $this->Cookie->read('pd.cart');
		
		
		return $this->Cart->read(null, $cart_id);
	}
	
	function updateCartCount($cart = null) {
				
		if($cart == NULL) {		
			$cart = $this->get_cart_by_id($this->Cookie->read('pd.cart'));	
		} 
		
		// $cart = $this->Cart->findById($cart['id']);
		
		if(isset($cart['CartProduct'])) {
			$cart['Cart']['count'] = count($cart['CartProduct']);
		} else {
			$cart['Cart']['count'] = 0;
		}			
		
		$this->Cart->save($cart['Cart']);
		
	}
	
	function reloadFrontendMiniCart() {
		$this->layout = 'ajax';
		$this->calcSumPriceByActiveCart();
		$this->updateCartCount();
		$this->render('/Elements/miniCart');

	}
	
	function reloadMiniCart($id = null) {
		$this->layout = 'ajax';
		$this->calcSumPriceByActiveCart($id);
		$this->updateCartCount($this->Cart->findById($id));
		$this->render('/Elements/backend/miniCart');

	}

	function reloadCartSheetProducts() {
		$this->layout = 'ajax';
		$offer = $active = $this->Offer->find('first', array('conditions' => array('Offer.status' => 'active')));
		$this->set('offer', $offer);
		$this->render('/Elements/backend/paper_cheet');
	}

	function reloadCartResult() {
		$this->render('/Elements/backend/portlets/Offer/offerCartFooterPortlet');
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

	function calcSumPriceByActiveCart($id = null) {
		$cart = $this->Cart->findById($id);
		
		return $this->calcSumPrice($cart);
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
	
	function calcPageLoad($cart = null, $cRow = 5, $tRow = 5) {
		$Products = new ProductsController();
		
		$rowPerPage = 30;
		$standardProductRow = 5;
		$calcRow = $cRow;
		$textRow = $tRow;
		$featureCount = 0;
		$featureCountMax = 0;
		$pages= 0;
		$page = array();
		$prodArr = array();
		$cartProducts = $cart['CartProduct'];
		
		//Holen maximale Zeilen
		foreach ($cart['CartProduct'] as $key => $value) {
			$features = $Products->seperatFeatureList($value['product_id']);		
			$featureCountMax += count($features)+$standardProductRow; // 5 Standardzeile
		}
		
		if(($featureCountMax % $rowPerPage) > 0) {
			if($featureCountMax < $rowPerPage) {
				$pages = 1;
			} else {
				$pages = ($featureCountMax - ($featureCountMax % $rowPerPage))/$rowPerPage + 1;
			}
			
		} else {
			$pages = $featureCountMax/$rowPerPage;
		}
		
					
		for($j = 0; $j <= $pages; $j++) {
			foreach ($cartProducts as $key => $value) {
				$features = $Products->seperatFeatureList($value['product_id']);
				$featureCount += count($features)+$standardProductRow; // 5 Standardzeile
				
				
								
				if($featureCount > $rowPerPage -5 || (count($cartProducts) == 1 && $pages > 1)) {
					$page[$j] = $prodArr;
					$featureCount = 0;
					$prodArr = array();
					array_push($prodArr, array('product' => $value , 'count' => count($features)+$standardProductRow));
					unset($cartProducts[$key]);
					$j++;
				} else {
					array_push($prodArr, array('product' => $value , 'count' => count($features)+$standardProductRow));
					unset($cartProducts[$key]);
					continue;
				}
			}	
			
			//auf die letzte Seite die restlichten Produkte packen
			if($j == $pages) {
				$addProdArr = array();
				
				if($calcRow > 0 ) {
					if(($featureCount + $calcRow) < $rowPerPage) {
						array_push($prodArr, 'C');
					} else {
						array_push($addProdArr, 'C');
					}
				}
					
				if(($featureCount + $calcRow + $textRow) < $rowPerPage) {
					array_push($prodArr, 'T');
				} else {
					array_push($addProdArr, 'T');
				}
				$page[$j] = $prodArr;
				
				if(!empty($addProdArr)) {
					$page[$j+1] = $addProdArr;
				}
			}
		}
		
		return $page;
		
	}

	


}
