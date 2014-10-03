<?php 
	echo $this->Html->script('jquery.dynamicSearch', false);
?>

<script>
$(document).ready(function() {
		
			$('#filter .search input').dynamicSearch({
			url: "<?php echo FULL_BASE_URL.$this->base;?>\/Offers\/search\/",
			renderTemplate: '/Elements/backend/portlets/offerPortletTableContent',
			cancel: '.form-search .cancel',
			loadingClass: 'loadingSpinner',
			loadingElement: '#filter .search .input-group-addon i',
			admin: true
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
					<th><?php echo('AngebotsNr');?></th>
					<th><?php echo('KundenNr');?></th>
					<th><?php echo('Anfragedatum');?></th>
					<th><?php echo('Artikelanzahl');?></th>
					<!-- <th><?php echo('Rabatt');?></th>
					<th><?php echo('Lieferkosten');?></th> -->
					<th><?php echo('Gesamtpreis');?></th>
					<th><?php echo('RechnungsNr');?></th>
					<th><?php echo('LieferscheinNr');?></th>
					<th><?php echo('Erstellungsdatum');?></th>
					<!-- <th><?php echo('Bearbeitungsdatum');?></th> -->
					<th class="actions"><?php __('');?></th>
				</tr> 
			</thead> 
			<tbody> 
							
				<?php echo $this->element('backend/portlets/offerPortletTableContent', array('offers' => $offers)); ?>


				
			</tbody>
			 
			</table>
			
		</div><!-- end of .tab_container -->
</article><!-- end of stats article -->