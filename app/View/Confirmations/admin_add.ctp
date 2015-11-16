 <?php 
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.dynamicSearch', false);
		
	echo $this->Html->css('backend/page');
?>	

<script>
$(document).ready(function() {

	$('#addProduct_btn').find('a').click(function() {

		$('#add_to_offer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Products\/indexAjax\/ajax\/<?php echo $this->data['Cart']['id'];?>');
		$('#add_to_offer_modal').modal('show')

	})
	
	var cusID = 0;
	<?php if(isset($this->data['Customer']['id']) ){	echo 'cusID = '.$this->data['Customer']['id'].';';	} ?>
	
	
	$('#additionalAddress_btn').find('a').click(function() {
		$('#additional_address_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Addresses\/index\/ajax\/<?php echo $this->data['Confirmation']['id'];?>\/<?php echo ucfirst($this->request->params['controller']) ?>\/2');
		$('#additional_address_modal').modal('show')

	})
	
	$('#addToCustomer_btn').find('a').click(function() {

		$('#add_to_customer_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Customers\/indexAjax\/ajax\/<?php echo $this->data['Confirmation']['cart_id'];?>');
		$('#add_to_customer_modal').modal('show')

	})
	
	$('#print_btn').click(function() {

		$('#print_btn_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Confirmations\/createPdf');
		$('#print_btn_modal').modal('show')

	})	

	$('#settings_btn').find('a').click(function() {
		$('#settings_btn_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Confirmations\/settings\/<?php echo $this->data['Confirmation']['id'];?>');
		$('#settings_btn_modal').modal('show')
	});

	$("body").on("hidden", "#add_to_customer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#add_to_offer_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#print_btn_modal", function(){ $(this).removeData("modal");});
	$("body").on("hidden", "#offersettings_btn_modal", function(){ $(this).removeData("modal");});
 
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

<div class="modal fade" id="address_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" style="display: none;">
	<div class="modal-dialog modal-md">
	 	<div class="modal-content">
			<div class="modal-body"></div>
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

<div class="modal" id="add_to_customer_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>

<div class="modal" id="settings_btn_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>

<div class="wood_bg">

	<?php echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons'); ?>
	
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
