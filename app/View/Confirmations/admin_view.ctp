<?php 
		
	echo $this->Html->css('backend/page');


?>	

<div class="wood_bg">
	<div class="buttons">
		 <div id="printOffer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
			<?php echo $this->Html->link('Drucken', '/admin/Confirmations/createPdf/'.$this->data['Confirmation']['id'], array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		</div>
	</div>
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/confirmation_cheet', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/confirmation_cheet');
			}
			 ?>
	</div>
</div>