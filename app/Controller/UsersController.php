<?php

// app/Controller/UsersController.php
class UsersController extends AppController {

	public $components = array(
        'Auth' => array(
        		'flash' => array(
                'element' => 'flash_message',
				'key' => 'auth',
				'params' => array(
					'class' => 'alert-danger'
				)
            )
        )
    );

    public function beforeFilter() {
	    parent::beforeFilter();
	    // Allow users to register and logout.
	    $this->Auth->allow('add', 'logout', 'createAnonymous');
	}
	
	public function admin_login() {
		
		return $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
	}
	
	public function login() {
	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
				$this->request->data['User']['id'] = $this->Auth->user('id');
				$this->request->data['User']['last_login'] = date('Y-m-d h:i:s');
        		if ($this->User->save($this->request->data)) {
					return $this->redirect(array('controller' => 'users', 'action' => 'dashboard', 'admin' => true,'prefix' => 'admin'));
	        	}
			}
	        $this->Session->setFlash('Der eingebene Benutzer oder das Passwort sind falsch!', 'flash_message', array('class' => 'alert-danger'));
	    }
	}
	
	public function logout() {
	    return $this->redirect(array('controller' => 'news', 'action' => 'start', 'admin' => false));
	}

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }
	
	 public function admin_view($id = null) {
       $this->layout = 'admin';
		if (!$id) {
			$this->Session->setFlash(__('Unbekannter Benutzer', true), 'flash_message', array('class' => 'alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->request->data = $this->User->read(null, $id);
		
		$this->set('title_for_panel','Benutzer betrachten');
		
		$this->render('/Elements/backend/portlets/userDetailPortlet');
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

	public function createAnonymous($user = null) {
		debug($user);
		$this->User->create();
		if ($this->User->save($user)) {
           return true;
        }
		return false;
	}

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

	//admin
	
	function admin_dashboard() {
		$this->layout = 'admin';
	}
	
	function admin_index() {
		$this->layout = 'admin';
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		$this->render('/Elements/backend/portlets/userPortlet');
	}
	
	function admin_add($id = null) {
		$this->layout = 'admin';
		$this->add($id);
		$this->set('title_for_panel','Benutzer anlegen');
		$this->render('/Elements/backend/portlets/userDetailPortlet');
	}
	
	function admin_delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
	
	function getUser() {
		$users = $this->User->find('all');
		return $users;
	}

}

?>