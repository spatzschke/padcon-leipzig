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
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'Delivery', 'AddressAddresstype', 'Process');
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
	
		//$this->Confirmation->recursive = 0;
		$this->Offer->recursive = 0;
		$this->Paginator->settings = array(
		    'order' => 'substring(Confirmation.confirmation_number, 5, 6) DESC, substring(Confirmation.confirmation_number, 1, 3) DESC',
		    'limit' => 25
		    );
	    $data = $this->Paginator->paginate('Confirmation');
			
		$this->set('title_for_panel', 'Alle Auftragsbestätigungen');	
		
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
		$options = array('conditions' => array('Process.confirmation_id' => $id, 'Process.type' => ''));
		$process = $this->Process->find('first', $options);
		
		$this->set('confirmation', $process);
		$this->set('pdf', null);
	
		$this->generateData($this->Process->findByConfirmationIdAndType($id, ''));
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
			
			// Wenn es noch eine leere AB (ohen Kunden) gibt, dann nimm die
			$emptyConfirmation = $this->Confirmation->find('first', array('conditions' => array('customer_id' => NULL, 'not' => array('Confirmation.cart_id' => 0))));
			if(!empty($emptyConfirmation)) {
				$this->Session->setFlash(__('Eine leere AB wurde gefunden! Bitte diese Ausfüllen.'));
				$this->redirect(array('action'=>'add', $emptyConfirmation['Confirmation']['id']));
			}
						
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
			
			//Erstelle neuen Prozess
			$this->Process->create();
			$proc['Process']['confirmation_id'] = $id;
			$proc['Process']['cart_id'] = $cart['Cart']['id'];
			$this->Process->save($proc);

			$this->redirect(array('action'=>'add', $id));
		}

		$this->generateData($this->Process->findByConfirmationId($id));
		$controller_name = 'Confirmations'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name','confirmation'));
	}

	public function admin_add_individual($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		if (!empty($this->data)) {
			$confirmation = null;	
			
			$offer_id = $id;
											
			$this->Confirmation->create();
			
			$data = $this->data;
			
			$data['Confirmation']['status'] = 'open';
			$data['Confirmation']['custom'] = '1';
			$data['Confirmation']['agent'] = 'Ralf Patzschke';
			$data['Confirmation']['confirmation_number'] = $this->data['Confirmation']['confirmation_number'];
			
			
			if(isset($offer_id)) {
				$offer_id = $id;
				$offer = $this->Offer->findById($offer_id);
					
				$data['Confirmation']['offer_id'] = $id;
				$data['Confirmation']['customer_id'] = $offer['Offer']['customer_id'];
				$data['Confirmation']['confirmation_price'] = $offer['Offer']['offer_price'];
				$data['Confirmation']['discount'] = $offer['Offer']['discount'];
			}
			
			$this->Confirmation->save($data);
			$id = $this->Confirmation->id;
			
			// Generate Hash für AB
			$data['Confirmation']['id'] =  $id;
			$data['Confirmation']['hash'] =  Security::hash($id, 'md5', true);
			$this->Confirmation->save($data);
			
			
			
			if(isset($offer_id)) {
				// Trage AB-Nummer in Angebot ein
				$offerArr['Offer']['id'] = $offer_id;
				$offerArr['Offer']['confirmation_id'] =  $id;
				$this->Offer->save($offerArr);
				
				//AB dem Prozess mit Offer zuschlüsseln
				$proc = $this->Process->findByOfferId($offer_id);
				$proc['Process']['confirmation_id'] =  $id;
				$this->Process->save($proc);				
				
			} else {
				//Neuen Prozess starten
				$proc['Process']['confirmation_id'] =  $id;
				$this->Process->save($proc);
			}

			$this->redirect(array('action'=>'edit_individual', $id));
		} 
		
		if($id){
			// Wenn es noch eine leere AB (ohen Kunden) gibt, dann nimm die
			$empty = $this->Confirmation->find('first', array('conditions' => array('customer_id' => NULL, 'Confirmation.cart_id' => 0)));
			if(!empty($empty)) {
				$this->Session->setFlash(__('Eine leere individuelle AB wurde gefunden! Bitte dieses ausfüllen.'));
				$this->redirect(array('action'=>'edit_individual', $empty['Confirmation']['id']));
			}
		}
		
		
		$data['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
		
		$this->request->data = $data;
		
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Individuelle Auftragsbestätigung anlegen');		
		$controller_name = 'Confirmations'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name','data'));
		
		$this->render('admin_individual');
	}

	public function admin_edit_individual($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		$data = $this->Confirmation->findById($id);
		
		
		if (!empty($this->data)) {
			$data = null;			
			
			$data = $this->data;
			$data['Confirmation']['order_date'] = date('Y-m-d',strtotime($data['Confirmation']['order_date']));
			// $data['Confirmation']['created'] = date('Y-m-d',strtotime($data['Confirmation']['created']));
			// $data['Confirmation']['modified'] = date('Y-m-d',strtotime($data['Confirmation']['created']));
			$data['Confirmation']['id'] = $id;
			
			//Preis von Komma auf Punkt konvertieren
			$Carts = new CartsController();
			$data['Confirmation']['cost'] = $Carts->convertPriceToSql($data['Confirmation']['cost']);
			$data['Confirmation']['confirmation_price'] = $Carts->convertPriceToSql($data['Confirmation']['confirmation_price']);
			
			if($data['Confirmation']['customer_id'] == "") {
				$this->Session->setFlash(__('Bitte geben Sie einen Kunden ein!'), 'flash_message', array('class' => 'alert-danger'));
			}elseif($data['Confirmation']['confirmation_price'] == "") {
				$this->Session->setFlash(__('Bitte geben Sie eine AB-Gesamtsumme ein!'), 'flash_message', array('class' => 'alert-danger'));
			} else {
				if($this->Confirmation->save($data)) {
					$this->Session->setFlash(__('Auftragsbestätigung wurde aktualisiert.'));
					
					//Kunde an Prozess übertragen
					$proc = $this->Process->findByConfirmationId($id);
					$proc['Process']['customer_id'] =  $data['Confirmation']['customer_id'];
					$this->Process->save($proc);							
					
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('Konnte nicht gespeichert werden'));
				}
			}

			$this->request->data = $data;
			
			$this->set('primary_button', 'Speichern');
			$this->set('title_for_panel', 'Individuelle Auftragsbestätigung anlegen');	
			
			$this->render('admin_individual');

		} else {
			if(empty($data['Confirmation']['additional_text'])) {
				$data['Confirmation']['additional_text'] = Configure::read('padcon.Auftragsbestaetigung.additional_text.default');
			}
			
			if(strcmp($data['Confirmation']['additional_text'],Configure::read('padcon.Auftragsbestaetigung.additional_text.default'))>=0) {
				$data['Confirmation']['order_date'] = date('d.m.Y',strtotime($data['Confirmation']['order_date']));	
				$data['Confirmation']['created'] = date('d.m.Y',strtotime($data['Confirmation']['created']));
				$data['Confirmation']['modified'] = date('d.m.Y',strtotime($data['Confirmation']['created']));
			}
			$data['Confirmation']['order_date'] = date('d.m.Y');
			if($data['Confirmation']['discount'] == 0)
				$data['Confirmation']['discount'] = null;
			
			if($data['Confirmation']['confirmation_price'] == 0)
				$data['Confirmation']['confirmation_price'] = null;
				
			if($data['Confirmation']['cost'] == 0)
				$data['Confirmation']['cost'] = null;
			$this->request->data = $data;
			
			$this->set('primary_button', 'Speichern');
			$this->set('title_for_panel', 'Individuelle Auftragsbestätigung anlegen');		
			$controller_name = 'Confirmations'; 
			$controller_id = $id;
			$this->set(compact('controller_id', 'controller_name','confirmation'));
			
			$this->render('admin_individual');
		}
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
			$this->generateData($this->Process->findByConfirmationId($id));
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

	public function admin_convert($offer_id = null) {
		$this->layout = 'admin';		
		if($offer_id) {
								
			$process = $this->Process->findByOfferId($offer_id);	
							
			if($process['Process']['confirmation_id'] == '0') {
				
				$this->Confirmation->create();
				$confirmation['Confirmation']['status'] = 'open';
				$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
				$confirmation['Confirmation']['customer_id'] = $process['Offer']['customer_id'];
				$confirmation['Confirmation']['offer_id'] = $process['Offer']['id'];
				$confirmation['Confirmation']['discount'] = $process['Offer']['discount'];
				$confirmation['Confirmation']['delivery_cost'] = $process['Offer']['delivery_cost'];
				$confirmation['Confirmation']['vat'] = $process['Offer']['vat'];
				$confirmation['Confirmation']['confirmation_price'] = $process['Offer']['offer_price'];
				$confirmation['Confirmation']['order_date'] = date('Y-m-d');
				$confirmation['Confirmation']['custom'] = false;
				$confirmation['Confirmation']['pattern'] = false;
				
				//Gernerierung der Auftragsbestätigungsnummer
				$confirmation['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
				
				//Default settings
				$confirmation['Confirmation']['additional_text'] = Configure::read('padcon.Auftragsbestaetigung.additional_text.default');
				
				//Warenkorb des Angebots kopieren
				$confirmationCart = $this->Cart->findById($process['Cart']['id']);
				$confirmationCart['Cart']['id'] = NULL;
				$this->Cart->save($confirmationCart);
		
				//Kopierten Cart in AB einfügen
				$lastCartId = $this->Cart->getLastInsertId();
				$confirmation['Confirmation']['cart_id'] = $lastCartId;
				
				
				//Alle Cart_Producte aus Angebot in AB Cart kopieren
				$cartProducts = $this->CartProduct->find('all',array('conditions' => array('CartProduct.cart_id' => $process['Process']['cart_id'])));
				foreach ($cartProducts as $cartProduct) {
					$this->CartProduct->create();
					$cartItem['CartProduct'] = $cartProduct['CartProduct'];
					$cartItem['CartProduct']['cart_id'] = $lastCartId;
					unset($cartItem['CartProduct']['created']);
					unset($cartItem['CartProduct']['id']);
					unset($cartItem['CartProduct']['modified']);			
					$this->CartProduct->save($cartItem);
				}

				//Kosten aus Cart der Offer in AB übernehmen
				$confirmation['Confirmation']['cost'] = $confirmationCart['Cart']['sum_base_price'];
				
				//Erste AB-Adresse zum Kunden finden
				$Addresses = new AddressesController(); 
				$address = $Addresses->getAddressByType($process, 2, TRUE);
				$confirmation['Confirmation']['address_id'] = $address['Address']['id'];
				
				$this->Confirmation->save($confirmation);
				$currConfirmationId = $this->Confirmation->getLastInsertId();
				
				//Neue Auftragsbestätigungs-ID der AB hinzufügen speichern 
				$confirmation['Confirmation']['id'] = $currConfirmationId;
				
				// Generate Hash für Offer
				$confirmation['Confirmation']['hash'] =  Security::hash($currConfirmationId, 'md5', true);
				$this->Confirmation->save($confirmation);
				
				//Neue Auftragsbestätigungs-ID in Prozess speichern 
				// $confirmation['Offer']['confirmation_id'] = $currConfirmationId;
				// $this->Offer->save($confirmation);
				$proc['Process']['id'] = $process['Process']['id'];
				$proc['Process']['confirmation_id'] = $currConfirmationId;
				$proc['Process']['cart_id'] = $lastCartId;
				$this->Process->save($proc);
				
				$this->generateData($this->Confirmation->findById($currConfirmationId));
				
				$this->set('pdf', null);
				
				$controller_name = 'Confirmations'; 
				$controller_id = $currConfirmationId;
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->render('admin_add');
				
			} else {
			//	$this->Session->setFlash(__('Auftragsbestätigung bereits vorhanden'));
				return $this->redirect(array('action' => 'edit', $process['Process']['confirmation_id']));
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

	function admin_table_setting($id = null) {
		
		$this->layout = 'ajax';

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$data = $this->Confirmation->findById($id);
				
				$this->request->data['Confirmation']['created'] = date('Y-m-d',strtotime($this->request->data['Confirmation']['created']));
				
				$this->Confirmation->id = $this->request->data['Confirmation']['id'];
				$this->Confirmation->save($this->request->data);
				        
							
			} else {
				$data = $this->Confirmation->findById($id);
				
				$date = date_create_from_format('Y-m-d', $data['Confirmation']['created']);
				$data['Confirmation']['created'] = date_format($date, 'd.m.Y');
				
				$this->request->data = $data;
				
			}
		}
		
		$controller_name = 'Confirmations'; 
		$controller_id = $data['Confirmation']['id'];
		
		$this->set(compact('controller_id', 'controller_name'));
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
								
				if($this->request->data['Confirmation']['pattern'] == '1') {
					$confirmation['Confirmation']['pattern'] = true;
				} else {
					$confirmation['Confirmation']['pattern'] = false;	
				}				
				
				$confirmation['Confirmation']['order_number'] = $this->request->data['Confirmation']['order_number'];
								
				$confirmation['Confirmation']['delivery_cost'] = $this->request->data['Confirmation']['deliveryCost'];
				
				if($this->Confirmation->save($confirmation)){
					$this->Session->setFlash(__('Speicherung erfolgreich', true));
				} else {
					$this->Session->setFlash(__('Es kam zu Fehlern beim Speichern', true));
				}
				
				$data = $this->Process->findByConfirmationId($id);
				$data['CartProducts'] = $this->getSettingCartProducts($data);
				
				$cart = $this->Cart->findById($data['Process']['cart_id']);
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
		
		$Carts->updateCart($confirmation['Cart']);
		
		$confirmation['CartProducts'] = $this->getSettingCartProducts($confirmation);
		$this->request->data = $confirmation;
		
		$controller = 'Confirmations'; 
		$controller_id = $confirmation_id;

		$this->set(compact('controller_id', 'controller'));
		
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
			
			if(empty($confirmation['Confirmation']['confirmation_number'])) {
				$confirmation['Confirmation']['confirmation_number'] = $this->generateConfirmationNumber();
			}
			$confirmation['Confirmation']['customer_id'] = $id;
			
			//Prozess updaten
			$process = $this->Process->findByConfirmationId($confirmation_id);
			$proc['Process']['id'] = $process['Process']['id'];
			$proc['Process']['customer_id'] = $id;
			$this->Process->save($proc);			
			
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
			 	'Cart.id' => $confirmation['Confirmation']['cart_id']
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

	function generateData($process = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();

	    $this->request->data = $process;
		
		
		if(!empty($process)) {
			
	    	$cart = $Carts->getCartById($process['Cart']['id']);
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart);			
			$this->request->data += $cart;
		}

		if(!isset($this->request->data['Address'])) {
			$this->request->data = $Addresses->getAddressByType($this->request->data, 2, TRUE);
		}
			
		if(isset($this->request->data['Address'])) {
			$a = $Addresses->splitAddressData($this->request->data);
			$this->request->data['Address'] += $a['Address'];
		}
		$this->request->data['Address']['count'] = $this->AddressAddresstype->find('count', array('conditions' => array(
			'customer_id' => $process['Process']['customer_id'],
			'type_id' => 1)));

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
			if($data['Confirmation']['custom']){
				$arr_data['Confirmation']['confirmation_price'] = $data['Confirmation']['confirmation_price'];
			} else {
				$arr_data['Confirmation']['confirmation_price'] = 0;
			}			
		} else {
			$arr_data['Confirmation']['confirmation_price'] = $data_price;
		}	

		//Kosten von Cart in AB übertragen/aktualisieren
		$arr_data['Confirmation']['cost'] = $data['Cart']['sum_base_price'];

		if(!$data['Confirmation']['id']) {
			 $data['Confirmation']['id'] = $data['Process']['confirmation_id']; 
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
		$countMonthConfirmations = count($this->Confirmation->find('all',array('conditions' => array('Confirmation.created BETWEEN ? AND ?' => array(date('Y-m-01 00:00:00'), date('Y-m-d 00:00:00', strtotime("+1 days")))))));
		$countMonthConfirmations++;
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
			
			$cart = $Carts->getCartById($item['Cart']['id']);
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
			
			
			//Wenn Teillierferung dann alle Lierscheine laden
			if(count($item['Process']) > 1) {
				
				foreach($item['Process'] as $key => $proc) {
					$del = $this->Delivery->findById($proc['delivery_id']);
					if(!empty($del))
						$item['Process'][$key]['delivery_number'] = $del['Delivery']['delivery_number'];
				}
			}
						
			array_push($data_temp, $item);
			
			
			
		}	
			
		return $data_temp;
	}

	function reloadSheet($id = null) {
		$this->layout = 'ajax';
		$this->set('pdf', null);
		
		$data = $this->Process->findByConfirmationId($id);
		
		$this->generateData($data);
		$calc = $this->calcPrice($data);
		
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
	    	$cart = $Carts->getCartById($data['Cart']['id']);
			
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
	
	function admin_fillConfirmationCosts() {
		$confirmations = $this->Confirmation->find('all');
		foreach ($confirmations as $key => $value) {
				
			if($value['Confirmation']['cost'] == 0 || $value['Confirmation']['cart_id'] != 0){
				$cart = $this->Cart->findById($value['Confirmation']['cart_id']);
				
				if(isset($cart['Cart'])) {
					$con['Confirmation']['id'] = $value['Confirmation']['id'];				
					$con['Confirmation']['cost'] = $cart['Cart']['sum_base_price'];
					
					if($this->Confirmation->save($con)) {
						$this->Session->setFlash(__('ABs aktualsiert', true));
					} else {			
						$this->Session->setFlash(__('Fehler', true));
					}
				}
			}			
		}
		
		$this->redirect(array('controller' => 'pages', 'action' => 'setting'));
	}
	
	function admin_fillPorcessIndex() {
		$confirmations = $this->Confirmation->find('all');
		foreach ($confirmations as $key => $value) {
			$process = array();			
			$conf = $this->Process->findByConfirmationId($value['Confirmation']['id']);
			if(empty($conf)) {
				$this->Process->create();
				$process['Process']['confirmation_id'] = $value['Confirmation']['id'];
				if($value['Delivery']['id'])
					$process['Process']['delivery_id'] = $value['Delivery']['id'];
				if($value['Billing']['id'])
					$process['Process']['billing_id'] = $value['Billing']['id'];
				$process['Process']['customer_id'] = $value['Confirmation']['customer_id'];
				$process['Process']['cart_id'] = $value['Confirmation']['cart_id'];
				
				if(isset($value['Delivery']['id'])) { $process['Process']['type'] = 'full'; }
				
				$offer = $this->Offer->findByConfirmationId($value['Confirmation']['id']);
				if(!empty($offer)) { $process['Process']['offer_id'] = $offer['Offer']['id']; }
				
				$this->Process->save($process);		
			}
					
		}
		
		$this->redirect(array('controller' => 'pages', 'action' => 'setting'));
	}
	
}
