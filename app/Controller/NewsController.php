<?php
class NewsController extends AppController {

	var $name = 'News';
	public $components = array('Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('start');
			
		}
	}

	function index() {
		$this->News->recursive = 0;
		$this->set('news', $this->paginate());
	}
	
	function start() {
		$news = $this->News->find('all',array('conditions' => 'News.active = 1', 'order' => 'News.created DESC'));
		$this->set('news', $news);
		$this->set('title_for_layout','Willkommen');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('news', $this->News->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for news', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->News->delete($id)) {
			$this->Session->setFlash(__('News deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('News was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
