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
		
		$this->generateData($data);
		$controller_name = 'Deliveries'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name'));
		$this->set('pdf', null);
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
		
				
				//Gernerierung der Auftragsbestätigungsnummer
				$billing['Billing']['billing_number'] = $this->generateBillingNumber();
				$billing['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
				$this->Billing->save($billing);
				
				$currBillingId = $this->Billing->getLastInsertId();
				
				//Neue Auftragsbestätigungs-ID in Angebot speichern 
				$confirmation['Confirmation']['billing_id'] = $currBillingId;
				$this->Confirmation->save($confirmation);
				
				$this->generateData($this->Billing->findById($currBillingId));
				
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

		debug($this->request->data);

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$id = $this->request->data['Billing']['id'];
				
				$data = $this->Billing->findById($id);
				
				$data['Billing']['additional_text'] = $this->request->data['Billing']['additional_text'];
					
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

	function admin_createPdf ($id= null){

		$this->layout = 'pdf';
		$pdf = true;
		
		$data = $this->Billing->findById($id);
		
		
		$this->generateData($data);
		
				
		$title = "Rechnung_".str_replace('/', '-', $data['Billing']['billing_number']);
		$this->set('title_for_layout', $title);
		
		$this->set('pdf', $pdf);
		$this->set(compact('data','pdf'));
      	$this->render('admin_view'); 
	    
	}

	function generateBillingNumber() {
	
		// Rechnung Nr.: 427/14
		// 427 = laufende Rechnung im Jahr
		// 14 = laufendes Jahr
	
		// 427 = laufende Rechnung im Jahr
		$countYearBillings = count($this->Billing->find('all',array('conditions' => array('Billing.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d'))))))+1;
		$countYearBillings = str_pad($countYearBillings, 2, "0", STR_PAD_LEFT);
		// 14 = aktuelles Jahr
		$year = date('y');
		
		// Rechnung Nr.: 427/14
		return $countYearBillings.'/'.$year;
	}
	
	function generateData($data = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
		$Confirmations = new ConfirmationsController();
	
		if(!$data) {
			$confirmation_id = $data['Billing']['confirmation_id'];
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
		
		$this->request->data = $Addresses->getAddressByType($this->request->data, 4);
		
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
