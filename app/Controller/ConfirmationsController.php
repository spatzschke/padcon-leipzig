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
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'AddressAddresstype');
	public $components = array('Auth', 'Session', 'Paginator');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
			$this->Auth->allow('createPdf');
			
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
		$data = $this->Confirmation->find('all', array('order' => array('Confirmation.created DESC', 'Confirmation.id DESC'), 'limit' => 100));
			
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
	public function admin_add($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		if(!$id) {
			$confirmation = null;	
			$cart = $this->requestAction('/admin/carts/add/');
					
			$this->Confirmation->create();
			
			$confirmation['Confirmation']['status'] = 'open';
			$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
			$confirmation['Confirmation']['customer_id'] = '';
			$confirmation['Confirmation']['cart_id'] = $cart['Cart']['id'];
			$confirmation['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
			$confirmation['Confirmation']['order_date'] = date('Y-m-d');
			
			//Default settings
			$confirmation['Confirmation']['additional_text'] = Configure::read('padcon.Auftragsbestaetigung.additional_text.default');
			
			$this->Confirmation->save($confirmation);
			$id = $this->Confirmation->id;
			
			// Generate Hash für Offer
			$confirmation['Confirmation']['hash'] =  Security::hash($id, 'md5', true);
			$this->Confirmation->save($confirmation);

			$this->redirect(array('action'=>'add', $id));
		}

		$this->generateData($this->Confirmation->findById($id));
		
		$controller_name = 'Confirmations'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name','confirmation'));
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
		$controller_name = 'Confirmations'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name'));
		$this->set('pdf', null);
		$this->render('admin_add'); 
		
		
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

	public function admin_convert($confirmation_id = null) {
		$this->layout = 'admin';		
		if($confirmation_id) {
				
			$confirmation = $this->Offer->findById($confirmation_id);
			
			if(empty($confirmation['Offer']['confirmation_id'])) {
				
				$this->Confirmation->create();
				$confirmation['Confirmation']['status'] = 'open';
				$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
				$confirmation['Confirmation']['customer_id'] = $confirmation['Offer']['customer_id'];
				$confirmation['Confirmation']['offer_id'] = $confirmation['Offer']['id'];
				$confirmation['Confirmation']['discount'] = $confirmation['Offer']['discount'];
				$confirmation['Confirmation']['delivery_cost'] = $confirmation['Offer']['delivery_cost'];
				$confirmation['Confirmation']['vat'] = $confirmation['Offer']['vat'];
				$confirmation['Confirmation']['confirmation_price'] = $confirmation['Offer']['offer_price'];
				$confirmation['Confirmation']['order_date'] = date('Y-m-d');
				
				//Gernerierung der Auftragsbestätigungsnummer
				$confirmation['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
				
				//Default settings
				$confirmation['Confirmation']['additional_text'] = Configure::read('padcon.Auftragsbestaetigung.additional_text.default');
				
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
				
				//Erste AB-Adresse zum Kunden finden
				$Addresses = new AddressesController(); 
				$address = $Addresses->getAddressByType($confirmation, 2, TRUE);
				$confirmation['Confirmation']['address_id'] = $address['Address']['id'];
				
				$this->Confirmation->save($confirmation);
				$currConfirmationId = $this->Confirmation->getLastInsertId();
				
				//Neue Auftragsbestätigungs-ID der AB hinzufügen speichern 
				$confirmation['Confirmation']['id'] = $currConfirmationId;
				$this->Offer->save($confirmation);
				
				// Generate Hash für Offer
				$confirmation['Confirmation']['hash'] =  Security::hash($currConfirmationId, 'md5', true);
				$this->Confirmation->save($confirmation);
				
				//Neue Auftragsbestätigungs-ID in Angebot speichern 
				$confirmation['Offer']['confirmation_id'] = $currConfirmationId;
				$this->Offer->save($confirmation);
				
				$this->generateData($this->Confirmation->findById($currConfirmationId));
				
				$this->set('pdf', null);
				
				$controller_name = 'Confirmations'; 
				$controller_id = $confirmation_id;
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->render('admin_add');
				
			} else {
				$this->Session->setFlash(__('Auftragsbestätigung bereits vorhanden'));
				return $this->redirect(array('action' => 'edit', $confirmation['Offer']['confirmation_id']));
			}
		} else {
			
			if(!empty($this->request->data)) {
				
				$number = $this->data['Offer']['offer_number'];
								
				$offer = $this->Offer->findByOfferNumber($number);
				if(!empty($offer)) {
					return $this->redirect(array('action' => 'convert', $offer['Offer']['id']));
				} else {
					$this->Session->setFlash(__('Angebot mit Angebotsnummer nicht vorhanden.'));
				}
			}
			$this->set('title_for_panel', 'Auftragsbestätigung aus Angebot erstellen');
		}
		
	}

	function admin_settings($id = null) {
		
		$this->layout = 'ajax';

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$id = $this->request->data['Confirmation']['id'];
				
				$confirmation = $this->Confirmation->findById($id);
				
				$confirmation['Confirmation']['discount'] = $this->request->data['Confirmation']['discount'];
				$confirmation['Confirmation']['additional_text'] = $this->request->data['Confirmation']['additional_text'];
					
				if(!empty($this->request->data['Confirmation']['order_date'])) {
					$date = date_create_from_format('d.m.Y', $this->request->data['Confirmation']['order_date']);
					$confirmation['Confirmation']['order_date'] = date_format($date, 'Y-m-d');
				}	
				
				
				$confirmation['Confirmation']['order_number'] = $this->request->data['Confirmation']['order_number'];
								
				$confirmation['Confirmation']['delivery_cost'] = $this->request->data['Confirmation']['deliveryCost'];
				
				debug($confirmation['Confirmation']['delivery_cost']);
				
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
				
				if($confirmation['Confirmation']['order_date'] == '0000-00-00' || $confirmation['Confirmation']['order_date'] == null) {
					$confirmation['Confirmation']['order_date'] = date('d.m.Y');
				} else {
					$date = date_create_from_format('Y-m-d', $confirmation['Confirmation']['order_date']);
					$confirmation['Confirmation']['order_date'] = date_format($date, 'd.m.Y');
				}
				
				$confirmation['Confirmation']['cart_id'] = $confirmation['Confirmation']['cart_id'];
				
				if(empty($confirmation['Confirmation']['additional_text'])) {
					$confirmation['Confirmation']['additional_text'] = Configure::read('padcon.Auftragsbestaetigung.additional_text.default');
				} 
				
				
				
				
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
//				$this->request->data['Customer']['last_discount'] = $lastOfferByCustomer[1]['Confirmation']['discount'];
				
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
	
	function admin_update($id = null, $confirmation_id = null, $address = null) {
		$this->layout="ajax";
		
		$Addresses = new AddressesController();

		$confirmation = $this->Confirmation->findById($confirmation_id);					
		
		if($confirmation) {
			if(!is_null($address)) {
				$address = $this->Address->findById($address);
				$confirmation['Confirmation']['address_id'] = $address['Address']['id'];
				$confirmation['Confirmation']['Address'] = $address['Address'];
			} else {
			//Suche erste Adresse
				if(is_null($confirmation['Customer']['id'])) {
					$customer = $this->Customer->findById($id);
					$confirmation['Customer'] = $customer['Customer'];
					$confirmation['Confirmation']['customer_id'] =  $customer['Customer']['id'];
				}
			
				$confirmation = $Addresses->getAddressByType($confirmation, 2, TRUE);	
				$confirmation['Confirmation']['address_id'] = $confirmation['Address']['id'];				
			}
			
			$confirmation['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
			$confirmation['Confirmation']['customer_id'] = $id;
			
			
			if($this->Confirmation->save($confirmation)){
				$confirmation['Confirmation']['stat'] = 'saved';
			} else {
				$confirmation['Confirmation']['stat'] = 'not saved';
			}
		} else {
			$confirmation['Confirmation']['stat'] = 'error';
		}
		$this->Confirmation->save($confirmation);
		
		$this->request->data = $confirmation;
		$this->autoRender = false;
		$this->layout = 'admin';
	}
	
	function createPdf ($hash = null) { 
		$result = $this->Confirmation->findByHash($hash);
		if(!empty($result)) {
			$this->admin_createPdf($result['Confirmation']['id']);
		} 			
	}
	
	function admin_createPdf ($id= null){

		$this->layout = 'pdf';
		$pdf = true;
		
		$confirmation = $this->Confirmation->findById($id);
		
		$this->generateData($confirmation);
		
		$title = "Auftragsbestätigung_".str_replace('/', '-', $confirmation['Confirmation']['confirmation_number']);
		$this->set('title_for_layout', $title);
		
		
		
		$this->set('pdf', $pdf);
		$this->set(compact('confirmation','pdf'));
      	$this->render('admin_add'); 
	    
	}

	function search($searchString = null) {
	
		if($this->Auth) {
			echo $this->admin_search($searchString);
		} 		
	}
	
	function admin_search($searchString = null) {
		
		$this->layout = 'ajax';
		
		$data = $this->Confirmation->find('all',array('conditions' => array("OR" => 
			array (	'Confirmation.confirmation_number LIKE' => '%'.$this->data['str'].'%' ,
					'Confirmation.customer_id LIKE' 	=> '%'.$this->data['str'].'%' ,
					'Confirmation.id LIKE' 	=> '%'.$this->data['str'].'%')),
					'order' => array('Confirmation.created DESC', 'Confirmation.id DESC')));	
		
		$this->set('data', $this->fillIndexData($data));
		
		if(isset($this->data['template'])) {
			$this->render($this->data['template']);
		}
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
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart);
			
			$this->request->data += $cart;
		}


		if(is_null($this->request->data['Address']['id'])) {
			$this->request->data = $Addresses->getAddressByType($this->request->data, 2, TRUE);
		}
			
		if(!is_null($this->request->data['Address'])) {
			$a = $Addresses->splitAddressData($this->request->data);
			$this->request->data['Address'] += $a['Address'];
		}
		$this->request->data['Address']['count'] = $this->AddressAddresstype->find('count', array('conditions' => array(
			'customer_id' => $confirmation['Confirmation']['customer_id'],
			'type_id' => 1)));
			
		debug($this->request->data['Confirmation']);
		debug($this->calcPrice($this->request->data));

		$this->request->data['Confirmation'] += $this->calcPrice($this->request->data);
		
		return $this->calcPrice($this->request->data);

	}

	function calcPrice($data = null) {

		$arr_data = null;
		
		$discount_price = $data['Confirmation']['discount'] * $data['Cart']['sum_retail_price'] / 100;
		$part_price = $data['Cart']['sum_retail_price'] - $discount_price + $data['Confirmation']['delivery_cost'];
		$vat_price = $data['Confirmation']['vat'] * $part_price / 100;
		$data_price = floatval($part_price + $vat_price);
		
		if($data['Cart']['sum_retail_price'] > Configure::read('padcon.delivery_cost.versandkostenfrei_ab') || strpos($data['Confirmation']['additional_text'],"frei Haus.")!==false) {
			$delivery_cost = Configure::read('padcon.delivery_cost.frei');
		} else {
			if($data['Confirmation']['delivery_cost'] != Configure::read('padcon.delivery_cost.paeckchen')) {
				$delivery_cost = Configure::read('padcon.delivery_cost.paket');
			} else {
				$delivery_cost = Configure::read('padcon.delivery_cost.paeckchen');
			}
			
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
		
		// Auftragsbestätigung Nr.: 019/11/14
		// 019 = Anzahl der AB im Monat - dreistellig
		// 11 = aktueller Monat
		// 14 = aktuelles Jahr
		
		// 019 = Anzahl der AB im Monat - dreistellig
		$countMonthConfirmations = count($this->Confirmation->find('all',array('conditions' => array('Confirmation.created BETWEEN ? AND ?' => array(date('Y-m-01'), date('Y-m-d'))))));
		$countMonthConfirmations = str_pad($countMonthConfirmations, 3, "0", STR_PAD_LEFT);
		// 11 = aktueller Monat
		$month = date('m');
		// 14 = aktuelles Jahr
		$year = date('y');
		
		// Auftragsbestätigung Nr.: 019/11/14
		return $countMonthConfirmations.'/'.$month.'/'.$year;
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
					$item['Cart']['CartProduct'][$j]['Information'] = $product;
					$j++;
				}
			}

			$item['Confirmation'] += $this->calcPrice($item);
			
			//Finde Offernumber
			if($item['Confirmation']['offer_id'] != 0) {
				$offer = $this->Offer->findById($item['Confirmation']['offer_id']);
				$item['Confirmation']['offer_number'] = $offer['Offer']['offer_number'];
			}
						
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
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart);
			
			
			$this->request->data += $cart;
		}

		$Addresses = new AddressesController();	
		
				
		$this->request->data = $Addresses->getAddressByType($this->request->data, 2, TRUE);
		if(!is_null($this->request->data['Address'])) {
			$a = $Addresses->splitAddressData($this->request->data);
			$this->request->data['Address'] += $a['Address'];
		}
	
		$this->request->data['Confirmation'] += $this->calcPrice($this->request->data);
		
		return 	$this->calcPrice($this->request->data);

	}
	
	function getAddressByType($data = null , $type = null)
	{
		
		if(!empty($data['Customer']['Address'])) {
			$addresses = $data['Customer']['Address'];
			foreach ($addresses as $address) {
				if($address['type'] == $type) {					
					$data['Address'] = $address;
					return $data;
				}
			}
		} else {
			return $data;
		}
	}
	
}
