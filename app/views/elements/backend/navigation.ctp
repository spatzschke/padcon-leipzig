<aside id="sidebar" class="column">
		
		<!--<h3>Angebote</h3>
		<ul class="toggle">
			<li class="icn_new_article"><a href="#">New Article</a></li>
			<li class="icn_edit_article"><a href="#">Edit Articles</a></li>
			<li class="icn_categories"><a href="#">Categories</a></li>
			<li class="icn_tags"><a href="#">Tags</a></li>
		</ul>-->
		<h3>Angebote</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Neues Angebot erstellen', '/admin/offers/add'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Aktives Angebot anzeigen', '/admin/offers/active'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Angebote anzeigen', '/admin/offers/index'); ?></li>
		</ul>
		
		<h3>Warenkorb</h3>
		<ul class="toggle">
			<div class="miniCart">
				<?php e($this->element('backend/miniCart')); ?>
			</div>
			<li class="icn_view_users"><?php echo $this->Html->link('Warenkorb deaktivieren', '/admin/carts/disable_cart'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Warenkörbe anzeigen', '/admin/carts/index'); ?></li>
		</ul>
		
		<h3>Produktdatenbank</h3>
		<ul class="toggle">
			<li class="icn_add_user"><?php echo $this->Html->link('Produkte hinzufügen', '/admin/products/add'); ?></li>
			<li class="icn_view_users"><?php echo $this->Html->link('Alle Produkte anzeigen', '/admin/products/index'); ?></li>
		</ul>
		<!--<h3>Seiteninhalte</h3>
		<ul class="toggle">
			<li class="icn_folder"><a href="#">File Manager</a></li>
			<li class="icn_photo"><a href="#">Gallery</a></li>
			<li class="icn_audio"><a href="#">Audio</a></li>
			<li class="icn_video"><a href="#">Video</a></li>
		</ul>-->
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
