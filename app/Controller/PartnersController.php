<?php
class PartnersController extends AppController {

	var $name = 'Partners';
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('listing');
			
		}
	}

	function index() {
		$this->Partner->recursive = 0;
		$this->set('partners', $this->paginate());
	}
	
	function listing($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid partner', true));
			$this->redirect(array('controller' => 'PartnerCategories', 'action' => 'overview'));
		}
		
		$partners = $this->Partner->find('all',array('conditions' => array('Partner.active' => '1', 'PartnerCategory.short' => $id )));
		
		$this->set(compact('partners'));
		$this->set('title_for_layout','Fachhandel - '.$partners[0]['PartnerCategory']['name']);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid partner', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('partner', $this->Partner->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Partner->create();
			if ($this->Partner->save($this->data)) {
				$this->Session->setFlash(__('The partner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The partner could not be saved. Please, try again.', true));
			}
		}
		$partnerCategories = $this->Partner->PartnerCategory->find('list');
		$this->set(compact('partnerCategories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid partner', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Partner->save($this->data)) {
				$this->Session->setFlash(__('The partner has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The partner could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Partner->read(null, $id);
		}
		$partnerCategories = $this->Partner->PartnerCategory->find('list');
		$this->set(compact('partnerCategories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for partner', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Partner->delete($id)) {
			$this->Session->setFlash(__('Partner deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Partner was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
