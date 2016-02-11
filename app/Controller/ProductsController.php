<?php
App::import('Controller', 'Carts');

class ProductsController extends AppController {
	
	var $name = 'Products';
	public $uses = array('Cart', 'Product', 'Material', 'Color', 'Image', 'Category', 'Core', 'ProductCore', 'ProductCategory', 'CartProduct');
	var $components = array('RequestHandler', 'Auth', 'Session', 'Paginator');
	var $helpers = array('Html', 'Js');
	
	public function beforeFilter() {

		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('listing', 'getColors', 'search', 'liveValidate', 'getProduct', 'seperatFeatureList');
			
			$this->set('auth',$this->Auth->user());	
		}
	}

	function index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
	}
	
	function admin_index($layout = null, $cart_id = null) {
		if($layout) {$this->layout = $layout; } else { $this->layout = 'admin'; }
	
		$this->Product->recursive = 0;
		 $this->Paginator->settings = array(
		 	'conditions' => array('Product.external' => '0'),
		 	'group' => array('Product.product_number'),
	        'order' => array('Product.name' => 'ASC'),
	        'limit' => 25
	    );
		$products = $this->Paginator->paginate('Product');
		
		$this->set(compact('products', 'cart_id'));
		$this->set('ajax', 0);
	}

	function admin_index_external($layout = null, $cart_id = null) {
		if($layout) {$this->layout = $layout; } else { $this->layout = 'admin'; }
	
		$this->Product->recursive = 0;
		 $this->Paginator->settings = array(
		 	'conditions' => array('Product.external' => '1'),
	        'order' => array('Product.product_number' => 'ASC'),
	        'limit' => 25
	    );
		$products = $this->Paginator->paginate('Product');
		
		$this->set(compact('products', 'cart_id'));
		$this->set('ajax', 0);
		
		$this->render('admin_index');
	}
	
	function admin_indexAjax($layout = null, $cart_id = null, $controller_id = null, $controller_name = null) {
		$this->admin_index($layout, $cart_id);
		
		$this->set(compact('controller_name', 'controller_id'));
		$this->render('/Elements/backend/portlets/Product/productPortletAjax');
	}
	
	function listing($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('controller' => 'Categories', 'action' => 'overview'));
		} 
		
		$category = $this->Category->findByShort($id);
		$products = $this->getProducts($id);
		
		foreach ($products as $i => $value) {
			$products[$i]['Category'] = $category['Category'];
		}
		
		$this->set(compact('products'));
		$this->set('title_for_layout','Produkte: '.$products[0]['Category']['name']);
	}
	
	function getProducts($categoryID = null){
		
		$products = array();
		
		if($categoryID  == null) {
			$con = array('Product.active' => '1');
			$products = $this->Product->find('all',array('conditions' =>  $con,'order' => array('Product.product_number ASC'), 'group' =>  array('Product.product_number')));
		
		} else {
			$this->ProductCategory->recursive = 0;
			$catId = $this->Category->findByShort($categoryID);
			$prodCat = $this->ProductCategory->findAllByCategoryId($catId['Category']['id']);
			
			foreach($prodCat as $product) {
				$query = $this->Product->findById($product['Product']['id']);
				//Nur akitve Produkte hinzufügen
				if($query['Product']['active'] == 1) {
					array_push($products, $query);
				}
			}	
		}
		
		
		return $products;
	}
	
	function getProduct($id = null){
		
		$product = $this->Product->findById($id);
		
		//Kerne hinzufügen
		$core_arr = array();
		$cores = $this->ProductCore->findAllByProductId($id);
		foreach ($cores as $i => $core) {
			array_push($core_arr, $core['ProductCore']['core_id']);
		}
		$product['Product']['cores'] = $core_arr;
		
		//Kategorien hinzufügen
		$cat_arr = array();
		$cats = $this->ProductCategory->findAllByProductId($id);
		foreach ($cats as $i => $cat) {
			array_push($cat_arr, $cat['ProductCategory']['category_id']);
		}
		$product['Product']['categories'] = $cat_arr;
		
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
		$product['Product']['product_number'] = $product['Product']['product_number'];
		$product['Product']['retail_price_string'] = $Number->currency($product['Product']['retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));
		$product['Product']['featurelist'] = $this->getListElement($product['Product']['featurelist'], FALSE);
		
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
			
			$prod = $this->data;
			$prod['Product']['featurelist'] = $this->getListElement($prod['Product']['featurelist'], TRUE);
			
			if ($this->Product->save($prod)) {
				$this->Session->setFlash(__('Produkt wurde angelegt!', true));
				$lastId = $this->Product->getLastInsertID();					
				$this->redirect(array('action' => 'edit', $lastId));
			} else {
				$errors = $this->Product->invalidFields();
				$this->set(compact("errors"));
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
			}
		}
		$data['Product']['product_number'] = '';
		$data['Product']['name'] = '';
		$data['Product']['categories'] = '';
		$data['Product']['featurelist'] = '';
		$data['Product']['material_id'] = '';
		$data['Product']['price'] = '';
		$data['Product']['retail_price'] = '';
		$data['Product']['custom'] = '';
		$data['Product']['new'] = '';
		$data['Product']['active'] = '';
		$data['Product']['size'] = '';
		$data['Product']['core_name'] = '';
		$data['Product']['cores'] = '';
		$data['Product']['reference'] = '';
		$data['Product']['company'] = '';
		$data['Product']['producer_name'] = '';
		$data['Product']['producer_number'] = '';
		
		
		$cores = $this->Core->find('list');
		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'carts', 'data', 'cores'));
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Produkt anlegen');
		// $this->render('/Elements/backend/portlets/Product/productDetailPortlet');
		
		// $this->request->data['Categories'] = $categories;
		// $this->request->data['Materials'] = $materials;
		// $this->request->data['Carts'] = $carts;
		
	}

	function admin_add_external() {
		$this->layout = 'admin';
		
		if (!empty($this->data)) {
			$this->Product->create();
			
			$prod = $this->data;
			
			$prod['Product']['external'] = true;
			$prod['Product']['active'] = true;
			$prod['Product']['featurelist'] = $this->getListElement($prod['Product']['featurelist'], TRUE);
			
			$Carts = new CartsController();
			$prod['Product']['price'] = $Carts->convertPriceToSql($prod['Product']['price']);
			$prod['Product']['retail_price'] = $Carts->convertPriceToSql($prod['Product']['retail_price']);
			
			if ($this->Product->save($prod)) {
				$this->Session->setFlash(__('Fremdprodukt wurde angelegt!', true));
				$lastId = $this->Product->getLastInsertID();					
				$this->redirect(array('action' => 'edit_external', $lastId));
			} else {
				$errors = $this->Product->invalidFields();
				$this->set(compact("errors"));
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
				
				$data = $this->data;
				
				$data['Product']['featurelist'] = str_replace('<li>', '', $data['Product']['featurelist']);
				$data['Product']['featurelist'] = str_replace('</li>', '', $data['Product']['featurelist']);
				
			}
		} else {
			$data['Product']['product_number'] = '';
		$data['Product']['name'] = '';
		$data['Product']['featurelist'] = '';
		$data['Product']['price'] = '';
		$data['Product']['retail_price'] = '';
		$data['Product']['company'] = '';
		}

		
			
		
		$this->set(compact('data'));	
		
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Fremdprodukt anlegen');
		
		$this->render('admin_external');
		
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
				$multiCount = substr_count($string, 'PD');
				
				if (strpos($string, ' PD') !== FALSE) {
				 $multiCount = $multiCount-1;	
				}
				$parts = false;
				if($multiCount > 1) {$multi = true;}
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
				$cores_arr = array();
				$bezug = array();
				$core_name = "";
				$referenz = "";
				$company = "";
				
				foreach( $input as $key => $value ) {
      				if( $value == ' ' || $value == '' ) {unset($input[$key]);}
				}
				$input = array_merge($input); 
								
				foreach($input as $i=>$value)
				{
	
					//Erste Zeile gesondert auslesen auslesen
					$val = $value;
					
					if($i == 0) {
				    	$val = trim($val);
						$val = explode('	',trim($val));
						
					    	$number = str_ireplace('-xx', '', trim($val[0]));
							//$number = str_ireplace('pd ', '', trim($number));
							$number = str_ireplace('(alt)', '', trim($number));
							
							$name = trim($val[1]);
						
						continue;
				    }
					
					//Firma aus 2. Zeile auslesen
					if($i == 1) {
				    	$val = trim($val);
						$string = explode('	',trim($val));
						$company = trim($string[0]);
						if(strcmp($company ,'Fa. padcon')) {
							$producerNumber = $number;
						}					
						
						if (strpos(trim($string[1]), 'Kern:') !== FALSE) {
							$val = $string[1];
							$t = explode('Kern: ', trim($val));
							$val = $t[1];								
							$split = split("/", $val);
							
							foreach($split as $item) {
								$entry = $this->Core->findByName($item);
								if(!empty($entry)) {	array_push($cores_arr, $entry['Core']['id']); }
								if(end($split) !== $item){
								    $core_name = $core_name.$item.' / ';
								} else {
									$core_name = $core_name.$item;
								}									
							}
						}
						
						if (strpos(trim($string[1]), 'Bezug:') !== FALSE) {
							$t = explode('Bezug:', trim($string[1]));
							$bezug = explode(', ', $t[1]);		
							$bezug = $this->Product->Material->findByName(trim($bezug[0]));
						}
						
						
						continue;
				    }
					
					//Kern					
					$val = $value;
					if (strpos($val, 'Kern:') !== FALSE) {
						$val = explode('	',trim($val));
						$val = $val[1];
						$t = explode('Kern: ', trim($val));
						$val = $t[1];								
						$split = split("/", $val);
						
						foreach($split as $item) {
							$entry = $this->Core->findByName($item);
							if(!empty($entry)) {	array_push($cores_arr, $entry['Core']['id']); }
							if(end($split) !== $item){
							    $core_name = $core_name.$item.' / ';
							} else {
								$core_name = $core_name.$item;
							}									
						}
						
						continue;
					}
										
					//Referenz					
					$val = $value;
					if (strpos($val, 'Alt:') !== FALSE) {
	
						$val = explode('Alt:',trim($val));
												
						$referenz = trim($val[1]);
						if(empty($referenz)) { $referenz = ""; }
						
						continue;
					}
	
					//Bezug					
					$val = $value;
					if (strpos($val, 'Bezug:') !== FALSE && strpos($val, '-Bezug:') == FALSE) {
	
						$val = explode(', Farbe',trim($val));
						$val = str_ireplace('Bezug:', '', trim($val[0]));
												
						$bezug = $this->Product->Material->findByName(trim($val));
						if(empty($bezug)) { $bezug = ""; }
						
						continue;
					}
	
					//Kategorien ermitteln
					$val = $value;
					if (strpos($val, 'Kategorie:') !== FALSE) {
						$val = explode('Kategorie:',trim($val));
						$val = trim($val[1]);
						foreach (explode(',',$val) as $value) {
							$cat = '';
							$value = trim($value);
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
							$stri = explode('-', trim($str[1]));	
														
							$producerName = trim($stri[0]);	
							if(isset($stri[1])) 
								$producerNumber = trim($stri[1]);
									
						continue;
					}
	
					//Alles weiter als Feature
					array_push($features, trim($value));
	
				}
				
				$tempFeatures = '';
				foreach($features as $entry) {
					if((strpos($entry, 'Maße: gemäß') !== FALSE) ) {} else {
						//Formatierung übertragen
						if((strpos($entry, '+') !== FALSE) ) {$entry = '<u>'.str_ireplace('+', '', $entry).'</u>';}
						if((strpos($entry, '*') !== FALSE) ) {$entry = '<b>'.str_ireplace('*', '', $entry).'</b>';}
						
						$tempFeatures = $tempFeatures.'<li>'.$entry.'</li>'.PHP_EOL;
					}
					
				}
				$features = $tempFeatures;
	
				if($multi) {
									
					foreach($number as $i=>$product) {
						
							$newProduct['Product']['product_number'] = $number[$i];
							$newProduct['Product']['name'] = $name;
							
							$newProduct['Product']['producer_name'] = $producerName;
							$newProduct['Product']['producer_number'] = $producerNumber;
		
					 		$newProduct['Product']['material_id'] = $bezug['Material']['id'];
							$newProduct['Product']['core_name'] = $core_name;
							$newProduct['Product']['cores'] = $cores_arr;
							$newProduct['Product']['reference'] = $referenz;							
							$newProduct['Product']['company'] = $company;
					 		$newProduct['Product']['featurelist'] = $features;
							$newProduct['Product']['size'] = $maße[$i];
							$p = str_replace(',', '.', str_replace(' €', '', $ek));
							$newProduct['Product']['price'] = $p[$i];
							$r = str_replace(',', '.', str_replace(' €', '', $vk));
							$newProduct['Product']['retail_price'] = $r[$i];
							$newProduct['Product']['active'] = 'checked';
							$newProduct['Product']['new'] = '';
							
							if (strpos($number, 'Z') !== FALSE || strcmp($company, 'Fa. padcon') < 0) {
								$newProduct['Product']['custom'] = 'checked';
							} else {
								$newProduct['Product']['custom'] = '';
							}
							$newProduct['Product']['categories'] = $categories;
							
							array_push($newProducts, $newProduct);
						
					}
				} else {
					
					
					if(empty($categories)) {
						
						$errors['prod-cat'] = array();
						$error = "Produkt <b>".$number."</b> hat keine Kategorien. Bitte prüfen!";
						 array_push($errors['prod-cat'], $error);
					}
										
						$newProduct['Product']['product_number'] = $number;
						$newProduct['Product']['name'] = $name;
		
						$newProduct['Product']['producer_name'] = $producerName;
						$newProduct['Product']['producer_number'] = $producerNumber;
		
						if(!empty($bezug) && $bezug != '') {
					 		$newProduct['Product']['material_id'] = $bezug['Material']['id'];
					 	} else {
					 		$newProduct['Product']['material_id'] = 0;
					 	}
						$newProduct['Product']['reference'] = $referenz;
						$newProduct['Product']['company'] = $company;
						$newProduct['Product']['core_name'] = $core_name;
						$newProduct['Product']['cores'] = $cores_arr;
					 	$newProduct['Product']['featurelist'] = $features;
						$newProduct['Product']['size'] = $maße;
						$newProduct['Product']['price'] = str_replace(',', '.', str_replace(' €', '', $ek));
						$newProduct['Product']['retail_price'] = str_replace(',', '.', str_replace(' €', '', $vk));
						$newProduct['Product']['active'] = 'checked';
						$newProduct['Product']['new'] = '';	
										
						if (strpos($number, 'Z') !== FALSE || strcmp($company, 'Fa. padcon') < 0) {
							$newProduct['Product']['custom'] = 'checked';
						} else {
							$newProduct['Product']['custom'] = '';
						}
						$newProduct['Product']['categories'] = $categories;
						
						array_push($newProducts, $newProduct);
					
				}

				$this->request->data['Products'] = $newProducts;
				}					
			} else {				
				if(isset($this->data['Product']['product_number']) || isset($this->data[0]['Product']['product_number'])) {			
					$data = $this->data;
					$errors = array();
					
					
					foreach($data as $i=>$prod) {
						$errors['prod'.$i] = array();
											
						$prod['retail_price'] = str_replace(',', '.', $prod['retail_price']);
						$prod['price'] = str_replace(',', '.', $prod['price']);														
												
						$this->Product->create();
						if ($this->Product->save($prod)) {
	
							$currId = $this->Product->getLastInsertId();
								
							//Kerne abspeichern
							$this->ProductCore->create();
							$prodCore = array();
							foreach ($prod['cores'] as $i => $core) {
								$prodCore[$i]['ProductCore']['product_id'] = $currId;
								$prodCore[$i]['ProductCore']['core_id'] = $core;
							}					
	
							//Kategorien abspeichern
							$this->ProductCategory->create();
							$prodCat = array();
							foreach ($prod['categories'] as $i => $category) {
								$prodCat[$i]['ProductCategory']['product_id'] = $currId;
								$prodCat[$i]['ProductCategory']['category_id'] = $category;
							}						
							if ($this->ProductCore->saveAll($prodCore) && $this->ProductCategory->saveAll($prodCat)) {
								$this->Session->setFlash(__('Produkt wurde angelegt!', true));
							} 
							
						} else {
							
							 // $cat = $this->Category->findById($prod['Product']['category_id']);	
	// 
							 // $error = "Produkt <b>".$prod['Product']['product_number']."</b> in Kategorie <b>".$cat['Category']['name']."</b> ist bereits vorhanden. Bitte prüfen!";
							 // array_push($errors['prod'.$i], $error);					
							 
							 $errors = $this->Product->invalidFields();
							 $this->set(compact("errors"));
						}			 
					}
				} else {
					$errors['prod3'][0] = "Die Beschreibung muss gefüllt sein!";
					 $this->set(compact("errors"));	
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
		$cores = $this->Core->find('list');
		$this->set(compact('categories', 'materials', 'carts', 'cores'));
		$this->set('primary_button', 'Anlegen');
		$this->set('title_for_panel', 'Produkt anlegen');
		//$this->render('/Elements/backend/portlets/Product/productDetailPortlet');
		
		// $this->request->data['Categories'] = $categories;
		// $this->request->data['Materials'] = $materials;
		// $this->request->data['Carts'] = $carts;
		
	}
	
	function admin_loadProductAddPopup($id = null, $cart_id = null, $controller_id = null, $controller_name = null) {
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
	
	function admin_edit($id = null) {
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$data = $this->data;
		//unset($data['Product']['product_number']);
		if (!empty($data)) {
			
			$product = $this->getProduct($id);
			
			//Preis von Komma auf Punkt konvertieren
			$Carts = new CartsController();
			$data['Product']['price'] = $Carts->convertPriceToSql($data['Product']['price']);
			$data['Product']['retail_price'] = $Carts->convertPriceToSql($data['Product']['retail_price']);
			
			//Kerne Updaten
			$cores = $this->ProductCore->findAllByProductId($id);

			if(count($data['Product']['cores']) <= count($cores)) {
				//Wenn alte Kerne mehr 
				foreach ($cores as $i => $value) {
					if($i < count($data['Product']['cores'])) {
						$tmpProdCore['ProductCore']['core_id'] = $data['Product']['cores'][$i];
						$this->ProductCore->id = $value['ProductCore']['id'];
						$this->ProductCore->save($tmpProdCore);
					} else {
						$this->ProductCore->delete($value['ProductCore']['id']);
					}
				}
			} else {
			//Wenn neue Kerne mehr 
				foreach ($data['Product']['cores'] as $i => $value) {
					if($i < count($cores)) {
						$coresTmp = $this->ProductCore->findAllByProductId($id);
						$tmpProdCore['ProductCore']['core_id'] = $data['Product']['cores'][$i];
						$this->ProductCore->id = $coresTmp[$i]['ProductCore']['id'];
						$this->ProductCore->save($tmpProdCore);
					} else {
						$tmpProdCore['ProductCore']['product_id'] = $data['Product']['id'];
						$tmpProdCore['ProductCore']['core_id'] = $data['Product']['cores'][$i];
						$this->ProductCore->create();
						$this->ProductCore->save($tmpProdCore);
					}
				}
			}		
			
			//Kategorien Updaten
			$cats = $this->ProductCategory->findAllByProductId($id);
			
			

			if(count($data['Product']['categories']) <= count($cats)) {
				//Wenn alte Cats mehr 
				foreach ($cats as $i => $value) {
					if($i < count($data['Product']['categories'])) {
						$tmpProdCat['ProductCore']['category_id'] = $data['Product']['categories'][$i];
						$this->ProductCategory->id = $value['ProductCategory']['id'];
						$this->ProductCategory->save($tmpProdCat);
					} else {
						$this->ProductCategory->delete($value['ProductCategory']['id']);
					}
				}
			} else {
			//Wenn neue Cats mehr 
				foreach ($data['Product']['categories'] as $i => $value) {
					if($i < count($cats)) {
						$catsTmp = $this->ProductCategory->findAllByProductId($id);
						$tmpProdCat['ProductCategory']['category_id'] = $data['Product']['categories'][$i];
						$this->ProductCategory->id = $catsTmp[$i]['ProductCategory']['id'];
						$this->ProductCategory->save($tmpProdCat);
					} else {
						$tmpProdCat['ProductCategory']['product_id'] = $data['Product']['id'];
						$tmpProdCat['ProductCategory']['category_id'] = $data['Product']['categories'][$i];
						$this->ProductCategory->create();
						$this->ProductCategory->save($tmpProdCat);
					}
				}
			}			
			
			if ($this->Product->save($data)) {
				$this->Session->setFlash(__('Das Produkt wurde gespeichert', true));
				
			} else {
				$this->Session->setFlash(__('Das Produkt konnte nicht gespeichert werden. Bitte prüfen Sie die Meldungen.', true));
			}
			
		}
		if (empty($this->data)) {
			$data = $this->getProduct($id);
			$data['Product']['featurelist'] = $this->getListElement($data['Product']['featurelist'], FALSE);
			$colors = $this->Color->find('list',array('conditions' => array('Color.material_id' => ($this->data['Material']['id'])), 'fields' => array('Color.name')));	
			$this->data = $data;
		}
		$categories = $this->Product->Category->find('list');
		$materials = $this->Product->Material->find('list');
		$cores = $this->Core->find('list');
		
		$carts = $this->Product->Cart->find('list');
		$this->set(compact('categories', 'materials', 'carts', 'colors', 'cores'));
		$this->layout = 'admin';
		$this->set('title_for_panel', 'Produkt bearbeiten');
		$this->set('primary_button', 'Speichern');
	}

	function admin_edit_external($id = null) {
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$data = $this->data;
		//unset($data['Product']['product_number']);
		if (!empty($data)) {
			
			$product = $this->getProduct($id);
			
			//Preis von Komma auf Punkt konvertieren
			$Carts = new CartsController();
			$data['Product']['price'] = $Carts->convertPriceToSql($data['Product']['price']);
			$data['Product']['retail_price'] = $Carts->convertPriceToSql($data['Product']['retail_price']);
						
			if ($this->Product->save($data)) {
				$this->Session->setFlash(__('Das Produkt wurde gespeichert', true));
				
			} else {
				$this->Session->setFlash(__('Das Produkt konnte nicht gespeichert werden. Bitte prüfen Sie die Meldungen.', true));
			}
			
		}
		
		$data = $this->getProduct($id);
		$data['Product']['featurelist'] = $this->getListElement($data['Product']['featurelist'], FALSE);
		
		$this->set(compact('data'));


		$this->layout = 'admin';
		$this->set('title_for_panel', 'Fremdprodukt bearbeiten');
		$this->set('primary_button', 'Speichern');
		
		$this->render('admin_external');
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
	
	function admin_search($ajax = null, $cart_id = null, $c_id = null, $c_name = null) {
		
		$products = $this->Product->find('all',array('conditions' => array("OR" => 
			array (	'Product.name LIKE' 			=> '%'.$this->data['str'].'%' ,
					'Product.product_number LIKE' 	=> '%'.$this->data['str'].'%' ,
					'Material.name LIKE' 	=> '%'.$this->data['str'].'%', 
					'Category.name LIKE' 	=> '%'.$this->data['str'].'%')), 'group' =>  array('Product.product_number')));	
		
		$this->set('products', $products);
		$this->set('ajax', $ajax);
		$this->set('cart_id', $cart_id);
		$this->set('controller_id', $c_id);
		$this->set('controller_name', $c_name);
		
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
	
	function getListElement($input, $mode) {
	
		$list = '';
	
		// WEnn True, dann Li hinzufüge, ansonsten entfernen
		if($mode) {
			$input = explode(PHP_EOL, $input);
			$list = '';
			foreach ($input as $key => $value) {
				$list =$list.'<li>'.$value.'</li>'.PHP_EOL;
			}
		} else {
			$list = str_replace('<li>', '', $input);
			$list = str_replace('</li>', '', $list);
		}

		return $list;
		
	}
	
	function admin_fillCustomerProductPrice() {
		
		$cartProds = $this->CartProduct->find('all');
		
		foreach ($cartProds as $key => $value) {

			$prod = $this->Product->findById($value['CartProduct']['product_id']);
			
			$cartProd['CartProduct']['id'] = $value['CartProduct']['id'];
			$cartProd['CartProduct']['price'] = $prod['Product']['price'];
			$cartProd['CartProduct']['retail_price'] = $prod['Product']['retail_price'];
			
			$this->CartProduct->save($cartProd);

		}
		
		$this->redirect(array('controller' =>'Pages', 'action' => 'setting'));
	}
		
}
