<?php
App::uses('AppController', 'Controller');
/**
 * Cores Controller
 *
 * @property Core $Core
 * @property PaginatorComponent $Paginator
 */
class CoresController extends AppController {

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
		$this->Core->recursive = 0;
		$this->set('cores', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Core->exists($id)) {
			throw new NotFoundException(__('Invalid core'));
		}
		$options = array('conditions' => array('Core.' . $this->Core->primaryKey => $id));
		$this->set('core', $this->Core->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Core->create();
			if ($this->Core->save($this->request->data)) {
				$this->Session->setFlash(__('The core has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The core could not be saved. Please, try again.'));
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
		if (!$this->Core->exists($id)) {
			throw new NotFoundException(__('Invalid core'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Core->save($this->request->data)) {
				$this->Session->setFlash(__('The core has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The core could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Core.' . $this->Core->primaryKey => $id));
			$this->request->data = $this->Core->find('first', $options);
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
		$this->Core->id = $id;
		if (!$this->Core->exists()) {
			throw new NotFoundException(__('Invalid core'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Core->delete()) {
			$this->Session->setFlash(__('The core has been deleted.'));
		} else {
			$this->Session->setFlash(__('The core could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Core->recursive = 0;
		$this->set('cores', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Core->exists($id)) {
			throw new NotFoundException(__('Invalid core'));
		}
		$options = array('conditions' => array('Core.' . $this->Core->primaryKey => $id));
		$this->set('core', $this->Core->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Core->create();
			if ($this->Core->save($this->request->data)) {
				$this->Session->setFlash(__('The core has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The core could not be saved. Please, try again.'));
			}
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
		if (!$this->Core->exists($id)) {
			throw new NotFoundException(__('Invalid core'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Core->save($this->request->data)) {
				$this->Session->setFlash(__('The core has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The core could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Core.' . $this->Core->primaryKey => $id));
			$this->request->data = $this->Core->find('first', $options);
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
		$this->Core->id = $id;
		if (!$this->Core->exists()) {
			throw new NotFoundException(__('Invalid core'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Core->delete()) {
			$this->Session->setFlash(__('The core has been deleted.'));
		} else {
			$this->Session->setFlash(__('The core could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
