<?php 
	echo $this->Html->script('jquery.bootstrap.modal', false);
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


<article class="module width_full offer">
		
		<div class="module_content row-fluid">


				<?php e($this->element('backend/portlets/customerSearchPortlet')); ?>
				
				<?php e($this->element('backend/portlets/offerInfoPortlet')); ?>

		</div>
		<div class="module_content row-fluid">
		
				<?php e($this->element('backend/portlets/offerCartHeaderPortlet')); ?>
				<?php e($this->element('backend/portlets/offerCartPortlet')); ?>
				<?php e($this->element('backend/portlets/offerCartFooterPortlet')); ?>

		</div">
</article>

