<?php 
	//echo $this->Html->script('jquery.autosize-min', false);
	//echo $this->Html->script('jquery.autoGrowInput', false);
	//echo $this->Html->script('jquery.caret.1.02.min', false);
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.dynamicSearch', false);
		
	echo $this->Html->css('backend/page');

?>	

<script>
$(document).ready(function() {
	<?php
			
		if(empty($offer)) {
	    	echo "$('#active_offer_modal').modal('show');";
		}
		
		
	?>
	
	$('.newOffer').click(function() {
	
		$('#active_offer_modal').modal('hide');
		$('#main').load('<?php echo FULL_BASE_URL.$this->base;?>\/Offers\/archiveActiveOffer\/');
		$('#sidebar .miniCart').load('<?php echo FULL_BASE_URL.$this->base;?>/carts/reloadMiniCart');
	});
	
	$('.showActive').click(function() {
	
		$('#active_offer_modal').modal('hide');
		$('#main').load('<?php echo FULL_BASE_URL.$this->base;?>\/Offers\/viewActiveOffer\/ajax');
		
	});
	
	
	
	// $('.module form').liveValidation({
		// url: '<?php echo FULL_BASE_URL.$this->base;?>\/Customers\/liveValidate\/',
		// urlBase: '<?php echo FULL_BASE_URL.$this->base;?>',
		// autoSave: false,
		// autoCompleteSuccess: function(id){
			// saveAndReloadOfferHeader(id);
		// }
	// });

	$('#addToOffer').click(function() {

		$('#add_to_offer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Products\/index\/ajax');
		$('#add_to_offer_modal').modal('show')

	})
	
	$('#addToCustomer').click(function() {

		$('#add_to_customer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Customers\/index\/ajax');
		$('#add_to_customer_modal').modal('show')

	})
	
	$('#print').click(function() {

		$('#print_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Offers\/createPdf');
		$('#print_modal').modal('show')

	})	

	$('#offerSettings').click(function() {
		$('#offerSettigs_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Offers\/settings');
		$('#offerSettigs_modal').modal('show')
	});

	$("body").on("hidden", "#add_to_offer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#add_to_customer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#print_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#offerSettings_modal", function(){ $(this).removeData("modal");});
 
});
</script>
				
<div class="modal" id="active_offer_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	    <div class="modal-content">
			<div class="modal-header">
				<h3 id="myModalLabel">Achtung! Aktives Angebot vorhanden.</h3>
			</div>
			<div class="modal-body">
				<p>Es ist ein aktives Angebot vorhanden.</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success newOffer">Neues Angebot erstellen</button>
				<button class="btn showActive">Aktives Angebot auswählen</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_to_offer_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" >
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>

<div class="modal" id="add_to_customer_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>

<div class="modal" id="offerSettigs_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>

<div class="wood_bg">

	<div class="buttons">
		
		<a id="addToOffer" href="#" class="btn btn-default">Produkt hinzufügen</a>
		<a id="addToCustomer" href="#" class="btn btn-default">Kunde hinzufügen</a>
		<a id="offerSettings" href="#" class="btn btn-default">Angebots-einstellungen</a>
		
		<?php echo $this->Html->link('Angebot drucken', '/admin/offers/createPdf', array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		
	</div>
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/offer_cheet', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/offer_cheet');
			}
			 ?>
	</div>
</div>
