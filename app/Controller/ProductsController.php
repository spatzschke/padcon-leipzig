<?php
class ProductsController extends AppController {

	var $name = 'Products';
	public $uses = array('Cart', 'Product', 'Material', 'Size', 'Color', 'Image');
	var $components = array('RequestHandler', 'Auth', 'Session');
	var $helpers = array('Html', 'Js');
	
	public function beforeFilter() {

		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('listing', 'sizeBuilder', 'getColors', 'search', 'liveValidate');
			
			$this->set('auth',$this->Auth->user());	
		}
	}

	function index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
	}
	
	function admin_index($layout = null, $cart_id = null) {
		if($layout) {$this->layout = $layout; } else { $this->layout = 'admin'; }
	
		$products = $this->getProducts(null);
		
		$this->set(compact('products', 'cart_id'));
		$this->set('ajax', 0);
	}
	
	function admin_indexAjax($layout = null, $cart_id = null) {
		$this->admin_index($layout, $cart_id);
		$this->render('/Elements/backend/portlets/Product/productPortletAjax');
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
		
		$products = $this->Product->find('all',array('conditions' =>  $con,'order' => array('Product.product_number ASC'), 'group' =>  array('Product.product_number')));
		
		return $products;
	}
	
	function getProduct($id = null){
		
		$product = $this->Product->findById($id);
		$color = $this->Material->findById($product['Material']['id']);
		
		return $product+$color;
	}  
	
	function seperatFeatureList($id = null) {
		
		$product = $this->getProduct($id);
		$features  = explode("</li>", $product['Product']['featurelist']);
		
		$fea = array();
		
		foreach($features as $feature) {
			
			$feature = trim($feature);
		
			if(!empty($feature))
				array_push($fea, str_replace(array('<li>','</li>'), "", $feature));
			
		}
		
		return $fea;
		
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
		$this->request->data = $this->Product->read(null, $id);
	}
	
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}

		$view = new View($this);
        $Number = $view->loadHelper('Number');

		$product = $this->Product->read(null, $id);
		$product['Product']['product_number'] = 'pd-'.$product['Product']['product_number'];
		$product['Product']['retail_price_string'] = $Number->currency($product['Product']['retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));
		$product['Product']['featurelist'] = str_replace('<li>', '', $product['Product']['featurelist']);
		$product['Product']['featurelist'] = str_replace('</li>', '', $product['Product']['featurelist']);
		
		$this->request->data = $product;
		
		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		$sizes = $this->Product->Size->find('list');
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'sizes', 'carts'));
		
		$this->layout = 'admin';
		$this->set('title_for_panel', 'Produkt betrachten');
	}
	
	function admin_add() {
		$this->layout = 'admin';
		
		
		if (!empty($this->data)) {
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('Produkt wurde angelegt!', true));
				$lastId = $this->Product->getLastInsertID();					
				$this->redirect(array('action' => 'edit', $lastId));
			} else {
				$errors = $this->Product->invalidFields();
				$this->set(compact("errors"));
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		$sizes = $this->Product->Size->find('list');
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'sizes', 'carts'));
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Produkt anlegen');
		$this->render('/Elements/backend/portlets/Product/productDetailPortlet');
		
		// $this->request->data['Categories'] = $categories;
		// $this->request->data['Materials'] = $materials;
		// $this->request->data['Sizes'] = $sizes;
		// $this->request->data['Carts'] = $carts;
		
	}
	
	function admin_loadProductAddPopup($id = null, $cart_id = null) {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			
			$product = $this->getProduct($id);
			
			$color = $product['Color'];
					
			$colors[] = null;
			foreach ($color as $c) {
				$colors[$c['code']] = $c['code'].' - '.$c['name'];
			}
			
			$product['Color'] = array_filter($colors);
			
			$this->request->data = $product;
			
			if($cart_id) {
				$cart = $this->Cart->findById($cart_id);
				$controller_id = 0;
				$controller_name = '';
				if(isset($cart['Offer']['id'])) {
					$controller_name = 'Offers';
					$controller_id = $cart['Offer']['id'];
				}
				if(isset($cart['Confirmation']['id'])) {
					$controller_name = 'Confirmations'; 
					$controller_id = $cart['Confirmation']['id'];
				}
				
				
				$this->set(compact('cart_id', 'controller_id', 'controller_name'));
			}
			
			$this->render('/Elements/backend/portlets/Product/productAddPortlet');
		}
		
	}
	

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$data = $this->data;
		unset($data['Product']['product_number']);

		if (!empty($data)) {
			if ($this->Product->save($data)) {
				$this->Session->setFlash(__('Das Produkt wurde gespeichert', true));
				
			} else {
				$this->Session->setFlash(__('Das Produkt konnte nicht gespeichert werden. Bitte prüfen Sie die Meldungen.', true));
			}
			
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
			$colors = $this->Color->find('list',array('conditions' => array('Color.material_id' => ($this->data['Material']['id'])), 'fields' => array('Color.name')));
			
		}
		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		
		$sizes = $this->Product->Size->find('list');
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'sizes', 'carts', 'colors'));
	}
	
	function admin_edit($id = null) {
		$this->edit($id);
		$this->layout = 'admin';
		$this->set('title_for_panel', 'Produkt bearbeiten');
		$this->set('primary_button', 'Speichern');
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product', true));
			//$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(__('Product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product was not deleted', true));
			$this->redirect(array('action' => 'index'));
	}
	
	function admin_delete($id = null) {
		$this->delete($id);
		$this->layout = 'admin';
	}
	
	function search($searchString = null) {
	
		if($this->Auth) {
			echo $this->admin_search($searchString);
		} else {
	
			$products = $this->Product->find('all',array('conditions' => array("OR" => 
			array (	'Product.name LIKE' 			=> '%'.$this->data['str'].'%' ,
					'Product.product_number LIKE' 	=> '%'.$this->data['str'].'%' ,
					'Material.name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Category.name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Size.name LIKE' 	=> '%'.$this->data['str'].'%'))));	
		
			$this->set('products', $products);
			
			if($this->data['template'] != '') {
				$this->render($this->data['template']);
			}
			
			$this->set('title_for_layout','Suchergebnis'); 
		}
		
	}
	
	function admin_search($ajax = null, $searchString = null) {
		
		$products = $this->Product->find('all',array('conditions' => array("OR" => 
			array (	'Product.name LIKE' 			=> '%'.$this->data['str'].'%' ,
					'Product.product_number LIKE' 	=> '%'.$this->data['str'].'%' ,
					'Material.name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Category.name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Size.name LIKE' 	=> '%'.$this->data['str'].'%'))));	
		
		$this->set('products', $products);
		$this->set('ajax', $ajax);
		
		if(isset($this->data['template'])) {
			$this->render($this->data['template']);
		}
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
		    	
		    	if($this->data['autoSave'] == 'true') {
		    	
					if ($this->Product->save($product)) {
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
	
	function reloadProductItem($id = null) {
	
		if($this->data['Id']) {
			
			$id = $this->data['Id'];
		}
		
		$product = $this->Product->find('first',array('conditions' => array('Product.id' => $id)));
		$this->set('product', $product);
		$this->render('/Elements/productItem');
	}
	
	function getNextCustomProductNumber() {
	
		$this->autoRender = false;
		$this->layout = 'ajax';
		
		$custom =  $this->Product->find('all',array('conditions' => array('Product.custom' => 1) ,'order' => array('Product.created' => 'desc')));
		
		if(empty($custom)) {
			$number = 1;
		} else {	
			$number = str_split($custom['0']['Product']['product_number'], 3);
		}
		$number = 'Z'.date("y").str_pad(intVal($number[1])+1, 3, "0", STR_PAD_LEFT);
		
		return $number;
		
	}
}
