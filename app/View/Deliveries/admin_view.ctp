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
		
		
		<script>
		$(document).ready(function() {
		
			$('#settings').find('a').click(function() {
				$('#settings_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Deliveries\/settings\/<?php echo $this->data['Delivery']['id'];?>');
				$('#settings_modal').modal('show')
			});
		
			$("body").on("hidden", "#settings", function(){ $(this).removeData("modal");});
		 
		});
		</script>
		
		
		<?php echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/buttons'); ?>

		
		
	</div>
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
