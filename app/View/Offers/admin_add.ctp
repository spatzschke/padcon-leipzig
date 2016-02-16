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
		
	?>
	
	$('#print').click(function() {
		$('#print_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Offers\/createPdf');
		$('#print_modal').modal('show')
	})	
 
});
</script>

<?php 



?>

<div class="wood_bg">


	
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/SheetOffer', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/SheetOffer');
			}
		?>
	</div>
	
		<?php if(!empty($offer)) {
		 	$redirectURL = FULL_BASE_URL.$this->base."\/admin\/".ucfirst($this->request->params['controller'])."\/edit\/".$offer['Offer']['id'];
			$cartId = $offer['Offer']['cart_id'];
			$dataId = $offer['Offer']['id'];
			$nextSheet = "Confirmations";
			$controller = "Offer";

			echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons', array(
				"redirectURL" => $redirectURL,
				"cartId" => $cartId,
				"dataId" => $dataId,
				"nextSheet" =>$nextSheet,
				"controller" => $controller,
				"addressType" => "1"
			)); 
		}
	?>
</div>
