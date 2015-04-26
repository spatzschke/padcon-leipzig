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
	
	$('.showNew').click(function() {
	
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

	$('#addToOffer').find('a').click(function() {

		$('#add_to_offer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Products\/indexAjax\/ajax\/<?php echo $offer['Offer']['cart_id'];?>');
		$('#add_to_offer_modal').modal('show')

	})
	
	$('#addToCustomer').find('a').click(function() {

		$('#add_to_customer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Customers\/indexAjax\/ajax\/<?php echo $offer['Offer']['cart_id'];?>');
		$('#add_to_customer_modal').modal('show')

	})
	
	<?php if(isset($offer['Customer']['id']) ){ ?>
	$('#additionalAddress').find('a').click(function() {

		$('#additional_address_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Addresses\/index\/ajax\/<?php echo $offer['Customer']['id'];?>\/<?php echo $offer['Offer']['id'];?>');
		$('#additional_address_modal').modal('show')

	})
	
	<?php } ?>
	
	$('#print').click(function() {

		$('#print_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Offers\/createPdf');
		$('#print_modal').modal('show')

	})	

	$('#offerSettings').find('a').click(function() {
		$('#offerSettigs_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Offers\/settings\/<?php echo $offer['Offer']['id'];?>');
		$('#offerSettigs_modal').modal('show')
	});
	


	$("body").on("hidden", "#add_to_customer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#add_to_offer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#print_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#offerSettings_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#address_add", function(){ $(this).removeData("modal");});
 
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
				<button class="btn btn-success showNew">Neues Angebot erstellen</button>
				<button class="btn showActive">Aktives Angebot auswählen</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_to_offer_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" >
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>		
			</div>
		</div>
	</div>
</div>



<div class="modal" id="add_to_customer_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>

<div class="modal" id="offerSettigs_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>

<div class="modal" id="additional_address_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog offer-dialog">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		
	</div>
</div>

<div class="wood_bg">

	
	<?php if(!empty($offer)) {
		echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons'); 
		}
	?>
	
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/SheetOffer', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/SheetOffer');
			}
		?>
	</div>
</div>
