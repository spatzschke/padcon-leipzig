<div class="cartProducts form">
<?php echo $this->Form->create('CartProduct');?>
	<fieldset>
		<legend><?php __('Edit Cart Product'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('cart_id');
		echo $this->Form->input('product_id');
		echo $this->Form->input('amount');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CartProduct.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CartProduct.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cart Products', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Carts', true), array('controller' => 'carts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart', true), array('controller' => 'carts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>