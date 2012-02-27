<?php
class CartProductsController extends AppController {

	var $name = 'CartProducts';
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->deny('*');
			
		}
	}

	function index() {
		$this->CartProduct->recursive = 0;
		$this->set('cartProducts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cart product', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('cartProduct', $this->CartProduct->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CartProduct->create();
			if ($this->CartProduct->save($this->data)) {
				$this->Session->setFlash(__('The cart product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart product could not be saved. Please, try again.', true));
			}
		}
		$carts = $this->CartProduct->Cart->find('list');
		$products = $this->CartProduct->Product->find('list');
		$this->set(compact('carts', 'products'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cart product', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->CartProduct->save($this->data)) {
				$this->Session->setFlash(__('The cart product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart product could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CartProduct->read(null, $id);
		}
		$carts = $this->CartProduct->Cart->find('list');
		$products = $this->CartProduct->Product->find('list');
		$this->set(compact('carts', 'products'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cart product', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CartProduct->delete($id)) {
			$this->Session->setFlash(__('Cart product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Cart product was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->CartProduct->recursive = 0;
		$this->set('cartProducts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cart product', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('cartProduct', $this->CartProduct->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CartProduct->create();
			if ($this->CartProduct->save($this->data)) {
				$this->Session->setFlash(__('The cart product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart product could not be saved. Please, try again.', true));
			}
		}
		$carts = $this->CartProduct->Cart->find('list');
		$products = $this->CartProduct->Product->find('list');
		$this->set(compact('carts', 'products'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cart product', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->CartProduct->save($this->data)) {
				$this->Session->setFlash(__('The cart product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart product could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CartProduct->read(null, $id);
		}
		$carts = $this->CartProduct->Cart->find('list');
		$products = $this->CartProduct->Product->find('list');
		$this->set(compact('carts', 'products'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cart product', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CartProduct->delete($id)) {
			$this->Session->setFlash(__('Cart product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Cart product was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
