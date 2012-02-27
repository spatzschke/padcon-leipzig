<?php
App::import('Core', 'File');

class SiteContentsController extends AppController {

	var $name = 'SiteContents';
	public $components = array('RequestHandler', 'Email', 'Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('loadCMSContent', 'contact');
			
		}
	}

	function index() {
		$this->SiteContent->recursive = 0;
		$this->set('siteContents', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid site content', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('siteContent', $this->SiteContent->read(null, $id));
	}
	
	function loadCMSContent($position = null, $controller = null, $action = null, $param = '') {
	
		$content = $this->SiteContent->find('first',array('conditions' => array('controller' => $controller, 'action' => $action, 'param' => $param, 'active' => 1, 'position' => $position), 'fields' => array('content_paragraph')));
	
		echo $content['SiteContent']['content_paragraph'];
		
	}
	
	function contact() {
		if (!empty($this->data)) {
			
			$this->Email->to = 'info@padcon-leipzig.de';
			$this->Email->subject = 'Kontaktformular';
			$this->Email->replyTo = 'noreply@padcon-leipzig.de';
			$this->Email->from = 'padcon Leipzig <noreply@padcon-leipzig.de>';
			$this->Email->template = 'contact'; 
			$this->Email->sendAs = 'both';
			$this->set('data', $this->data);
			
			if($this->Email->send() ) {
				$this->Session->setFlash('Ihre Email wurde erfolgreich versandt!');
				$this->redirect('/Kontakt');
			} else {
				$this->Session->setFlash('Fehler');	
			}
		}
		$this->set('title_for_layout','Kontakt');
	}

	function add() {
		$file = new File(CSS . 'cms.css', false, 0777);
		
		if (!empty($this->data)) {
			$this->SiteContent->create();
			if ($this->SiteContent->save($this->data)) {
				
				$file->write($this->data['SiteContent']['style_content']);
				
				$this->Session->setFlash(__('The site content has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site content could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			
			$content = $file->read();
			$this->set('styleContent', $content);
		}
	}

	function edit($id = null) {
		$file = new File(CSS . 'cms.css', false, 0777);
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid site content', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->SiteContent->save($this->data)) {
				
				$file->write($this->data['SiteContent']['style_content']);
				
				$this->Session->setFlash(__('The site content has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site content could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SiteContent->read(null, $id);
			
			
			$content = $file->read();
			$this->set('styleContent', $content);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site content', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SiteContent->delete($id)) {
			$this->Session->setFlash(__('Site content deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Site content was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
