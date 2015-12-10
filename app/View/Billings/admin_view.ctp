 <?php 
	//echo $this->Html->script('jquery.autosize-min', false);
	//echo $this->Html->script('jquery.autoGrowInput', false);
	//echo $this->Html->script('jquery.caret.1.02.min', false);
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.dynamicSearch', false);
		
	echo $this->Html->css('backend/page');
?>	



<div class="wood_bg">

	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/SheetBilling', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/SheetBilling');
			}
			 ?>
	</div>
	
	<?php	
		$dataId = $this->data['Billing']['id'];
		$redirectURL = FULL_BASE_URL.$this->base."\/admin\/".ucfirst($this->request->params['controller'])."\/view\/".$dataId;
		$cartId = $this->data['Confirmation']['cart_id'];
		$controller = "Billing";
		$customId = $this->data['Confirmation']['id'];

		echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons', array(
			"redirectURL" => $redirectURL,
			"cartId" => $cartId,
			"dataId" => $dataId,
			"controller" => $controller,
			"addressType" => "4",
			"customId" => $customId
		)); 
	?>
</div>
