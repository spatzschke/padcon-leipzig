 <?php 
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.dynamicSearch', false);
		
	echo $this->Html->css('backend/page');
?>	

				

<div class="wood_bg">

	<?php 

		$dataId = $this->data['Confirmation']['id'];
		$redirectURL = FULL_BASE_URL.$this->base."\/admin\/".ucfirst($this->request->params['controller'])."\/edit\/".$dataId;
		$cartId = $this->data['Confirmation']['cart_id'];
		$nextSheet = "Deliveries";
		$controller = "Confirmation";

		echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons', array(
			"redirectURL" => $redirectURL,
			"cartId" => $cartId,
			"dataId" => $dataId,
			"nextSheet" =>$nextSheet,
			"controller" => $controller,
			"addressType" => "2"
		)); 

	?>
	
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
