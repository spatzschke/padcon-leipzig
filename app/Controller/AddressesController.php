<?php
App::uses('AppController', 'Controller');
/**
 * Addresses Controller
 *
 * @property Address $Address
 * @property PaginatorComponent $Paginator
 */
class AddressesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Customer', 'Address', 'CustomerAddress', 'AddressAddresstype', 'Addresstype', 'Offer', 'Confirmation', 'Billing', 'Delivery');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Address->recursive = 0;
		$this->set('addresses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
		$this->set('address', $this->Address->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('The address has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('The address has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
			$this->request->data = $this->Address->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Address->id = $id;
		if (!$this->Address->exists()) {
			throw new NotFoundException(__('Invalid address'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Address->delete()) {
			$this->Session->setFlash(__('The address has been deleted.'));
		} else {
			$this->Session->setFlash(__('The address could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($layout = null, $controller_id = null, $controller_name = null, $type = null) {
		
		$this->layout = 'ajax';
		$data = null;
		$addresses = null;
		$customer_id = null;
		if($controller_name == "Offers") {
			$data = $this->Offer->findById($controller_id); 
			$customer_id = $data['Offer']['customer_id'];
		}
		if($controller_name == "Confirmations") {
			$data = $this->Confirmation->findById($controller_id);
			$customer_id = $data['Confirmation']['customer_id'];
		}
		if($controller_name == "Deliveries") {
			$data = $this->Delivery->findById($controller_id); 
			$data = $this->Confirmation->findByDeliveryId($data['Delivery']['id']);			
			$customer_id = $data['Confirmation']['customer_id'];
		}
		if($controller_name == "Billings") {
			$data = $this->Billing->findById($controller_id); 
			$customer_id = $data['Confirmation']['customer_id'];
		}

        $addresses = $this->AddressAddresstype->findAllByCustomerIdAndTypeId($customer_id, $type);
		
		$customer = $this->Customer->findById($customer_id);
		
		$this->set('controller_id', $controller_id);
		$this->set('controller_name', $controller_name);
		$this->set('customer', $customer);
		$this->set('addresses', $addresses);
		$this->set('type', $type);
		
		$this->render('/Elements/backend/portlets/Address/addressListPortlet');
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
		$this->set('address', $this->Address->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($customer = null) {

		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->Address->create();
			
			$types = $this->request->data['Address']['addressTypes'];
			$this->request->data['Address']['addressTypes'] = 0;
			
			
			if ($this->Address->save($this->request->data)) {
				//$this->Session->setFlash(__('Adresse gespeichert.'));
					
				$lastAddressId = $this->Address->getLastInsertID();
				
				//Addresse dem Customer in CustomerAddress zusammenführen
				$this->CustomerAddress->create();
				$custAdd['CustomerAddress']['customer_id'] = $customer;
				$custAdd['CustomerAddress']['address_id'] = $lastAddressId;
				$this->CustomerAddress->save($custAdd);
				
				//Schleife zur Anlage von Addressen udn Addresstypen
				foreach ($types as $value) {
					$this->AddressAddresstype->create();
					$addType['AddressAddresstype']['customer_id'] = $customer;
					$addType['AddressAddresstype']['address_id'] = $lastAddressId;
					$addType['AddressAddresstype']['type_id'] = $value;
					$this->AddressAddresstype->save($addType);
				}			
				
				
				
				//Vorbereitung um neue Addresse anzuzeigen
				if(is_null($customer)) {
					$this->request->data['Address'] = $this->splitAddressData($this->request->data['Address']);
					$this->request->data['Address']['id'] = $lastAddressId;
					$this->set('count', $count);
					$this->set('addressTypes', $this->Address->getAddressTypes());
					$this->render('/Elements/backend/portlets/Address/addressMiniViewPortlet');
				} else {
					$this->request->data['CustomerAddress']['customer_id'] = $customer;
					$this->request->data['CustomerAddress']['address_id'] = $lastAddressId;
					if ($this->CustomerAddress->save($this->request->data)) {
						$loadAddress = $this->Address->findById($lastAddressId);
						$this->request->data['Address'] = $this->splitAddressData($loadAddress['Address']);
						
						$this->render('/Elements/backend/portlets/Customer/customerFormPortlet');	
					}
				}
				
				$this->autoRender = false;
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'));
			}
		}
		else {
			
			if($customer) {
				$options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $customer));
				$customerArr = $this->Customer->find('first', $options);
				$this->request->data = $customerArr;
				$this->request->data['Customer']['salutation'] = array();
				$this->request->data['Customer']['title'] = array();
				$this->request->data['Customer']['first_name'] = array();
				$this->request->data['Customer']['last_name'] = array();
				$this->request->data['Customer']['department'] = array();
			} else {
				$this->request->data['Customer']['salutation'] = array();
				$this->request->data['Customer']['title'] = array();
				$this->request->data['Customer']['first_name'] = array();
				$this->request->data['Customer']['last_name'] = array();
				$this->request->data['Customer']['organisation'] = array();
				$this->request->data['Customer']['department'] = array();
			}
			
						
			unset($this->request->data['Offer']);
			$types = $this->Address->getAddressTypes();
			$this->request->data['Address']['addressType'] = null; 
				
			$this->set('primary_button','Hinzufügen');
			
			$this->set('addressTypes', $this->Address->getAddressTypes());
			$this->render('/Elements/backend/portlets/Address/addressDetailPortlet');	
		}
		
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($customer = null, $id = null) {
			
		$this->layout = 'ajax';
			
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			$this->AddressAddresstype->deleteAll(array('address_id' => $this->request->data['Address']['id']), false);
			foreach ($this->request->data['Address']['addressTypes'] as $key => $value) {
				$this->AddressAddresstype->create();
				$type['AddressAddresstype']['address_id'] = $this->request->data['Address']['id'];
				$type['AddressAddresstype']['type_id'] = $value;
				$this->AddressAddresstype->save($type);	
			}
			
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('Die Addresse wurde aktualisiert.'));
				return $this->redirect(array('controller' => 'Customers', 'action' => 'edit', $customer));
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'));
			}
		} 
		
		
		$options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $customer));
		$customerArr = $this->Customer->find('first', $options);
		$this->request->data = $customerArr;
	
		$this->request->data['Address']['addressTypes'] = $this->Address->getAddressTypes();
		
		$address = $this->Address->findById($id);
		$types = $this->AddressAddresstype->findAllByAddressId($id);
		$typeInput= array();
		foreach($types as $key => $typ) {
			array_push($typeInput, intval($typ['Addresstype']['id']));
		}
		
		
		
		$addressTypes = $this->Addresstype->find('list');
		$this->set(compact('addressTypes'));
	 	
		$this->request->data['Address'] += $address['Address'];	
		
		$this->request->data['Address']['addressType'] = $typeInput;	
		$this->render('/Elements/backend/portlets/Address/addressDetailPortlet');	
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null, $customer_id = null) {
		$this->Address->id = $id;
		if (!$this->Address->exists()) {
			throw new NotFoundException(__('Invalid address'));
		}
		
		
		$this->AddressAddresstype->deleteAll(array('address_id' => $id), false);
		if ($this->CustomerAddress->deleteAll(array('address_id' => $id), false)) {
			$this->Session->setFlash(__('Die Adresse wurde gelöscht'));
		} else {
			$this->Session->setFlash(__('The address could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('controller' => 'Customers','action' => 'edit', $customer_id));
	}

	
	function splitAddressData($data = null)
	{		
		if(!empty($data['Address'])) {
			$data = $data['Address'];
		}	
			
		$arr_customer = null;
		$str_salutation = '';
		$str_title = '';
		$str_first_name = '';
		$str_last_name = '';
		
		if(!empty($data['organisation'])){
			$arr_customer['Address']['organisation'] = trim($data['organisation']);
		};
		if(!empty($data['department'])){
			$arr_customer['Address']['department'] = trim($data['department']);
		};
		if(!empty($data['salutation'])){
			$str_salutation = trim($data['salutation']).' ';
		};
		if(!empty($data['title'])){
			$str_title = trim($data['title']).' ';
		};
		if(!empty($data['first_name'])){
			$str_first_name = trim($data['first_name']).' ';
		};
		if(!empty($data['last_name'])){
			$str_last_name = trim($data['last_name']);
		};
		$arr_customer['Address']['name'] = $str_salutation.$str_title.$str_first_name.$str_last_name;
		
		$arr_customer['Address']['street'] = trim($data['street']);
		
		$data['postal_code'] = str_pad($data['postal_code'], 5, "0", STR_PAD_LEFT);
		
		$arr_customer['Address']['city_combination'] = trim($data['postal_code']).' '.trim($data['city']);
		$arr_customer['Address']['id'] = $data['id'];
			
		return $arr_customer;
	}

	function getAddressByType($data = null , $type = null, $first = FALSE)
	{
						
		if(isset($data['Customer'])) {

			$customerId = $data['Customer']['id'];			
			$addresses = null;

			if($first) {				
				$addresses = $this->AddressAddresstype->find('first', array('conditions' => array('customer_id' => $customerId, 'type_id' => $type)));
			} else {
				$addresses = $this->AddressAddresstype->find('all', array('conditions' => array('customer_id' => $customerId, 'type_id' => $type)));
			}
					
			if(!empty($addresses)) {
				$data['Address'] = $addresses['Address'];				
			} else {
				$data['Address'] = null;
			}
			return $data;	
		} else {			
			return $data;
		}
		return $data;
	}
}
