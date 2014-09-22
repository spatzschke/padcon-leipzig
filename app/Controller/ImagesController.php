<?php
class ImagesController extends AppController {

	var $name = 'Images';
	var $helpers = array('Js' => array('Jquery'));
	var $components = array('RequestHandler', 'Auth', 'Session');
	public $uses = array('Product', 'Image');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('add');
			
		}
	}
 
	function index() {
		$this->Image->recursive = 0;
		$this->set('images', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('image', $this->Image->read(null, $id));
	}

	function add() {
		
			
		
		  if (!empty($this->data)) {
				
				$product = $this->Product->find('first',array('conditions' => array('Product.id' => $this->data['id'])));
				$images = $this->Image->find('all',array('conditions' => array('Image.product_id' => $product['Product']['id'], 'Image.color' => $this->data['color'])));
				
				
				$newImageData['Image']['name'] = $product['Product']['name'];
				$newImageData['Image']['product_id'] = $this->data['id'];
				$newImageData['Image']['color'] = $this->data['color'];
				$newImageData['Image']['path'] = $this->data['path'];
				$newImageData['Image']['ext'] = $this->data['ext'];
				
				if(empty($images)) {
					
					$this->Image->create();
					if ($this->Image->save($newImageData)) {
						//$this->Session->setFlash(__('The image has been saved', true));
					} else {
						$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
					}
				}
			
				
			}
		
		  Configure::write('debug', 0); 
		
		  $this->autoRender = false;
		  
		  exit;
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Image->save($this->data)) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Image->read(null, $id);
		}
		$products = $this->Image->Product->find('list');
		$colors = $this->Image->Color->find('list');
		$this->set(compact('products', 'colors'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for image', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Image->delete($id)) {
			$this->Session->setFlash(__('Image deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
