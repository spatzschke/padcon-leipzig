<?php
//Import controller
  App::import('Controller', 'SiteContents');


class CatalogsController extends AppController {

	var $name = 'Catalogs';
	
	var $components = array('RequestHandler', 'Auth', 'Session');
	
	public $uses = array('Catalog', 'Category', 'Product', 'Material', 'Color', 'SiteContent');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->allow('overview', 'view');
			
		}
	}

	function index() {
		$this->Catalog->recursive = 0;
		$this->set('catalogs', $this->paginate());
	}
	
	function overview() {
		$catalogs = $this->Catalog->find('all',array('conditions' => 'Catalog.active = 1'));
		$this->set('catalogs', $catalogs);
		$this->set('title_for_layout','Katalogübersicht');
	}

	function view($id = null) {
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid catalog', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('catalog', $this->Catalog->read(null, $id));
		$this->layout = 'catalog-iframe';
	}

	function add() {
		if (!empty($this->data)) {
			$this->Catalog->create();
			if ($this->Catalog->save($this->data)) {
				$this->Session->setFlash(__('The catalog has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The catalog could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Catalog->Category->find('list');
		$this->set(compact('categories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid catalog', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Catalog->save($this->data)) {
				$this->Session->setFlash(__('The catalog has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The catalog could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Catalog->read(null, $id);
		}
		$categories = $this->Catalog->Category->find('list');
		$this->set(compact('categories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for catalog', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Catalog->delete($id)) {
			$this->Session->setFlash(__('Catalog deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Catalog was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function admin_generate($id = null) {
		$this->layout = 'admin';
		$this->set('title_for_panel', 'Katalog generieren');
		
		if(isset($this->request->data['Categories'])) {
				$id = $this->request->data['Categories']['id'];
		}
		
		if($id) {
			
			if(isset($this->request->data['Categories']['price'])) {
				$price = $this->request->data['Categories']['price'];
			} else {
				$price = 0;
			}
			
					
			if($id != '99') {
				$this->request->data['Catalogs'] = $this->Catalog->find('all', array('conditions' => array('Catalog.category_id' => $id)));
				$this->request->data['Catalogs'][0]['Catalog']['count'] = $this->Product->find('count', array('conditions' => array('Product.category_id' => $id)));
				
				$this->Product->unbindModel(array('hasAndBelongsToMany' => array('Cart')));			
				$this->request->data['Catalogs'][0]['Products'] = $this->Product->find('all', array(
					'conditions' => array(
						'Product.category_id' => $this->request->data['Catalogs'][0]['Category']['id'],
						'Product.custom' => 0,
						'Product.active' => 1
					),
					'fields' => array('Product.*', 'Size.*', 'Material.*'), 
					'order' => array('Product.product_number' => 'ASC')));					
			} else {
				$catalogs = $this->Catalog->find('all');
					
				$data = array();
				
				foreach ($catalogs as $catalog) {
					$catalog['Catalog']['count'] = $this->Product->find('count', array('conditions' => array('Product.category_id' => $catalog['Category']['id'])));
					
					$this->Product->unbindModel(array('hasAndBelongsToMany' => array('Cart')));
					$this->Product->unbindModel(array('hasMany' => array('Image')));
						
					$catalog['Products'] = $this->Product->find('all', array(
						'conditions' => array('Product.category_id' => $catalog['Category']['id']),
						'fields' => array(
							'Product.*', 
							'Size.*', 
							'Material.*'
						), 
						'order' => array('Product.product_number' => 'ASC')));			
					
					array_push($data, $catalog);				
				}

				$this->request->data['Catalogs'] = $data;

			}		
			
			
			$Sites = new SiteContentsController;
			
			$content = array('infromation');
			$contentArr = array('information', 'lagerung', 'color', 'agb', 'material', 'waschanleitung');
			$fields = array('headline', 'content_paragraph');
			
			foreach ($contentArr as $c) {
				
				foreach ($fields as $f) {
					if($c == "agb") {
						$content[$c][$f] = $Sites->loadCatalogInformation('Pages', 'display', $c,$f);
					} else {
						$content[$c][$f] = $Sites->loadCatalogInformation('Catalog', 'sonderseite', $c,$f);
					}
					
				}
				
			}
			$this->request->data['SiteContent'] = $content;
			$this->request->data['Categories'] = $this->Catalog->Category->find('list');
			
			$material = $this->Material->find('all', array('fields' => 'Material.name'));
			$materials = array();
			foreach ($material as $m) {
				unset($m['Product']);
				array_push($materials, $m);
			}
			
			$this->request->data['Material'] = $materials;
			$this->request->data['Price'] = $price;
			
			$this->set('catalog_id', $id);
			
		} else {
			$this->request->data['Categories'] = $this->Catalog->Category->find('list');
			$this->request->data['Categories'][99] = 'Gesamt';

			ksort($this->request->data['Categories']);
			$this->request->data['Catalogs'] = array();
		}
	}

	function admin_generate_pl($id = null, $layout ='admin') {

		$this->admin_generate($id);
		$this->layout = $layout;
		$this->set('title_for_panel', 'Preisliste generieren');
		$this->render('admin_generate_pl'); 
	}

	function admin_createPdf($id = null, $priceFlag = 0){

		$this->layout = 'pdf';
		if($id != 99) {
			$this->request->data['Catalogs'][0] = $this->Catalog->find('first', array('conditions' => array('Catalog.category_id' => $id)));
			$this->request->data['Catalogs'][0]['Catalog']['count'] = $this->Product->find('count', array('conditions' => array('Product.category_id' => $id)));
			$this->request->data['Catalogs'][0]['Products'] = $this->Product->find('all', array(
					'conditions' => array(
						'Product.category_id' => $this->request->data['Catalogs'][0]['Category']['id'],
						'Product.custom' => 0,
						'Product.active' => 1
					),
					'fields' => array('Product.*', 'Size.*', 'Material.*'), 
					'order' => array('Product.product_number' => 'ASC')));
				
			$title = $this->data['Catalogs'][0]['Catalog']['name'].'-Katalog-'.date('y');
		} else {
			$title = 'Gesamt-Katalog-'.date('y');
		}
		
		
		$Sites = new SiteContentsController;
		
		$content = array('infromation');
		$contentArr = array('information', 'lagerung', 'color', 'agb', 'material', 'waschanleitung');
		$fields = array('headline', 'content_paragraph');
		
		foreach ($contentArr as $c) {
			
			foreach ($fields as $f) {
				if($c == "agb") {
					$content[$c][$f] = $Sites->loadCatalogInformation('Pages', 'display', $c,$f);
				} else {
					$content[$c][$f] = $Sites->loadCatalogInformation('Catalog', 'sonderseite', $c,$f);
				}
				
			}
			
		}
		$this->request->data['SiteContent'] = $content;
		$this->request->data['Categories'] = $this->Catalog->Category->find('list');
		$this->request->data['Material'] = $this->Material->find('all');
		
		$this->request->data['Price'] = $priceFlag;
		
		
		$title = $this->data['Catalogs'][0]['Catalog']['name'].'-Katalog-'.date('y');
		
		$this->set('title_for_layout', $title);
      	$this->render('admin_generate'); 
	    
	}

	function admin_createPdf_pl($id = null){
	
		$catalog = $this->Catalog->find('first', array('conditions' => array('Catalog.category_id' => $id)));
		$name = "";
		if(!empty($catalog['Catalog'])) {
			$name = $catalog['Catalog']['name'];
		} else {
			$name = "Gesamt";
		}
		
		$title = 'Preisliste-'.$name.'-'.date('m/Y');
		$this->set('title_for_layout', $title);

		$this->admin_generate_pl($id, 'pdf');
		
	    
	}

}
