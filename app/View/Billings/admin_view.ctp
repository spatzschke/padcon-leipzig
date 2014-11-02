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
	<div class="buttons">
		 <div id="printOffer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
			<?php echo $this->Html->link('Angebot drucken', '/admin/offers/createPdf', array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		</div>
	</div>
	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/billing_cheet', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/billing_cheet');
			}
			 ?>
	</div>
</div>
