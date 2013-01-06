<?php 
	echo $this->Html->script('jquery.bootstrap.modal', false);
	echo $this->Html->script('jquery.autosize-min', false);
	echo $this->Html->script('jquery.autoGrowInput', false);
	echo $this->Html->script('jquery.caret.1.02.min', false);
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.dynamicSearch', false);

?>


<script>
$(document).ready(function() {
	<?php
	
		if($active) {
		 echo 	"$('#active_offer_modal').modal('show');";
		}
	?>
	
	$('.newOffer').click(function() {
	
		$('#active_offer_modal').modal('hide');
		$('#main').load('<?php echo FULL_BASE_URL.$this->base;?>/Offers/archiveActiveOffer');
		
	});
	
	$('.showActive').click(function() {
	
		$('#active_offer_modal').modal('hide');
		$('#main').load('<?php echo FULL_BASE_URL.$this->base;?>/Offers/viewActiveOffer');
		
	});
	
	$('.module form').liveValidation({
		url: '<?php echo FULL_BASE_URL.$this->base;?>\/Customers\/liveValidate\/',
		urlBase: '<?php echo FULL_BASE_URL.$this->base;?>',
		autoSave: false,
		autoCompleteSuccess: function(id){
			saveAndReloadOfferHeader(id);
		}
	});	

	$('#addToOffer').click(function() {

		$('#add_to_offer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>/admin/Products/index');
		$('#add_to_offer_modal').modal('show')

	})

	$("body").on("hidden", "#add_to_offer_modal", function(){
	    $(this).removeData("modal");
	  });
 
});
</script>
				



<div class="modal" id="active_offer_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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

<div class="modal" id="add_to_offer_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; width: 910px; left: 49%">
	<div class="modal-header">
		

	</div>
	<div class="modal-body">
		
	</div>
	<div class="modal-footer">
		
	</div>
</div>

<div class="wood_bg">

	<a id="addToOffer" href="#" class="btn">Produkt hinzufügen</a>
	<a id="printOffer" href="create_pdf" class="btn">Angebot drucken</a>
	<div class="pages">
		<?php e($this->element('backend/offer_cheet')); ?>
	</div>
</div>
