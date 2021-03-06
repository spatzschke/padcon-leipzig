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

	
	public $uses = array('Billing', 'Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'Delivery', 'Process');
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
		$data = $this->Billing->find('all', array('order' => array('Billing.billing_number DESC')));
		
		foreach ($data as $key => $value) {
			
			if($value['Process']['confirmation_id']) {
				$confirmation = $this->Confirmation->findById($value['Process']['confirmation_id']);
				
				if(!empty($confirmation))
					$data[$key]['Confirmation'] = $confirmation['Confirmation'];
			}
			
		}	
			
		$this->set('title_for_panel', 'Alle Rechnungen');	
			
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
		$data = $this->Process->findByBillingId($id);

		if($data['Confirmation']['delivery_id']) {
			$delivery = $this->Delivery->findById($data['Confirmation']['delivery_id']);
			$this->generateData($data, $delivery['Delivery']['cart_id']);	
		} else {
			$this->generateData($data, $data['Confirmation']['cart_id']);	
		}
		

		
		$controller_name = 'Deliveries'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name'));
		$this->set('pdf', null);
	}
	
	public function admin_edit($id = null) {
		$this->admin_view($id);
		$this->render('admin_view');
	}
	
	public function admin_add_individual($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		if (!empty($this->data)) {
			
			$confirmation = array();
			if(!empty($this->data['Billing']['confirmation_number'])) {
				$confirmation = $this->Confirmation->findByConfirmationNumber($this->data['Billing']['confirmation_number']);
			}
			
			if($this->data['Billing']['confirmation_number'] == "") {
				$this->Session->setFlash(__('Bitte geben Sie eine Auftragsbestätigungs-Nummer ein!'), 'flash_message', array('class' => 'alert-danger'));
				$data = $this->data;
			} elseif(!isset($confirmation['Confirmation'])) {
				$this->Session->setFlash(__('Auftragsbestätigung existiert nicht!'), 'flash_message', array('class' => 'alert-danger'));
				$data = $this->data;
			} else {	
				$data = null;	
												
				$this->Billing->create();
				
				$data = $this->data;
				
				$data['Billing']['status'] = 'open';
				$data['Billing']['custom'] = '1';
				$data['Billing']['billing_number'] = $this->data['Billing']['billing_number'];
				
				$this->Billing->save($data);
				$bil_id = $this->Billing->id;
				
				if(!$id) {
					$id = $confirmation['Confirmation']['id'];
				}
				
				// Rechnung in AB eintragen
				$confirmation['Confirmation']['id'] =  $id;
				$confirmation['Confirmation']['billing_id'] =  $bil_id;
				$this->Confirmation->save($confirmation);
				
				//Delivery zu Prozess zuschlüsseln
				$proc = $this->Process->findByConfirmationId($id);
				$proc['Process']['billing_id'] =  $bil_id;
				$this->Process->save($proc);	
				
				
				// Generate Hash für AB
				$data['Billing']['id'] =  $bil_id;
				$data['Billing']['hash'] =  Security::hash($bil_id, 'md5', true);
				$this->Billing->save($data);
	
				$this->redirect(array('action'=>'edit_individual', $bil_id));
			}
		} 
		
		
		$data['Billing']['billing_number'] = $this->generateBillingNumber();
		
		$con = $this->Confirmation->findById($id);
		if(isset($con['Confirmation']))
			$data['Billing']['confirmation_number'] = $con['Confirmation']['confirmation_number'];
		$data['Billing']['check'] = $id;
		
		$this->request->data = $data;
		
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Individuelle Rechnung anlegen');		
		$controller_name = 'Billings'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name','data'));
		
		$this->render('admin_individual');
	}

	public function admin_edit_individual($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		$data = $this->Confirmation->findByBillingId($id);
		if(!isset($data['Confirmation'])) {
			$data = $this->Billing->findById($id);		
		}
		
		if (!empty($this->data)) {
			$confirmation = null;			
			
			$data = $this->data;
			$data['Billing']['created'] = date('Y-m-d',strtotime($data['Billing']['created']));
			$data['Billing']['id'] = $id;
			$billing['Billing']['billing_price'] = $this->$data['Billing']['billing_price'];
			
			//Filtere Zahlungsziel aus Text heraus
			$data['Billing']['payment_target'] = $this->findPaymentTarget($data);
			
			//Filtere SkontoDate aus Text heraus
			$data['Billing']['skonto_date'] = $this->findSkontoDate($data);
			
			//Filtere Skonto aus Text heraus
			$data['Billing']['skonto'] = $this->findSkonto($data);
			
			$Carts = new CartsController();
			$data['Confirmation']['billing_price'] = $Carts->convertPriceToSql($this->$data['Billing']['billing_price']);
			
			if($this->Billing->save($data)) {
				$this->Session->setFlash(__('Rechnung wurde gespeichert.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Es trat ein Fehler beim Speichern der Rechnung aus. Bitte versuchen Sie es erneut.'));
			}

		} else {
			
			$data['Billing']['billing_price'] = $data['Confirmation']['confirmation_price'];
			
			if(empty($data['Billing']['additional_text'])) {
				$data['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
			}

			if(isset($data['Confirmation'])) {
				$data['Billing']['created'] = date('d.m.Y',strtotime($data['Billing']['created']));			
			}			
			
			$this->request->data = $data;
			
			$this->set('primary_button', 'Speichern');
			$this->set('title_for_panel', 'Individuelle Rechnung bearbeiten');		
			$controller_name = 'Billings'; 
			$controller_id = $id;
			$this->set(compact('controller_id', 'controller_name','data'));
			
			$this->render('admin_individual');
		}
	}

	public function admin_add_placeholder() {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		if (!empty($this->data)) {
		
				$data = null;	
												
				$this->Billing->create();
				
				$data = $this->data;
				
				$data['Billing']['status'] = 'open';
				$data['Billing']['custom'] = '1';
				$data['Billing']['billing_number'] = $this->data['Billing']['billing_number'];
				$data['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
				$data['Billing']['payment_target'] = $this->findPaymentTarget($data);
				$data['Billing']['created'] = date('Y-m-d h:i:s');		
				
				$this->Billing->save($data);
				$dev_id = $this->Billing->id;
					
				// Generate Hash für AB
				$data['Billing']['id'] =  $dev_id;
				$data['Billing']['hash'] =  Security::hash($dev_id, 'md5', true);
				$this->Billing->save($data);
	
				$this->redirect(array('action'=>'index'));
		} 
		
		
		$data['Billing']['billing_number'] = $this->generateBillingNumber();
		
		$this->request->data = $data;
		
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Platzhalter für eine Rechnung anlegen');		
		$controller_name = 'Billings'; 
		$this->set(compact('controller_name','data'));
		
		$this->render('admin_individual');
	}
/**
 * admin_add method
 *
 * @return void
 */
	public function admin_convert($delivery_id = null, $confirmation_id = null) {
		$this->layout = 'admin';			
		
		if($delivery_id != 0 || $confirmation_id) {

			//Prozess nachladen
			if($delivery_id != '0') {
				$process = $this->Process->findByDeliveryId($delivery_id);
			} else {
				$process = $this->Process->findByConfirmationId($confirmation_id);
			}
					
			$billing = array();
			
			if($process['Process']['billing_id'] == 0) {
				
				$this->Billing->create();
				
				$billing['Billing']['status'] = 'open';
				$billing['Billing']['custom'] = FALSE;
				$billing['Billing']['billing_price'] = $process['Confirmation']['confirmation_price'];
				
				//Default Settings
				$billing['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
		
				//Gernerierung der REchnungsnummer
				$billing['Billing']['billing_number'] = $this->generateBillingNumber();
				$billing['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
				
				//Zahlungsziel anhand des Standardtextes bestimmen
				$billing['Billing']['payment_target'] = date('Y-m-d', strtotime("+".Configure::read('padcon.zahlungsbedingung.netto.tage')." days"));
				
				//Skonto  anhand des Standardtextes bestimmen
				$billing['Billing']['skonto_date'] = date('Y-m-d', strtotime("+".Configure::read('padcon.zahlungsbedingung.skonto.tage')." days"));
				$billing['Billing']['skonto'] = Configure::read('padcon.zahlungsbedingung.skonto.wert');
				
				//Erste AB-Adresse zum Kunden finden
				$Addresses = new AddressesController(); 
				$address = $Addresses->getAddressByType($process, 4, TRUE);
				
				if(empty($address['Address'])) {
					$billing['Billing']['address_id'] = 0;
				} else {
					$billing['Billing']['address_id'] = $address['Address']['id'];
				}
				
				$this->Billing->save($billing);
				
				$currBillingId = $this->Billing->getLastInsertId();
				
				// Generate Hash für Offer
				$billing['Billing']['id'] = $currBillingId;
				$billing['Billing']['hash'] =  Security::hash($currBillingId, 'md5', true);
				$this->Billing->save($billing);
				
				//Neue Rechnungs-ID in AB speichern wenn es keine Teillieferung ist
				if($process['Process']['type'] == 'full' || $delivery_id == '0') {
					$confirmation['Confirmation']['id'] = $process['Process']['confirmation_id'];
					$confirmation['Confirmation']['billing_id'] = $currBillingId;
					$confirmation['Confirmation']['status'] = 'close';
					$this->Confirmation->save($confirmation);
				}
				
				//Neue Rechnungs-ID in Mapping-Tabelle speichern 
				
				$proc['Process']['id'] = $process['Process']['id'];
				$proc['Process']['billing_id'] = $currBillingId;
				
				//Wenn Prozess-Type leer ist, dann mit full auffüllen 
				if(empty($process['Process']['type'])) 
					$proc['Process']['type'] = 'full';
				
				$this->Process->save($proc);
				
				$this->generateData($this->Billing->findById($currBillingId), $process['Process']['cart_id']);
			
				$this->set('pdf', null);
				
				$controller_name = 'Billings'; 
				$controller_id = $currBillingId;
				$this->set(compact('controller_id', 'controller_name'));
				
				return $this->redirect(array('action' => 'view', $currBillingId));
				
			} else {
				//$this->Session->setFlash(__('Rechnung bereits vorhanden'));
				return $this->redirect(array('action' => 'view', $process['Process']['billing_id']));
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
				
				
				
				if(!empty($this->request->data['Billing']['payment_date']) && strcmp('1970-01-01', $payment_date) != 0 && strcmp('0000-00-00', $payment_date) != 0) {
					$this->request->data['Billing']['payment_date'] = date('Y-m-d',strtotime($this->request->data['Billing']['payment_date']));
					if(strpos($this->request->data['Billing']['status'], 'cancel') === FALSE) {
						$this->request->data['Billing']['status'] = "close";					
					}
				} else {
					$this->request->data['Billing']['payment_date'] = null;
					if(strpos($this->request->data['Billing']['status'], 'cancel') === FALSE) {
						$this->request->data['Billing']['status'] = "open";						
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
				$data['Billing']['created'] = date('d.m.Y',strtotime($data['Billing']['created']));
				
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
				$save['Billing']['additional_text'] = $this->request->data['Billing']['additional_text'];
				$save['Billing']['skonto'] = $this->request->data['Billing']['skonto'];
				$save['Billing']['created'] = date('Y-m-d', strtotime($this->request->data['Billing']['created']));
				$save['Billing']['payment_target'] = $this->findPaymentTarget($this->request->data);
				$save['Billing']['skonto_date'] = $this->findSkontoDate($this->request->data);

				$save['Billing']['id'] = $id;
					
				if($this->Billing->save($save)){
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
				$data['Billing']['id'] = $id;
				
				//WEnn noch nicht gesetzt, standardtext nehmen
				if(empty($data['Billing']['additional_text'])) {
					$data['Billing']['additional_text'] = Configure::read('padcon.Rechnung.additional_text.default');
				}
				
				//Zahlungsziel anhand des Standardtextes bestimmen
				if(empty($data['Billing']['payment_target']) || strcmp('1970-01-01', $data['Billing']['payment_target']) == 0 || strcmp('0000-00-00', $data['Billing']['payment_target']) == 0) {
					$data['Billing']['payment_target'] = date('d.m.Y', strtotime("+".Configure::read('padcon.zahlungsbedingung.netto.tage')." days"));
					$data['Billing']['nettoDays'] = Configure::read('padcon.zahlungsbedingung.netto.tage');
				} else {
					$data['Billing']['payment_target'] = date('d.m.Y', strtotime($data['Billing']['payment_target']));
					$datetime1 = new DateTime($data['Billing']['payment_target']);
					$datetime2 = new DateTime($data['Billing']['created']);
					$interval = $datetime1->diff($datetime2);	
					$data['Billing']['nettoDays'] = $interval->format('%a')+1;
				}
				//Skonto  anhand des Standardtextes bestimmen
				//SkontoDatum anhand des Standardtextes bestimmen
				if(empty($data['Billing']['skonto_date']) || strcmp('1970-01-01', $data['Billing']['skonto_date']) == 0 || strcmp('0000-00-00', $data['Billing']['skonto_date']) == 0) {
					$data['Billing']['skonto_date'] = date('d.m.Y', strtotime("+".(Configure::read('padcon.zahlungsbedingung.skonto.tage'))." days"));
					$data['Billing']['skontoDays'] = Configure::read('padcon.zahlungsbedingung.skonto.tage');
				} else {
					$data['Billing']['skonto_date'] = date('d.m.Y', strtotime($data['Billing']['skonto_date']));
					$datetime1 = new DateTime($data['Billing']['skonto_date']);
					$datetime2 = new DateTime($data['Billing']['created']);
					$interval = $datetime1->diff($datetime2);	
					$data['Billing']['skontoDays'] = $interval->format('%a')+1;
				}


				//Skonto  anhand des Standardtextes bestimmen
				if(empty($data['Billing']['skonto']) || $data['Billing']['skonto'] == 0) {
					$data['Billing']['skonto'] = Configure::read('padcon.zahlungsbedingung.skonto.wert');
				} 
				
				$data['Billing']['created'] = date('d.m.Y', strtotime($data['Billing']['created']));
				

				
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
		
		$data = $this->Process->findByBillingId($id);
		
		$delivery = $this->Delivery->findById($data['Confirmation']['delivery_id']);
		$this->generateData($data, $delivery['Delivery']['cart_id']);
		
				
		$title = "Rechnung_".str_replace('/', '-', $data['Billing']['billing_number']);
		$this->set('title_for_layout', $title);
		
		$this->set('pdf', $pdf);
		$this->set(compact('data','pdf'));
      	$this->render('admin_view'); 
	    
	}

	function admin_payed($id = null) {
		
		$this->layout = 'ajax';
		
		$process = $this->Process->findByBillingId($id);
		
		
		
		if(!empty($this->request->data)) {
			
			$data['Billing']['id'] = $id;
			$data['Billing']['payment_date'] = date('y-m-d',strtotime($this->request->data['Billing']['payment_date']));	
			$data['Billing']['status'] = "close";	
			
			//Update Billing_price mit Skonto			
			if(isset($this->request->data['Billing']['skontoTake']) && $this->request->data['Billing']['skontoTake'] == "true") {
				$data['Billing']['skonto_take'] = 1;
				
				$process['Billing']['confirmation_price'] = $process['Confirmation']['confirmation_price'];
				$price = $this->calcSkonto($process['Billing'], true);
				$data['Billing']['billing_price'] = $price['billing_price'];
				
			} else {
				$data['Billing']['skonto_take'] = 0;
			}
			
			debug($data);
					
			$this->Billing->id = $id;
			$this->Billing->save($data);
			
		//	$this->redirect('index');
		}
			
		$this->request->data = $process;
		$this->request->data['Billing']['skonto_date'] = date('d.m.Y',strtotime($process['Billing']['skonto_date']));
		$this->request->data['Billing']['payment_date'] = date("d.m.Y");
		$controller_name = 'Billings'; 
		$controller_id = $id;
		
		$this->set(compact('controller_id', 'controller_name'));
	}

	function generateBillingNumber() {
	
		// Rechnung Nr.: 427/14
		// 427 = laufende Rechnung im Jahr - dreistellig
		// 14 = laufendes Jahr
	
		// 427 = laufende Rechnung im Jahr
		$countYearBillings = count($this->Billing->find('all',array('conditions' => array('Billing.created BETWEEN ? AND ?' => array(date('Y-01-01 00:00:00'), date('Y-m-d 00:00:00', strtotime("+1 days")))))))+1;
		$countYearBillings = str_pad($countYearBillings, 3, "0", STR_PAD_LEFT);
		// 14 = aktuelles Jahr
		$year = date('y');
		// Rechnung Nr.: 427/14
		return $countYearBillings.'/'.$year;
	}
	
	function generateData($data = null, $cart_id = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
		$Confirmations = new ConfirmationsController();
	
	    $this->request->data = $data;
		
		if(!empty($data)) {
			
	    	$cart = $Carts->getCartById($data['Process']['cart_id']);
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart, 7, 5);
	
			$cart = $Carts->calcSumPrice($cart);
			
			$this->request->data['Cart'] = $cart['Cart'];
			if($cart['Cart']) {
				$this->request->data += $cart;			
			}
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
			if(isset($this->request->data['Billing']['address_id']) && $this->request->data['Billing']['address_id'] != 0 ) {

				$addressDelivery = $this->Address->findById($this->request->data['Billing']['address_id']);
				$this->request->data['Address'] = $addressDelivery['Address'];
			} else {
				$this->request->data = $Addresses->getAddressByType($this->request->data, 4, TRUE);
			}
		}
	
		
		
		// if(!is_null($this->request->data['Address'])) {
		if(isset($this->request->data['Address'])) {
			$a = $Addresses->splitAddressData($this->request->data);
			$this->request->data['Address'] += $a['Address'];
		}
		
		//$confirmation = $Confirmations->calcPrice($this->request->data);				
		//$this->request->data['Confirmation'] += $confirmation;		

		//Nachladen des Lieferscheins
		if($this->request->data['Confirmation']['delivery_id']) {
			$delivery = $this->Delivery->find('first', array('conditions' => array('Delivery.id' => $this->request->data['Confirmation']['delivery_id'])));
			$this->request->data['Delivery'] = $delivery['Delivery'];
		}

		$calcBilling =  $this->calcPrice($this->request->data);
		$this->request->data['Billing'] += $calcBilling;

		return $calcBilling;

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
			if($item['Process']['cart_id'] != 0) {
				
				$customer= $this->Customer->findById($item['Process']['customer_id']);				
				$address = $this->Address->findById($item['Billing']['address_id']);
				
				if(isset($address['Address'])) {
					$customer['Address'] = $address['Address'];
					if($Customers->splitCustomerData($customer)) {
						$item['Address'] = $Customers->splitCustomerData($customer);
					}	
				}
				
				$item['Customer'] = $customer['Customer'];

				$cart = $Carts->getCartById($item['Process']['cart_id']);
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
				
				$item['Billing'] += $this->calcPrice($item);	
				
				$item['Billing']['confirmation_price'] = $item['Confirmation']['confirmation_price'];
							
				$item['Billing'] = $this->calcSkonto($item['Billing']);
			}			
			
			//if(isset($item['Confirmation']['customer_id'])) {
			
				//Auftragsbestätigung
				
				if(!empty($confirmation))
					$item['Billing']['confirmation_number'] = $confirmation['Confirmation']['confirmation_number'];
				
				//Lieferschein
				if($item['Process']['delivery_id']) {
					$delivery = $this->Delivery->findById($item['Process']['delivery_id']);
					$item['Billing']['delivery_number'] = $delivery['Delivery']['delivery_number'];
				}
			//}	
				
			array_push($data_temp, $item);
		}	
			
		return $data_temp;
	}

	function findPaymentTarget($data = null) {
		
		//Filtere Zahlungsziel aus Text heraus
		$text = $data['Billing']['additional_text'];
		
		$plus = explode('% Skonto oder', $text);
		$plus = explode('Tage', $plus[1]);
		return date('Y-m-d', strtotime($data['Billing']['created']." +".trim($plus[0])." days"));
	}
	
	function findSkontoDate($data = null) {
		//Filtere Zahlungsziel aus Text heraus
		$text = $data['Billing']['additional_text'];
		
		$plus = explode('% Skonto oder', $text);
		$plus = explode(':', $plus[0]);
		$plus = explode('Tage', $plus[1]);
		return date('Y-m-d', strtotime($data['Billing']['created']." +".trim($plus[0])." days"));
	}
	
	function findSkonto($data = null) {
		//Filtere Zahlungsziel aus Text heraus
		$text = $data['Billing']['additional_text'];
		$plus = explode('% Skonto oder', $text);		
		$plus = explode('Tage', $plus[0]);
		
		return trim($plus[1]);
	}
	
	function calcSkonto($data = null, $update = false) {

		$skonto = 1 - ($data['skonto'] / 100);
		$price = $data['confirmation_price'] * $skonto;
		$data['skonto_price'] = $data['confirmation_price'] - $price;
		if($update) {
			$data['billing_price'] = $price;
		}
				
		return $data;
	}
	
	function admin_fillBillingPrice() {
		$all = $this->Billing->find('all');
		
		foreach ($all as $key => $item) {
			
			if(!$item['Billing']['skonto_take']) {
				
				$data['Billing']['billing_price'] = $item['Confirmation']['confirmation_price'];

				$this->Billing->id = $item['Billing']['id'];
				if($this->Billing->save($data)) {
					$this->Session->setFlash(__('Rechnungen aktualsiert', true));
				} else {			
					$this->Session->setFlash(__('Images not update', true));
				}
			}
		}
		
		$this->redirect(array('controller' => 'pages', 'action' => 'setting'));
	}

	function calcPrice($data = null) {
		
		
		$data = $this->Process->findByBillingId($data['Billing']['id']);
		 $arr_data = null;

		// Kosten aus AB berechen
		 $discount_price = $data['Confirmation']['discount'] * $data['Cart']['sum_retail_price'] / 100;
		 $part_price = $data['Cart']['sum_retail_price'] - $discount_price + $data['Confirmation']['delivery_cost'];
		 $vat_price = $data['Confirmation']['vat'] * $part_price / 100;
		 $data_price = floatval($part_price + $vat_price);
// 		
		//Lieferkosten bestimmen
		 if($data['Cart']['sum_retail_price'] > Configure::read('padcon.delivery_cost.versandkostenfrei_ab') || strpos($data['Confirmation']['additional_text'],"frei Haus.")!==false) {
			 $delivery_cost = Configure::read('padcon.delivery_cost.frei');
		 } else {
			if($data['Confirmation']['delivery_cost'] != Configure::read('padcon.delivery_cost.paeckchen')) {
				 $delivery_cost = Configure::read('padcon.delivery_cost.paket');
			 } else {
				 $delivery_cost = Configure::read('padcon.delivery_cost.paeckchen');
			 }

		 }
 		
		 $arr_data['Billing']['delivery_cost'] = $delivery_cost;
		 $arr_data['Billing']['vat_price'] = $vat_price;
		 $arr_data['Billing']['discount_price'] = $discount_price;
		 $arr_data['Billing']['part_price'] = $part_price;

		 if($data['Cart']['sum_retail_price'] == 0) {
			 if($data['Billing']['custom']){
				 $arr_data['Billing']['billing_price'] = $data['Billing']['billing_price'];
			 } else {
				 $arr_data['Billing']['billing_price'] = 0;
			 }			
		 } else {
			 $arr_data['Billing']['billing_price'] = $data_price;
		 }	
 
		//Kosten von Cart in AB übertragen/aktualisieren
 		
		// $arr_data['Billing']['cost'] = $data['Cart']['sum_base_price'];
 		
		 $arr_data['Billing']['id'] = $data['Billing']['id']; 
		 $this->Billing->save($arr_data['Billing']);
				
		return $arr_data['Billing'];
	}
}
