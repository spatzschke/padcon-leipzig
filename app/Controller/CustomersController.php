<?php
App::import('Controller', 'Addresses');

class CustomersController extends AppController {

	var $name = 'Customers';
	public $components = array('Auth', 'Session');
	public $uses = array('Customer', 'Offer', 'Confirmation', 'Billings', 'User', 'Address', 'CustomerAddress', 'Cart', 'AddressAddresstype');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->deny('*');
			$this->Auth->loginRedirect = '/admin';
		}

	}


	function index() {
		$this->Customer->recursive = 0;
		$this->set('customers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Unbekannter Kunde', true), 'flash_message', array('class' => 'alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Customer->create();
			if ($this->Customer->save($this->request->data)) {
				
				$lastId = $this->Customer->getLastInsertID();
					
				$this->redirect(array('action' => 'edit', $lastId));			
			
			} else {
				$this->Session->setFlash(__('Kunde konnte nicht erstellt werden!. Bitte versuchen Sie es erneut.', true), 'flash_message', array('class' => 'alert-danger'));
			}
		}
		$users = $this->Customer->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Customer->save($this->request->data)) {
				$this->Session->setFlash(__('Kunde wurde erfolgreich bearbeitet!', true), 'flash_message', array('class' => 'alert-success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Kunde konnte nicht bearbeitet werden!. Bitte versuchen Sie es erneut.', true), 'flash_message', array('class' => 'alert-danger'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Customer->read(null, $id);
		}
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Unbekannter Kunde', true), 'flash_message', array('class' => 'alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->delete($id)) {
			$this->Session->setFlash(__('Kunde wurde erfolgreich gelöscht!', true), 'flash_message', array('class' => 'alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Kunde konnte nicht gelöscht werden!. Bitte versuchen Sie es erneut.', true), 'flash_message', array('class' => 'alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index($layout = null, $cart_id = null) {
		if($layout) {$this->layout = $layout; } else { $this->layout = 'admin'; }
	
		$this->Customer->recursive = 0;
		
		$customer = $this->Customer->find('all');
		$this->set('customers', $customer);
		$cart = $this->Cart->findById($cart_id);
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
		
		
		$this->set(compact('cart_id', 'controller_id', 'controller_name'));
	}

	function admin_indexAjax($layout = null, $cart_id = null) {
		$this->admin_index($layout, $cart_id);
		$this->render('/Elements/backend/portlets/Customer/customerPortletAjax');
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Unbekannter Kunde', true), 'flash_message', array('class' => 'alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$customer = $this->Customer->read(null, $id);
		unset($customer['Offer']);
		
		$customerAddresses = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $id)));
		
		$customer['Customer']['Addresses'] = array();
		
		$Addresses = new AddressesController();
		
		foreach ($customerAddresses as $address) {
			$types = $this->AddressAddresstype->findAllByAddressId($address['Address']['id']);
			
			$addressType = array();
			foreach ($types as $key => $value) {				
				array_push($addressType, $value['Addresstype']['name']);
			}			
			$formatAddress = $Addresses->splitAddressData($address);
			$formatAddress['Address']['Types'] = $addressType;			
			array_push($customer['Customer']['Addresses'], $formatAddress);
		}
		
		$customer += $this->getCustomerChartInformation($id);
		
		$this->request->data = $customer;
		
		$this->set('addressTypes', $this->Address->getAddressTypes());
		$this->set('title_for_panel','Kundeninformationen');
		$this->set('primary_button','Speichern');
		$this->render('/Elements/backend/portlets/Customer/customerDetailPortlet');
	}

	function admin_add($id = null) {
		$this->layout = 'admin';
		if (!empty($this->request->data)) {
			$this->Customer->create();
			
			$data = $this->request->data;
			$data['Customer']['merchant'] = $this->request->data['Customer']['merchant2'];
			
			if ($this->Customer->save($data)) {
				
				$lastId = $this->Customer->getLastInsertID();			
					
				$this->redirect(array('action' => 'edit', $lastId));			
			
			} else {
				$this->Session->setFlash(__('Kunde konnte nicht erstellt werden!. Bitte versuchen Sie es erneut.', true), 'flash_message', array('class' => 'alert-danger'));
			}
		}
		$users = $this->Customer->find('list');
		$this->set(compact('users'));
		
		$this->set('title_for_panel','Kunde anlegen');
		$this->set('primary_button','Anlegen');
		$this->render('/Elements/backend/portlets/Customer/customerDetailPortlet');
	}

	function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {

			if ($this->Customer->save($this->request->data)) {

				$this->Session->setFlash(__('Kunde erfolgriech gespeichert.', true));
			
			
			} else {
				$this->Session->setFlash(__('Kunde konnte nicht bearbeitet werden!. Bitte versuchen Sie es erneut.', true), 'flash_message', array('class' => 'alert-danger'));
			}
		}
		
			//$this->request->data = $this->Customer->read(null, $id);
			$customer = $this->Customer->read(null, $id);
			unset($customer['Offer']);
			
			$customerAddresses = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $id)));
			$customer['Customer']['Addresses'] = array();
			
			$Addresses = new AddressesController();
			
			foreach ($customerAddresses as $address) {
				$types = $this->AddressAddresstype->findAllByAddressId($address['Address']['id']);
			
				$addressType = array();
				foreach ($types as $key => $value) {				
					array_push($addressType, $value['Addresstype']['name']);
				}			
				$formatAddress = $Addresses->splitAddressData($address);
				$formatAddress['Address']['Types'] = $addressType;			
				array_push($customer['Customer']['Addresses'], $formatAddress);
			}

			$this->request->data = $customer;
			
		
		$this->set('addressTypes', $this->Address->getAddressTypes());
		$this->set('title_for_panel','Kunde bearbeiten');
		$this->set('primary_button','Änderungen speichern');
		$this->render('/Elements/backend/portlets/Customer/customerDetailPortlet');
	}

	function admin_delete($id = null) {
		$this->delete($id);
	}
	
	function search($searchString = null) {
	
		if($this->Auth) {
			echo $this->admin_search($searchString);
		} 		
	}
	
	function admin_search($c_name = null, $c_id = null) {
		
		$this->layout = 'ajax';
		
		
		 $customers2 = $this->Customer->find('all',array('conditions' => array("OR" => 
			 array (	'Customer.id LIKE' 			=> '%'.$this->data['str'].'%' ,					
					 'Customer.organisation LIKE' 	=> '%'.$this->data['str'].'%'))));	
		
		$customers = array();
		foreach ($customers2 as $i => $customer) {
			$c['Customer'] = $customer['Customer'];
			array_push($customers, $c);
		}
	
 		$this->set('controller_name', $c_name);
		$this->set('controller_id', $c_id);
		
		$this->set('customers', $customers);
		
		
		if(isset($this->data['template'])) {
			$this->render($this->data['template']);
		}
	}
	
	function liveValidate($string = null) {
	
		$validateString = $this->request->data[$this->request->data['Model']][$this->request->data['Field']];
		
		
		
		$this->Customer->set( $this->request->data );
		
	    if ($this->Customer->validates()) {
		    $status['status'] = 'success';
		    
		    $product = $this->Customer->find('first',array('conditions' => array('Customer.id' => $this->request->data['Id'])));	
		    $status['id'] = $product['Customer']['id'];
		    
		    if (!empty($this->request->data) && !empty($product)) {
		    
		    	
		    	
		    	if($this->request->data['autoSave'] == 'true') {
		    	
		    		$product[$this->request->data['Model']][$this->request->data['Field']] = $validateString;
		    	
					if ($this->Customer->save($product)) {
						$status['status'] = 'save success';				
					} else {
						$status['status'] = 'save error';
					}
				} 
			
			}
	
			echo json_encode($status);	    
		} else {
			$errors = $this->Product->invalidFields();
			//echo $errors[$this->request->data['Field']]	; 
			
			$status['message'] = $errors[$this->request->data['Field']];
			$status['status'] = 'error';
			unset($errors[$this->request->data['Field']]);

	
			echo json_encode($status);
	    }
		
		$this->autoRender = false;
	}
	
	function autoComplete($string = null) {
		
		$return = '';
		
		$conditions = array('Customer.'.$this->request->data['Field'].' LIKE' => $this->request->data[$this->request->data['Model']][$this->request->data['Field']].'%');
		
		if(!empty($this->request->data['lock'])) {
			$locked = explode(';',$this->request->data['lock']);
			
			foreach($locked as $lock) {
				
				$lock = explode('=', $lock);
				
				if(!empty($lock[1]) && $this->request->data['Field'] != $lock[0])
					$conditions['Customer.'.$lock[0]] = $lock[1];
				
			}
		}
		
		
		
		
		$customer = $this->Customer->find('first',array('conditions' => $conditions));	
		
		
		$return = $customer['Customer'];
		    		
		echo json_encode($return);
		$this->autoRender = false;
		
	}
	
	/*
	
		GETTeR & SETTER
	
	*/
	
	function getCustomerByOffer($id = null) {
		
		if(!$id) {
			
		}
		
		return $this->Customer->find('first', array('conditions' => array('id' => $id)));
		
	}
	
	function getCustomerChartInformation($id = null) {
			
		$tempCustomer['CustomerInformation'] = array();	
		
		$view = new View($this);
        $Number = $view->loadHelper('Number');
		
// Anzahl der Angebote zu einem Kunden
		
		$customerOfferCount = $this->Offer->find('count', array('conditions' => array('Offer.customer_id' => $id))); 
		$allOfferCount = $this->Offer->find('count');

		$percent = 0;
		if($allOfferCount != 0) {
			$percent = $customerOfferCount / $allOfferCount;
		}
		
		$offerArray = array('title' => 'Angebot', 
			'percent' => $Number->toPercentage($percent, 0, array(
			    'multiply' => true
			)),
			'ownCount' => $customerOfferCount,
			'allCount' => $allOfferCount,
			'description' => '',	
			'type' => 'Doughnut'	
		);
		if (strpos($offerArray['title'],' ') !== false) {
		    $offerArray += array('data' => strtolower(str_replace(' ', '', $offerArray['title'])));
		}
		$offerArray += array('data' => strtolower($offerArray['title']));
		
		array_push($tempCustomer['CustomerInformation'], $offerArray);
		
		
// Anzahl der Auftragsbestätigung zu einem Kunden
		
		$customerCount = $this->Confirmation->find('count', array('conditions' => array('customer_id' => $id))); 
		$allCount = $this->Confirmation->find('count');

		$percent = 0;
		if($allCount != 0) {
			$percent = $customerCount / $allCount;
		}
		
		$data = array('title' => 'Auftragsbestaetigung', 
			'percent' => $Number->toPercentage($percent, 0, array(
			    'multiply' => true
			)),
			'ownCount' => $customerCount,
			'allCount' => $allCount,
			'description' => '',	
			'type' => 'Doughnut'	
		);
		if (strpos($data['title'],' ') !== false) {
		    $data += array('data' => strtolower(str_replace(' ', '', $data['title'])));
		}
		$data += array('data' => strtolower($data['title']));
		
		array_push($tempCustomer['CustomerInformation'], $data);
	
// Offene Angebote
		
		$customerOfferStatus = $this->Offer->find('count', array(
			'conditions' => array(
			 	'Offer.customer_id' => $id,
			 	'Offer.status' => 'open',
				)
		));
				
		$allOfferStatus = $this->Offer->find('count', array(
			'conditions' => array(
			 	'Offer.customer_id' => $id,
				)
		));
		
		$perc = 0;
		if($allOfferStatus > 0) {
			$perc = $Number->toPercentage($customerOfferStatus / $allOfferStatus, 0, array(
			    'multiply' => true
			));
		}

		$offerStatusArray = array('title' => 'Offene Angebote', 
			'percent' => $perc,
			'ownCount' => $customerOfferStatus,
			'allCount' => $allOfferStatus,
			'description' => '',	
			'type' => 'Doughnut'			
		);
		if (strpos($offerStatusArray['title'],' ') !== false) {
		    $offerStatusArray += array('data' => strtolower(str_replace(' ', '', $offerStatusArray['title'])));
		}
		$offerStatusArray += array('data' => strtolower($offerStatusArray['title']));
			
		array_push($tempCustomer['CustomerInformation'], $offerStatusArray);
	
		return $tempCustomer;
	}

	function format_num($num, $precision = 2) {
		   if ($num < 1000) {
		    $n_format = number_format($num,$precision);
		   } else if ($num >= 1000 && $num < 1000000) {
		    $n_format = number_format($num/1000,$precision).'K';
		    } else if ($num >= 1000000 && $num < 1000000000) {
		    $n_format = number_format($num/1000000,$precision).'M';
		   } else if ($num >= 1000000000) {
		   $n_format=number_format($num/1000000000,$precision).'B';
		   } else {
		   $n_format = $num;
		    }
		  return $n_format;
	  } 
	
	function splitCustomerData($data = null)
	{
		$Addresses = new AddressesController();
		$temp = $Addresses->splitAddressData($data);		
		return $temp['Address'];
	}

}
