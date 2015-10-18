<?php
App::import('Controller', 'Offers');
App::import('Controller', 'Carts');
App::import('Controller', 'Confirmations');

App::uses('AppController', 'Controller');
/**
 * Deliveries Controller
 *
 * @property Delivery $Delivery
 * @property PaginatorComponent $Paginator
 */
class DeliveriesController extends AppController {

	public $uses = array('Delivery', 'Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'Billing');
	
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
	function admin_index() {
		$this->layout = 'admin';
	
		$this->Delivery->recursive = 0;
		$data = $this->Delivery->find('all', array('order' => array('Delivery.created DESC', 'Delivery.id DESC'), 'limit' => 100));
			
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
		if (!$this->Delivery->exists($id)) {
			throw new NotFoundException(__('Invalid delivery'));
		}
		$options = array('conditions' => array('Delivery.' . $this->Delivery->primaryKey => $id));
		$data = $this->Delivery->find('first', $options);		
		
		$this->generateData($data);
		$controller_name = 'Deliveries'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name'));
		$this->set('pdf', null);
	}

	public function admin_convert($confirmation_id = null) {
		$this->layout = 'admin';		
		if($confirmation_id) {
				
			$confirmation = $this->Confirmation->findById($confirmation_id);
			$delivery = array();
			
			if(empty($confirmation['Confirmation']['delivery_id'])) {
				
				$this->Delivery->create();
				
				$delivery['Delivery']['status'] = 'open';
				$delivery['Delivery']['confirmation_id'] = $confirmation['Confirmation']['id'];
				
				//Gernerierung der Auftragsbestätigungsnummer
				$delivery['Delivery']['delivery_number'] = $this->generateDeliveryNumber();
				$this->Delivery->save($delivery);
				
				$currDeliveryId = $this->Delivery->getLastInsertId();
				
				//Neue Lieferschein-ID in AUftragsbestäätigung speichern 
				$confirmation['Confirmation']['delivery_id'] = $currDeliveryId;
				$this->Confirmation->save($confirmation);
				
				$this->generateData($this->Delivery->findById($currDeliveryId));
				
				$this->set('pdf', null);
				
				$controller_name = 'Deliveries'; 
				$controller_id = $currDeliveryId;
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->render('admin_view');
				
			} else {
				$this->Session->setFlash(__('Lieferschein bereits vorhanden'));
				return $this->redirect(array('action' => 'view', $confirmation['Confirmation']['delivery_id']));
			}
		} else {
			
			if(!empty($this->request->data)) {
				
				$number = $this->data['Confirmation']['confirmation_number'];
								
				$confirmation = $this->Confirmation->findByConfirmationNumber($number);
				if(!empty($confirmation)) {
					return $this->redirect(array('action' => 'convert', $confirmation['Confirmation']['id']));
				} else {
					$this->Session->setFlash(__('Rechnung mit Rechnungsnummer nicht vorhanden.'));
				}
			}
			$this->set('title_for_panel', 'Rechnung aus Auftragsbestätigung erstellen');
		}
	}

	function admin_settings($id = null) {
		
		$this->layout = 'ajax';


		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$id = $this->request->data['Delivery']['id'];
				
				$data = $this->Billing->findById($id);
				
				$data['Delivery']['additional_text'] = $this->request->data['Delivery']['additional_text'];
					
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

				$data['Delivery']['additional_text'] = '
Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto<br />
Lieferung frei Haus<br />
Lieferzeit: ca. 3-4 Wochen
				';
				
				$controller_name = 'Billings'; 
				$controller_id = $data['Delivery']['id'];

				$this->set(compact('controller_id', 'controller_name'));
				
				$this->request->data = $data;
			
			    $this->render('admin_settings', 'ajax'); 
			}
		}
	}

	function admin_createPdf ($id= null){

		$this->layout = 'pdf';
		$pdf = true;
		
		$data = $this->Billing->findById($id);
		
		
		$this->generateData($data);
		
				
		$title = "Rechnung_".str_replace('/', '-', $data['Delivery']['billing_number']);
		$this->set('title_for_layout', $title);
		
		$this->set('pdf', $pdf);
		$this->set(compact('data','pdf'));
      	$this->render('admin_view'); 
	    
	}

	function generateDeliveryNumber() {
	
		// Lieferschein Nr.: 01711/478
		// 017 = laufende Anzahl im Monat
		// 11 = aktueller Monat
		// 478 = laufende Anzahl im Jahr
		
		// 017 = laufende Anzahl im Monat
		$countMonthDeliveries = count($this->Delivery->find('all',array('conditions' => array('Delivery.created BETWEEN ? AND ?' => array(date('Y-m-01'), date('Y-m-d'))))))+1;
		$countMonthDeliveries = str_pad($countMonthDeliveries, 2, "0", STR_PAD_LEFT);
		// 11 = aktueller Monat
		$month = date('m');
		// 017 = laufende Anzahl im Jahr
		$countYearDeliveries = count($this->Delivery->find('all',array('conditions' => array('Delivery.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d'))))))+1;
		$countYearDeliveries = str_pad($countYearDeliveries, 2, "0", STR_PAD_LEFT);
		
		// Lieferschein Nr.: 01711/478
		return $countMonthDeliveries.$month.'/'.$countYearDeliveries;
	}
	
	function generateData($data = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
		$Confirmations = new ConfirmationsController();
	
		if(!$data) {
			$confirmation_id = $data['Delivery']['confirmation_id'];
			$data = $this->Confirmation->findById($confirmation_id);		
		} 
			
	    $this->request->data = $data;
		
		if(!empty($data)) {
			
	    	$cart = $Carts->get_cart_by_id($data['Confirmation']['cart_id']);
	
			$cart = $Carts->calcSumPrice($cart);
			
			$this->request->data['Cart'] = $cart['Cart'];
		
			$this->request->data['Cart']['CartProduct'] = $cart['CartProduct'];
			$this->request->data['Cart']['count'] = count($cart['CartProduct']);
		}
		
	
		if(!is_null($this->request->data['Confirmation']['customer_id'])) {
			
			$customer = $this->Customer->find('first', array('conditions' => array('Customer.id' => $this->request->data['Confirmation']['customer_id'])));
			$this->request->data['Customer'] = $customer['Customer'];
			
			$customerAddresses = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $this->request->data['Confirmation']['customer_id'])));
			$this->request->data['Customer']['Addresses'] = array();
						
			foreach ($customerAddresses as $address) {						
				array_push($this->request->data['Customer']['Addresses'], $Addresses->splitAddressData($address['Address']));
			}
			
		}
		
		$this->request->data = $Addresses->getAddressByType($this->request->data, 3);
		
		$confirmation = $Confirmations->calcPrice($this->request->data);		
		$this->request->data['Confirmation'] += $confirmation;		

		return $Confirmations->calcPrice($this->request->data);

	}	

	function reloadSheet($id = null) {
		$this->layout = 'ajax';
		$this->set('pdf', null);
		
		$Confirmations = new ConfirmationsController();
		
		$data = $this->Billing->findById($id);
		
		$this->generateData($data);
		
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
			$address = $this->Address->findById($item['Delivery']['address_id']);
			$customer['Address'] = $address['Address'];
			$item['Customer'] = $customer['Customer'];
			
			if($Customers->splitCustomerData($customer)) {
				$item['Address'] = $Customers->splitCustomerData($customer);
			}			

			$cart = $Carts->get_cart_by_id($item['Confirmation']['cart_id']);
			
			$item += $cart;
			
			if(!empty($cart['CartProduct'])) {
				$j = 0;
				$item['Cart']['CartProduct'] = $item['CartProduct'];
				foreach ($cart['CartProduct'] as $cartProd) {
					$product = $Products->getProduct($cartProd['product_id']);
					unset($product['Cart']);
					unset($product['Category']);
					unset($product['Material']);
					$item['Cart']['CartProduct'][$j]['Information'] = $product;
					$j++;
				}
			}

			$item['Delivery'] += $Confirmations->calcPrice($item);
			
			//Finde Offernumber
			if(!isset($item['Delivery']['confirmation_id'])) {
				$item['Delivery']['confirmation_number'] = $item['Confirmation']['confirmation_number'];
				
				//Rechnung
				$billing = $this->Billing->findById($item['Confirmation']['billing_id']);
				if(!is_null($item['Confirmation']['billing_id'])) {
					$item['Delivery']['billing_number'] = $billing['Billing']['billing_number'];
				}
			}
						
			array_push($data_temp, $item);
			
		}	
			
		return $data_temp;
	}
}
