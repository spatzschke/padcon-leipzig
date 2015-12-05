<script>
$(document).ready(function() {

	$('#<?php echo $id;?>_btn').find('a').on('click',function() {
		$('#<?php echo $id;?>_modal .modal-body').load('<?php echo FULL_BASE_URL.$this->base.$url; ?>');
		$('#<?php echo $id;?>_modal').modal('show');
		console.log("open");
	})

	$("#<?php echo $id;?>_modal").on("hidden.bs.modal", function(){ 
		$(this).removeData("modal");
		window.location = '<?php echo $redirect;?>';
	});
 
});
</script>

<div class="modal" id="<?php echo $id;?>_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="<?php echo (isset($backdrop) ? $backdrop : "true");?>">
	<div class="modal-dialog <?php echo (isset($modalSize) ? $modalSize : "modal-lg");?> offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>