
<aside id="sidebar" class="column">
</br>
		<ul class="toggle">
			<li><i class="glyphicon glyphicon-dashboard" style="color: grey"></i><?php echo $this->Html->link('Dashboard', '/admin/Pages/dashboard'); ?></li>
			<li><i class="glyphicon glyphicon-tasks" style="color: grey"></i><?php echo $this->Html->link('Vorgangsübersicht', '/admin/Processes/index'); ?></li>
		</ul>
		<!--<h3>Dokumente erstellen</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('AB aus Angebot erstellen', '/admin/confirmations/convert'); ?></li>
			<li class="icn_add_user"><?php echo $this->Html->link('Lieferschein aus AB erstellen', '/admin/deliveries/convert'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Rechnung aus Lieferschein erstellen', '/admin/billings/convert', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Auswertung anzeigen', '/admin/offers/index', array('disabled' => 'disabled')); ?></li>
		</ul>-->
		<h3><i class="glyphicon glyphicon-send" style="color: grey"></i>&nbsp;&nbsp;Angebote</h3>
		<ul class="toggle">
			<li><i class="glyphicon glyphicon-plus" style="color: grey"></i><?php echo $this->Html->link('Neues AN erstellen', '/admin/offers/add'); ?></li>
			<li><i class="glyphicon glyphicon-hand-right" style="color: grey"></i><?php echo $this->Html->link('Indiv. AN erstellen', '/admin/offers/add_individual'); ?></li>
			<li><i class="glyphicon glyphicon-list" style="color: grey"></i><?php echo $this->Html->link('Alle AN anzeigen', '/admin/offers/index'); ?></li>
		</ul>
		<h3><i class="glyphicon glyphicon-check" style="color: grey"></i>&nbsp;&nbsp;Auftragsbestätigung</h3>
		<ul class="toggle">
			<li><i class="glyphicon glyphicon-plus" style="color: grey"></i><?php echo $this->Html->link('Neue AB erstellen', '/admin/confirmations/add'); ?></li>
			<li><i class="glyphicon glyphicon-hand-right" style="color: grey"></i><?php echo $this->Html->link('Indiv. AB erstellen', '/admin/confirmations/add_individual'); ?></li>
			<li><i class="glyphicon glyphicon-list" style="color: grey"></i><?php echo $this->Html->link('Alle ABs anzeigen', '/admin/confirmations/index'); ?></li>
		</ul>
		<h3><i class="glyphicon glyphicon-qrcode" style="color: grey"></i>&nbsp;&nbsp;Lieferschein</h3>
		<ul class="toggle">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Lieferschein aus AB erstellen', '/admin/deliveries/convert', array('disabled' => 'disabled')); ?></li> -->
			<li><i class="glyphicon glyphicon-hand-right" style="color: grey"></i><?php echo $this->Html->link('Indiv. LS erstellen', '/admin/deliveries/add_individual'); ?></li>
			<li><i class="glyphicon glyphicon-list" style="color: grey"></i><?php echo $this->Html->link('Alle LS anzeigen', '/admin/deliveries/index'); ?></li>
		</ul>
		<h3><i class="glyphicon glyphicon-euro" style="color: grey"></i>&nbsp;&nbsp;Rechnung</h3>
		<ul class="toggle">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Rechnung aus AB erstellen', '/admin/billings/convert', array('disabled' => 'disabled')); ?></li> -->
			<li><i class="glyphicon glyphicon-hand-right" style="color: grey"></i><?php echo $this->Html->link('Indiv. RE erstellen', '/admin/billings/add_individual'); ?></li>
			<li><i class="glyphicon glyphicon-list" style="color: grey"></i><?php echo $this->Html->link('Alle RE anzeigen', '/admin/billings/index'); ?></li>
		</ul>
		<!--<h3>Warenkorb</h3>
		<ul class="toggle">
			<div class="miniCart">
				<?php echo $this->element('backend/miniCart'); ?>
			</div>
			<li class="icn_view_users"><?php echo $this->Html->link('Warenkorb deaktivieren', '/admin/carts/disable_cart'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Warenkörbe anzeigen', '/admin/carts/index'); ?></li>
		</ul>-->
		
		<h3><i class="glyphicon glyphicon-th-large" style="color: grey"></i>&nbsp;&nbsp;Produktdatenbank</h3>
		<ul class="toggle">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Produkte hinzufügen', '/admin/products/add'); ?></li> -->
			<li><i class="glyphicon glyphicon-fast-forward" style="color: grey"></i><?php echo $this->Html->link('Produkte QuickAdd', '/admin/products/quickAdd'); ?></li>
			<li><i class="glyphicon glyphicon-list" style="color: grey"></i><?php echo $this->Html->link('Alle Produkte anzeigen', '/admin/products/index'); ?></li>
			<!--<li class="icn_view_users"><?php echo $this->Html->link('Material hinzufügen', '/admin/materials/add', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Farben hinzufügen', '/admin/colors/add', array('disabled' => 'disabled')); ?></li> -->
		</ul>
		
		<!-- <h3>Partnerdatenbank</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Partner hinzufügen', '/admin/products/add', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Produkte anzeigen', '/admin/products/index', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Partnerkategorie hinzufügen', '/admin/materials/add', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Partnerkategorien anzeigen', '/admin/colors/add', array('disabled' => 'disabled')); ?></li>
		</ul> -->
		
		<h3><i class="glyphicon glyphicon-book" style="color: grey"></i>&nbsp;&nbsp;Katalogverwaltung</h3>
		<ul class="toggle">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Kataloge verwalten', '/admin/products/add', array('disabled' => 'disabled')); ?></li> -->
			<li><i class="glyphicon glyphicon-book" style="color: grey"></i><?php echo $this->Html->link('Kataloge generieren', '/admin/catalogs/generate'); ?></li>
			<li><i class="glyphicon glyphicon-tag" style="color: grey"></i><?php echo $this->Html->link('Preisliste generieren', '/admin/catalogs/generate_pl'); ?></li>
		</ul>
		
		<h3><i class="glyphicon glyphicon-user" style="color: grey"></i>&nbsp;&nbsp;Kundendatenbank</h3>
		<ul class="toggle">
			<li><i class="glyphicon glyphicon-plus" style="color: grey"></i><?php echo $this->Html->link('Neuer Kunde', '/admin/customers/add'); ?></li>
			<li><i class="glyphicon glyphicon-list" style="color: grey"></i><?php echo $this->Html->link('Alle Kunden anzeigen', '/admin/customers/index'); ?></li>
		</ul>
		<!--<h3>Kundenkonten</h3>
		<ul class="toggle">	
			<li class="icn_add_user"><?php echo $this->Html->link('Neues Kundekonto', '/admin/users/add'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Kundenkonten anzeigen', '/admin/users/index'); ?></li>
		</ul>-->
		<h3><i class="glyphicon glyphicon-cog" style="color: grey"></i>&nbsp;&nbsp;Admin</h3>
		<ul class="toggle">
			<!-- <li class="icn_settings"><?php echo $this->Html->link('Einstellungen', '/admin/pages/setting'); ?></li>
			<li class="icn_security"><a href="#">Security</a></li>-->
			<li class="icn_jump_back"><a href="#">Logout</a></li> 
		</ul>
		
		
		<footer>
			<hr />
		</footer>
</aside><!-- end of sidebar -->
