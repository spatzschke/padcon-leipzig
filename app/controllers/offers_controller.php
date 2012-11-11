<?php
class OffersController extends AppController {

	var $name = 'Offers';
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'Customer');
	public $components = array('Auth', 'Session');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
			
		}
	}

	function admin_index() {
		$this->layout = 'admin';
	
		$this->Offer->recursive = 0;
		$this->set('offers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('offer', $this->Offer->read(null, $id));
	}

	function admin_add($isActive = null) {
		$this->layout = 'admin';
		
		$active = null;
		
		if(!$isActive) {
			$active = $this->Offer->find('first', array('conditions' => array('Offer.status' => 'active')));
		} 

		
		$offer = null;
		if($active || $isActive) {
			
			$this->set(compact('offer', 'active'));
			
		} else {
		
			$cart = $this->requestAction('/admin/carts/add/');
			$this->Offer->create();
			
			$offer['Offer']['status'] = 'active';
			$offer['Offer']['agent'] = 'Ralf Patzschke';
			$offer['Offer']['customer_id'] = '';
			$offer['Offer']['cart_id'] = $cart['Cart']['id'];
			
			
			$this->Offer->save($offer);
	
			$offer = $this->Offer->findById($this->Offer->id);
			$this->data = $offer;
			$this->set(compact('offer', 'active'));
			
		}
		
		$this->render('admin_add');
		
		
	}
	
	function admin_active() {
	
		$this->layout = 'admin';
		
		$this->viewActiveOffer();		
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid offer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Offer->save($this->data)) {
				$this->Session->setFlash(__('The offer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Offer->read(null, $id);
		}
		$carts = $this->Offer->Cart->find('list');
		$users = $this->Offer->User->find('list');
		$this->set(compact('carts', 'users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for offer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Offer->delete($id)) {
			$this->Session->setFlash(__('Offer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Offer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	/*
	
		GETTR & SETTER
	
	*/
	
	function getActiveOffer() {
		
		return $this->Offer->find('first', array('conditions' => array('Offer.status' => 'active')));
		
	}
	
	function updateOffer($id = null, $offer = null) {
		
		if(!$offer) {
			$offer = $this->getActiveOffer();
			$offer = $offer['Offer']['id'];
		}
		
		$offer = $this->Offer->findById($offer);
		
		if($offer) {
			$offer['Offer']['offer_number'] = $this->generateOfferNumber($id, $offer);
			$offer['Offer']['customer_id'] = $id;
			
			
			if($this->Offer->save($offer)){
				$offer['Offer']['stat'] = 'saved';
			} else {
				$offer['Offer']['stat'] = 'not saved';
			}
		} else {
			$offer['Offer']['stat'] = 'error';
		}
		
				
		
		echo json_encode($offer['Offer']);
		$this->autoRender = false;
		
	}
	
	function archiveActiveOffer(){
		
	    $this->Offer->updateAll(
		    array('Offer.status' => "'open'"),
		    array('Offer.status' => "active")
	    );
		
		$this->admin_add();
		

	}
	
	function viewActiveOffer(){
		
	    $this->data = $this->getActiveOffer();
	    $this->set('offer', $this->data);
		
		$this->admin_add(true);
	}
	
	function generateOfferNumber($customerId = null, $offer = null) {
	
		// Anzahl aller Angebote im Jahr / Anzahl aller Angebote im Monat_Aktueller Monat_Anzahl aller Angebote des Kunden	
		
		$countYearOffers = count($this->Offer->find('all',array('conditions' => array('Offer.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d'))))));
		$countMonthOffers = count($this->Offer->find('all',array('conditions' => array('Offer.created BETWEEN ? AND ?' => array(date('Y-m-01'), date('Y-m-d'))))));
		$countCustomerOffers = count($this->Offer->find('all',array('conditions' => array('Offer.customer_id' => $customerId), 'Offer.created BETWEEN ? AND ?' => array(date('Y-01-01'), date('Y-m-d')))))+1;
		
		
		return str_pad($countYearOffers, 3, "0", STR_PAD_LEFT).'/'.str_pad($countMonthOffers, 2, "0", STR_PAD_LEFT).date('m', strtotime($offer['Offer']['created'])).str_pad($countCustomerOffers, 2, "0", STR_PAD_LEFT);
	}
}
