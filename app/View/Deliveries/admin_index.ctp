<?php 
	echo $this->Html->script('jquery.dynamicSearch', false);
?>

<script>
$(document).ready(function() {
		
			$('#filter .search input').dynamicSearch({
			url: "<?php echo FULL_BASE_URL.$this->base;?>\/Offers\/search\/",
			renderTemplate: '/Elements/backend/portlets/Offer/offerPortletTableContent',
			cancel: '.form-search .cancel',
			loadingClass: 'loadingSpinner',
			loadingElement: '#filter .search .input-group-addon i',
			admin: true,
			content: '.offersIndex tbody'
		});	
		
		$('.glyphicon').popover({
            html:true
        });
});

</script>



<article class="module width_full offersIndex">
		<div class="modal fade" id="product_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" style="display: none;">
			<div class="modal-dialog modal-sm">
			 	<div class="modal-content">
					<div class="modal-body"></div>
				</div>
			</div>
		</div>
		<header>
			<?php
				if($this->request->is('ajax')) {
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
   					<th></th>					
					<th><?php echo('LI-Nr');?></th>
					<th><?php echo('Kunde');?></th>
					<th><?php echo('Lieferschein vom');?></th>
					<th><?php echo('Produkt');?></th>
					<th><?php echo('AB-Nr');?></th>
					<!-- <th><?php echo('RE-Nr');?></th> -->
					<th><?php echo('RE-Nr');?></th>
					<th><?php echo('Erstellt');?></th>
					<!-- <th><?php echo('Bearbeitungsdatum');?></th> -->
					<th class="actions"><?php __('');?></th>
				</tr> 
			</thead> 
			<tbody> 
							
				<?php echo $this->element('backend/portlets/Deliveries/tableContent', array('data' => $data)); ?>


				
			</tbody>
			 
			</table>
			
		</div><!-- end of .tab_container -->
</article><!-- end of stats article -->