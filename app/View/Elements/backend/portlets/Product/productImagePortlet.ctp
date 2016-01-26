<?php 
	echo $this->Html->css('productItem');
	
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);

?>

<script>

$(document).ready(function() {
	$('select').on('change', function() {
		console.log('select change');
	})		
}
);

</script>

<div class="imagePanel panel panel-info" >
        <div class="panel-body" >
		
		<div class="input-group">
			
				
			
		<iframe class="imageIframe" wdith="250" height="220"  frameborder="0"  src="<?php echo FULL_BASE_URL; ?>/media/index.php?p=35&c=99"></iframe>
		</div>
		<div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
            <?php echo $this->Form->input('Color', array(
				'label' => false,
				'class' => 'form-control',
				'data-model' => 'Product',
				'placeholder' => 'Größe',
				'data-field' => 'size_id', 
				'autoComplete' => true
			));
			?>                                      
         </div>
     
		
		
		
	
</div>