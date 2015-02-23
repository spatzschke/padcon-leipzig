<aside id="sidebar" class="column">
		<!-- <ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Dashboard', '/admin/Users/dashboard'); ?></li>
		</ul> -->
		<!--<h3>Dokumente erstellen</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('AB aus Angebot erstellen', '/admin/confirmations/convert'); ?></li>
			<li class="icn_add_user"><?php echo $this->Html->link('Lieferschein aus AB erstellen', '/admin/deliveries/convert'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Rechnung aus Lieferschein erstellen', '/admin/billings/convert', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Auswertung anzeigen', '/admin/offers/index', array('disabled' => 'disabled')); ?></li>
		</ul>-->
		<h3>Angebote</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Neues Angebot erstellen', '/admin/offers/add'); ?></li>
			<!-- <li class="icn_view_users"><?php echo $this->Html->link('Aktives Angebot anzeigen', '/admin/offers/active'); ?></li> -->
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Angebote anzeigen', '/admin/offers/index'); ?></li>
		</ul>
		<h3>Auftragsbestätigung</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Neue AB erstellen', '/admin/confirmations/add'); ?></li>
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('AB aus Angebot erstellen', '/admin/confirmations/convert'); ?></li> -->
			<li class="icn_view_users"><?php echo $this->Html->link('Alle ABs anzeigen', '/admin/confirmations/index'); ?></li>
		</ul>
		<h3>Lieferschein</h3>
		<ul class="toggle">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Lieferschein aus AB erstellen', '/admin/deliveries/convert', array('disabled' => 'disabled')); ?></li> -->
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Lieferscheine anzeigen', '/admin/deliveries/index'); ?></li>
		</ul>
		<h3>Rechnung</h3>
		<ul class="toggle">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Rechnung aus AB erstellen', '/admin/billings/convert', array('disabled' => 'disabled')); ?></li> -->
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Rechnungen anzeigen', '/admin/billings/index'); ?></li>
		</ul>
		
		
		
		<!--<h3>Warenkorb</h3>
		<ul class="toggle">
			<div class="miniCart">
				<?php echo $this->element('backend/miniCart'); ?>
			</div>
			<li class="icn_view_users"><?php echo $this->Html->link('Warenkorb deaktivieren', '/admin/carts/disable_cart'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Warenkörbe anzeigen', '/admin/carts/index'); ?></li>
		</ul>-->
		
		<h3>Produktdatenbank</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Produkte hinzufügen', '/admin/products/add'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Produkte anzeigen', '/admin/products/index'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Material hinzufügen', '/admin/materials/add', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Farben hinzufügen', '/admin/colors/add', array('disabled' => 'disabled')); ?></li>
		</ul>
		
		<h3>Partnerdatenbank</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Partner hinzufügen', '/admin/products/add', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Produkte anzeigen', '/admin/products/index', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Partnerkategorie hinzufügen', '/admin/materials/add', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Partnerkategorien anzeigen', '/admin/colors/add', array('disabled' => 'disabled')); ?></li>
		</ul>
		
		<h3>Katalogverwaltung</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Kataloge verwalten', '/admin/products/add', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Kataloge generieren', '/admin/catalogs/generate'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Preisliste generieren', '/admin/catalogs/generate_pl'); ?></li>
		</ul>
		
		<h3>Kundendatenbank</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Neuer Kunde', '/admin/customers/add'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Kunden anzeigen', '/admin/customers/index'); ?></li>
		</ul>
		<h3>Kundenkonten</h3>
		<ul class="toggle">	
			<li class="icn_add_user"><?php echo $this->Html->link('Neues Kundekonto', '/admin/users/add'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Kundenkonten anzeigen', '/admin/users/index'); ?></li>
		</ul>
		<!--<h3>Admin</h3>
		<ul class="toggle">
			<li class="icn_settings"><a href="#">Options</a></li>
			<li class="icn_security"><a href="#">Security</a></li>
			<li class="icn_jump_back"><a href="#">Logout</a></li>
		</ul>-->
		
		<footer>
			<hr />
		</footer>
</aside><!-- end of sidebar -->
