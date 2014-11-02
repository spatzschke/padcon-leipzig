<?php
App::import('Controller', 'Carts');
App::import('Controller', 'Products');

class OffersController extends AppController {

	var $name = 'Offers';
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color');
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
			
		}
	}

	function admin_index() {
		$this->layout = 'admin';
	
		$this->Offer->recursive = 0;
		$offers = $this->Offer->find('all', array('order' => array('Offer.created DESC', 'Offer.id DESC')));
			
		$this->set('offers', $this->fillIndexOfferData($this->paginate()));
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
		$this->generateDataByOffer($offer);
	}

	function admin_add($isActive = null) {
		
		$active = null;
		$this->set('pdf', null);
		
		if(!$isActive) {
			$active = $this->Offer->find('first', array('conditions' => array('Offer.status' => 'active')));
		} 
		
		$offer = null;
		if($active || $isActive) {
			
			$this->request->data['Cart'] = array();
			$this->set(compact('offer', 'active'));
			
		} else {
		
			$cart = $this->requestAction('/admin/carts/add/');
			
			$this->Offer->create();
			
			$offer['Offer']['status'] = 'active';
			$offer['Offer']['agent'] = 'Ralf Patzschke';
			$offer['Offer']['customer_id'] = '';
			$offer['Offer']['cart_id'] = $cart['Cart']['id'];
			
			$this->Offer->save($offer);
	
			$this->generateDataByOffer($this->Offer->findById($this->Offer->id));
			
			$this->set(compact('offer', 'active'));
			
		}
		
	}
	
	function admin_active() {
	
		$this->layout = 'admin';		
		$this->viewActiveOffer();	
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Offer->save($this->data)) {
				$this->Session->setFlash(__('The offer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Offer->read(null, $id);
		}
		$carts = $this->Offer->Cart->find('list');
		$users = $this->Offer->User->find('list');
		$this->set(compact('carts', 'users'));
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

	function admin_createPdf ($offerID = null){

		$this->layout = 'pdf';
		
		$pdf = true;
		if(!$offerID) {
			$offer = $this->getActiveOffer();
		} else {
			$offer = $this->Offer->findById($offerID);
		}
		
		$this->generateDataByOffer($this->Offer->findById($offerID));
		
		$title = "Angebot_".str_replace('/', '-', $offer['Offer']['offer_number']);
		$this->set('title_for_layout', $title);
		
		$this->set('pdf', $pdf);
		$this->set(compact('offer','pdf'));
      	$this->render('admin_add'); 
	    
	}
	
	function admin_settings() {
		
		$this->layout = 'ajax';
		
		$offer = $this->getActiveOffer();
		
		if ($this->request->is('ajax')) {
			if(!empty($this->request->data)) {
				
				$offer['Offer']['discount'] = $this->request->data['Offer']['discount'];
				$offer['Offer']['additional_text'] = $this->request->data['Offer']['additional_text'];
				$offer['Offer']['request_date'] = $this->request->data['Offer']['request_date']['year']."-".$this->request->data['Offer']['request_date']['month']."-".$this->request->data['Offer']['request_date']['day'];
				
				if($this->Offer->save($offer)){
					$this->Session->setFlash(__('Speicherung erfolgreich', true));
				} else {
					$this->Session->setFlash(__('Es kam zu Fehlern beim Speichern', true));
				}
				
				$offer = $this->getActiveOffer();
				$offer['CartProducts'] = $this->getSettingCartProducts();
				
				$this->request->data = $offer;
							
			} else {
				if($offer['Offer']['request_date'] == '0000-00-00') {
					$offer['Offer']['request_date'] = date('Y-m-d');
				}
				
				
				$offer['Offer']['additional_text'] = '
				
Zahlungsbedingung: 10 Tage 2% Skonto oder 30 Tage netto <br />
Die Lieferung erfolgt zuzüglich anteiliger Versandkosten in Höhe von 8,00 Euro (Lieferung frei Haus ab einem Nettobestellwert von 500,00 Euro). <br />
Lieferzeit: ca. 2-3 Wochen
				';
				
				
				$offer['CartProducts'] = $this->getSettingCartProducts();
				
				$this->request->data = $offer;
				
				$lastOfferByCustomer = $this->Offer->find('all', array(
					'order' => array('Offer.id' => 'desc'),
			        'conditions' => array('Customer.id' => $offer['Customer']['id'])
			    ));
				$this->request->data['Customer']['last_discount'] = $lastOfferByCustomer[1]['Offer']['discount'];
				
			    // Use data from serialized form
			    // print_r($this->request->data['Contacts']); // name, email, message
			    $this->render('admin_settings', 'ajax'); // Render the contact-ajax-response view in the ajax layout
			}
		}
		
		
	}

	function admin_removeProductFromOffer($id = null) {
		
		$this->layout = 'ajax';
		$this->autoRender = false;
		
		//Lösche Eintrag
		if ($id) {
			$this->CartProduct->delete($id);
		}
		
		
		$offer['CartProducts'] = $this->getSettingCartProducts();
		$this->request->data = $offer;
		
		$this->render('/Elements/backend/portlets/Offer/settingsProductTable');
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
					'Billing.billing_number LIKE' 	=> '%'.$this->data['str'].'%', 
					'Delivery.delivery_number LIKE' 	=> '%'.$this->data['str'].'%')),
					'order' => array('Offer.created DESC', 'Offer.id DESC')));	
		
		
		$this->set('offers', $this->fillIndexOfferData($offers));
		
		if(isset($this->data['template'])) {
			$this->render($this->data['template']);
		}
	}

	function getSettingCartProducts() {
		$offer = $this->getActiveOffer();	
		$cart = $this->Cart->find('first', array(
			'conditions' => array(
			 	'Cart.id' => $offer['Cart']['id'],
				'Cart.active' => 'true'
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
	
	function getActiveOffer() {
		
		return $this->Offer->find('first', array('conditions' => array('Offer.status' => 'active')));
		
	}
	
	function admin_updateOffer($id = null, $offer = null) {
		$this->updateOffer($id, $offer);
	}
	
	function updateOffer($id = null, $offer = null) {
		
		$this->layout="ajax";
		
		if(!$offer) {
			$offer = $this->getActiveOffer();
			$offer = $offer['Offer']['id'];
		}
		
		$offer = $this->Offer->findById($offer);
		
		
		
		if($offer) {
			$offer['Offer']['offer_number'] = $this->generateOfferNumber($id, $offer);
			$offer['Offer']['customer_id'] = $id;
			
			
			if($this->Offer->save($offer)){
				$offer['Offer']['stat'] = 'saved';
			} else {
				$offer['Offer']['stat'] = 'not saved';
			}
		} else {
			$offer['Offer']['stat'] = 'error';
		}	
		
		
		$this->request->data = $offer;
				
		//echo json_encode($offer['Offer']);
		$this->autoRender = false;
		$this->layout = 'admin';
		//$this->render('admin_add');
		
	}
	
	function reloadOfferSheetProducts() {
		$this->layout = 'ajax';
		$this->set('pdf', null);
		
		$this->generateDataByOffer();
		
		$this->request->data['Offer'] += $this->generateDataByOffer();
		
		$this->render('/Elements/backend/paper_cheet');
	}
	
	function splitAddressData($offer = null)
	{
		$arr_customer = null;
		

		$customerAddress = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $offer['Customer']['id'])));
		
		if(empty($customerAddress)) {
			return null;
		}
		
		for($j=0; $j < count($customerAddress); $j++) {
			//split department and company
			$split_arr = array('department','organisation');
			
			foreach($split_arr as $split_str) {
				$arr = explode("\n", $customerAddress[$j]['Address'][$split_str]);
				$count = 0;
				for ($i = 0; $i <= count($arr)-1; $i++) {
					if($arr[$i] != '') {
						$arr_customer['Address'][$j][$split_str.'_'.$i] = str_replace('\n', '', $arr[$i]);
						$count++;			
					}
				}
				
				$arr_customer['Address'][$j][$split_str.'_count'] = $count;
			}
			
			$str_title = '';
			$str_first_name = '';
			
			if(!empty($customerAddress[$j]['Address']['title'])){
				$str_title = $customerAddress[$j]['Address']['title'].' ';
			};
			if(!empty($customerAddress[$j]['Address']['first_name'])){
				$str_first_name = $customerAddress[$j]['Address']['first_name'].' ';
			};
			$arr_customer['Address'][$j]['name'] = $customerAddress[$j]['Address']['salutation'].' '.$str_title.$str_first_name.$customerAddress[$j]['Address']['last_name'];
			$arr_customer['Address'][$j]['street'] = $customerAddress[$j]['Address']['street'];
			$arr_customer['Address'][$j]['city_combination'] = $customerAddress[$j]['Address']['postal_code'].' '.$customerAddress[$j]['Address']['city'];
			$arr_customer['Address'][$j]['type'] = $customerAddress[$j]['Address']['type'];
		}		
		return $arr_customer;
	}

	function splitCustomerData($offer = null)
	{
		$arr_customer = null;
		
		$customerAddress = $offer['Customer'];	

			//split department and company
			$split_arr = array('department','organisation');
			
			foreach($split_arr as $split_str) {
				$arr = explode("\n", $customerAddress[$split_str]);
				$count = 0;
				for ($i = 0; $i <= count($arr)-1; $i++) {
					if($arr[$i] != '') {
						$arr_customer[$split_str.'_'.$i] = str_replace('\n', '', $arr[$i]);
						$count++;			
					}
				}
				
				$arr_customer[$split_str.'_count'] = $count;
			}
			
			$str_title = '';
			$str_first_name = '';
			
			if(!empty($customerAddress['title'])){
				$str_title = $customerAddress['title'].' ';
			};
			if(!empty($customerAddress['first_name'])){
				$str_first_name = $customerAddress['first_name'].' ';
			};
			$arr_customer['name'] = $customerAddress['salutation'].' '.$str_title.$str_first_name.$customerAddress['last_name'];
		
		return $arr_customer;
	}

	function getAddressByType($offer = null , $type = null)
	{
		
		if(!empty($offer['Customer']['Address'])) {
			$addresses = $offer['Customer']['Address'];
			foreach ($addresses as $address) {
				if($address['type'] == $type) {					
					$offer['Address'] = $address;
					return $offer;
				}
			}
		} else {
			return $offer;
		}
	}
	
	function calcOfferPrice($offer = null) {
		
		$arr_offer = null;
		
		$discount_price = $offer['Offer']['discount'] * $offer['Cart']['sum_retail_price'] / 100;
		$part_price = $offer['Cart']['sum_retail_price'] - $discount_price + $offer['Offer']['delivery_cost'];
		$vat_price = $offer['Offer']['vat'] * $part_price / 100;
		$offer_price = floatval($part_price + $vat_price);
		
		if($offer['Cart']['sum_retail_price'] > 500) {
			$delivery_cost = 0;
		} else {
			$delivery_cost = 8;
		}
		
		$arr_offer['Offer']['delivery_cost'] = $delivery_cost;
		$arr_offer['Offer']['vat_price'] = $vat_price;
		$arr_offer['Offer']['discount_price'] = $discount_price;
		$arr_offer['Offer']['part_price'] = $part_price;
		
		
		
		if($offer['Cart']['sum_retail_price'] == 0) {
			$arr_offer['Offer']['offer_price'] = 0;
		} else {
			$arr_offer['Offer']['offer_price'] = $offer_price;
		}
		
		
		$arr_offer['Offer']['id'] = $offer['Offer']['id'];

		$this->Offer->save($arr_offer['Offer']);
				
		return $arr_offer['Offer'];
	}

	
	function archiveActiveOffer(){
		
	    $this->Offer->updateAll(
		    array('Offer.status' => "'open'"),
		    array('Offer.status' => "active")
	    );
		$this->admin_add(false,"ajax");
		$this->render('admin_add');
	}
	
	function viewActiveOffer($layout = "admin"){
		$this->layout = $layout;
		
		$this->generateDataByOffer();
		
		$this->set('pdf', null);
	    $this->set('offer', $this->data['Offer']);
		$this->render('admin_add');
	}
	
	function generateOfferNumber($customerId = null, $offer = null) {
	
		// Anzahl aller Angebote im Jahr / Anzahl aller Angebote im Monat_Aktueller Monat_Anzahl aller Angebote des Kunden	
		
		$countYearOffers = count($this->Offer->find('all',array('conditions' => array('Offer.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d'))))));
		$countMonthOffers = count($this->Offer->find('all',array('conditions' => array('Offer.created BETWEEN ? AND ?' => array(date('Y-m-01'), date('Y-m-d'))))));
		$countCustomerOffers = count($this->Offer->find('all',array('conditions' => array('Offer.customer_id' => $customerId), 'Offer.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d')))))+1;
		
		
		return str_pad($countYearOffers, 3, "0", STR_PAD_LEFT).'/'.str_pad($countMonthOffers, 2, "0", STR_PAD_LEFT).date('m', strtotime($offer['Offer']['created'])).str_pad($countCustomerOffers, 2, "0", STR_PAD_LEFT);
	}
	
	function generateDataByOffer($offer = null) {
	
		if(!$offer) {
			$offer = $this->getActiveOffer();		
		} 
			
	    $this->request->data = $offer;
		
		if(!empty($offer)) {
			$Carts = new CartsController();
	    	$cart = $Carts->get_cart_by_id($offer['Cart']['id']);
			$this->request->data['Cart']['CartProduct'] = $cart['CartProduct'];
		}

		
		
		if(!is_null($this->request->data['Customer']['id'])) {
			$split_str = $this->splitAddressData($offer);
			if(!is_null($split_str)) {	
				$this->request->data['Customer'] = $this->request->data['Customer'] + array();
				$this->request->data['Customer'] += $split_str;
			}
		}
				
		$this->request->data = $this->getAddressByType($this->request->data, 1);
	
		$this->request->data['Offer'] += $this->calcOfferPrice($this->request->data);
		
		return 	$this->calcOfferPrice($this->request->data);

	}
	
	function fillIndexOfferData($offers = null) {
	
		$offers2 = array();
		$Carts = new CartsController();
		$Products = new ProductsController();
		
		// for($i=0; $i<=10;$i++) {
		foreach ($offers as $offer) {
			
			//$offer = $offers[$i];
	
			if($this->splitCustomerData($offer)) {
				
				$offer['Customer'] += $this->splitCustomerData($offer);
				//$offer = $this->getAddressByType($offer,'1');	
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
					unset($product['Size']);
					$offer['Cart']['CartProduct'][$j]['Information'] = $product;
					$j++;
				}
			}
			$offer['Offer'] = $offer['Offer'] + $this->calcOfferPrice($offer);
						
			array_push($offers2, $offer);
			
		}	
			
		return $offers2;
	}
}
