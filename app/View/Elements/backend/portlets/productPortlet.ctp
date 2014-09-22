<?php 
	$products = $this->requestAction('Products/getProducts/');
	echo $this->Html->script('jquery.dynamicSearch', false);
	echo $this->Html->script('jquery.bootstrap.modal', false);
?>

<script>
$(document).ready(function() {
	
			$('#filter .search input').dynamicSearch({
				url: "<?php echo FULL_BASE_URL.$this->base;?>\/Products\/search\/",
				renderTemplate: '/elements/backend/portlets/productPortletTableContent',
			});
			
			$('.addToCart').on('click', function(){
				
				//$(this).addClass('loading');
				
				$('#product_add .modal-content').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Products\/loadProductAddPopup\/'+$(this).attr('pdid'));
				$('#product_add').modal('show');
			});
		
			$("body").on("hidden", "#product_add", function(){ $(this).removeData("modal");});
							
			
});



</script>



<article class="module width_full productPortlet">
		<div class="modal fade" id="product_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" style="display: none;">
			<div class="modal-dialog">
			    <div class="modal-content row-fluid">
			     
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			
		</div>
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
   					<?php
						if($this->request->is('ajax')) {
							echo '<th></th> ';
						}
					?>
    			<!--<th><?php __('ID');?></th>-->
					<th><?php echo('pd-#');?></th>
					<th><?php echo('Name');?></th>
				<!--<th><?php __('Beschreibung');?></th>
					<th><?php __('Featurelist');?></th>-->
					<th><?php echo('Kategorie');?></th>
					<th><?php echo('Material');?></th>
					<th><?php echo('Größe');?></th>
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
				
				<?php echo $this->element('backend/portlets/productPortletTableContent', array('products' => $products)); ?>
				
			</tbody>
			 
			</table>
			
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->
