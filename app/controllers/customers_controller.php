<?php
class CustomersController extends AppController {

	var $name = 'Customers';
	public $components = array('Auth', 'Session');
	
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
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Customer->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
		}
		$users = $this->Customer->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->delete($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Customer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->layout = 'admin';
		$this->User->recursive = 0;
		$this->set('customers', $this->paginate());
		$this->render('/elements/backend/portlets/customerPortlet');
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function admin_add($id = null) {
		$this->layout = 'admin';
		$this->add($id);
		$this->render('/elements/backend/portlets/customerDetailPortlet');
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
		}
		$users = $this->Customer->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->delete($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Customer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function liveValidate($string = null) {
	
		$validateString = $this->data[$this->data['Model']][$this->data['Field']];
		
		
		$this->Customer->set( $this->data );
		
	    if ($this->Customer->validates()) {
		    $status['status'] = 'success';
		    
		    $product = $this->Customer->find('first',array('conditions' => array('Customer.id' => $this->data['Id'])));	
		    $status['id'] = $product['Customer']['id'];
		    
		    if (!empty($this->data) && !empty($product)) {
		    
		    	
		    	
		    	if($this->data['autoSave'] == 'true') {
		    	
		    		$product[$this->data['Model']][$this->data['Field']] = $validateString;
		    	
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
			//echo $errors[$this->data['Field']]	; 
			
			$status['message'] = $errors[$this->data['Field']];
			$status['status'] = 'error';
			unset($errors[$this->data['Field']]);

	
			echo json_encode($status);
	    }
		
		$this->autoRender = false;
	}
	
	function autoComplete($string = null) {
		
		$return = '';
		
		$customer = $this->Customer->find('first',array('conditions' => array('Customer.'.$this->data['Field'].' LIKE' => $this->data[$this->data['Model']][$this->data['Field']].'%')));	
		
		
		$return = $customer['Customer'];
		    		
		echo json_encode($return);
		$this->autoRender = false;
		
	}

}
