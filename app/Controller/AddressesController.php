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
	public $uses = array('Customer', 'Address', 'CustomerAddress');

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
	public function admin_index() {
		$this->Address->recursive = 0;
		$this->set('addresses', $this->Paginator->paginate());
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
	public function admin_add($count = 0) {
		
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('The address has been saved.'));
						
				$this->request->data = $this->splitAddressData($this->request->data);
				$this->request->data['Address'][$count]['id'] = $this->Address->getLastInsertID();
				$this->set('count', $count);
				$this->set('addressTypes', $this->Address->getAddressTypes());
				$this->render('/Elements/backend/portlets/Address/addressMiniViewPortlet');
				$this->autoRender = false;
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'));
			}
		}
		else {	
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
		$arr_customer = null;
		

		$customerAddress = $this->CustomerAddress->find('all', array('conditions' => array('CustomerAddress.customer_id' => $data['Customer']['id'])));
		
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
		return $data;
	}
}
