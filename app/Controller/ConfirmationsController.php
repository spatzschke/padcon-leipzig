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
			
		$this->set('data', $this->fillIndexData($this->paginate()));
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
		
		$offer = null;	
		
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
			$this->request->data = $this->Confirmation->find('first', $options);
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

	public function admin_convertOffer($offer_id = null) {
		
		$this->layout = 'admin';
		
		$offer = $this->Offer->findById($offer_id);
		
		if(empty($offer['Offer']['confirmation_id'])) {
			
			$this->Confirmation->create();
			
			$confirmation['Confirmation']['status'] = 'active';
			$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
			$confirmation['Confirmation']['customer_id'] = $offer['Offer']['customer_id'];
			$confirmation['Confirmation']['offer_id'] = $offer['Offer']['id'];
			$confirmation['Confirmation']['discount'] = $offer['Offer']['discount'];
			$confirmation['Confirmation']['delivery_cost'] = $offer['Offer']['delivery_cost'];
			$confirmation['Confirmation']['vat'] = $offer['Offer']['vat'];
			$confirmation['Confirmation']['confirmation_price'] = $offer['Offer']['offer_price'];
			
			//Gernerierung der Auftragsbestätigungsnummer
			$confirmation['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
			
			//Warenkorb des Angebots kopieren
			$offerCart = $this->Cart->findById($offer['Cart']['id']);
			$offerCart['Cart']['id'] = NULL;
			$this->Cart->save($offerCart);
					
			$lastCartId = $this->Cart->getLastInsertId();
			$confirmation['Confirmation']['cart_id'] = $lastCartId;
			
			$cartProducts = $this->CartProduct->find('all',array('conditions' => array('CartProduct.cart_id' => $offer['Cart']['id'])));
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
			$offer['Offer']['confirmation_id'] = $currConfirmationId;
			$this->Offer->save($offer);
			
			$this->generateData($this->Confirmation->findById($currConfirmationId));
			
			$this->set('pdf', null);
			
			$this->render('admin_add');
			
		} else {
			$this->Session->setFlash(__('Auftragsbestätigung bereits vorhanden'));
			return $this->redirect(array('action' => 'edit', $offer['Offer']['confirmation_id']));
		}
		
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
			$arr_data['Confirmation']['price'] = 0;
		} else {
			$arr_data['Confirmation']['price'] = $data_price;
		}
		
		
		$arr_data['Confirmation']['id'] = $data['Confirmation']['id'];

		$this->Offer->save($arr_data['Confirmation']);
				
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
		
		$this->generateData($this->Confirmation->findById($id));
		
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
