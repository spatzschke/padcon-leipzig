<?php 
	echo $this->Html->script('jquery.bootstrap.tooltip', false);
	echo $this->Html->script('jquery.bootstrap.popover', false);
	echo $this->Html->css('productItem');
	
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);

?>

<script>

$(document).ready(function() {
			
				
});

</script>


<article class="module width_full productPortlet">
		<header>
			<?php 	
				if(empty($this->data['Product']['product_number'])) {
			?>
				<h3 class=""><?php __('Kunde hinzufuegen');?></h3>
			<?php
				} else {
			?>
				<h3 class=""><?php __('Kunde bearbeiten');?></h3>
			<?php
				}
			?>
				
		</header>
		<div class="module_content row-fluid">
					<?php echo $this->Form->create('User');?>
					
					<div class="span4">
					
					<?php 
						echo $this->Form->input('username');
				        echo $this->Form->input('password');
				        echo $this->Form->input('role', array(
				            'options' => array('admin' => 'Admin', 'author' => 'Author')
				        ));
				    ?>
					</div>
					<div class="span10">
					
						<?php echo $this->Form->end(__('Speichern', true));?>	
					
					</div>
					

		</div><!-- end of .tab_container -->
	</article><!-- end of stats article -->
	<script>





</script>


