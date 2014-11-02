<?php
App::import('Controller', 'Offers');
App::import('Controller', 'Carts');

App::uses('AppController', 'Controller');
/**
 * Billings Controller
 *
 * @property Billing $Billing
 * @property PaginatorComponent $Paginator
 */
class BillingsController extends AppController {

	
	public $uses = array('Billing', 'Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color');
	
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Billing->recursive = 0;
		$this->set('billings', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
	public function admin_view($id = null) {
		
		$this->layout = "admin";
		
		if (!$this->Billing->exists($id)) {
			throw new NotFoundException(__('Invalid billing'));
		}
		$options = array('conditions' => array('Billing.' . $this->Billing->primaryKey => $id));
		$billing = $this->Billing->find('first', $options);
		
		$offer = $this->Offer->find('first', array('conditions' => array('Offer.billing_id' => $billing['Billing']['id'])));
		
		$Offers = new OffersController();
		$cart = $this->Cart->find('first', array('conditions' => array('Cart.' . $this->Billing->primaryKey => $offer['Offer']['cart_id'])));
		
		$offer['Cart']['CartProduct'] = $cart['CartProduct'];
		
		if(!is_null($offer['Customer']['id'])) {
			$split_str = $Offers->splitAddressData($offer);
			if(!is_null($split_str)) {	
				$offer['Customer'] = $offer['Customer'] + array();
				$offer['Customer'] += $split_str;
			}
		}
		
		$this->request->data = $billing;
		$this->request->data += $offer;
		
		$this->set('pdf', null);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($offer_id = null) {
		$this->layout = "admin";
		
		$active = null;
		$this->set('pdf', null);

		$this->Billing->create();
		
		$billing['Billing']['status'] = 'open';
		$billing['Billing']['offer_id'] = $offer_id;
		
		//Gernerate Billing-number
		$billing['Billing']['billing_number'] = $this->Billing->find('count', array('Billing.created' => 'like "'.date('Y').'"')).'/'.date('y');
		
		if(is_null($offer['Offer']['billing_id'])) {
			if ($this->Billing->save($billing)) {	
				$offerUpdate['Offer']['id'] = $offer_id;
				$offerUpdate['Offer']['billing_id'] = $this->Billing->getLastInsertId();
				
				$this->Offer->save($offerUpdate);
							
				$lastBillingId = $this->Billing->getLastInsertId();
				$this->request->data = $this->Billing->findById($lastBillingId);
				$this->redirect(array('action' => 'view', $lastBillingId));
			} else {
				$this->Session->setFlash(__('Es kam zu einem Fehler bei der Erstellung einer Rechnung. Bitte versuchen Sie es erneut.'));
			}
		} else {
			$this->Session->setFlash(__('Es ist bereits eine Rechnung vorhanden'));
			$this->redirect(array('controller' => 'Offers', 'action' => 'index'));
		}
		
		$this->autoRender = false;
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Billing->exists($id)) {
			throw new NotFoundException(__('Invalid billing'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Billing->save($this->request->data)) {
				$this->Session->setFlash(__('The billing has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The billing could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Billing.' . $this->Billing->primaryKey => $id));
			$this->request->data = $this->Billing->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Billing->id = $id;
		if (!$this->Billing->exists()) {
			throw new NotFoundException(__('Invalid billing'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Billing->delete()) {
			$this->Session->setFlash(__('The billing has been deleted.'));
		} else {
			$this->Session->setFlash(__('The billing could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
