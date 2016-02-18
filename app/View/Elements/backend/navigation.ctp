<?php

?>


<aside id="sidebar" class="col-md-2 col-sm-1 col-xs-1">
</br>
		<ul class="toggle">
			<?php $color = 'grey'; if(!empty($warningBilling)) { $color = 'red'; }?>
				
			<li><?php echo $this->Html->link('
			<i class="glyphicon glyphicon-dashboard hidden-lg hidden-md" style="color: '.$color.'"></i>
			<i class="glyphicon glyphicon-dashboard hidden-sm" style="color: grey"></i> <span class="hidden-sm">Dashboard</span>', '/admin/Pages/dashboard', array('escape' => false)); ?>
				<?php if(!empty($warningBilling)) {
					echo '<i style="
	color: red;
    cursor: pointer;
    font-size: 15px;
    left: -15px;
    top: 5px" 
						class="glyphicon glyphicon-alert pull-right hidden-sm" 
						data-original-title="" 
						data-toggle="popover"
						data-content="Es gibt <b>'.count($warningBilling).'</b> überfällige Zahlungen."
						data-trigger="hover"
						title=""></i>';
				} ?>
				</li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-tasks" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Vorgangsübersicht</span>', '/admin/Processes/index', array('escape' => false)); ?></li>
		</ul>
		<!--<h3>Dokumente erstellen</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('AB aus Angebot erstellen', '/admin/confirmations/convert', array('escape' => false)); ?></li>
			<li class="icn_add_user"><?php echo $this->Html->link('Lieferschein aus AB erstellen', '/admin/deliveries/convert', array('escape' => false)); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Rechnung aus Lieferschein erstellen', '/admin/billings/convert', array('disabled' => 'disabled')); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Auswertung anzeigen', '/admin/offers/index', array('disabled' => 'disabled')); ?></li>
		</ul>-->
		<h3><i class="glyphicon glyphicon-send" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Angebote</span><span class="visible-sm-inline">AN</span></h3>
		<ul class="">
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Neues AN</span>', '/admin/offers/add', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-hand-right" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Indiv. AN</span>', '/admin/offers/add_individual', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-list" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Alle AN</span>', '/admin/offers/index', array('escape' => false)); ?></li>
		</ul>
		<h3><i class="glyphicon glyphicon-check" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Auftragsbestätigung</span><span class="visible-sm-inline">AB</span></h3>
		<ul class="">
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Neue AB</span>', '/admin/confirmations/add', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-hand-right" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Indiv. AB</span>', '/admin/confirmations/add_individual', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-list" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Alle ABs</span>', '/admin/confirmations/index', array('escape' => false)); ?></li>
		</ul>
		<h3><i class="glyphicon glyphicon-qrcode" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Lieferschein</span><span class="visible-sm-inline">LS</span></h3>
		<ul class="">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Lieferschein aus AB erstellen', '/admin/deliveries/convert', array('disabled' => 'disabled')); ?></li> -->
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-hand-right" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Indiv. LS</span>', '/admin/deliveries/add_individual', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-list" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Alle LS</span>', '/admin/deliveries/index', array('escape' => false)); ?></li>
		</ul>
		<h3><i class="glyphicon glyphicon-euro" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Rechnung</span><span class="visible-sm-inline">RE</span></h3>
		<ul class="">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Rechnung aus AB erstellen', '/admin/billings/convert', array('disabled' => 'disabled')); ?></li> -->
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-hand-right" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Indiv. RE</span>', '/admin/billings/add_individual', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-list" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Alle RE</span>', '/admin/billings/index', array('escape' => false)); ?></li>
		</ul>
		<!--<h3>Warenkorb</h3>
		<ul class="toggle">
			<div class="miniCart">
				<?php echo $this->element('backend/miniCart'); ?>
			</div>
			<li class="icn_view_users"><?php echo $this->Html->link('Warenkorb deaktivieren', '/admin/carts/disable_cart', array('escape' => false)); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Warenkörbe anzeigen', '/admin/carts/index', array('escape' => false)); ?></li>
		</ul>-->
		
		<h3><i class="glyphicon glyphicon-th-large" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Produktdatenbank</span><span class="visible-sm-inline">PRD</span></h3>
		<ul class="">
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-fast-forward" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">QuickAdd</span>', '/admin/products/quickAdd', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Neues Produkt</span>', '/admin/products/add', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-list" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Alle Produkte</span>', '/admin/products/index', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-tag" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Neues Fremdprodukt</span>', '/admin/products/add_external', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-tags" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Alle Fremdprodukte</span>', '/admin/products/index_external', array('escape' => false)); ?></li>
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
		
		<h3><i class="glyphicon glyphicon-book" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Katalogverwaltung</span><span class="visible-sm-inline">CAT</span></h3>
		<ul class="">
			<!-- <li class="icn_add_user"><?php echo $this->Html->link('Kataloge verwalten', '/admin/products/add', array('disabled' => 'disabled')); ?></li> -->
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-book" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Kataloge generieren</span>', '/admin/catalogs/generate', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-tag" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Preisliste generieren</span>', '/admin/catalogs/generate_pl', array('escape' => false)); ?></li>
		</ul>
		
		<h3><i class="glyphicon glyphicon-user" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Kundendatenbank</span><span class="visible-sm-inline">KDN</span></h3>
		<ul class="">
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Neuer Kunde</span>', '/admin/customers/add', array('escape' => false)); ?></li>
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-list" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Alle Kunden</span>', '/admin/customers/index', array('escape' => false)); ?></li>
		</ul>
		<!--<h3>Kundenkonten</h3>
		<ul class="toggle">	
			<li class="icn_add_user"><?php echo $this->Html->link('Neues Kundekonto', '/admin/users/add', array('escape' => false)); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Kundenkonten anzeigen', '/admin/users/index', array('escape' => false)); ?></li>
		</ul>-->
		<h3><i class="glyphicon glyphicon-cog" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Admin</span><span class="visible-sm-inline">ADM</span></h3>
		<ul class="">
			<!-- <li class="icn_settings"><?php echo $this->Html->link('Einstellungen', '/admin/pages/setting', array('escape' => false)); ?></li>
			<li class="icn_security"><a href="#">Security</a></li>-->
			<li><?php echo $this->Html->link('<i class="glyphicon glyphicon-log-out" style="color: grey"></i>&nbsp;&nbsp;<span class="hidden-sm">Logout</span>', '/Abmelden', array('escape' => false)); ?></li> 
		</ul>
		
		
		<footer>
		</footer>
</aside><!-- end of sidebar -->
