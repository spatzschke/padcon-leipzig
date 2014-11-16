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

	
	public $uses = array('Billing', 'Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation');
	
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
		$this->Billing->recursive = 0;
		$this->set('billings', $this->Paginator->paginate());
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
		$billing = $this->Billing->find('first', $options);
		
		$offer = $this->Offer->find('first', array('conditions' => array('Offer.billing_id' => $billing['Billing']['id'])));
		
		$Offers = new OffersController();
		$cart = $this->Cart->find('first', array('conditions' => array('Cart.' . $this->Billing->primaryKey => $offer['Offer']['cart_id'])));
		
		$offer['Cart']['CartProduct'] = $cart['CartProduct'];
		
		if(!is_null($offer['Customer']['id'])) {
			$split_str = $Offers->splitAddressData($offer);
			if(!is_null($split_str)) {	
				$offer['Customer'] = $offer['Customer'] + array();
				$offer['Customer'] += $split_str;
			}
		}
		
		$this->request->data = $billing;
		$this->request->data += $offer;
		
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
			
			if(empty($billing['Offer']['confirmation_id'])) {
				
				$this->Billing->create();
				
				$billing['Billing']['status'] = 'open';
				$billing['Billing']['confirmation_id'] = $confirmation['Confirmation']['id'];
				
				//Gernerierung der Auftragsbestätigungsnummer
				$billing['Billing']['billing_number'] = $this->generateBillingNumber();
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
				return $this->redirect(array('action' => 'view', $billing['Billing']['id']));
			}
		} else {
			
			if(!empty($this->request->data)) {
				
				$number = $this->data['Confirmation']['confirmation_number'];
								
				$confirmation = $this->Confirmation->findByConfirmationNumber($number);
				if(!empty($confirmation)) {
					return $this->redirect(array('action' => 'convert', $confirmation['Confirmation']['id']));
				} else {
					$this->Session->setFlash(__('Rechnung mit Rechnugnsnummer nicht vorhanden.'));
				}
			}
			$this->set('title_for_panel', 'Rechnung aus Auftragsbestätigung erstellen');
		}
	}

	function admin_settings($id = null) {
		
		$this->layout = 'ajax';

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$id = $this->request->data['Billing']['id'];
				
				$data = $this->Confirmation->findById($id);
				
				$data['Confirmation']['discount'] = $this->request->data['Confirmation']['discount'];
				$data['Confirmation']['additional_text'] = $this->request->data['Confirmation']['additional_text'];
					
				if(!empty($this->request->data['Confirmation']['order_date'])) {
					$date = date_create_from_format('d.m.Y', $this->request->data['Confirmation']['order_date']);
					$data['Confirmation']['order_date'] = date_format($date, 'Y-m-d');
				}	
				
				
				$data['Confirmation']['order_number'] = $this->request->data['Confirmation']['order_number'];
				
				
				if($this->Confirmation->save($data)){
					$this->Session->setFlash(__('Speicherung erfolgreich', true));
				} else {
					$this->Session->setFlash(__('Es kam zu Fehlern beim Speichern', true));
				}
				
				$data = $this->Confirmation->findById($id);
				$data['CartProducts'] = $this->getSettingCartProducts($data);
				
				$cart = $this->Cart->findById($data['Confirmation']['cart_id']);
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
				
				$this->request->data = $data;
							
			} else {
				$data = $this->Billing->findById($id);
				
				
				$confirmation['Confirmation']['additional_text'] = '
Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto<br />
Lieferung frei Haus<br />
Lieferzeit: ca. 40. KW 2014
				';


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
	
		// Anzahl aller Auftragsbestätigungen im Monat / Aktueller Monat / Aktuelles Jahr		
		$countMonth = count($this->Confirmation->find('all',array('conditions' => array('Confirmation.created BETWEEN ? AND ?' => array(date('Y-m-01'), date('Y-m-d'))))));
		return str_pad($countMonth, 3, "0", STR_PAD_LEFT).'/'.date('m').'/'.date('y');
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
		$calc = $Confirmations->calcPrice($data);
		
		$this->request->data['Confirmation']['confirmation_price'] = $calc['confirmation_price'];
		
		$this->render('/Elements/backend/SheetBilling');
	}
}
