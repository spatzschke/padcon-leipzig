<?php
class CustomersController extends AppController {

	var $name = 'Customers';
	public $components = array('Auth', 'Session');
	public $uses = array('Customer', 'Offer');
	
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
				$this->Session->setFlash(__('Kunder wurde erfolgreich erstellt', true), 'flash_message', array('class' => 'alert-success'));
			//	$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Kunde konnte nicht erstellt werden!. Bitte versuchen Sie es erneut.', true), 'flash_message', array('class' => 'alert-danger'));
			}
		}
		$users = $this->Customer->User->find('list');
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
		$users = $this->Customer->User->find('list');
		$this->set(compact('users'));
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
	function admin_index($layout = null) {
		if($layout) {$this->layout = $layout; } else { $this->layout = 'admin'; }
	
		$this->Customer->recursive = 0;
		$this->set('customers', $this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Unbekannter Kunde', true), 'flash_message', array('class' => 'alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$customer = $this->Customer->read(null, $id);
		unset($customer['Offer']);
		
		
		$customer += $this->getCustomerChartInformation($id);
		
		$this->request->data = $customer;
				
		$this->set('title_for_panel','Kundeninformationen');
		$this->render('/Elements/backend/portlets/customerInfoPortlet');
	}

	function admin_add($id = null) {
		$this->layout = 'admin';
		$this->add($id = null);
		$this->set('title_for_panel','Kunde anlegen');
		$this->render('/Elements/backend/portlets/customerDetailPortlet');
	}

	function admin_edit($id = null) {
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
		$users = $this->Customer->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		$this->delete($id);
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
		
		
		// Anzahl der Angebote zu einem Kunden
		
		$customerOfferCount = $this->Offer->find('count', array('conditions' => array('Offer.customer_id' => $id))); 
		$allOfferCount = $this->Offer->find('count');
		
		$offerArray = array('title' => 'Angebot', 
			'percent' => intval(($customerOfferCount * 100) / $allOfferCount),
			'ownCount' => $customerOfferCount,
			'allCount' => $allOfferCount			
		);
		
		array_push($tempCustomer['CustomerInformation'], $offerArray);
		
		
		// Gesamtumsatz eines Kunden
				
		$offerArray2 = array('title' => 'Angebot2', 
			'percent' => intval(($customerOfferCount * 100) / $allOfferCount),
			'ownCount' => $customerOfferCount,
			'allCount' => $allOfferCount			
		);
		
		array_push($tempCustomer['CustomerInformation'], $offerArray2);
	
		return $tempCustomer;
	}

}
