<?php
App::import('Controller', 'Addresses');

class CustomersController extends AppController {

	var $name = 'Customers';
	public $components = array('Auth', 'Session');
	public $uses = array('Customer', 'Offer', 'User', 'Address', 'CustomerAddress', 'Cart');
	
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
				
				if(isset($this->data['Address'])) {
					
					$this->Session->setFlash(__('Kunde ohne Adresse wurde erfolgreich erstellt', true), 'flash_message', array('class' => 'alert-success'));
					
					$lastCustomerId = $this->Customer->getLastInsertID();
				
					$customerAddresses = array();
					$i = 0;
					foreach ($this->request->data['Address'] as $address) {
						array_push($customerAddresses, array('CustomerAddress' => 
							array('customer_id' => $lastCustomerId,'address_id' => $address['id'])
						));
						
					}
					
					if ($this->CustomerAddress->saveMany($customerAddresses)) {
						$this->Session->setFlash(__('Kunde mit Adresse wurde erfolgreich erstellt', true), 'flash_message', array('class' => 'alert-success'));
						//	$this->redirect(array('action' => 'index'));
						
						$customer = $this->Customer->read(null, $lastCustomerId);
						unset($customer['Offer']);
						
						$customerAddresses = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $lastCustomerId)));
						$customer['Customer']['Addresses'] = array();
						
						$Addresses = new AddressesController();
						
						foreach ($customerAddresses as $address) {
							array_push($customer['Customer']['Addresses'], $Addresses->splitAddressData($address));
						}
						$this->set('addressTypes', $this->Address->getAddressTypes());
						$this->request->data = $customer;
					}	
				}
				
			
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
		$this->set('customers', $this->paginate());
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
			array_push($customer['Customer']['Addresses'], $Addresses->splitAddressData($address));
		}
		
		$customer += $this->getCustomerChartInformation($id);
		
		$this->request->data = $customer;
		
		$this->set('addressTypes', $this->Address->getAddressTypes());
		$this->set('title_for_panel','Kundeninformationen');
		$this->render('/Elements/backend/portlets/Customer/customerInfoPortlet');
	}

	function admin_add($id = null) {
		$this->layout = 'admin';
		$this->add($id = null);
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
				$customerAddresses = array();
				$i = 0;
				foreach ($this->request->data['Address'] as $address) {
					array_push($customerAddresses, array('CustomerAddress' => 
						array('customer_id' => $id,'address_id' => $address['id'])
					));
					
				}
				
				if ($this->CustomerAddress->saveMany($customerAddresses)) {
					$this->Session->setFlash(__('Kunde wurde erfolgreich erstellt', true), 'flash_message', array('class' => 'alert-success'));
					//	$this->redirect(array('action' => 'index'));
					$customer = $this->Customer->read(null, $id);
					unset($customer['Offer']);
					
					$customerAddresses = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $id)));
					$customer['Customer']['Addresses'] = array();
					
					$Addresses = new AddressesController();
					
					foreach ($customerAddresses as $address) {						
						array_push($customer['Customer']['Addresses'], $Addresses->splitAddressData($address['Address']));
					}
					
					$this->request->data = $customer;
				}
			
			} else {
				$this->Session->setFlash(__('Kunde konnte nicht bearbeitet werden!. Bitte versuchen Sie es erneut.', true), 'flash_message', array('class' => 'alert-danger'));
			}
		}
		if (empty($this->request->data)) {
			//$this->request->data = $this->Customer->read(null, $id);
			$customer = $this->Customer->read(null, $id);
			unset($customer['Offer']);
			
			$customerAddresses = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $id)));
			$customer['Customer']['Addresses'] = array();
			
			$Addresses = new AddressesController();
			
			foreach ($customerAddresses as $address) {
				array_push($customer['Customer']['Addresses'], $Addresses->splitAddressData($address['Address']));
			}

			$this->request->data = $customer;
			
		}
		$this->set('addressTypes', $this->Address->getAddressTypes());
		$this->set('title_for_panel','Kunde bearbeiten');
		$this->set('primary_button','Speichern');
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
	
	function admin_search($searchString = null) {
		
		$this->layout = 'ajax';
		
		$customers = $this->Customer->find('all',array('conditions' => array("OR" => 
			array (	'Customer.id LIKE' 			=> '%'.$this->data['str'].'%' ,
					'Customer.first_name LIKE' 	=> '%'.$this->data['str'].'%' ,
					'Customer.last_name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Customer.organisation LIKE' 	=> '%'.$this->data['str'].'%',
					'Customer.department LIKE' 	=> '%'.$this->data['str'].'%'))));	
		
		
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
		
		$offerArray = array('title' => 'Angebot', 
			'percent' => $Number->toPercentage($customerOfferCount / $allOfferCount, 0, array(
			    'multiply' => true
			)),
			'ownCount' => $customerOfferCount,
			'allCount' => $allOfferCount,
			'description' => ''		
		);
		if (strpos($offerArray['title'],' ') !== false) {
		    $offerArray += array('data' => strtolower(str_replace(' ', '', $offerArray['title'])));
		}
		$offerArray += array('data' => strtolower($offerArray['title']));
		
		array_push($tempCustomer['CustomerInformation'], $offerArray);
		
		
// Gesamtumsatz eines Kunden
		
		$customerRevenue = $this->Offer->find('first', array(
			'conditions' => array(
			 	'Offer.customer_id' => $id,
				),
			'fields' => array('SUM(Offer.offer_price) AS summe')
		));
		
		
		$allRevenue = $this->Offer->find('first', array(
			'fields' => array('SUM(Offer.offer_price) AS summe')
		));

		$revenueArray = array(
			'title' => 'Umsatz', 
			'percent' => $this->format_num(floatval($customerRevenue[0]['summe']),1),
			'ownCount' => $Number->precision($customerRevenue[0]['summe'],2),
			'allCount' => $Number->precision($allRevenue[0]['summe'],2),
			'description' => ''			
		);
		if (strpos($revenueArray['title'],' ') !== false) {
		    $revenueArray += array('data' => strtolower(str_replace(' ', '', $revenueArray['title'])));
		}
		$revenueArray += array('data' => strtolower($revenueArray['title']));
			
		array_push($tempCustomer['CustomerInformation'], $revenueArray);
	
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

		$offerStatusArray = array('title' => 'Offene Angebote', 
			'percent' => $Number->toPercentage($customerOfferStatus / $allOfferStatus, 0, array(
			    'multiply' => true
			)),
			'ownCount' => $customerOfferStatus,
			'allCount' => $allOfferStatus,
			'description' => ''			
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
		$arr_customer = null;
		
		$customerAddress = $data['Customer'];	

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

}
