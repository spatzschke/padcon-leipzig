<?php
App::uses('AppController', 'Controller');
/**
 * AddressAddresstypes Controller
 *
 * @property AddressAddresstype $AddressAddresstype
 * @property PaginatorComponent $Paginator
 */
class AddressAddresstypesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AddressAddresstype->recursive = 0;
		$this->set('addressAddresstypes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->AddressAddresstype->exists($id)) {
			throw new NotFoundException(__('Invalid address addresstype'));
		}
		$options = array('conditions' => array('AddressAddresstype.' . $this->AddressAddresstype->primaryKey => $id));
		$this->set('addressAddresstype', $this->AddressAddresstype->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AddressAddresstype->create();
			if ($this->AddressAddresstype->save($this->request->data)) {
				$this->Session->setFlash(__('The address addresstype has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address addresstype could not be saved. Please, try again.'));
			}
		}
		$addresses = $this->AddressAddresstype->Address->find('list');
		$types = $this->AddressAddresstype->Type->find('list');
		$this->set(compact('addresses', 'types'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->AddressAddresstype->exists($id)) {
			throw new NotFoundException(__('Invalid address addresstype'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AddressAddresstype->save($this->request->data)) {
				$this->Session->setFlash(__('The address addresstype has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address addresstype could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AddressAddresstype.' . $this->AddressAddresstype->primaryKey => $id));
			$this->request->data = $this->AddressAddresstype->find('first', $options);
		}
		$addresses = $this->AddressAddresstype->Address->find('list');
		$types = $this->AddressAddresstype->Type->find('list');
		$this->set(compact('addresses', 'types'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->AddressAddresstype->id = $id;
		if (!$this->AddressAddresstype->exists()) {
			throw new NotFoundException(__('Invalid address addresstype'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->AddressAddresstype->delete()) {
			$this->Session->setFlash(__('The address addresstype has been deleted.'));
		} else {
			$this->Session->setFlash(__('The address addresstype could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->AddressAddresstype->recursive = 0;
		$this->set('addressAddresstypes', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->AddressAddresstype->exists($id)) {
			throw new NotFoundException(__('Invalid address addresstype'));
		}
		$options = array('conditions' => array('AddressAddresstype.' . $this->AddressAddresstype->primaryKey => $id));
		$this->set('addressAddresstype', $this->AddressAddresstype->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->AddressAddresstype->create();
			if ($this->AddressAddresstype->save($this->request->data)) {
				$this->Session->setFlash(__('The address addresstype has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address addresstype could not be saved. Please, try again.'));
			}
		}
		$addresses = $this->AddressAddresstype->Address->find('list');
		$types = $this->AddressAddresstype->Type->find('list');
		$this->set(compact('addresses', 'types'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->AddressAddresstype->exists($id)) {
			throw new NotFoundException(__('Invalid address addresstype'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AddressAddresstype->save($this->request->data)) {
				$this->Session->setFlash(__('The address addresstype has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address addresstype could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AddressAddresstype.' . $this->AddressAddresstype->primaryKey => $id));
			$this->request->data = $this->AddressAddresstype->find('first', $options);
		}
		$addresses = $this->AddressAddresstype->Address->find('list');
		$types = $this->AddressAddresstype->Type->find('list');
		$this->set(compact('addresses', 'types'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->AddressAddresstype->id = $id;
		if (!$this->AddressAddresstype->exists()) {
			throw new NotFoundException(__('Invalid address addresstype'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->AddressAddresstype->delete()) {
			$this->Session->setFlash(__('The address addresstype has been deleted.'));
		} else {
			$this->Session->setFlash(__('The address addresstype could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
