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
	
	$('#print').click(function() {
		$('#print_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Offers\/createPdf');
		$('#print_modal').modal('show')
	})	
 
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


<?php 

echo $this->element('backend/helper/modalHelper', array(
	"id" => "addCustomer",
	"url" => "\/admin\/Customers\/indexAjax\/ajax\/".$offer['Offer']['cart_id']));
	
echo $this->element('backend/helper/modalHelper', array(
	"id" => "addProduct",
	"url" => "\/admin\/Products\/indexAjax\/ajax\/".$offer['Offer']['cart_id']));
	
echo $this->element('backend/helper/modalHelper', array(
	"backdrop" => "false",
	"id" => "address_add",
	"url" => "\/admin\/Customers\/indexAjax\/ajax\/".$offer['Offer']['cart_id']));	

echo $this->element('backend/helper/modalHelper', array(
	"id" => "settings",
	"url" => "\/admin\/Offers\/settings\/".$offer['Offer']['id']));

echo $this->element('backend/helper/modalHelper', array(
	"id" => "additionalAddress", 
	"url" => "\/admin\/Addresses\/index\/ajax\/".(isset($offer['Customer']) ? $offer['Customer']['id'] : "0")."\/".$offer['Offer']['id']."\/Offers\/1")); 


?>

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
