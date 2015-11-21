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

 
});
</script>


<div class="wood_bg">
		
		
<?php 
		$dataId = $this->data['Confirmation']['id'];
		$redirectURL = FULL_BASE_URL.$this->base."\/admin\/".ucfirst($this->request->params['controller'])."\/view\/".$dataId;
		$cartId = $this->data['Confirmation']['cart_id'];
		$nextSheet = "Billings";
		$controller = "Delivery";

		echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons', array(
			"redirectURL" => $redirectURL,
			"cartId" => $cartId,
			"dataId" => $dataId,
			"nextSheet" =>$nextSheet,
			"controller" => $controller,
			"addressType" => "3"
		)); 
?>

		
		
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/SheetDelivery', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/SheetDelivery');
			}
			 ?>
	</div>
</div>
