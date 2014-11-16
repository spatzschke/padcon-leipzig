 <?php 
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.dynamicSearch', false);
		
	echo $this->Html->css('backend/page');
?>	

<script>
$(document).ready(function() {

	$('#addProduct').find('a').click(function() {

		$('#add_to_offer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Products\/index\/ajax\/<?php echo $this->data['Cart']['id'];?>');
		$('#add_to_offer_modal').modal('show')

	})
	
	$('#addToCustomer').find('a').click(function() {

		$('#add_to_customer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Customers\/index\/ajax\/<?php echo $this->data['Confirmation']['cart_id'];?>');
		$('#add_to_customer_modal').modal('show')

	})
	
	$('#print').click(function() {

		$('#print_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Confirmations\/createPdf');
		$('#print_modal').modal('show')

	})	

	$('#settings').find('a').click(function() {
		$('#settings_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Confirmations\/settings\/<?php echo $this->data['Confirmation']['id'];?>');
		$('#settings_modal').modal('show')
	});

	$("body").on("hidden", "#add_to_customer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#add_to_offer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#print_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#offerSettings_modal", function(){ $(this).removeData("modal");});
 
});
</script>
				
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

<div class="modal" id="settings_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>

<div class="wood_bg">

	<div class="buttons">
		     
	    <div id="addToCustomer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span> 
			<a href="#" class="btn btn-default">Kunde hinzufügen</a>
		</div>
		<div id="addProduct" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
			<a  href="#" class="btn btn-default">Produkt hinzufügen</a>
		 </div>
		<div id="settings" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
			<a href="#" class="btn btn-default">Einstellungen</a>
		 </div>
		 <div id="printOffer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
			<?php echo $this->Html->link('Angebot drucken', '/admin/Confirmations/createPdf/'.$controller_id, array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		</div>
	</div>
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/SheetConfirmation', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/SheetConfirmation');
			}
			 ?>
	</div>
</div>
