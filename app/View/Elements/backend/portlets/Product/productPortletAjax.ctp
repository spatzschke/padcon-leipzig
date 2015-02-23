<?php 
	$products = $this->requestAction('Products/getProducts/');
	echo $this->Html->script('jquery.dynamicSearch', false);	
	echo $this->Html->script('jquery.bootstrap.modal', false);
	
	if($this->request->params['isAjax']) {
		$ajax = 1;
	} else {
		$ajax = 0;
	}
?>

<script>
$(document).ready(function() {
	
		$('#filter .search input').dynamicSearch({
			url: "<?php echo FULL_BASE_URL.$this->base;?>\/Products\/search\/<?php echo $ajax;?>\/",
			renderTemplate: '/Elements/backend/portlets/Product/productPortletTableContentAjax',
			cancel: '.form-search .cancel',
			addToCartUrl: '<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Products\/loadProductAddPopup\/',
			loadingClass: 'loadingSpinner',
			loadingElement: '#filter .search .input-group-addon i',
			admin: true
		});	

		$('.addToCart').on('click', function(){
				
			$('#product_add .modal-content').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Products\/loadProductAddPopup\/'+$(this).attr('pdid')+'\/<?php echo $cart_id;?>');
			$('#product_add').modal('show');
			$('#product_add').css('zIndex','1000')
			$('#product_add').css('display','block')
			
			return false;
		});
});

</script>



<article class="module width_full productPortlet">
		<div class="modal fade" id="product_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" style="display: none;">
			<div class="modal-dialog modal-sm">
			 	<div class="modal-content">
					<div class="modal-body"></div>
				</div>
			</div>
		</div>
		<header>
			<?php
				if($this->request->params['isAjax']) {
					echo '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>';
				}
			?>
			
		</header>
		<section id="filter">
			<div class="input-group search form-search">
	            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
	         	<input class="text form-control search-query" placeholder="Suche"/>   
	         	<div class="cancel"><i class="glyphicon glyphicon-remove"></i></div>                                
	        </div>	
		</section>

		<div class="module_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th><?php __('');?></th>
    			<!--<th><?php __('ID');?></th>-->
					<th><?php echo('pd-#');?></th>
					<th><?php echo('Name');?></th>
				<!--<th><?php __('Beschreibung');?></th>
					<th><?php __('Featurelist');?></th>-->
				<!--<th><?php echo('Kategorie');?></th> -->
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
				
				<?php echo $this->element('backend/portlets/Product/productPortletTableContentAjax', array('products' => $products)); ?>
				
			</tbody>
			 
			</table>
			
		</div><!-- end of .tab_container -->
		</article><!-- end of stats article -->
