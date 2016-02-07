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
		
		$this->umsatz();
		$this->platzierungKunde();
		$this->platzierungProdukt();
	
	}
	
	function admin_setting() {
		$this->layout = 'admin';
	
	} 
	
	private function platzierungProdukt() {
		$topProduct = $this->Billing->query('
			SELECT count(CP.product_id) AS ANZAHL, PO.name AS NAME, PO.product_number AS NUMBER
			FROM billings RE 
			INNER JOIN processes PR 
			ON RE.id = PR.billing_id 
			INNER JOIN carts CA
			ON PR.cart_id = CA.id
			INNER JOIN cart_products CP
			ON CA.id = CP.cart_id
			INNER JOIN products PO
			ON CP.product_id = PO.id
			WHERE RE.status = ? AND RE.created BETWEEN ? AND ?
			GROUP BY CP.product_id
			ORDER BY ANZAHL DESC, RE.created ASC
			LIMIT 5', array('close', date('Y-01-01 00:00:00'), date('Y-12-23 23:59:59')));
						
		$this->set(compact('topProduct'));

	}  
	
	private function platzierungKunde() {
		$topCustomer = $this->Billing->query('
			SELECT PR.customer_id AS KUNDENNUMMER, sum(RE.billing_price) AS SUMME, CU.organisation AS KUNDENNAME
			FROM billings RE 
			INNER JOIN processes PR 
			ON RE.id = PR.billing_id 
			INNER JOIN customers CU
			ON PR.customer_id = CU.id
			WHERE RE.status = ? AND RE.created BETWEEN ? AND ?
			GROUP BY customer_id 
			ORDER BY SUMME DESC
			LIMIT 5', array('close', date('Y-01-01 00:00:00'), date('Y-12-23 23:59:59')));			
		$this->set(compact('topCustomer'));
			
	}  
	
	private function umsatz() {
		
		$umsatz = array();
		
		for($i = 1; $i <= 12; $i++) {
			$monthUmsatz = $this->Billing->query('
			Select sum(RE.billing_price) AS EINNAHME, sum(CO.cost) AS AUSGABE, (sum(RE.billing_price) - sum(CO.cost)) AS DIFFERENZ
			from billings RE 
			INNER JOIN processes PR 
			ON RE.id = PR.billing_id 
			INNER JOIN confirmations CO
			ON PR.confirmation_id = CO.id
			WHERE RE.created BETWEEN ? AND ?', array( date('Y-'.$i.'-01 00:00:00'), date('Y-m-d 00:00:00', strtotime("+1 days"))));	
			
			setlocale(LC_ALL, 'de_DE', 'German_Germany.1252');
			$monthUmsatz[0][0]['MONAT'] = utf8_encode(strftime('%B', mktime(0, 0, 0, date('F') + $i, 1)));;
			$monthUmsatz[0][0]['MONATSHORT'] = utf8_encode(strftime('%b', mktime(0, 0, 0, date('F') + $i, 1)));;
			
			array_push($umsatz, $monthUmsatz[0][0]);
		}
		
		$this->set('umsatz', $umsatz);
	}  

}

