<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'news', 'action' => 'start'));
	//Router::connect('/', array('controller' => 'Products', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
//Nav Routes
	
	Router::connect('/Produkte', array('controller' => 'Categories', 'action' => 'overview'));
	Router::connect('/Kataloge', array('controller' => 'Catalogs', 'action' => 'overview'));
	Router::connect('/Fachhandel', array('controller' => 'PartnerCategories', 'action' => 'overview'));

//Product Routes	
	
	Router::connect('/Produkte-PhysiotherapieU.Pflege', array('controller' => 'Products', 'action' => 'listing', 'physio'));
	Router::connect('/Produkte-Kranken-UndAltenpflege', array('controller' => 'Products', 'action' => 'listing', 'pflege'));
	Router::connect('/Produkte-Intensivbereich', array('controller' => 'Products', 'action' => 'listing', 'intensiv'));
	Router::connect('/Produkte-OP-Lagerungshilfsmittel', array('controller' => 'Products', 'action' => 'listing', 'op'));
	Router::connect('/Produkte-Röntgen', array('controller' => 'Products', 'action' => 'listing', 'rontgen'));
	Router::connect('/Produkte-Notfallbereich', array('controller' => 'Products', 'action' => 'listing', 'notfall'));
	Router::connect('/Produkte-MutterUndKind', array('controller' => 'Products', 'action' => 'listing', 'baby'));
	Router::connect('/Produkte-Funktionsdiagnostik', array('controller' => 'Products', 'action' => 'listing', 'funktion'));
	
//Catalog Routes	
	
	Router::connect('/Katalog-PhysiotherapieU.Pflege', array('controller' => 'Catalogs', 'action' => 'listing', 'physio'));
	Router::connect('/Katalog-Kranken-UndAltenpflege', array('controller' => 'Catalogs', 'action' => 'listing', 'pflege'));
	Router::connect('/Katalog-Intensivbereich', array('controller' => 'Catalogs', 'action' => 'listing', 'intensiv'));
	Router::connect('/Katalog-OP-Lagerungshilfsmittel', array('controller' => 'Catalogs', 'action' => 'listing', 'op'));
	Router::connect('/Katalog-Röntgen', array('controller' => 'Catalogs', 'action' => 'listing', 'rontgen'));
	Router::connect('/Katalog-Notfallbereich', array('controller' => 'Catalogs', 'action' => 'listing', 'notfall'));
	Router::connect('/Katalog-MutterUndKind', array('controller' => 'Catalogs', 'action' => 'listing', 'baby'));
	Router::connect('/Katalog-Funktionsdiagnostik', array('controller' => 'Catalogs', 'action' => 'listing', 'funktion'));
	
//Partner Routes	
	
	Router::connect('/Fachhandel-HilfsmittelFürPatientenlagerung', array('controller' => 'Partners', 'action' => 'listing', 'lagerung'));
	Router::connect('/Fachhandel-HilfsmittelFürDenPatiententransport', array('controller' => 'Partners', 'action' => 'listing', 'transport'));
	Router::connect('/Fachhandel-MedizinprodukteAusEdelstahl', array('controller' => 'Partners', 'action' => 'listing', 'stahl'));
	Router::connect('/Fachhandel-MedizinprodukteFürDiePflege', array('controller' => 'Partners', 'action' => 'listing', 'medizinpflege'));
	Router::connect('/Fachhandel-HilfsmittelFürPatiententransfer', array('controller' => 'Partners', 'action' => 'listing', 'transfer'));
	Router::connect('/Fachhandel-Medizintechnik', array('controller' => 'Partners', 'action' => 'listing', 'technik'));
	
//Footer Routes
	
	Router::connect('/Uber_uns', array('controller' => 'Pages', 'action' => 'display', 'about_us'));
	Router::connect('/AGB', array('controller' => 'Pages', 'action' => 'display', 'agb'));
	Router::connect('/Impressum', array('controller' => 'Pages', 'action' => 'display', 'imprint'));
	Router::connect('/Kontakt', array('controller' => 'Site_Contents', 'action' => 'contact'));
	
//Other Routes
	
	Router::connect('/Anmelden', array('controller' => 'Users', 'action' => 'login'));
	Router::connect('/Abmelden', array('controller' => 'Users', 'action' => 'logout'));
