<?php
class PartnerCategoriesController extends AppController {

	var $name = 'PartnerCategories';
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('overview');
			
		}
	}

	function index() {
		$this->PartnerCategory->recursive = 0;
		$this->set('partnerCategories', $this->paginate());
	}
	
	function overview() {
		$categories = $this->PartnerCategory->find('all',array('conditions' => 'PartnerCategory.active = 1'));
		$this->set('categories', $categories);
		$this->set('title_for_layout','Fachhandelübersicht');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid partner category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('partnerCategory', $this->PartnerCategory->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PartnerCategory->create();
			if ($this->PartnerCategory->save($this->data)) {
				$this->Session->setFlash(__('The partner category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The partner category could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid partner category', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PartnerCategory->save($this->data)) {
				$this->Session->setFlash(__('The partner category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The partner category could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PartnerCategory->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for partner category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PartnerCategory->delete($id)) {
			$this->Session->setFlash(__('Partner category deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Partner category was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
