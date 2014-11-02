<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Addresses');
App::import('Controller', 'Carts ');
/**
 * Confirmations Controller
 *
 * @property Confirmation $Confirmation
 * @property PaginatorComponent $Paginator
 */
class ConfirmationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation');
	public $components = array('Auth', 'Session', 'Paginator');
	
	public function beforeFilter() {
		if(isset($this->Auth)) {
			$this->Auth->deny('*');
			
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Confirmation->recursive = 0;
		$this->set('confirmations', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Confirmation->exists($id)) {
			throw new NotFoundException(__('Invalid confirmation'));
		}
		$options = array('conditions' => array('Confirmation.' . $this->Confirmation->primaryKey => $id));
		$this->set('confirmation', $this->Confirmation->find('first', $options));
	}


/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Confirmation->exists($id)) {
			throw new NotFoundException(__('Invalid confirmation'));
		}
		$options = array('conditions' => array('Confirmation.' . $this->Confirmation->primaryKey => $id));
		$this->set('confirmation', $this->Confirmation->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Confirmation->create();
			if ($this->Confirmation->save($this->request->data)) {
				$this->Session->setFlash(__('The confirmation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The confirmation could not be saved. Please, try again.'));
			}
		}

		
		$this->set('pdf', null);
		
		$offer = null;	
		
		$this->Confirmation->create();
		
		$confirmation['Confirmation']['status'] = 'active';
		$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
		$confirmation['Confirmation']['customer_id'] = '';
		$confirmation['Confirmation']['cart_id'] = $cart['Cart']['id'];
		
		$this->Confirmation->save($confirmation);

		$this->generateData($this->Confirmation->findById($this->Confirmation->id));
		
		$this->set(compact('confirmation'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Confirmation->exists($id)) {
			throw new NotFoundException(__('Invalid confirmation'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Confirmation->save($this->request->data)) {
				$this->Session->setFlash(__('The confirmation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The confirmation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Confirmation.' . $this->Confirmation->primaryKey => $id));
			$this->request->data = $this->Confirmation->find('first', $options);
		}
		$customers = $this->Confirmation->Customer->find('list');
		$billings = $this->Confirmation->Billing->find('list');
		$deliveries = $this->Confirmation->Delivery->find('list');
		$this->set(compact('customers', 'billings', 'deliveries'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Confirmation->id = $id;
		if (!$this->Confirmation->exists()) {
			throw new NotFoundException(__('Invalid confirmation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Confirmation->delete()) {
			$this->Session->setFlash(__('The confirmation has been deleted.'));
		} else {
			$this->Session->setFlash(__('The confirmation could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_convertOffer($offer_id = null) {
		
		$offer = $this->Offer->findById($offer_id);
		$this->Confirmation->create();
		
		$confirmation['Confirmation']['status'] = 'active';
		$confirmation['Confirmation']['agent'] = 'Ralf Patzschke';
		$confirmation['Confirmation']['customer_id'] = $offer['Offer']['customer_id'];
		$confirmation['Confirmation']['offer_id'] = $offer['Offer']['id'];
		$confirmation['Confirmation']['discount'] = $offer['Offer']['discount'];
		$confirmation['Confirmation']['delivery_cost'] = $offer['Offer']['delivery_cost'];
		$confirmation['Confirmation']['vat'] = $offer['Offer']['vat'];
		$confirmation['Confirmation']['price'] = $offer['Offer']['offer_price'];
		
		//Warenkorb des Angebots kopieren
		$offerCart = $this->Cart->findById($offer['Cart']['id']);
		$offerCart['Cart']['id'] = NULL;
		$this->Cart->save($offerCart);
				
		$lastCartId = $this->Cart->getLastInsertId();
		$confirmation['Confirmation']['cart_id'] = $lastCartId;
		
		$cartProducts = $this->CartProduct->find('all',array('conditions' => array('CartProduct.cart_id' => $offer['Cart']['id'])));
		foreach ($cartProducts as $cartProduct) {
			$this->CartProduct->create();
			$cartItem['CartProduct'] = $cartProduct['CartProduct'];
			$cartItem['CartProduct']['cart_id'] = $lastCartId;
			unset($cartItem['CartProduct']['created']);
			unset($cartItem['CartProduct']['id']);
			unset($cartItem['CartProduct']['modified']);			
			$this->CartProduct->save($cartItem);
		}
		
		$this->Confirmation->save($confirmation);
		
		 $this->generateData($this->Confirmation->findById($this->Confirmation->getLastInsertId()));

		
		$this->set('pdf', null);
		
		$this->render('admin_add');
		
	}


	function generateData($confirmation = null) {
	
		$Addresses = new AddressesController();	
		$Carts = new CartsController();
	
		if(!$confirmation) {
			$confirmation_id = $this->Confirmation->getLastInsertId();
			$confirmation = $this->Confirmation->findById($confirmation_id);		
		} 
			
	    $this->request->data = $confirmation;
		
		if(!empty($confirmation)) {
			
	    	$cart = $Carts->get_cart_by_id($confirmation['Cart']['id']);
			$this->request->data['Cart']['CartProduct'] = $cart['CartProduct'];
		}
	
		if(!is_null($this->request->data['Customer']['id'])) {
			$split_str = $Addresses->splitAddressData($confirmation);
			if(!is_null($split_str)) {	
				$this->request->data['Customer'] = $this->request->data['Customer'] + array();
				$this->request->data['Customer'] += $split_str;
			}
		}
		
		$this->request->data = $Addresses->getAddressByType($this->request->data, 2);
		$this->request->data['Confirmation'] += $this->calcPrice($this->request->data);
		return $this->calcPrice($this->request->data);

	}

	function calcPrice($data = null) {
		
		$arr_data = null;
		
		$discount_price = $data['Confirmation']['discount'] * $data['Cart']['sum_retail_price'] / 100;
		$part_price = $data['Cart']['sum_retail_price'] - $discount_price + $data['Confirmation']['delivery_cost'];
		$vat_price = $data['Confirmation']['vat'] * $part_price / 100;
		$data_price = floatval($part_price + $vat_price);
		
		if($data['Cart']['sum_retail_price'] > 500) {
			$delivery_cost = 0;
		} else {
			$delivery_cost = 8;
		}
		
		$arr_data['Confirmation']['delivery_cost'] = $delivery_cost;
		$arr_data['Confirmation']['vat_price'] = $vat_price;
		$arr_data['Confirmation']['discount_price'] = $discount_price;
		$arr_data['Confirmation']['part_price'] = $part_price;
		
		if($data['Cart']['sum_retail_price'] == 0) {
			$arr_data['Confirmation']['price'] = 0;
		} else {
			$arr_data['Confirmation']['price'] = $data_price;
		}
		
		
		$arr_data['Confirmation']['id'] = $data['Confirmation']['id'];

		$this->Offer->save($arr_data['Confirmation']);
				
		return $arr_data['Confirmation'];
	}
}
