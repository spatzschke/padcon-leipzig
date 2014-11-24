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
		
		<?php if($this->request->params['action'] == 'admin_convert') {	?>	
		
		<script>
		$(document).ready(function() {
		
			$('#settings').find('a').click(function() {
				$('#settings_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Billings\/settings\/<?php echo $this->data['Delivery']['id'];?>');
				$('#settings_modal').modal('show')
			});
		
			$("body").on("hidden", "#settings", function(){ $(this).removeData("modal");});
		 
		});
		</script>
		
		
		<div id="settings" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
			<a href="#" class="btn btn-default">Einstellungen</a>
		 </div>
		
		<?php 
			}
		?>	
		
		<div id="printOffer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
			<?php echo $this->Html->link('Angebot drucken', '/admin/billings/createPdf/'.$this->data['Delivery']['id'], array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		</div>
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
