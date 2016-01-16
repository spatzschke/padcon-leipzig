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

	public $uses = array('Delivery', 'Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'Billing', 'ConfirmationDelivery');
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
		$data = $this->Delivery->find('all', array('order' => array('Delivery.id DESC'), 'limit' => 100));
		
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
		
		$data = $this->ConfirmationDelivery->findByDeliveryId($id);	
		
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
			$data = null;	
											
			$this->Delivery->create();
			
			$data = $this->data;
			
			$data['Delivery']['status'] = 'custom_open';
			$data['Delivery']['delivery_number'] = $this->data['Delivery']['delivery_number'];
			
			$this->Delivery->save($data);
			$dev_id = $this->Delivery->id;
			
			// Lierschein in AB eintragen
			$confirmation['Confirmation']['id'] =  $id;
			$confirmation['Confirmation']['delivery_id'] =  $dev_id;
			$this->Confirmation->save($confirmation);
			
			// Generate Hash für AB
			$data['Delivery']['id'] =  $dev_id;
			$data['Delivery']['hash'] =  Security::hash($id, 'md5', true);
			$this->Delivery->save($data);

			$this->redirect(array('action'=>'edit_individual', $dev_id));
		} 
		
		// Wenn es noch eine leere AB (ohen Kunden) gibt, dann nimm die
		// $emptyData = $this->Confirmation->find('first', array('conditions' => array('customer_id' => NULL, 'Confirmation.cart_id' => 0)));
		// if(!empty($emptyData)) {
			// $this->Session->setFlash(__('Eine leere individuelle AB wurde gefunden! Bitte diese Ausfüllen.'));
			// $this->redirect(array('action'=>'edit_individual', $emptyData['Delivery']['id']));
		// }
		
		$data['Delivery']['delivery_number'] = $this->generateDeliveryNumber();
		
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
		
		$data = $this->Confirmation->findByDeliveryId($id);
		
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

	public function admin_convert($confirmation_id = null, $cart_id = null) {
		$this->layout = 'admin';		
		if($confirmation_id) {
				
			$confirmation = $this->Confirmation->findById($confirmation_id);
			$delivery = array();
			
			
			
			if(empty($confirmation['Confirmation']['delivery_id'])) {
							
				$this->Delivery->create();
				
				$delivery['Delivery']['status'] = 'open';
				$delivery['Delivery']['confirmation_id'] = $confirmation['Confirmation']['id'];
				$delivery['Delivery']['delivery_date'] = time();
				
				//Gernerierung der Auftragsbestätigungsnummer
				$delivery['Delivery']['delivery_number'] = $this->generateDeliveryNumber();
				
				//Erste AB-Adresse zum Kunden finden
				$Addresses = new AddressesController(); 
				$address = $Addresses->getAddressByType($confirmation, 3, TRUE);
				$delivery['Delivery']['address_id'] = $address['Address']['id'];
								
				if($cart_id) {
					//Cart des Teillieferscheins an Lieferschein übertragen
					$delivery['Delivery']['cart_id'] = $cart_id;
				} else {
					//Cart von AB an  Lieferschein übertragen
					$delivery['Delivery']['cart_id'] = $confirmation['Confirmation']['cart_id'];
				}
				
				
				$this->Delivery->save($delivery);
				
				$currDeliveryId = $this->Delivery->getLastInsertId();
				
				//Neue ConfirmationDelivery erzeugen und Cart übertagen
				$this->ConfirmationDelivery->create();
				if($cart_id) {
					$cd['ConfirmationDelivery']['type'] = 'part';
					$cd['ConfirmationDelivery']['cart_id'] = $cart_id;
				} else {
					$cd['ConfirmationDelivery']['type'] = 'full';
					$cd['ConfirmationDelivery']['cart_id'] = $confirmation['Confirmation']['cart_id'];
				}
				
				$cd['ConfirmationDelivery']['delivery_id'] = $currDeliveryId;
				$cd['ConfirmationDelivery']['confirmation_id'] = $confirmation['Confirmation']['id'];
				$this->ConfirmationDelivery->save($cd);
				
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

	public function admin_convertPart($confirmation_id = null, $edit = false) {
		$this->layout = 'ajax';
		
		$confirmation = $this->Confirmation->findById($confirmation_id);
		$cart = $this->Cart->findById($confirmation['Cart']['id']);
		
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
			
			echo $cart_id;
			$this->render(false);
		}
		
		$this->request->data = $confirmation;
		$this->request->data['CartProduct'] = $cart['CartProduct'];
		
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
					if(strpos($data['Delivery']['status'], 'cancel') !== FALSE) {
						if(strpos($this->request->data['Delivery']['status'], 'custom') !== FALSE){
							$this->request->data['Delivery']['status'] = "custom_close";
						} else {
							$this->request->data['Delivery']['status'] = "close";
						}
					}
				} else {
					$this->request->data['Delivery']['deliver_date'] = null;
					if(strpos($data['Delivery']['status'], 'cancel') !== FALSE) {
						if(strpos($this->request->data['Delivery']['status'], 'custom') !== FALSE){
							$this->request->data['Delivery']['status'] = "custom_open";
						} else {
							$this->request->data['Delivery']['status'] = "open";
						}
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
		
		if(strpos($delivery['Delivery']['status'], 'custom') !== FALSE){
			$data['Delivery']['status'] = "custom_close";
		} else {
			$data['Delivery']['status'] = "close";
		}
	
				
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
		$countMonthDeliveries = count($this->Delivery->find('all',array('conditions' => array('Delivery.created BETWEEN ? AND ?' => array(date('Y-m-01 00:00:01'), date('Y-m-d 23:59:59'))))))+1;
		$countMonthDeliveries = str_pad($countMonthDeliveries, 3, "0", STR_PAD_LEFT);
		// 11 = aktueller Monat
		$month = date('m');
		// 017 = laufende Anzahl im Jahr - dreistellig
		$countYearDeliveries = count($this->Delivery->find('all',array('conditions' => array('Delivery.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d'))))))+1;
		$countYearDeliveries = str_pad($countYearDeliveries, 3, "0", STR_PAD_LEFT);
		
		// Lieferschein Nr.: 01711/478
		return $countMonthDeliveries.$month.'/'.$countYearDeliveries;
	}
	
	function generateData($data = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
		$Confirmations = new ConfirmationsController();

		if(!$data || !isset($data['Confirmation'])) {
			$confirmation_id = $data['ConfirmationDelivery']['confirmation_id'];
			$data = $this->Confirmation->findById($confirmation_id);		
		} 
				
	    $this->request->data = $data;
		
		if(!empty($data)) {
			
	    	$cart = $Carts->get_cart_by_id($data['Delivery']['cart_id']);
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart, 0, 1);
				
			$cart = $Carts->calcSumPrice($cart);
			
			$this->request->data['Cart'] = $cart['Cart'];
		
			$this->request->data += $cart;
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
			if(isset($this->request->data['Delivery']['address_id'])) {
				$addressDelivery = $this->Address->findById($this->request->data['Delivery']['address_id']);
				$this->request->data['Address'] = $addressDelivery['Address'];
			} else {
				$this->request->data = $Addresses->getAddressByType($this->request->data, 3, TRUE);
			}
		}
		
		$a = $Addresses->splitAddressData($this->request->data);
		
		$this->request->data['Address'] += $a['Address'];
		
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
				$item += $this->Confirmation->findByDeliveryId($item['Delivery']['id']);
			}

			//Load Customer for the Delivery
			if($item['Confirmation']['cart_id'] != 0) {
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
