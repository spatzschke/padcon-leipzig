<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
 	public $uses = array('Offer', 'Product', 'CartProduct', 'Cart', 'CustomerAddress', 'Customer', 'Address', 'Color', 'Confirmation', 'AddressAddresstype', 'Billing', 'Process');
	
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			
			
			switch(Inflector::humanize($path[$count - 1])) {
			
				case 'About Us': $title_for_layout = 'Über uns';
								 break;
							
				case 'Agb': $title_for_layout = 'Allgemeine Geschäftsbedingungen';
								 break;
						
				case 'Imprint': $title_for_layout = 'Impressum';
								 break;
								 
				default: $title_for_layout = Inflector::humanize($path[$count - 1]);
						 break;
				
			}
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
	
	function admin_dashboard() {
		$this->layout = 'admin';
		
		$this->monthUmsatz();
	
	}
	
	function admin_setting() {
		$this->layout = 'admin';
	
	} 
	
	private function monthUmsatz() {
		$billings = $this->Billing->find('all', array('conditions' => array('Billing.created BETWEEN ? AND ?' => array(date('Y-m-01 00:00:00'), date('Y-m-d 00:00:00', strtotime("+1 days"))))));
		$einnahme = 0;
		$ausgabe =  0;
		foreach ($billings as $key => $value) {
			$proc = $this->Process->findByBillingId($value['Billing']['id']);
			$einnahme += $value['Billing']['billing_price'];
			if(isset($proc['Confirmation']))
				$ausgabe += $proc['Confirmation']['cost'];
		}
		$diff = $einnahme - $ausgabe;
		
		$this->set(compact('diff','einnahme','ausgabe'));
	}  

}

