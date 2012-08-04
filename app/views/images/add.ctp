<div class="images form">
<?php echo $this->Form->create('Image');?>
	<fieldset>
		<legend><?php __('Add Image'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('product_id');
		echo $this->Form->input('color_id');
		echo $this->Html->link(__('Bild hochladen', true), 'http://localhost:81/padcon-leipzig-media/index.php', array('class' => 'mediaURL'));
		echo $this->Form->input('path');
		echo $this->Form->input('description');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
<?php echo $this->Html->css('colorbox');?>
<?php echo $this->Html->script('jquery.colorbox-min.js');?>
<?php echo '
	<script>
		
	
	
		$(".button").colorbox({
			iframe:true, 
			width:"320", 
			height:"320"
		});
	</script>
';?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors', true), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color', true), array('controller' => 'colors', 'action' => 'add')); ?> </li>
	</ul>
</div>