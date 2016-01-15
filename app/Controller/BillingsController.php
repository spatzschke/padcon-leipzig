<?php
App::import('Controller', 'Offers');
App::import('Controller', 'Carts');
App::import('Controller', 'Confirmations');

App::uses('AppController', 'Controller');
/**
 * Billings Controller
 *
 * @property Billing $Billing
 * @property PaginatorComponent $Paginator
 */
class BillingsController extends AppController {

	
	public $uses = array('Billing', 'Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'Delivery');
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
			$this->Auth->allow('createPdf');
			
		}
	}
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		
		$this->layout = "admin";
		$data = $this->Billing->find('all', array('order' => array('Billing.created DESC', 'Billing.id DESC'), 'limit' => 100));
			
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
		
		$this->layout = "admin";
		
		if (!$this->Billing->exists($id)) {
			throw new NotFoundException(__('Invalid billing'));
		}
		$options = array('conditions' => array('Billing.' . $this->Billing->primaryKey => $id));
		$data = $this->Billing->find('first', $options);
		
		$delivery = $this->Delivery->findById($data['Confirmation']['delivery_id']);
		$this->generateData($data, $delivery['Delivery']['cart_id']);

		
		$controller_name = 'Deliveries'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name'));
		$this->set('pdf', null);
	}
	
	public function admin_edit($id = null) {
		$this->admin_view($id);
		$this->render('admin_view');
	}
	

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_convert($confirmation_id = null) {
		$this->layout = 'admin';		
		if($confirmation_id) {
				
			$confirmation = $this->Confirmation->findById($confirmation_id);
			$billing = array();
			
			if(empty($confirmation['Confirmation']['billing_id'])) {
				
				$this->Billing->create();
				
				$billing['Billing']['status'] = 'open';
				$billing['Billing']['confirmation_id'] = $confirmation['Confirmation']['id'];
				
				//Default Settings
				$billing['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
		
				
				//Gernerierung der REchnungsnummer
				$billing['Billing']['billing_number'] = $this->generateBillingNumber();
				$billing['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
				
				//Zahlungsziel anhand des Standardtextes bestimmen
				$billing['Billing']['payment_target'] = date('Y-m-d', strtotime("+30 days"));;
				
				//Erste AB-Adresse zum Kunden finden
				$Addresses = new AddressesController(); 
				$address = $Addresses->getAddressByType($confirmation, 3, TRUE);
				$billing['Billing']['address_id'] = $address['Address']['id'];
				
				$this->Billing->save($billing);
				
				$currBillingId = $this->Billing->getLastInsertId();
				
				// Generate Hash für Offer
				$billing['Billing']['hash'] =  Security::hash($currBillingId, 'md5', true);
				$this->Billing->save($billing);
				
				//Neue Rechnungs-ID in AB speichern 
				$confirmation['Confirmation']['billing_id'] = $currBillingId;
				$this->Confirmation->save($confirmation);
				
				$delivery = $this->Delivery->findById($confirmation['Confirmation']['delivery_id']);
								
				$this->generateData($this->Billing->findById($currBillingId), $delivery['Delivery']['cart_id']);
				
				$this->set('pdf', null);
				
				$controller_name = 'Billings'; 
				$controller_id = $currBillingId;
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->render('admin_view');
				
			} else {
				$this->Session->setFlash(__('Rechnung bereits vorhanden'));
				return $this->redirect(array('action' => 'view', $confirmation['Confirmation']['billing_id']));
			}
		} else {
			
			if(!empty($this->request->data)) {
				
				$number = $this->data['Confirmation']['confirmation_number'];
								
				$confirmation = $this->Confirmation->findByConfirmationNumber($number);
				if(!empty($confirmation)) {
					return $this->redirect(array('action' => 'convert', $confirmation['Confirmation']['billing_id']));
				} else {
					$this->Session->setFlash(__('Rechnung mit Rechnungsnummer nicht vorhanden.'));
				}
			}
			$this->set('title_for_panel', 'Rechnung aus Auftragsbestätigung erstellen');
		}
	}

	function admin_table_setting($id = null) {
		
		$this->layout = 'ajax';
		
		$data = $this->Billing->findById($id);
		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$date = new DateTime($this->request->data['Billing']['payment_target']);
				$payment_date = $date->format('Y-m-d');
				if(!empty($this->request->data['Billing']['payment_date']) && strcmp('1970-01-01', $payment_date) != 0) {
					$this->request->data['Billing']['payment_date'] = date('Y-m-d',strtotime($this->request->data['Billing']['payment_date']));
					if(strcmp($data['Billing']['status'],'cancel') != 0) {
						$this->request->data['Billing']['status'] = 'close'; 
					}
				} else {
					$this->request->data['Billing']['payment_date'] = null;
					if(strcmp($this->request->data['Billing']['status'],'cancel') != 0) {
						$this->request->data['Billing']['status'] = 'open'; 
					}
				}
				
				$date = new DateTime($this->request->data['Billing']['payment_target']);
				$payment_target = $date->format('Y-m-d');
				if(!empty($this->request->data['Billing']['payment_target']) && strcmp('1970-01-01', $payment_target) != 0) {
					$this->request->data['Billing']['payment_target'] = date('Y-m-d',strtotime($this->request->data['Billing']['payment_target']));	
				} else {
					$this->request->data['Billing']['payment_target'] = null;
				}

				$this->request->data['Billing']['created'] = date('Y-m-d',strtotime($this->request->data['Billing']['created']));

				$this->Billing->id = $this->request->data['Billing']['id'];
				$this->Billing->save($this->request->data);
							
			} else {
				$date = date_create_from_format('Y-m-d h:i:s', $data['Billing']['created']);				
				$data['Billing']['created'] = date_format($date, 'd.m.Y');
				
				$date = new DateTime($data['Billing']['payment_target']);
				$payment_target = $date->format('Y-m-d');
				if(!is_null($data['Billing']['payment_target']) && strcmp('1970-01-01', $payment_target) != 0) {
					$data['Billing']['payment_target'] = date('d.m.Y',strtotime($data['Billing']['payment_target']));
				} else {
					$data['Billing']['payment_target'] = null;
				}
				
				$date = new DateTime($data['Billing']['payment_date']);
				$payment_date = $date->format('Y-m-d');
				if(!is_null($data['Billing']['payment_date']) && strcmp('1970-01-01', $payment_date) != 0) {
					$data['Billing']['payment_date'] = date('d.m.Y',strtotime($data['Billing']['payment_date']));
				} else {
					$data['Billing']['payment_date'] = null;
				}
				
				$this->request->data = $data;
				
			}
		}
		
		$controller_name = 'Billings'; 
		$controller_id = $data['Billing']['id'];
		
		$this->set(compact('controller_id', 'controller_name'));
	}

	function admin_update($customer_id = null, $data_id = null, $address = null) {
		$this->layout="ajax";
		
		$Addresses = new AddressesController();

		$data = $this->Billing->findById($data_id);					
		
		if($data) {
			if(!is_null($address)) {
				$address = $this->Address->findById($address);
				$data['Billing']['address_id'] = $address['Address']['id'];
				$data['Billing']['Address'] = $address['Address'];
			} else {
			//Suche erste Adresse
				if(is_null($data['Customer']['id'])) {
					$customer = $this->Customer->findById($customer_id);
					$data['Customer'] = $customer['Customer'];
					$data['Confirmation']['customer_id'] =  $customer['Customer']['id'];
				}
			
				$data = $Addresses->getAddressByType($data, 2, TRUE);	
				$data['Billing']['address_id'] = $data['Address']['id'];				
			}
			
			if(empty($data['Billing']['billing_number'])) {
				$data['Billing']['billing_number'] = $this->generateBillingNumber();
			}
			$data['Confirmation']['customer_id'] = $customer_id;
			$this->Billing->save($data);
		} else {
			
		}
		
		$this->request->data = $data;
		$this->autoRender = false;
		$this->layout = 'admin';
	}

	function admin_settings($id = null) {
		
		$this->layout = 'ajax';

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$id = $this->request->data['Billing']['id'];
				
				$data = $this->Billing->findById($id);
				
				$data['Billing']['additional_text'] = $this->request->data['Billing']['additional_text'];
				
				//Filtere Zahlungsziel aus Text heraus
				$text = $this->request->data['Billing']['additional_text'];
				
				$plus = explode('% Skonto oder', $text);
				$plus = explode('Tage', $plus[1]);
				$data['Billing']['payment_target'] = date('Y-m-d', strtotime("+".trim($plus[0])." days"));
					
				if($this->Billing->save($data)){
					$this->Session->setFlash(__('Speicherung erfolgreich', true));
				} else {
					$this->Session->setFlash(__('Es kam zu Fehlern beim Speichern', true));
				}
				
				$data = $this->Billing->findById($id);
				
				$controller_id = $id;
				$controller_name = 'Billings'; 
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->request->data = $data;
							
			} else {
				$data = $this->Billing->findById($id);

				$data['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
				
				$controller_name = 'Billings'; 
				$controller_id = $data['Billing']['id'];

				$this->set(compact('controller_id', 'controller_name'));
				
				$this->request->data = $data;
			
			    $this->render('admin_settings', 'ajax'); 
			}
		}
	}

	function createPdf ($hash = null) { 
		$result = $this->Billing->findByHash($hash);
		if(!empty($result)) {
			$this->admin_createPdf($result['Billing']['id']);
		} 			
	}

	function admin_createPdf ($id= null){

		$this->layout = 'pdf';
		$pdf = true;
		
		$data = $this->Billing->findById($id);
		
		$delivery = $this->Delivery->findById($data['Confirmation']['delivery_id']);
		$this->generateData($data, $delivery['Delivery']['cart_id']);
		
				
		$title = "Rechnung_".str_replace('/', '-', $data['Billing']['billing_number']);
		$this->set('title_for_layout', $title);
		
		$this->set('pdf', $pdf);
		$this->set(compact('data','pdf'));
      	$this->render('admin_view'); 
	    
	}

	function admin_payed($id = null) {
		$data['Billing']['id'] = $id;
		
		$data['Billing']['payment_date'] = date("y-m-d");
		$data['Billing']['status'] = "close";
		
		$this->Billing->id = $id;
		$this->Billing->save($data);
		
		$this->redirect('index');
		
	}

	function generateBillingNumber() {
	
		// Rechnung Nr.: 427/14
		// 427 = laufende Rechnung im Jahr - dreistellig
		// 14 = laufendes Jahr
	
		// 427 = laufende Rechnung im Jahr
		$countYearBillings = count($this->Billing->find('all',array('conditions' => array('Billing.created BETWEEN ? AND ?' => array(date('Y-01-01 00:00:01'), date('Y-m-d 23:59:59'))))))+1;
		$countYearBillings = str_pad($countYearBillings, 3, "0", STR_PAD_LEFT);
		// 14 = aktuelles Jahr
		$year = date('y');
		
		debug($countYearBillings);
		
		// Rechnung Nr.: 427/14
		return $countYearBillings.'/'.$year;
	}
	
	function generateData($data = null, $cart_id = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
		$Confirmations = new ConfirmationsController();
	
	    $this->request->data = $data;
		
		if(!empty($data)) {
			
	    	$cart = $Carts->get_cart_by_id($cart_id);
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart, 7, 5);
	
			$cart = $Carts->calcSumPrice($cart);
			
			$this->request->data['Cart'] = $cart['Cart'];
		
			$this->request->data += $cart;
			$this->request->data['Cart']['count'] = count($cart['CartProduct']);
		}
		
		//Customer holen
		$this->Customer->recursive = 0;
		$this->request->data += $this->Customer->findById($this->request->data['Confirmation']['customer_id']);
		
	
		$addressDelivery = array();
		if(isset($this->request->data['Address']) && ($this->request->data['Address']['id'] != $this->request->data['Billing']['address_id']) ) {
			$addressDelivery = $this->Address->findById($this->request->data['Billing']['address_id']);
			$this->request->data['Address'] = $addressDelivery['Address'];
		} else {
			if(isset($this->request->data['Billing']['address_id'])) {
				$addressDelivery = $this->Address->findById($this->request->data['Billing']['address_id']);
				$this->request->data['Address'] = $addressDelivery['Address'];
			} else {
				$this->request->data = $Addresses->getAddressByType($this->request->data, 4, TRUE);
			}
		}
		
		if(!is_null($this->request->data['Address'])) {
			$a = $Addresses->splitAddressData($this->request->data);
			$this->request->data['Address'] += $a['Address'];
		}
		
		$confirmation = $Confirmations->calcPrice($this->request->data);		
		$this->request->data['Confirmation'] += $confirmation;		

		//Nachladen des Lieferscheins
		$delivery = $this->Delivery->find('first', array('conditions' => array('Delivery.id' => $this->request->data['Confirmation']['delivery_id'])));
		$this->request->data['Delivery'] = $delivery['Delivery'];

		return $Confirmations->calcPrice($this->request->data);

	}	

	function reloadSheet($id = null) {
		$this->layout = 'ajax';
		$this->set('pdf', null);
		
		$Confirmations = new ConfirmationsController();
		
		$data = $this->Billing->findById($id);
		
		$delivery = $this->Delivery->findById($data['Confirmation']['delivery_id']);
		$this->generateData($data, $delivery['Delivery']['cart_id']);
		
		$calc = $Confirmations->calcPrice($this->request->data);
		
		$this->request->data['Confirmation']['confirmation_price'] = $calc['confirmation_price'];		
		$this->render('/Elements/backend/SheetBilling');
	}

	function fillIndexData($data = null) {
	
		$data_temp = array();
		$Carts = new CartsController();
		$Products = new ProductsController();
		$Customers = new CustomersController();
		$Confirmations = new ConfirmationsController();
		
		
		// for($i=0; $i<=10;$i++) {
		foreach ($data as $item) {
						
			//Load Customer for the Delivery
			$customer= $this->Customer->findById($item['Confirmation']['customer_id']);
			$address = $this->Address->findById($item['Billing']['address_id']);
			$customer['Address'] = $address['Address'];

			$item['Customer'] = $customer['Customer'];
			
			if($Customers->splitCustomerData($customer)) {
				$item['Address'] = $Customers->splitCustomerData($customer);
			}				
			
			$cart = $Carts->get_cart_by_id($item['Confirmation']['cart_id']);
			$item['Cart'] = $cart['Cart'];
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

			$item['Billing'] += $Confirmations->calcPrice($item);
			
			
			//Auftragsbestätigung
			$confirmation = $this->Confirmation->findByBillingId($item['Billing']['id']);
			$item['Billing']['confirmation_number'] = $confirmation['Confirmation']['confirmation_number'];
			
			//Lieferschein
			$delivery = $this->Delivery->findById($item['Confirmation']['delivery_id']);
			$item['Billing']['delivery_number'] = $delivery['Delivery']['delivery_number'];

						
			array_push($data_temp, $item);
			
		}	
			
		return $data_temp;
	}
}
