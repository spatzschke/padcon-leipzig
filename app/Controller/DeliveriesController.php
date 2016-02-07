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

	public $uses = array('Delivery', 'Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'Billing', 'Process');
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
	function admin_index() {
		$this->layout = 'admin';
	
		$this->Delivery->recursive = 0;
		$this->Paginator->settings = array(
	        'order' => array('substring(Delivery.delivery_number, 4, 5)' => 'DESC', 'substring(Delivery.delivery_number, 1, 3)' => 'DESC'),
	        'limit' => 20
	    );
	//    $data = $this->Paginator->paginate('Delivery');
		$data = $this->Delivery->find('all', array('order' => array('substring(Delivery.delivery_number, 4, 5) DESC', 'substring(Delivery.delivery_number, 1, 3) DESC')));
		
		$this->set('title_for_panel', 'Alle Lieferscheine');	
			
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
		
		$data = $this->Process->findByDeliveryId($id);	
		
		$this->generateData($data);
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
			if(!empty($this->data['Delivery']['confirmation_number'])) {
				$confirmation = $this->Confirmation->findByConfirmationNumber($this->data['Delivery']['confirmation_number']);
			}
			
			if($this->data['Delivery']['confirmation_number'] == "") {
				$this->Session->setFlash(__('Bitte geben Sie eine Auftragsbestätigungs-Nummer ein!'), 'flash_message', array('class' => 'alert-danger'));
				$data = $this->data;
			} elseif(!isset($confirmation['Confirmation'])) {
				$this->Session->setFlash(__('Auftragsbestätigung existiert nicht!'), 'flash_message', array('class' => 'alert-danger'));
				$data = $this->data;
			} else {				
				$data = null;	
												
				$this->Delivery->create();				
				$data = $this->data;
				
				$data['Delivery']['status'] = 'open';
				$data['Delivery']['custom'] = '1';
				$data['Delivery']['delivery_number'] = $this->data['Delivery']['delivery_number'];
				$data['Delivery']['confirmation_number'] = $this->data['Delivery']['confirmation_number'];
				
				$this->Delivery->save($data);
				$dev_id = $this->Delivery->id;
				
				if(!$id) {
					$id = $confirmation['Confirmation']['id'];
				}
				// Lierschein in AB eintragen
				
				$conf = $this->Confirmation->findById($id);
				$confirmation['Confirmation']['id'] = $id;
				$confirmation['Confirmation']['delivery_id'] =  $dev_id;
							
				if($conf['Confirmation']['status'] != 'cancel') {	
					$confirmation['Confirmation']['status'] = "close";
				}
				
				$this->Confirmation->save($confirmation);			
				
		
				//Delivery zu Prozess zuschlüsseln
				$proc = $this->Process->findByConfirmationId($id);
				$proc['Process']['delivery_id'] =  $dev_id;
				$proc['Process']['type'] =  'full';
				$this->Process->save($proc);			
				
				// Generate Hash für AB
				$data['Delivery']['id'] =  $dev_id;
				$data['Delivery']['hash'] =  Security::hash($id, 'md5', true);
				$this->Delivery->save($data);
	
				$this->redirect(array('action'=>'edit_individual', $dev_id));
			}

			$this->request->data = $this->data;

			$this->set('primary_button', 'Anlegen');
			$this->set('title_for_panel', 'Individuellen Lieferschein anlegen');	
			
			
		} 
		
		// Wenn es noch eine leere AB (ohen Kunden) gibt, dann nimm die
		// $emptyData = $this->Confirmation->find('first', array('conditions' => array('customer_id' => NULL, 'Confirmation.cart_id' => 0)));
		// if(!empty($emptyData)) {
			// $this->Session->setFlash(__('Eine leere individuelle AB wurde gefunden! Bitte diese Ausfüllen.'));
			// $this->redirect(array('action'=>'edit_individual', $emptyData['Delivery']['id']));
		// }
		
		$data['Delivery']['delivery_number'] = $this->generateDeliveryNumber();
		
		$con = $this->Confirmation->findById($id);
		if(isset($con['Confirmation']))
			$data['Delivery']['confirmation_number'] = $con['Confirmation']['confirmation_number'];
		$data['Delivery']['check'] = $id;
		
		$this->request->data = $data;
		
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Individuellen Lieferschein anlegen');		
		$controller_name = 'Deliveries'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name','data'));
		
		$this->render('admin_individual');
	}

	public function admin_edit_individual($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		$data = $this->Process->findByDeliveryId($id);
		
		if (!empty($this->data)) {
			$confirmation = null;			
			
			$data = $this->data;
			$data['Delivery']['created'] = date('Y-m-d',strtotime($data['Delivery']['created']));
			$data['Delivery']['id'] = $id;
			
			if($this->Delivery->save($data)) {
				$this->Session->setFlash(__('Lierschein wurde gespeichert.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Es trat ein Fehler beim speichern des Lieferscheins auf. Bitte versuchen Sie es noch einmal.'));
			}

		} else {
			
			$data['Delivery']['created'] = date('d.m.Y',strtotime($data['Delivery']['created']));			
			$this->request->data = $data;
			
			$this->set('primary_button', 'Speichern');
			$this->set('title_for_panel', 'Individuellen Lieferschein bearbeiten');		
			$controller_name = 'Deliveries'; 
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
												
				$this->Delivery->create();
				
				$data = $this->data;
				
				$data['Delivery']['status'] = 'open';
				$data['Delivery']['custom'] = '1';
				$data['Delivery']['delivery_number'] = $this->data['Delivery']['delivery_number'];
				$data['Delivery']['additional_text'] = Configure::read('padcon.Lieferschein.additional_text.default');
				$data['Delivery']['created'] = date('Y-m-d h:i:s');		
				
				$this->Delivery->save($data);
				$dev_id = $this->Delivery->id;
					
				// Generate Hash für AB
				$data['Delivery']['id'] =  $dev_id;
				$data['Delivery']['hash'] =  Security::hash($dev_id, 'md5', true);
				$this->Delivery->save($data);
				
				//Neue ConfirmationDeliver erstellen - Full
				$Process['Process']['type'] =  'full';
				$Process['Process']['delivery_id'] =  $dev_id;
				$Process['Process']['confirmation_id'] = 0;
								
				$this->Process->create();
				$this->Process->save($Process);	
	
				$this->redirect(array('action'=>'index'));
		} 
		
		
		$data['Delivery']['delivery_number'] = $this->generateDeliveryNumber();
		
		$this->request->data = $data;
		
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Platzhalter für einen Lieferschein anlegen');		
		$controller_name = 'Deliveries'; 
		$this->set(compact('controller_name','data'));
		
		$this->render('admin_individual');
	}

	public function admin_convert($confirmation_id = null, $cart_id = null) {
		$this->layout = 'admin';		
		if($confirmation_id) {
				
			$confirmation = $this->Confirmation->findById($confirmation_id);
			$process = $this->Process->findByConfirmationId($confirmation_id);

			if($process['Process']['delivery_id'] == '0' || $cart_id) {
				$this->Delivery->create();
				
				$delivery['Delivery']['status'] = 'open';
				$delivery['Delivery']['custom'] = FALSE;
				$delivery['Delivery']['confirmation_id'] = $confirmation['Confirmation']['id'];
				$delivery['Delivery']['delivery_date'] = time();
				$delivery['Delivery']['cost'] = $confirmation['Confirmation']['cost'];
				
				//Gernerierung der Auftragsbestätigungsnummer
				$delivery['Delivery']['delivery_number'] = $this->generateDeliveryNumber();
				
				//Erste AB-Adresse zum Kunden finden
				$Addresses = new AddressesController(); 
				$address = $Addresses->getAddressByType($confirmation, 3, TRUE);
				
				if(empty($address['Address'])) {
					$delivery['Delivery']['address_id'] = 0;
				} else {
					$delivery['Delivery']['address_id'] = $address['Address']['id'];
				}
				
				//NUR bei Teillieferschein				
				if($cart_id) {
					//Cart des Teillieferscheins an Lieferschein übertragen
					$delivery['Delivery']['cart_id'] = $cart_id;
				} else {
					//Cart von AB an  Lieferschein übertragen
					$delivery['Delivery']['cart_id'] = $confirmation['Confirmation']['cart_id'];
				}
				
				$this->Delivery->save($delivery);				
				$currDeliveryId = $this->Delivery->getLastInsertId();
				
				//Neue Process erzeugen und Cart übertragen
				if($cart_id) {
					$this->Process->create();
					$proc['Process']['type'] = 'part';
					$proc['Process']['cart_id'] = $cart_id;
					$proc['Process']['offer_id'] = $process['Process']['offer_id'];
					$proc['Process']['confirmation_id'] = $process['Process']['confirmation_id'];
					$proc['Process']['customer_id'] = $process['Process']['customer_id'];
					$proc['Process']['cart_id'] = $cart_id;
				} else {
					$proc['Process']['id'] = $process['Process']['id'];
					$proc['Process']['type'] = 'full';
					$proc['Process']['cart_id'] = $confirmation['Confirmation']['cart_id'];
				}				
				$proc['Process']['delivery_id'] = $currDeliveryId;
				$this->Process->save($proc);
				
				// Generate Hash für Offer
				$delivery['Delivery']['hash'] =  Security::hash($currDeliveryId, 'md5', true);
				$this->Delivery->save($delivery);
				
				//Neue Lieferschein-ID in AUftragsbestäätigung speichern 
				$confirmation['Confirmation']['delivery_id'] = $currDeliveryId;
				$confirmation['Confirmation']['status'] = 'close';
				
				$this->Confirmation->save($confirmation);

				$this->generateData($this->Delivery->findById($currDeliveryId));
								
				$this->set('pdf', null);
				
				$controller_name = 'Deliveries'; 
				$controller_id = $currDeliveryId;
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->redirect(array('action' => 'view', $currDeliveryId));
				
			} else {
			//	$this->Session->setFlash(__('Lieferschein bereits vorhanden'));
				return $this->redirect(array('action' => 'view', $process['Process']['delivery_id']));
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

	public function admin_convertPart($confirmation_id = null, $edit = false) {
		$this->layout = 'ajax';
		
		$process = $this->Process->findByConfirmationId($confirmation_id);
		$processPart = $this->Process->findByConfirmationIdAndType($confirmation_id, 'part');
		$processCount = $this->Process->find('count', array('conditions' => array('Process.confirmation_id' => $confirmation_id)));
		$processCountPart = $this->Process->find('count', array('conditions' => array('Process.confirmation_id' => $confirmation_id, 'Process.type' => 'part')));
		
		if($edit) {
			//Erzeuge neuen Cart
			$this->Cart->create();
			$this->Cart->save();
			$cart_id = $this->Cart->getLastInsertId();

			$newCart = array();

			foreach($this->data['Product'] as $key => $item) {
				
				$this->CartProduct->create();
				$cartProduct['CartProduct']['cart_id'] = $cart_id;
				$cartProduct['CartProduct']['product_id'] = $item['product_id'];
				$cartProduct['CartProduct']['amount'] = $item['amount'];
				$cartProduct['CartProduct']['color_id'] = $item['color_id'];
				
				$this->CartProduct->save($cartProduct);
			}
			$cartNew['Cart']['id'] = $cart_id;
			$cartNew['Cart']['count'] = count($this->data['Product']);
			$this->Cart->save($cartNew);
			
			echo $cart_id;
			
			$this->render(false);
		}
		
		$this->request->data = $process;
		
		//Wenn bereits eine Teillieferung besteht, dann differenz ermitteln
		$mainCartProducts = $this->Cart->findById($process['Confirmation']['cart_id']);
		$mainCartProducts = $mainCartProducts['CartProduct'];

		if($processCountPart > 0) {
			
			//Wenn bisher nur eine Teillieferung, dann Array erzeugen
			if($processCountPart == 1) {
				$proc['Process'][0] = $processPart['Process'];
				$process = $proc;
			}
			
			//Iteration über alle Teillieferscheine
			foreach($process['Process'] as $key => $item) {
				
				$partCartProducts = $this->Cart->findById($item['cart_id']);
				$partCartProducts = $partCartProducts['CartProduct'];
				
				//Iteration über alle Produkte des Main
				foreach($mainCartProducts as $mainKey => $main){
					
					//Iteration über alle Produkte des Part
					foreach($partCartProducts as $partKey => $part){
						
						//Produktvergleich
						if($main['product_id'] == $part['product_id']) {
							
							//Anzahlvergleich
							if($main['amount'] == $part['amount']) {
								unset($mainCartProducts[$mainKey]);
							}
							elseif($main['amount'] > $part['amount']) {
								$mainCartProducts[$mainKey]['amount'] = $part['amount'];
								
							}else {
							}
							
						}
					}
				}	
			} 
		}
		
		$this->request->data['CartProduct'] = $mainCartProducts;
		//$this->request->data['CartProduct'] = $cart['CartProduct'];
		
		$controller_name = 'Deliveries'; 
		$controller_id = $confirmation_id;
		$this->set(compact('controller_id', 'controller_name'));
	}

	function admin_table_setting($id = null) {
		
		$this->layout = 'ajax';
		

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$this->request->data['Delivery']['created'] = date('Y-m-d h:i:s',strtotime($this->request->data['Delivery']['created']));
				$this->request->data['Delivery']['send_date'] = date('Y-m-d',strtotime($this->request->data['Delivery']['send_date']));
				
				
				if(!empty($this->request->data['Delivery']['deliver_date']) && strcmp('1970-01-01', $this->request->data['Delivery']['deliver_date']) != 0 && strcmp('0000-00-00', $this->request->data['Delivery']['deliver_date']) != 0) {
					$this->request->data['Delivery']['deliver_date'] = date('Y-m-d',strtotime($this->request->data['Delivery']['deliver_date']));
					if(strpos($data['Delivery']['status'], 'cancel') === FALSE) {
						$this->request->data['Delivery']['status'] = "close";
					}
				} else {
					$this->request->data['Delivery']['deliver_date'] = null;
					if(strpos($data['Delivery']['status'], 'cancel') === FALSE) {		
						$this->request->data['Delivery']['status'] = "open";
					}
				}
				
				$this->Delivery->id = $this->request->data['Delivery']['id'];
				$this->Delivery->save($this->request->data);
							
			} else {
				$data = $this->Delivery->findById($id);
				
				
				if(!empty($data['Delivery']['send_date']) && strcmp('1970-01-01', $data['Delivery']['send_date']) != 0 && strcmp('0000-00-00', $data['Delivery']['send_date']) != 0) {
					$data['Delivery']['send_date'] = date('d.m.Y',strtotime($data['Delivery']['send_date']));
				} else {
					$data['Delivery']['send_date'] = null;
				}
				
				if(!empty($data['Delivery']['deliver_date']) && strcmp('1970-01-01', $data['Delivery']['deliver_date']) != 0 && strcmp('0000-00-00', $data['Delivery']['deliver_date']) != 0) {
					$data['Delivery']['deliver_date'] = date('d.m.Y',strtotime($data['Delivery']['deliver_date']));
				} else {
					$data['Delivery']['deliver_date'] = null;
				}
				
				$data['Delivery']['created'] = date('d.m.Y',strtotime($data['Delivery']['created']));				
				$this->request->data = $data;
				
			}
		}
		
		$controller_name = 'Deliveries'; 
		$controller_id = $data['Delivery']['id'];
		
		$this->set(compact('controller_id', 'controller_name'));
	}

	function admin_update($customer_id = null, $data_id = null, $address = null) {
		$this->layout="ajax";
		
		$Addresses = new AddressesController();

		$data = $this->Delivery->findById($data_id);					
		
		if($data) {
			if(!is_null($address)) {
				$address = $this->Address->findById($address);
				$data['Delivery']['address_id'] = $address['Address']['id'];
				$data['Delivery']['Address'] = $address['Address'];
			} else {
			//Suche erste Adresse
				if(is_null($data['Customer']['id'])) {
					$customer = $this->Customer->findById($customer_id);
					$data['Customer'] = $customer['Customer'];
					$data['Confirmation']['customer_id'] =  $customer['Customer']['id'];
				}
			
				$data = $Addresses->getAddressByType($data, 2, TRUE);	
				$data['Delivery']['address_id'] = $data['Address']['id'];				
			}
			
			if(empty($data['Delivery']['delivery_number'])) {
				$data['Delivery']['delivery_number'] = $this->generateDeliveryNumber();
			}
			$data['Confirmation']['customer_id'] = $customer_id;
			
			
			if($this->Delivery->save($data)){
				$data['Delivery']['stat'] = 'saved';
			} else {
				$data['Delivery']['stat'] = 'not saved';
			}
		} else {
			$data['Delivery']['stat'] = 'error';
		}
		$this->Delivery->save($data);
		
		$this->request->data = $data;
		$this->autoRender = false;
		$this->layout = 'admin';
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

	function admin_search($searchString = null) {
		
		$this->layout = 'ajax';
		
		$offers = $this->Delivery->find('all',array('conditions' => array("OR" => 
			array (	'Delivery.delivery_number LIKE' => '%'.$this->data['str'].'%' ,
					'Delivery.id LIKE' 	=> '%'.$this->data['str'].'%',
					'Process.customer_id LIKE' 	=> '%'.$this->data['str'].'%')),
					'order' => array('substring(Delivery.delivery_number, 4, 5) DESC', 'substring(Delivery.delivery_number, 1, 3) DESC')));	
		
		$this->set('data', $this->fillIndexData($offers));
		
		if(isset($this->data['template'])) {
			$this->render($this->data['template']);
		}
	}

	function createPdf ($hash = null) { 
		$result = $this->Delivery->findByHash($hash);
		if(!empty($result)) {
			$this->admin_createPdf($result['Delivery']['id']);
		} 			
	}

	function admin_createPdf ($id= null){

		$this->layout = 'pdf';
		$pdf = true;
		
		$data = $this->Delivery->findById($id);
		
		$this->generateData($data);		
					
		$title = "Lieferschein_".str_replace('/', '-', $data['Delivery']['delivery_number']);
		$this->set('title_for_layout', $title);
		
		$this->set('pdf', $pdf);
		$this->set(compact('data','pdf'));
      	$this->render('admin_view'); 
	    
	}

	function admin_sended($id = null) {
		$data['Delivery']['id'] = $id;
		$data['Delivery']['send_date'] = date("y-m-d");
		
		if(!empty($this->data['Delivery']['trackingcode']))
			$data['Delivery']['trackingcode'] = $this->data['Delivery']['trackingcode'];
						
		$this->Delivery->id = $id;
		$this->Delivery->save($data);
		
		$this->redirect('index');
		
	}
	
	function admin_delivered($id = null) {
		$data['Delivery']['id'] = $id;
		$data['Delivery']['deliver_date'] = date("y-m-d");
		
		$delivery = $this->Delivery->findById($id);
		$data['Delivery']['status'] = "close";
					
		$this->Delivery->id = $id;
		$this->Delivery->save($data);
		
		$this->redirect('index');
		
	}
	
	function admin_trackingcode($id = null) {
			$this->layout = 'ajax';
		
		
		$this->request->data = $this->Delivery->findById($id);
		$this->request->data['Delivery']['send_date'] = date("d.m.Y");
		
		$controller_name = 'Deliveries'; 
		$controller_id = $this->request->data['Delivery']['id'];
		$this->set(compact('controller_id', 'controller_name'));
				
	}

	function generateDeliveryNumber() {
	
		// Lieferschein Nr.: 01711/478
		// 017 = laufende Anzahl im Monat - dreistellig
		// 11 = aktueller Monat
		// 478 = laufende Anzahl im Jahr - dreistellig
		
		// 017 = laufende Anzahl im Monat - dreistellig
		$countMonthDeliveries = count($this->Delivery->find('all',array('conditions' => array('Delivery.created BETWEEN ? AND ?' => array(date('Y-m-01 00:00:0='), date('Y-m-d 00:00:00', strtotime("+1 days")))))))+1;
		$countMonthDeliveries = str_pad($countMonthDeliveries, 3, "0", STR_PAD_LEFT);
		// 11 = aktueller Monat
		$month = date('m');
		// 017 = laufende Anzahl im Jahr - dreistellig
		$countYearDeliveries = count($this->Delivery->find('all',array('conditions' => array('Delivery.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d', strtotime("+1 days")))))))+1;
		$countYearDeliveries = str_pad($countYearDeliveries, 3, "0", STR_PAD_LEFT);
		
		// Lieferschein Nr.: 01711/478
		return $countMonthDeliveries.$month.'/'.$countYearDeliveries;
	}
	
	function generateData($data = null) {
		
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
		$Confirmations = new ConfirmationsController();

		if(!$data || !isset($data['Confirmation'])) {			
			$data = $this->Process->findById($data['Process']['id']);		
		} 
				
	    $this->request->data = $data;
		
		if(!empty($data)) {
			
	    	$cart = $Carts->getCartById($data['Delivery']['cart_id']);
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart, 0, 1);
				
			$cart = $Carts->calcSumPrice($cart);
			
			$this->request->data['Cart'] = $cart['Cart'];
		
			//$this->request->data += $cart;
			$this->request->data['Cart']['count'] = count($cart['CartProduct']);
		}
		
		//Customer holen
		$this->Customer->recursive = 0;
		$this->request->data += $this->Customer->findById($this->request->data['Confirmation']['customer_id']);
		
		$addressDelivery = array();
		if(isset($this->request->data['Address']) && ($this->request->data['Address']['id'] != $this->request->data['Delivery']['address_id']) ) {
			$addressDelivery = $this->Address->findById($this->request->data['Delivery']['address_id']);
			$this->request->data['Address'] = $addressDelivery['Address'];
		} else {
			if(isset($this->request->data['Delivery']['address_id']) && $this->request->data['Delivery']['address_id'] != 0) {
				$addressDelivery = $this->Address->findById($this->request->data['Delivery']['address_id']);
				$this->request->data['Address'] = $addressDelivery['Address'];
			} else {
				$this->request->data = $Addresses->getAddressByType($this->request->data, 3, TRUE);
			}
		}

		if(!empty($this->request->data['Address'])) {
			$a = $Addresses->splitAddressData($this->request->data);
			$this->request->data['Address'] += $a['Address'];	
		}
		
		
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
						
			if(!isset($item['Confirmation'])) {
				$item += $this->Process->findByDeliveryId($item['Delivery']['id']);
				$item += $this->Confirmation->findById($item['Process']['confirmation_id']);
				
			}

			//Load Customer for the Delivery
			if($item['Process']['cart_id'] != 0) {
				$customer= $this->Customer->findById($item['Confirmation']['customer_id']);
				$address = $this->Address->findById($item['Delivery']['address_id']);				
				
				if(!empty($address)) {
					$customer['Address'] = $address['Address'];				
					$item['Customer'] = $customer['Customer'];
				
					if($Customers->splitCustomerData($customer)) {
						$item['Address'] = $Customers->splitCustomerData($customer);
					}	
				}
			
				$cart = $Carts->getCartById($item['Process']['cart_id']);
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
			}
			
			
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
