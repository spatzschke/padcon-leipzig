<?php
class ProductsController extends AppController {

	var $name = 'Products';
	public $uses = array('Product', 'Material', 'Size', 'Color', 'Image');
	var $components = array('RequestHandler', 'Auth', 'Session');
	var $helpers = array('Html', 'Javascript');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('listing', 'sizeBuilder', 'getColors', 'search', 'liveValidate');
			
			$this->set('auth',$this->Auth->user());
		}
		if($this->Auth) {
			$this->layout = 'admin';
		}
		
	}

	function index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
	}
	
	function admin_index() {
		$products = $this->getProducts(null);
		
		$this->set(compact('products'));
	}
	
	function listing($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('controller' => 'Categories', 'action' => 'overview'));
		} 
		
		$products = $this->getProducts($id);
		
		$this->set(compact('products'));
		$this->set('title_for_layout','Produkte: '.$products[0]['Category']['name']);
	}
	
	function getProducts($categoryID = null){
		
		if($categoryID  == null) {
			$con = array('Product.active' => '1');
		} else {
			$con = array('Product.active' => '1', 'Category.short' => $categoryID);
		}
		
		$products = $this->Product->find('all',array('conditions' =>  $con,'order' => array('Product.product_number ASC')));
		
		return $products;
	} 
	
	function sizeBuilder($id = null) {
		$size = $this->Size->findById( $id );
		
		$sizeString = '';
		
        // B x L
		if($size['Size']['depth'] != '' && $size['Size']['width'] != '') {
			$sizeString = $size['Size']['depth'].' x '.$size['Size']['width'];
		}
		
		// B x L x H
		if($size['Size']['depth'] != '' && $size['Size']['width'] != '' && $size['Size']['height'] != '') {
			$sizeString = $size['Size']['depth'].' x '.$size['Size']['width'].' x '.$size['Size']['height'];
		}
		
        // ØA, ØI, H
		if($size['Size']['outer'] != '' && $size['Size']['inner'] != '' && $size['Size']['height'] != '') {
			$sizeString = 'ØA:'.$size['Size']['outer'].', ØI:'.$size['Size']['inner'].', '.$size['Size']['height'];
		}
		
        // Ø x L
		if($size['Size']['outer'] != '' && $size['Size']['width'] != '') {
			$sizeString = 'Ø'.$size['Size']['outer'].' x '.$size['Size']['width'];
		}
		
        // B x L x H, ØI
		if($size['Size']['depth'] != '' && $size['Size']['width'] != '' && $size['Size']['height'] != '' && $size['Size']['inner'] != '') {
			$sizeString = $size['Size']['depth'].' x '.$size['Size']['width'].' x '.$size['Size']['height'].', ØI:'.$size['Size']['inner'];
		}		
		
		if($sizeString == '') {
			echo 'siehe Eigenschaften';
		} else {
			echo $sizeString. ' cm';	
		}
		
		
	}
	
	function getColors($material = null) {
		
		
		$colors = $this->Color->find('all',array('conditions' => array('Color.material_id' => $material)));
		return $colors;	
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		$sizes = $this->Product->Size->find('list');
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'sizes', 'carts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
			}
			
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
		}
		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		$sizes = $this->Product->Size->find('list');
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'sizes', 'carts'));
	}
	
	function admin_edit($id = null) {
		$this->edit($id);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(__('Product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function search($searchString = null) {
	
		if($this->Auth) {
			echo $this->admin_search($searchString);
		} else {
	
			if (!$searchString && empty($this->data)) {
				$this->Session->setFlash(__('Invalid product', true));
			}
			if($this->data['searchNumber'] == '') {
				$products = $this->Product->find('all',array('conditions' => array('Product.active' => '1', 'Product.name LIKE' => '%'.$this->data['searchStr'].'%' )));
			} else {
				$products = $this->Product->find('all',array('conditions' => array('Product.active' => '1', 'Product.product_number LIKE' => $this->data['searchNumber'].'%' )));	
			}
			$this->set(compact('products'));
			$this->set('title_for_layout','Suchergebnis'); 
		}
		
	}
	
	function admin_search($searchString = null) {
		
		$products = $this->Product->find('all',array('conditions' => array("OR" => 
			array (	'Product.name LIKE' 			=> '%'.$this->data['str'].'%' ,
					'Product.product_number LIKE' 	=> '%'.$this->data['str'].'%' ,
					'Material.name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Category.name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Size.name LIKE' 	=> '%'.$this->data['str'].'%'))));	
		
		$this->set('products', $products);
		$this->render('/elements/backend/portlets/productPortletTableContent');
	}
	
	function liveValidate($string = null) {
	
		$validateString = $this->data[$this->data['Model']][$this->data['Field']];
		
		
		$this->Product->set( $this->data );
		
	    if ($this->Product->validates()) {
		    $status['status'] = 'success';
		    
		    $product = $this->Product->find('first',array('conditions' => array('Product.id' => $this->data['Id'])));	
		    $status['id'] = $product['Product']['id'];
		    
		    if (!empty($this->data) && !empty($product)) {
		    
		    	$product[$this->data['Model']][$this->data['Field']] = $validateString;
		    	
				if ($this->Product->save($product)) {
					$status['status'] = 'save success';				
				} else {
					$status['status'] = 'save error';
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
	
	function reloadProductItem($id = null) {
		$product = $this->Product->find('first',array('conditions' => array('Product.id' => $id)));
		$this->set('product', $product);
		$this->render('/elements/productItem');
	}
}
