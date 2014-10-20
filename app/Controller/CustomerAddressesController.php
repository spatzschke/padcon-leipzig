<?php
App::uses('AppController', 'Controller');
/**
 * CustomerAddresses Controller
 *
 * @property CustomerAddress $CustomerAddress
 * @property PaginatorComponent $Paginator
 */
class CustomerAddressesController extends AppController {

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
	public function admin_index() {
		$this->CustomerAddress->recursive = 0;
		$this->set('customerAddresses', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->CustomerAddress->exists($id)) {
			throw new NotFoundException(__('Invalid customer address'));
		}
		$options = array('conditions' => array('CustomerAddress.' . $this->CustomerAddress->primaryKey => $id));
		$this->set('customerAddress', $this->CustomerAddress->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CustomerAddress->create();
			if ($this->CustomerAddress->save($this->request->data)) {
				$this->Session->setFlash(__('The customer address has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer address could not be saved. Please, try again.'));
			}
		}
		$customers = $this->CustomerAddress->Customer->find('list');
		$addresses = $this->CustomerAddress->Address->find('list');
		$this->set(compact('customers', 'addresses'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->CustomerAddress->exists($id)) {
			throw new NotFoundException(__('Invalid customer address'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CustomerAddress->save($this->request->data)) {
				$this->Session->setFlash(__('The customer address has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer address could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CustomerAddress.' . $this->CustomerAddress->primaryKey => $id));
			$this->request->data = $this->CustomerAddress->find('first', $options);
		}
		$customers = $this->CustomerAddress->Customer->find('list');
		$addresses = $this->CustomerAddress->Address->find('list');
		$this->set(compact('customers', 'addresses'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->CustomerAddress->id = $id;
		if (!$this->CustomerAddress->exists()) {
			throw new NotFoundException(__('Invalid customer address'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CustomerAddress->delete()) {
			$this->Session->setFlash(__('The customer address has been deleted.'));
		} else {
			$this->Session->setFlash(__('The customer address could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
