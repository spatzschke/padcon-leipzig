<?php
class ProductsController extends AppController {

	var $name = 'Products';
	public $uses = array('Cart', 'Product', 'Material', 'Color', 'Image', 'Category');
	var $components = array('RequestHandler', 'Auth', 'Session');
	var $helpers = array('Html', 'Js');
	
	public function beforeFilter() {

		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('listing', 'getColors', 'search', 'liveValidate');
			
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
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'carts'));
		
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
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'carts'));
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Produkt anlegen');
		$this->render('/Elements/backend/portlets/Product/productDetailPortlet');
		
		// $this->request->data['Categories'] = $categories;
		// $this->request->data['Materials'] = $materials;
		// $this->request->data['Carts'] = $carts;
		
	}

	function admin_quickAdd() {
		$this->layout = 'admin';
		$errors = array();
				
		if (!empty($this->data)) {
			 
			 if(!empty($this->data['Product']['description_quick'])) {
					
				$newProduct;
				$newProducts = array();
				
				
				$features = array();
		
				$string = trim($this->data['Product']['description_quick']);
				
				$string = explode('€

', $string);
			
			foreach($string as $string) {
				
							
			
				$multi = false;
				$parts = false;
				if(substr_count($string, 'PD') > 1) {$multi = true;}
				if(substr_count($string, 'Maße') > 1 && !$multi) {$parts = true;}
				
				$input = explode(PHP_EOL, $string);
				
				$features = array();
				$ek = array();
				$vk = array();
				$maße = array();
				$number = array();
				$producerName = array();
				$producerNumber = array();
				$categories = array();
				
				foreach($input as $i=>$value)
				{
	
					//Erste Zeile gesondert auslesen auslesen
					$val = $value;
				    if($i == 0) {
						$val = explode('	',trim($val));
						if (
							strpos($val[0], 'PD') !== FALSE ||
							strpos($val[0], 'SB') !== FALSE ||
							strpos($val[0], 'Z') !== FALSE
						) {
					    	$number = str_ireplace('-xx', '', trim($val[0]));
							$number = str_ireplace('pd ', '', trim($number));
							$number = str_ireplace('(alt)', '', trim($number));
							$name = trim($val[1]);
						} else {
							$name = trim($val[0]);
						}
						continue;
				    }
					
					//Feature Schaum
					$val = $value;
					if (strpos($val, 'Fa. padcon') !== FALSE) {
						$val = explode('	',trim($val));
						
						//Sonderfall: Im Feature steht der Bezug
						if (strpos($val[1], 'Bezug') !== FALSE) {
							$bezug = explode(', ', explode('Bezug:', trim($val[1]))[1]);		
							$bezug = $this->Product->Material->findByName(trim($bezug[0]));
						} else {
							array_push($features, trim($val[1]));
						}
						continue;	
					}
	
					//Bezug
					$val = $value;
					if (strpos($val, 'Bezug:') !== FALSE) {
	
						$val = explode(', Farbe',trim($val));
						$val = str_ireplace('Bezug:', '', trim($val[0]));
						$bezug = $this->Product->Material->findByName(trim($val));
						continue;
					}
	
					//Kategorien ermitteln
					$val = $value;
					if (strpos($val, 'Kategorie:') !== FALSE) {
						$val = explode('Kategorie:',trim($val));
						$val = trim($val[1]);
						foreach (explode(',',$val) as $value) {
							$cat = '';
							if($value == 'P') { $cat = 'pflege'; }
							if($value == 'O') { $cat = 'op'; }
							if($value == 'I') { $cat = 'intensiv'; }
							if($value == 'R') { $cat = 'rontgen'; }
							if($value == 'B') { $cat = 'baby'; }
							if($value == 'F') { $cat = 'funktion'; }
							if($value == 'N') { $cat = 'notfall'; }
							
							$id = $this->Category->findByShort($cat);
							
							array_push($categories, $id['Category']['id']);
						}
						continue;
					}
					
					//Maße und Preise - Auswertung Multiprodukt
					$val = $value;
					if (strpos($val, 'cm') !== FALSE && strpos($val, '	Maße:') !== FALSE) {
						if($multi) {
							$str = explode('	', trim($val));	
							$tempNumber = str_ireplace('-xx', '', $str[0]);
							$tempNumber = str_ireplace('pd ', '', trim($tempNumber));
							$tempNumber = str_ireplace('(alt)', '', trim($tempNumber));
							array_push($number, $tempNumber);
							$tempMaße = str_ireplace('Maße:', '', $str[1]);	
							array_push($maße, trim(str_replace('cm', '', trim($tempMaße))));
							if(!empty($str[3])) {array_push($vk, $str[2]);}
							if(!empty($str[3])) {array_push($vk, $str[3]);}
						} else {
							$str = explode('	', trim($val));		
							if($parts){
								array_push($features, trim($val));
								$maße = '';
							} else {
								$tempMaße = str_ireplace('Maße:', '', $str[0]);	
								$maße = trim(str_replace('cm', '', trim($tempMaße)));
							}						
							if(strpos($val, '€') !== FALSE) {
								$ek = $str[1];	
								$vk = $str[2];
							}
						}			
						continue;
					}
					
					//Preise
					$val = $value;
					if (strpos($val, '€') !== FALSE) {
							$str = explode('	', trim($val));		
														
							$ek = $str[0];
							if(!empty($str[1]))	{ $vk = $str[1]; }
									
						continue;
					}
					
					//Hersteller
					$val = $value;
					if (strpos($val, 'Hersteller:') !== FALSE) {
							$str = explode(':', trim($val));		
														
							$producerName = $str[1];	
							$producerNumber = $str[2];
									
						continue;
					}
	
					//Alles weiter als Feature
					array_push($features, trim($value));
	
				}
				
				$tempFeatures = '';
				foreach($features as $entry) {
					$tempFeatures = $tempFeatures.'<li>'.$entry.'</li>'.PHP_EOL;
				}
				$features = $tempFeatures;
	
				if($multi) {
									
					foreach($number as $i=>$product) {
						foreach($categories as $category) {
							$newProduct['Product']['number'] = $number[$i];
							$newProduct['Product']['name'] = $name;
							
							$newProduct['Product']['producerName'] = $producerName;
							$newProduct['Product']['producerNumber'] = $producerNumber;
		
					 		$newProduct['Product']['material'] = $bezug['Material']['id'];
					 		$newProduct['Product']['feature'] = $features;
							$newProduct['Product']['maße'] = $maße[$i];
							$newProduct['Product']['ek'] = str_replace(',', '.', str_replace(' €', '', $ek))[$i];
							$newProduct['Product']['vk'] = str_replace(',', '.', str_replace(' €', '', $vk))[$i];
							$newProduct['Product']['active'] = 'checked';
							$newProduct['Product']['new'] = '';
							if (strpos($number[$i], 'Z') !== FALSE) {
								$newProduct['Product']['custom'] = 'checked';
							} else {
								$newProduct['Product']['custom'] = '';
							}
							$newProduct['Product']['category_id'] = $category;
							
							array_push($newProducts, $newProduct);
						}
					}
				} else {
					if(empty($categories)) {
						
						$errors['prod-cat'] = array();
						$error = "Produkt <b>".$number."</b> hat keine Kategorien. Bitte prüfen!";
						 array_push($errors['prod-cat'], $error);
					}
										
					foreach($categories as $category) {
						$newProduct['Product']['number'] = $number;
						$newProduct['Product']['name'] = $name;
		
						$newProduct['Product']['producerName'] = $producerName;
						$newProduct['Product']['producerNumber'] = $producerNumber;
		
					 	$newProduct['Product']['material'] = $bezug['Material']['id'];
					 	$newProduct['Product']['feature'] = $features;
						$newProduct['Product']['maße'] = $maße;
						$newProduct['Product']['ek'] = str_replace(',', '.', str_replace(' €', '', $ek));
						$newProduct['Product']['vk'] = str_replace(',', '.', str_replace(' €', '', $vk));
						$newProduct['Product']['active'] = 'checked';
						$newProduct['Product']['new'] = '';
						if (strpos($number, 'Z') !== FALSE) {
							$newProduct['Product']['custom'] = 'checked';
						} else {
							$newProduct['Product']['custom'] = '';
						}
						$newProduct['Product']['category_id'] = $category;
						
						array_push($newProducts, $newProduct);
					}
				}
				
				$this->request->data['Products'] = $newProducts;
				}					
			} else {				
				$data = $this->data;
				$errors = array();
				foreach($data as $i=>$prod) {
					$errors['prod'.$i] = array();
					$check = $this->Product->find('count', array('conditions' => array('product_number' => $prod['Product']['product_number'], 
																						'category_id' => $prod['Product']['category_id'])));																				
					
					$this->Product->create();
					if ($check == 0 && $this->Product->save($prod)) {
						$this->Session->setFlash(__('Produkt wurde angelegt!', true));
					} else {
						
						 $cat = $this->Category->findById($prod['Product']['category_id']);	

						 $error = "Produkt <b>".$prod['Product']['product_number']."</b> in Kategorie <b>".$cat['Category']['name']."</b> ist bereits vorhanden. Bitte prüfen!";
						 array_push($errors['prod'.$i], $error);					
					}
				}
				
				
				
							
				//$this->redirect(array('action' => 'edit', $lastId));
			}
		}

		if(!empty($errors['prod0']) || !empty($errors['prod-cat'])) {
			$this->set(compact("errors"));
			//$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
		}

		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'carts'));
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Produkt anlegen');
		//$this->render('/Elements/backend/portlets/Product/productDetailPortlet');
		
		// $this->request->data['Categories'] = $categories;
		// $this->request->data['Materials'] = $materials;
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
		
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'carts', 'colors'));
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
					'Category.name LIKE' 	=> '%'.$this->data['str'].'%'))));	
		
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
					'Category.name LIKE' 	=> '%'.$this->data['str'].'%'))));	
		
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
		
		$custom =  $this->Product->find('all',array('conditions' => array(
			'Product.custom' => 1,
			'Product.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d'))),
			
			'order' => array('Product.created' => 'desc'))
		);
		
		if(empty($custom)) {
			$number = 1;
		} else {	
			$number = str_split($custom['0']['Product']['product_number'], 3);
		}
		$number = 'Z'.date("y").str_pad(intVal($number[1])+1, 3, "0", STR_PAD_LEFT);
		
		return $number;
		
	}
}
