<?php
App::uses('AppController', 'Controller');
/**
 * Processes Controller
 *
 * @property Process $Process
 * @property PaginatorComponent $Paginator
 */
class ProcessesController extends AppController {

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
		
		$this->layout = "admin";
		
		$this->Process->recursive = 0;
		$this->set('processes', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Process->exists($id)) {
			throw new NotFoundException(__('Invalid process'));
		}
		$options = array('conditions' => array('Process.' . $this->Process->primaryKey => $id));
		$this->set('process', $this->Process->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Process->create();
			if ($this->Process->save($this->request->data)) {
				$this->Session->setFlash(__('The process has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The process could not be saved. Please, try again.'));
			}
		}
		$offers = $this->Process->Offer->find('list');
		$confirmations = $this->Process->Confirmation->find('list');
		$deliveries = $this->Process->Delivery->find('list');
		$billings = $this->Process->Billing->find('list');
		$customers = $this->Process->Customer->find('list');
		$carts = $this->Process->Cart->find('list');
		$this->set(compact('offers', 'confirmations', 'deliveries', 'billings', 'customers', 'carts'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Process->exists($id)) {
			throw new NotFoundException(__('Invalid process'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Process->save($this->request->data)) {
				$this->Session->setFlash(__('The process has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The process could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Process.' . $this->Process->primaryKey => $id));
			$this->request->data = $this->Process->find('first', $options);
		}
		$offers = $this->Process->Offer->find('list');
		$confirmations = $this->Process->Confirmation->find('list');
		$deliveries = $this->Process->Delivery->find('list');
		$billings = $this->Process->Billing->find('list');
		$customers = $this->Process->Customer->find('list');
		$carts = $this->Process->Cart->find('list');
		$this->set(compact('offers', 'confirmations', 'deliveries', 'billings', 'customers', 'carts'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Process->id = $id;
		if (!$this->Process->exists()) {
			throw new NotFoundException(__('Invalid process'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Process->delete()) {
			$this->Session->setFlash(__('The process has been deleted.'));
		} else {
			$this->Session->setFlash(__('The process could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
