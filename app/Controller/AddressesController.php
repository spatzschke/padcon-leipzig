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
	public $uses = array('Customer', 'Address', 'CustomerAddress', 'AddressAddressType', 'Offer', 'Confirmation', 'Billing', 'Delivery');

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
			$customer_id = $data['Offer']['customer_id'];
		}
		if($controller_name == "Deliveries") {
			$data = $this->Delivery->findById($controller_id); 
			$customer_id = $data['Offer']['customer_id'];
		}
		if($controller_name == "Billings") {
			$data = $this->Billing->findById($controller_id); 
			$customer_id = $data['Offer']['customer_id'];
			
		}

        $addresses = $this->CustomerAddress->findAllByCustomerId($customer_id);
		
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
	public function admin_add($count = 0, $customer = null, $type = null) {

		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				//$this->Session->setFlash(__('Adresse gespeichert.'));
					
				$lastAddressId = $this->Address->getLastInsertID();
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
			$this->request->data['addressType'] = $type; 
				
			$this->set('primary_button','Hinzufügen');
			$this->set('count', $count);
			
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
	public function admin_edit($id = null) {
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
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
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
		
		if(count($data['postal_code']) < 5) {
			$data['postal_code'] = "0".$data['postal_code'];
		}
		
		$arr_customer['Address']['city_combination'] = trim($data['postal_code']).' '.trim($data['city']);
			
		return $arr_customer;
	}

	function getAddressByType($data = null , $type = null, $first = FALSE)
	{
			
		if($data['Customer']['id'] != null) {

			$customerId = $data['Customer']['id'];
			$addresses = null;

			if($first) {
				$addresses = $this->AddressAddressType->find('first', array('conditions' => array('customer_id' => $customerId, 'type_id' => $type)));
			} else {
				$addresses = $this->AddressAddressType->find('all', array('conditions' => array('customer_id' => $customerId, 'type_id' => $type)));
			}
			
			if(!empty($addresses)) {
				$data['Address'] = $addresses['Address'];				
			}	
			return $data;	
		} else {			
			return $data;
		}
		return $data;
	}
}
