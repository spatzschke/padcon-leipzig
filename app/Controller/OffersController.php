<?php
App::import('Controller', 'Carts');
App::import('Controller', 'Products');
App::import('Controller', 'Customers');
App::import('Controller', 'Addresses');

class OffersController extends AppController {

	var $name = 'Offers';
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'User', 'AddressAddresstype', 'Process');
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
			$this->Auth->allow('createPdf');
			
		}
	}

	function admin_index() {
		$this->layout = 'admin';
	
		$this->Offer->recursive = 0;
		$offers = $this->Offer->find('all', array('order' => array('Offer.id DESC')));
		
		$this->set('title_for_panel', 'Alle Angebote');	
		
		$this->set('offers', $this->fillIndexData($offers));
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		$offer = $this->Offer->read(null, $id);
		
		$this->set('offer', $offer);
		$this->set('pdf', null);
		//$this->request->data = $offer;
		$this->generateData($offer);
	}

	function admin_add($layout = "admin") {		
		$this->layout = $layout;
		$this->set('pdf', null);	
		$offer = null;	
		
		// Wenn es noch eine leere Offer (ohne Kunden) gibt, dann nimm die
		$empty = $this->Offer->find('first', array('conditions' => array('Offer.customer_id' => '0')));		
		if(!empty($empty)) {
			//$this->Session->setFlash(__('Eine leeres Angebot wurde gefunden! Bitte diese Ausfüllen.'));
			$this->redirect(array('action'=>'edit', $empty['Offer']['id']));
		}
		
		//Erzeuge neuen Cart
		$cart = $this->requestAction('/admin/carts/add/');
		
		$this->Offer->create();
		
		$data['Offer']['status'] = 'open';
		$data['Offer']['agent'] = 'Ralf Patzschke';
		$data['Offer']['customer_id'] = 0;
		$data['Offer']['cart_id'] = $cart['Cart']['id'];
		$data['Offer']['custom'] = FALSE;
		
		//Default settings
		$data['Offer']['additional_text'] = Configure::read('padcon.Angebot.additional_text.default');
		$this->Offer->save($data);
		$data_id = $this->Offer->id;
		
		$this->generateData($this->Offer->findById($data_id));
		$data['Offer']['id'] = $data_id;
		
		//Starte neuen Prozess
		$this->Process->create();
		$proc['Process']['offer_id'] = $data_id;
		$proc['Process']['customer_id'] = $data['Offer']['customer_id'];
		$proc['Process']['cart_id'] = $cart['Cart']['id'];
		$this->Process->save($proc);
				
		// Generate Hash für Offer
		$data['Offer']['hash'] =  Security::hash($this->Offer->id, 'md5', true);
		$this->Offer->save($data);
		
		//Alt-Last
		$offer = $data;
		$this->set(compact('data','offer'));
		
		//$this->redirect(array('action'=>'edit', $data_id));
	}

	public function admin_add_individual($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
			
		if (!empty($this->data)) {
			$data = null;	
											
			$this->Offer->create();
			
			$data = $this->data;
			
			$data['Offer']['status'] = 'open';
			$data['Offer']['custom'] = '1';
			$data['Offer']['offer_number'] = $this->data['Offer']['offer_number'];
			
			$this->Offer->save($data);
			$offer_id = $this->Offer->id;
		
			// Generate Hash für AB
			$data['Offer']['id'] =  $offer_id;
			$data['Offer']['hash'] =  Security::hash($id, 'md5', true);
			$this->Offer->save($data);

			$this->redirect(array('action'=>'edit_individual', $offer_id));
		} 
		
		// Wenn es noch eine leere AB (ohen Kunden) gibt, dann nimm die
		$empty = $this->Offer->find('first', array('conditions' => array('Offer.customer_id' => NULL, 'Offer.cart_id' => 0)));
		if(!empty($empty)) {
			$this->Session->setFlash(__('Ein leeres individuelles Angebot wurde gefunden! Bitte dieses ausfüllen.'));
			$this->redirect(array('action'=>'edit_individual', $empty['Offer']['id']));
		}
			
		$data['Offer']['offer_number'] = $this->generateOfferNumber();
		
		$this->request->data = $data;
		
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Individuelles Angebot anlegen');		
		$controller_name = 'Offers'; 
		$controller_id = $id;
		$this->set(compact('controller_id', 'controller_name','data'));
		
		$this->render('admin_individual');
	}

	public function admin_edit_individual($id = null) {
		
		$this->layout = "admin";
		$this->set('pdf', null);
		
		$data = $this->Offer->findById($id);
		
		if (!empty($this->data)) {
			$data = null;			
			
			$data = $this->data;
			$data['Offer']['request_date'] = date('Y-m-d',strtotime($data['Offer']['request_date']));
			$data['Offer']['id'] = $id;
			
			if($this->Offer->save($data)) {
				$this->Session->setFlash(__('Angebot wurde gespeichert!'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Fehler beim Speichern.'));
			}

		} else {
			if(empty($data['Offer']['additional_text'])) {
				$data['Offer']['additional_text'] = Configure::read('padcon.Angebot.additional_text.default');
			}
			
			if(strcmp($data['Offer']['additional_text'],Configure::read('padcon.Angebot.additional_text.default'))>=0) {
				$data['Offer']['request_date'] = date('d.m.Y',strtotime($data['Offer']['request_date']));	
				$data['Offer']['created'] = date('d.m.Y',strtotime($data['Offer']['created']));
				$data['Offer']['modified'] = date('d.m.Y',strtotime($data['Offer']['created']));
			}
			$data['Offer']['request_date'] = date('d.m.Y');
			if($data['Offer']['discount'] == 0)
				$data['Offer']['discount'] = null;
			
			if($data['Offer']['offer_price'] == 0)
				$data['Offer']['offer_price'] = null;
			$this->request->data = $data;
			
			$this->set('primary_button', 'Speichern');
			$this->set('title_for_panel', 'Individuelles Angebot bearbeiten');		
			$controller_name = 'Offers'; 
			$controller_id = $id;
			$this->set(compact('controller_id', 'controller_name','data'));
			
			$this->render('admin_individual');
		}
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		
		$offer = $this->Offer->read(null, $id);
		
		$this->set('offer', $offer);
		$this->set('pdf', null);
		//$this->request->data = $offer;
		$this->generateData($offer);
		$this->render('admin_add'); 
	}
	
	function admin_update($customer_id = null, $offer_id = null, $address_id = null) {
		$Addresses = new AddressesController();
		
		$this->layout="ajax";
		
		//Angebot, Prozess und Customer beziehen
		$offer = $this->Offer->findById($offer_id);
		$customer = $this->Customer->findById($customer_id);
		$process = $this->Process->findByOfferId($offer['Offer']['id']);
		
		if($offer) {
			
			//Offer-Status setzen
			$offer['Offer']['status'] = 'open';
			$offer['Offer']['customer_id'] = $customer['Customer']['id'];
			$offer['Customer'] = $customer['Customer'];
			
			//Addressen suchen						
			if(!is_null($address_id)) {
				$address = $this->Address->findById($address_id);
				$offer['Offer']['address_id'] = $address['Address']['id'];
				$offer['Offer']['Address'] = $address['Address'];
			} else {
			//Suche erste Adresse
				$offer = $Addresses->getAddressByType($offer, 1, TRUE);	
				$offer['Offer']['address_id'] = $offer['Address']['id'];
			}
			
			//Prozess aktualisieren
			$process['Process']['customer_id'] = $customer_id;
			$this->Process->save($process);
			
			//Offer-Nummer generieren
			if(empty($confirmation['Offer']['offer_number'])) {
				$offer['Offer']['offer_number'] = $this->generateOfferNumber($customer['Customer']['id']);
			}
			
			$this->Offer->save($offer);
			
		} else {
			$this->Session->setFlash(__('Fehler beim der Aktualisierung des Angebots!'));
		}	
		
		$this->request->data = $offer;
				
		//echo json_encode($offer['Offer']);
		$this->autoRender = false;
		$this->layout = 'admin';
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for offer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Offer->delete($id)) {
			$this->Session->setFlash(__('Offer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Offer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function createPdf ($hash = null) { 
		$result = $this->Offer->findByHash($hash);
		if(!empty($result)) {
			 $this->pdfConfig = array(
	            'orientation' => 'portrait',
	            'filename' => 'Invoice_' . $hash
	            );
			$this->admin_createPdf($result['Offer']['id']);
		} 			
	}

	function admin_createPdf ($offerID = null){

		$this->layout = 'pdf';
		
		$pdf = true;
		if(!$offerID) {
			$offer = $this->getActiveOffer();
		} else {
			$offer = $this->Offer->findById($offerID);
		}
		
		$this->generateData($this->Offer->findById($offerID));
		
		$title = "Angebot_".str_replace('/', '-', $offer['Offer']['offer_number']);
		$this->set('title_for_layout', $title);
		
		$this->set('pdf', $pdf);
		$this->set(compact('offer','pdf'));
      	$this->render('admin_add'); 
	    
	}
	
	function admin_settings($id = null) {
		
		$this->layout = 'ajax';
				
		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
								
				$offer = $this->Offer->findById($this->request->data['Offer']['id']);
				
				$offer['Offer']['discount'] = $this->request->data['Offer']['discount'];
				$offer['Offer']['additional_text'] = $this->request->data['Offer']['additional_text'];
				
				$de_Date = $this->request->data['Offer']['request_date'];
				
				if(!empty($this->request->data['Offer']['request_date'])) {					
					$date = date_create_from_format('d.m.Y', $this->request->data['Offer']['request_date']);
					$offer['Offer']['request_date'] = date_format($date, 'Y-m-d');
				}	
								
				$offer['Offer']['request_number'] = $this->request->data['Offer']['request_number'];
				$offer['Offer']['delivery_cost'] = $this->request->data['Offer']['deliveryCost'];
				
				if($this->Offer->save($offer)){
					$this->Session->setFlash(__('Speicherung erfolgreich', true));
				} else {
					$this->Session->setFlash(__('Es kam zu Fehlern beim Speichern', true));
				}
				
				$offer['CartProducts'] = $this->getSettingCartProducts($offer);

				
				$cart = $this->Cart->findById($offer['Offer']['cart_id']);
				$controller_id = 0;
				$controller_name = '';
				
				$controller_name = 'Offers';
				$controller_id = $cart['Offer']['id'];
				$this->set(compact('controller_id', 'controller_name'));
				
				$offer['Offer']['request_date'] = $de_Date;
				
				$this->request->data = $offer;
							
			} else {
				$offer = $this->Offer->findById($id);
				
				if($offer['Offer']['request_date'] == null || $offer['Offer']['request_date'] == '0000-00-00') {
					$offer['Offer']['request_date'] = date('d.m.Y');
				} else {
					$date = date_create_from_format('Y-m-d', $offer['Offer']['request_date']);
					$offer['Offer']['request_date'] = date_format($date, 'd.m.Y');
				}
				
				
				$offer['Offer']['cart_id'] = $offer['Offer']['cart_id'];
				
				if(empty($offer['Offer']['additional_text'])) {
					$offer['Offer']['additional_text'] = Configure::read('padcon.Angebot.additional_text.default');
				} 				
				
				$offer['CartProducts'] = $this->getSettingCartProducts($offer);
				
				$cart = $this->Cart->findById($offer['Offer']['cart_id']);
				$controller_id = 0;
				$controller_name = '';
				if(isset($cart['Offer']['id'])) {
					$controller_name = 'Offers';
					$controller_id = $cart['Offer']['id'];
				}
				if(isset($cart['Confirmation']['id'])) {
					$controller_name = 'Confirmations'; 
					$controller_id = $cart['Confirmation']['id'];
				}
				$this->set(compact('controller_id', 'controller_name'));
				
				$this->request->data = $offer;
				
				$lastOfferByCustomer = $this->Offer->find('all', array(
					'order' => array('Offer.id' => 'desc'),
			        'conditions' => array('Customer.id' => $offer['Customer']['id'])
			    ));
				
				$this->request->data['Customer']['last_discount'] = $lastOfferByCustomer[0]['Offer']['discount'];
				
			    // Use data from serialized form
			    // print_r($this->request->data['Contacts']); // name, email, message
			    $this->render('admin_settings', 'ajax'); // Render the contact-ajax-response view in the ajax layout
			}
		}
		
		
	}

	function admin_table_setting($id = null) {
		
		$this->layout = 'ajax';

		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$data = $this->Offer->findById($id);
				
				$this->request->data['Offer']['created'] = date('Y-m-d',strtotime($this->request->data['Offer']['created']));
				
				$this->Offer->id = $this->request->data['Offer']['id'];
				
				debug($this->request->data);
				
				$this->Offer->save($this->request->data);
				        
							
			} else {
				$data = $this->Offer->findById($id);
				
				$data['Offer']['created'] = date('d.m.Y',strtotime($data['Offer']['created']));
				
				$this->request->data = $data;
				
			}
		}
		
		$controller_name = 'Offers'; 
		$controller_id = $data['Offer']['id'];
		
		$this->set(compact('controller_id', 'controller_name'));
	}

	function admin_removeProductFromOffers($id = null, $offer_id = null) {
		
		$this->layout = 'ajax';
		$this->autoRender = false;
		
		$offer = $this->Offer->findById($offer_id);
		
		//Lösche Eintrag
		if ($id) {
			$this->CartProduct->delete($id);
		}
		$Carts = new CartsController();		
		$Carts->updateCart($offer['Cart']);
		
		$offer = $this->Offer->findById($offer_id);
		
		$offer['CartProducts'] = $this->getSettingCartProducts($offer);
		
		$this->request->data = $offer;
		
		$this->set('controller', 'Offer');
		$this->set('controller_id', $id);
		
		$this->render('/Elements/backend/portlets/Product/settingsProductTable');
	}
	
	function search($searchString = null) {
	
		if($this->Auth) {
			echo $this->admin_search($searchString);
		} 		
	}
	
	function admin_search($searchString = null) {
		
		$this->layout = 'ajax';
		
		$offers = $this->Offer->find('all',array('conditions' => array("OR" => 
			array (	'Offer.offer_number LIKE' 			=> '%'.$this->data['str'].'%' ,
					'Offer.customer_id LIKE' 	=> '%'.$this->data['str'].'%' ,
					'Offer.confirmation_id LIKE' 	=> '%'.$this->data['str'].'%')),
					'order' => array('Offer.created DESC', 'Offer.id DESC')));	
		
		$this->set('data', $this->fillIndexData($offers));
		
		if(isset($this->data['template'])) {
			$this->render($this->data['template']);
		}
	}

	function getSettingCartProducts($offer) {
		$cart = $this->Cart->find('first', array(
			'conditions' => array(
			 	'Cart.id' => $offer['Cart']['id']
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

	function gerneratePdfContent() {
		$html =	$this->render('admin_add');	
		return $html;
		
	}
	
	/*
	
		GETTeR & SETTER
	
	*/

	
	
	function reloadSheet($offer_id = null) {
		$this->layout = 'ajax';
		$this->set('pdf', null);
		
		$offer = $this->Offer->find('first', array('conditions' => array('Offer.id' => $offer_id)));
		
		$this->generateData($offer);
		
		array_push($this->request->data['Offer'] ,$this->generateData($offer));
		
		$this->render('/Elements/backend/SheetOffer');
	}
	
	function calcPrice($offer = null) {
		
		$arr_offer = null;
		
		$discount_price = $offer['Offer']['discount'] * $offer['Cart']['sum_retail_price'] / 100;
		$part_price = $offer['Cart']['sum_retail_price'] - $discount_price + $offer['Offer']['delivery_cost'];
		$vat_price = $offer['Offer']['vat'] * $part_price / 100;
		$offer_price = floatval($part_price + $vat_price);
		
		if($offer['Cart']['sum_retail_price'] > Configure::read('padcon.delivery_cost.versandkostenfrei_ab') || strpos($offer['Offer']['additional_text'],"frei Haus.")!==false) {
			$delivery_cost = Configure::read('padcon.delivery_cost.frei');
		} else {
			if($offer['Offer']['delivery_cost'] != Configure::read('padcon.delivery_cost.paeckchen')) {
				$delivery_cost = Configure::read('padcon.delivery_cost.paket');
			} else {
				$delivery_cost = Configure::read('padcon.delivery_cost.paeckchen');
			}
		}
		
		$arr_offer['Offer']['delivery_cost'] = $delivery_cost;
		$arr_offer['Offer']['vat_price'] = $vat_price;
		$arr_offer['Offer']['discount_price'] = $discount_price;
		$arr_offer['Offer']['part_price'] = $part_price;
		
		
		
		if($offer['Cart']['sum_retail_price'] == 0) {
			if($offer['Offer']['custom']){
				$arr_data['Offer']['offer_price'] = $offer['Offer']['offer_price'];
			} else {
				$arr_data['Offer']['offer_price'] = 0;
			}	
		} else {
			$arr_offer['Offer']['offer_price'] = $offer_price;
		}
		
		
		$arr_offer['Offer']['id'] = $offer['Offer']['id'];

		$this->Offer->save($arr_offer['Offer']);
				
		return $arr_offer['Offer'];
	}

	function generateOfferNumber($customerId = null) {
	
		// Angebot Nr.: 204/091104
		// 204 = Fortlaufende Nummer im Jahr
		// 09 = laufende Nummer im Monat
		// 11 = Monat November
		// 04 = Anzahl der gemachten Angebote für den Kunden im laufendem Jahr
		
		// 204 = Fortlaufende Nummer im Jahr
		$countYearOffers = count($this->Offer->find('all',array('conditions' => array('Offer.created BETWEEN ? AND ?' => array(date('Y-01-01 00:00:00'), date('Y-m-d 00:00:00', strtotime("+1 days")))))));
		$countYearOffers = str_pad($countYearOffers, 2, "0", STR_PAD_LEFT);
		
		// 09 = laufende Nummer im Monat
		$countMonthOffers = count($this->Offer->find('all',array('conditions' => array('Offer.created BETWEEN ? AND ?' => array(date('Y-m-01 00:00:00'), date('Y-m-d 00:00:00', strtotime("+1 days")))))));
		$countMonthOffers = str_pad($countMonthOffers, 2, "0", STR_PAD_LEFT);
		// 11 = Monat November
		$month = date('m');
		// 04 = Anzahl der gemachten Angebote für den Kunden im laufendem Jahr
		$countCustomerOffers = count($this->Offer->find('all',array('conditions' => array('Offer.customer_id' => $customerId), 'Offer.created BETWEEN ? AND ?' => array(date('Y-01-01 00:00:00'), date('Y-m-d 00:00:00', strtotime("+1 days"))))))+1;
		$countCustomerOffers = str_pad($countCustomerOffers, 2, "0", STR_PAD_LEFT);
		
		// Angebot Nr.: 204/091104
		return $countYearOffers.'/'.$countMonthOffers.$month.$countCustomerOffers;
	}
	
	function generateData($offer = null) {
	
		$Addresses = new AddressesController(); 
					
	    $this->request->data = $offer;
		
		if(!empty($offer)) {
			$Carts = new CartsController();
	    	$cart = $Carts->get_cart_by_id($offer['Cart']['id']);		
			
			//Berechen Seitenbelegung mit Produkte
			$this->request->data['Pages'] = $Carts->calcPageLoad($cart);
			
			$this->request->data += $cart;
		}	
			
		if(empty($offer['Address']['id'])){		
			$this->request->data = $Addresses->getAddressByType($this->request->data, 1, TRUE);
		}
		if(!is_null($this->request->data['Address'])) {		
			$add = $Addresses->splitAddressData($this->request->data);
			$this->request->data['Address'] += $add['Address'];	
		}
		
		$this->request->data['Address']['count'] = $this->AddressAddresstype->find('count', array('conditions' => array(
			'customer_id' => $offer['Offer']['customer_id'],
			'type_id' => 1)));

		$this->request->data['Offer'] += $this->calcPrice($this->request->data);
		
		return 	$this->calcPrice($this->request->data);

	}
	
	function fillIndexData($offers = null) {
	
		$offers2 = array();
		$Carts = new CartsController();
		$Products = new ProductsController();
		$Customers = new CustomersController();
		$Addresses = new AddressesController();
		
		// for($i=0; $i<=10;$i++) {
		foreach ($offers as $offer) {
			
			//$offer = $offers[$i];
	
			if($Customers->splitCustomerData($offer)) {
				
				$offer['Customer'] += $Customers->splitCustomerData($offer);
			}			
			
			$cart = $Carts->get_cart_by_id($offer['Cart']['id']);
			$offer['Cart']['CartProduct'] = $cart['CartProduct'];
			if(!empty($cart['CartProduct'])) {
				$j = 0;
				foreach ($cart['CartProduct'] as $cartProd) {
					$product = $Products->getProduct($cartProd['product_id']);
					
					unset($product['Cart']);
					unset($product['Category']);
					unset($product['Material']);
					$offer['Cart']['CartProduct'][$j]['Information'] = $product;
					$j++;
				}
			}
			$offer['Offer'] = $offer['Offer'] + $this->calcPrice($offer);
						
			array_push($offers2, $offer);
			
		}	
			
		return $offers2;
	}
}
