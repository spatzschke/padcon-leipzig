<?php 
		
	echo $this->Html->css('backend/page');


?>	

<div class="wood_bg">
	
	
	
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/SheetConfirmation', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/SheetConfirmation');
			}
			 ?>
	</div>
	
	<?php echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons'); ?>
</div>