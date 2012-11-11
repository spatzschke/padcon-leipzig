<?php 
	echo $this->Html->script('jquery.bootstrap.modal', false);
	echo $this->Html->script('jquery.autosize-min', false);
	echo $this->Html->script('jquery.autoGrowInput', false);
	echo $this->Html->script('jquery.caret.1.02.min', false);
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

<div class="wood_bg">

	<article class="module width_full offer row-fluid">
		
		<div class="module_content row">

			<div class="offerHead span12">

			</div>

			<div class="offerCustomer span5 firstItem">
				<?php e($this->element('backend/portlets/customerSearchPortlet')); ?>
			</div>
			<div class="span2">
			</div>
			<div class="span5">	
				<?php e($this->element('backend/portlets/offerInfoPortlet')); ?>
			</div>
		
			<div class="firstItem span12">
				<article class="offerCartPortlet offerSheet">
					<div >
						<?php e($this->element('backend/portlets/offerCartHeaderPortlet')); ?>
						<?php e($this->element('backend/portlets/offerCartPortlet')); ?>
						<?php e($this->element('backend/portlets/offerCartFooterPortlet')); ?>
					</div><!-- end of .tab_container -->
				</article><!-- end of stats article -->
			</div>
		</div>
	</article>
	
</div>
