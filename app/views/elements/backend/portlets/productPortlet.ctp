<?php 
	$products = $this->requestAction('Products/getProducts/');
	echo $this->Html->script('jquery.dynamicSearch', false)
?>

<script>
$(document).ready(function() {
	
			$('#filter .search input').dynamicSearch({
				url: "\/padcon-leipzig\/Products\/search\/"
			});
});

</script>

<article class="module width_full productPortlet">
		<header>
			<h3 class=""><?php __('Produkte');?></h3>
			
		</header>
		<section id="filter">
			<div class="search form-search">
				<div class="cancel"></div>
				<input class="text search-query" type="text" placeholder="Suche"/>
			</div>			
		</section>

		<div class="module_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th></th> 
    			<!--<th><?php __('ID');?></th>-->
					<th><?php __('pd-Nummer');?></th>
					<th><?php __('Name');?></th>
				<!--<th><?php __('Beschreibung');?></th>
					<th><?php __('Featurelist');?></th>-->
					<th><?php __('Kategorie');?></th>
					<th><?php __('Material');?></th>
					<th><?php __('Grš§e');?></th>
				<!--<th><?php __('Preis');?></th>
					<th><?php __('Neu');?></th>
					<th><?php __('Aktiv');?></th>
					<th><?php __('Erstellt');?></th>
					<th><?php __('Bearbeitet');?></th>-->
					<th class="actions"><?php __('');?></th>
				</tr> 
			</thead> 
			<tbody> 
				<?php /*<tr class="filter">
					<td>&nbsp;</td>
				<!--<td>&nbsp;</td>-->
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				<!--<td>&nbsp;</td>
					<td>&nbsp;</td>-->
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				<!--<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>-->
					<td>&nbsp;</td>-->
				</tr> */ ?>
				
				<?php e($this->element('backend/portlets/productPortletTableContent', array('products' => $products))); ?>
				
			</tbody>
			 
			</table>
			
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->
