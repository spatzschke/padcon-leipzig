<div class="carts form">
<?php echo $this->Form->create('Cart');?>
	<fieldset>
		<legend><?php __('Edit Cart'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('session_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Cart.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Cart.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Carts', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cart Products', true), array('controller' => 'cart_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart Product', true), array('controller' => 'cart_products', 'action' => 'add')); ?> </li>
	</ul>
</div>