<div class="orderConfirmations form">
<?php echo $this->Form->create('OrderConfirmation'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Order Confirmation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('customer_id');
		echo $this->Form->input('order_confirmation_number');
		echo $this->Form->input('agent');
		echo $this->Form->input('order_date');
		echo $this->Form->input('order_number');
		echo $this->Form->input('vat');
		echo $this->Form->input('discount');
		echo $this->Form->input('delivery_cost');
		echo $this->Form->input('order_confirmation_price');
		echo $this->Form->input('additional_text');
		echo $this->Form->input('billing_id');
		echo $this->Form->input('delivery_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('OrderConfirmation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('OrderConfirmation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Order Confirmations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Billings'), array('controller' => 'billings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing'), array('controller' => 'billings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Deliveries'), array('controller' => 'deliveries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Delivery'), array('controller' => 'deliveries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carts'), array('controller' => 'carts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart Id'), array('controller' => 'carts', 'action' => 'add')); ?> </li>
	</ul>
</div>
