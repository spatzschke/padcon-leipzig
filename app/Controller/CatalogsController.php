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
		$id = $this->request->data['Categories']['id'];
		
		if($id) {
					
			$this->request->data = $this->Catalog->find('first', array('conditions' => array('Catalog.category_id' => $id)));
			$this->request->data['Catalog']['count'] = $this->Product->find('count', array('conditions' => array('Product.category_id' => $id)));
			$this->request->data['Catalog']['Products'] = $this->Product->find('all', array('conditions' => array('Product.category_id' => $id),
			'fields' => array('Product.*', 'Size.*', 'Material.*')));
			
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
			
		} else {
			$this->request->data['Categories'] = $this->Catalog->Category->find('list');
			$this->request->data['Catalog'] = array();
		}
	}

	function admin_createPdf($id = null){

		$this->layout = 'pdf';
		
		$this->request->data = $this->Catalog->find('first', array('conditions' => array('Catalog.category_id' => $id)));
		$this->request->data['Catalog']['count'] = $this->Product->find('count', array('conditions' => array('Product.category_id' => $id)));
		$this->request->data['Catalog']['Products'] = $this->Product->find('all', array('conditions' => array('Product.category_id' => $id),
		'fields' => array('Product.*', 'Size.*', 'Material.*')));
		
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
		
		
		$title = $this->data['Catalog']['name'].'-Katalog-'.date('y');
		
		$this->set('title_for_layout', $title);
      	$this->render('admin_generate'); 
	    
	}

}
