<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Addresses');
App::import('Controller', 'Carts ');
App::import('Controller', 'Customers');
App::import('Controller', 'Products');
/**
 * Confirmations Controller
 *
 * @property Confirmation $Confirmation
 * @property PaginatorComponent $Paginator
 */
class ConfirmationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation');
	public $components = array('Auth', 'Session', 'Paginator');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
			
		}
	}

/**
 * admin_index method
 *
 *  
*/

	function admin_index() {
		$this->layout = 'admin';
	
		$this->Confirmation->recursive = 0;
		$data = $this->Confirmation->find('all', array('order' => array('Confirmation.created DESC', 'Confirmation.id DESC')));
			
		$this->set('data', $this->fillIndexData($data));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
			
		$this->layout = 'admin';
			
		if (!$this->Confirmation->exists($id)) {
			throw new NotFoundException(__('Invalid confirmation'));
		}
		$options = array('conditions' => array('Confirmation.' . $this->Confirmation->primaryKey => $id));
		$confirmation = $this->Confirmation->find('first', $options);
		
		
		$this->set('confirmation', $confirmation);
		$this->set('pdf', null);
	
		$this->generateData($confirmation);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Confirmation->create();
			if ($this->Confirmation->save($this->request->data)) {
				$this->Session->setFlash(__('The confirmation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The confirmation could not be saved. Please, try again.'));
			}
		}

		
		$this->set('pdf', null);
		
		$confirmation = null;	
		
		$this->Confirmation->create();
		
		$confirmation['Confirmation']['status'] = 'active';
		$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
		$confirmation['Confirmation']['customer_id'] = '';
		$confirmation['Confirmation']['cart_id'] = $cart['Cart']['id'];
		
		$this->Confirmation->save($confirmation);

		$this->generateData($this->Confirmation->findById($this->Confirmation->id));
		
		$this->set(compact('confirmation'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		
		$this->layout = "admin";
		
		if (!$this->Confirmation->exists($id)) {
			throw new NotFoundException(__('Invalid confirmation'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Confirmation->save($this->request->data)) {
				$this->Session->setFlash(__('The confirmation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The confirmation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Confirmation.' . $this->Confirmation->primaryKey => $id));
			$confirmation = $this->Confirmation->find('first', $options);
			
			$this->generateData($confirmation);
		}
		$this->set('pdf', null);
		
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Confirmation->id = $id;
		if (!$this->Confirmation->exists()) {
			throw new NotFoundException(__('Invalid confirmation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Confirmation->delete()) {
			$this->Session->setFlash(__('The confirmation has been deleted.'));
		} else {
			$this->Session->setFlash(__('The confirmation could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_convertOffer($confirmation_id = null) {
		
		$this->layout = 'admin';
		
		$confirmation = $this->Offer->findById($confirmation_id);
		
		if(empty($confirmation['Offer']['confirmation_id'])) {
			
			$this->Confirmation->create();
			
			$confirmation['Confirmation']['status'] = 'active';
			$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
			$confirmation['Confirmation']['customer_id'] = $confirmation['Offer']['customer_id'];
			$confirmation['Confirmation']['offer_id'] = $confirmation['Offer']['id'];
			$confirmation['Confirmation']['discount'] = $confirmation['Offer']['discount'];
			$confirmation['Confirmation']['delivery_cost'] = $confirmation['Offer']['delivery_cost'];
			$confirmation['Confirmation']['vat'] = $confirmation['Offer']['vat'];
			$confirmation['Confirmation']['confirmation_price'] = $confirmation['Offer']['offer_price'];
			
			//Gernerierung der Auftragsbestätigungsnummer
			$confirmation['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
			
			//Warenkorb des Angebots kopieren
			$confirmationCart = $this->Cart->findById($confirmation['Cart']['id']);
			$confirmationCart['Cart']['id'] = NULL;
			$this->Cart->save($confirmationCart);
					
			$lastCartId = $this->Cart->getLastInsertId();
			$confirmation['Confirmation']['cart_id'] = $lastCartId;
			
			$cartProducts = $this->CartProduct->find('all',array('conditions' => array('CartProduct.cart_id' => $confirmation['Cart']['id'])));
			foreach ($cartProducts as $cartProduct) {
				$this->CartProduct->create();
				$cartItem['CartProduct'] = $cartProduct['CartProduct'];
				$cartItem['CartProduct']['cart_id'] = $lastCartId;
				unset($cartItem['CartProduct']['created']);
				unset($cartItem['CartProduct']['id']);
				unset($cartItem['CartProduct']['modified']);			
				$this->CartProduct->save($cartItem);
			}
			
			$this->Confirmation->save($confirmation);
			
			$currConfirmationId = $this->Confirmation->getLastInsertId();
			
			//Neue Auftragsbestätigungs-ID in Angebot speichern 
			$confirmation['Offer']['confirmation_id'] = $currConfirmationId;
			$this->Offer->save($confirmation);
			
			$this->generateData($this->Confirmation->findById($currConfirmationId));
			
			$this->set('pdf', null);
			
			$this->render('admin_add');
			
		} else {
			$this->Session->setFlash(__('Auftragsbestätigung bereits vorhanden'));
			return $this->redirect(array('action' => 'edit', $confirmation['Offer']['confirmation_id']));
		}
		
	}

	function admin_settings($id = null) {
		
		$this->layout = 'ajax';

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$confirmation = $this->Confirmation->findById($this->request->data['Confirmation']['id']);
				
				$confirmation['Confirmation']['discount'] = $this->request->data['Confirmation']['discount'];
				$confirmation['Confirmation']['additional_text'] = $this->request->data['Confirmation']['additional_text'];
				$confirmation['Confirmation']['request_date'] = $this->request->data['Confirmation']['request_date']['year']."-".$this->request->data['Confirmation']['request_date']['month']."-".$this->request->data['Confirmation']['request_date']['day'];
				
				if($this->Confirmation->save($confirmation)){
					$this->Session->setFlash(__('Speicherung erfolgreich', true));
				} else {
					$this->Session->setFlash(__('Es kam zu Fehlern beim Speichern', true));
				}
				
				$confirmation = $this->Confirmation->findById($id);
				$confirmation['CartProducts'] = $this->getSettingCartProducts($confirmation);
				
				$cart = $this->Cart->findById($confirmation['Confirmation']['cart_id']);
				$controller_id = 0;
				$controller_name = '';
				if(isset($cart['Confirmation']['id'])) {
					$controller_name = 'Offers';
					$controller_id = $cart['Confirmation']['id'];
				}
				if(isset($cart['Confirmation']['id'])) {
					$controller_name = 'Confirmations'; 
					$controller_id = $cart['Confirmation']['id'];
				}
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->request->data = $confirmation;
							
			} else {
				$confirmation = $this->Confirmation->findById($id);
				
				if($confirmation['Confirmation']['order_date'] == '0000-00-00') {
					$confirmation['Confirmation']['order_date'] = date('Y-m-d');
				}
				
				$confirmation['Confirmation']['cart_id'] = $confirmation['Confirmation']['cart_id'];
				$confirmation['Confirmation']['additional_text'] = '
Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto<br />
Lieferung frei Haus<br />
Lieferzeit: ca. 40. KW 2014
				';
				
				
				$confirmation['CartProducts'] = $this->getSettingCartProducts($confirmation);
				
				$cart = $this->Cart->findById($confirmation['Confirmation']['cart_id']);
				$controller_id = 0;
				$controller_name = '';
				
				$controller_name = 'Confirmations'; 
				$controller_id = $cart['Confirmation']['id'];

				$this->set(compact('controller_id', 'controller_name'));
				
				$this->request->data = $confirmation;
				
				$lastOfferByCustomer = $this->Confirmation->find('all', array(
					'order' => array('Confirmation.id' => 'desc'),
			        'conditions' => array('Customer.id' => $confirmation['Customer']['id'])
			    ));
				$this->request->data['Customer']['last_discount'] = $lastOfferByCustomer[1]['Confirmation']['discount'];
				
			    // Use data from serialized form

			    $this->render('admin_settings', 'ajax'); 
			}
		}
	}

	function admin_removeProductFromConfirmations($id = null, $confirmation_id = null) {
		
		$this->layout = 'ajax';
		$this->autoRender = false;
		
		$confirmation = $this->Confirmation->findById($confirmation_id);
		
		//Lösche Eintrag
		if ($id) {
			$this->CartProduct->delete($id);
		}
		$Carts = new CartsController();		
		
		$Carts->updateCartCount($confirmation['Cart']);
		
		$confirmation['CartProducts'] = $this->getSettingCartProducts($confirmation);
		$this->request->data = $confirmation;
		
		$this->render('/Elements/backend/portlets/Product/settingsProductTable');
	}
		
	function getSettingCartProducts($confirmation = null) {
		$cart = $this->Cart->find('first', array(
			'conditions' => array(
			 	'Cart.id' => $confirmation['Cart']['id']
				)
			)
		);
		
		$cartProductsNew = array();
		
		foreach ($cart['CartProduct'] as $cartEntry) {

			$tempCartProducts = array();

			$product = $this->Product->find('first', array(
			'conditions' => array(
			 	'Product.id' => $cartEntry['product_id'],
				),
			'fields' => array('Product.name', 'Product.product_number')
			));
			
			unset($product['Image']);
			unset($product['Cart']);
			
			$color = $this->Color->find('first', array(
			'conditions' => array(
			 	'Color.id' => $cartEntry['color_id'],
				),
			'fields' => array('Color.name', 'Color.code', 'Color.rgb')
			));
			
			
			$product['Product']['cartProduct_id'] = $cartEntry['id'];
			$product['Product']['amount'] = $cartEntry['amount'];
			$product += $color;
			$tempCartProducts += $product;
			array_push($cartProductsNew, $tempCartProducts);
						
		}
		return $cartProductsNew;
	}

	function generateData($confirmation = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
	
		if(!$confirmation) {
			$confirmation_id = $this->Confirmation->getLastInsertId();
			$confirmation = $this->Confirmation->findById($confirmation_id);		
		} 
			
	    $this->request->data = $confirmation;
		
		
		if(!empty($confirmation)) {
			
	    	$cart = $Carts->get_cart_by_id($confirmation['Cart']['id']);
			
			$this->request->data['Cart']['CartProduct'] = $cart['CartProduct'];
		}
	
		
	
		if(!is_null($this->request->data['Customer']['id'])) {
			
			$customerAddresses = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $this->request->data['Customer']['id'])));
			$this->request->data['Customer']['Addresses'] = array();
						
			foreach ($customerAddresses as $address) {						
				array_push($this->request->data['Customer']['Addresses'], $Addresses->splitAddressData($address['Address']));
			}
			
		}
		
		
		
		$this->request->data = $Addresses->getAddressByType($this->request->data, 2);
		$this->request->data['Confirmation'] += $this->calcPrice($this->request->data);
		return $this->calcPrice($this->request->data);

	}

	function calcPrice($data = null) {

		$arr_data = null;
		
		$discount_price = $data['Confirmation']['discount'] * $data['Cart']['sum_retail_price'] / 100;
		$part_price = $data['Cart']['sum_retail_price'] - $discount_price + $data['Confirmation']['delivery_cost'];
		$vat_price = $data['Confirmation']['vat'] * $part_price / 100;
		$data_price = floatval($part_price + $vat_price);
		
		if($data['Cart']['sum_retail_price'] > 500) {
			$delivery_cost = 0;
		} else {
			$delivery_cost = 8;
		}
		
		$arr_data['Confirmation']['delivery_cost'] = $delivery_cost;
		$arr_data['Confirmation']['vat_price'] = $vat_price;
		$arr_data['Confirmation']['discount_price'] = $discount_price;
		$arr_data['Confirmation']['part_price'] = $part_price;
		
		if($data['Cart']['sum_retail_price'] == 0) {
			$arr_data['Confirmation']['confirmation_price'] = 0;
		} else {
			$arr_data['Confirmation']['confirmation_price'] = $data_price;
		}	
		
		$arr_data['Confirmation']['id'] = $data['Confirmation']['id'];

		$this->Confirmation->save($arr_data['Confirmation']);
				
		return $arr_data['Confirmation'];
	}

	function generateConfirmationNumber() {
	
		// Anzahl aller Auftragsbestätigungen im Monat / Aktueller Monat / Aktuelles Jahr		
		$countMonth = count($this->Confirmation->find('all',array('conditions' => array('Confirmation.created BETWEEN ? AND ?' => array(date('Y-m-01'), date('Y-m-d'))))));
		return str_pad($countMonth, 3, "0", STR_PAD_LEFT).'/'.date('m').'/'.date('y');
	}
	
	function fillIndexData($data = null) {
	
		$data_temp = array();
		$Carts = new CartsController();
		$Products = new ProductsController();
		$Customers = new CustomersController();
		
		// for($i=0; $i<=10;$i++) {
		foreach ($data as $item) {
			
			//$item = $items[$i];
	
			if($Customers->splitCustomerData($item)) {
				
				$item['Customer'] += $Customers->splitCustomerData($item);
			}			
			
			$cart = $Carts->get_cart_by_id($item['Cart']['id']);
			$item['Cart']['CartProduct'] = $cart['CartProduct'];
			if(!empty($cart['CartProduct'])) {
				$j = 0;
				foreach ($cart['CartProduct'] as $cartProd) {
					$product = $Products->getProduct($cartProd['product_id']);
					unset($product['Cart']);
					unset($product['Category']);
					unset($product['Material']);
					unset($product['Size']);
					$item['Cart']['CartProduct'][$j]['Information'] = $product;
					$j++;
				}
			}

			$item['Confirmation'] += $this->calcPrice($item);
						
			array_push($data_temp, $item);
			
		}	
			
		return $data_temp;
	}

	function reloadSheet($id = null) {
		$this->layout = 'ajax';
		$this->set('pdf', null);
		
		$confirmation = $this->Confirmation->findById($id);
		
		$this->generateData($confirmation);
		$calc = $this->calcPrice($confirmation);
		
		$this->request->data['Confirmation']['confirmation_price'] = $calc['confirmation_price'];
		
		$this->render('/Elements/backend/SheetConfirmation');
	}
	
	function generateSheetData($data= null) {
	
		if(!$data) {
			return null;	
		} 
			
	    $this->request->data = $data;
		
		if(!empty($data)) {
			$Carts = new CartsController();
	    	$cart = $Carts->get_cart_by_id($data['Cart']['id']);
			$this->request->data['Cart']['CartProduct'] = $cart['CartProduct'];
		}

		
		
		if(!is_null($this->request->data['Customer']['id'])) {
			$split_str = $this->splitAddressData($data);
			if(!is_null($split_str)) {	
				$this->request->data['Customer'] = $this->request->data['Customer'] + array();
				$this->request->data['Customer'] += $split_str;
			}
		}
				
		$this->request->data = $this->getAddressByType($this->request->data, 1);
	
		$this->request->data['Offer'] += $this->calcOfferPrice($this->request->data);
		
		return 	$this->calcOfferPrice($this->request->data);

	}
}
