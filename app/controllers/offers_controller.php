<?php
class OffersController extends AppController {

	var $name = 'Offers';
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->deny('*');
			
		}
	}

	function index() {
		$this->Offer->recursive = 0;
		$this->set('offers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('offer', $this->Offer->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Offer->create();
			if ($this->Offer->save($this->data)) {
				$this->Session->setFlash(__('The offer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.', true));
			}
		}
		$carts = $this->Offer->Cart->find('list');
		$users = $this->Offer->User->find('list');
		$this->set(compact('carts', 'users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Offer->save($this->data)) {
				$this->Session->setFlash(__('The offer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Offer->read(null, $id);
		}
		$carts = $this->Offer->Cart->find('list');
		$users = $this->Offer->User->find('list');
		$this->set(compact('carts', 'users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for offer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Offer->delete($id)) {
			$this->Session->setFlash(__('Offer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Offer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Offer->recursive = 0;
		$this->set('offers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('offer', $this->Offer->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Offer->create();
			if ($this->Offer->save($this->data)) {
				$this->Session->setFlash(__('The offer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.', true));
			}
		}
		$carts = $this->Offer->Cart->find('list');
		$users = $this->Offer->User->find('list');
		$this->set(compact('carts', 'users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Offer->save($this->data)) {
				$this->Session->setFlash(__('The offer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Offer->read(null, $id);
		}
		$carts = $this->Offer->Cart->find('list');
		$users = $this->Offer->User->find('list');
		$this->set(compact('carts', 'users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for offer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Offer->delete($id)) {
			$this->Session->setFlash(__('Offer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Offer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
