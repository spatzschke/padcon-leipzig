<div class="addresses form">
<?php echo $this->Form->create('Address'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Address'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('salutation');
		echo $this->Form->input('title');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('organisation');
		echo $this->Form->input('department');
		echo $this->Form->input('street');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('city');
		echo $this->Form->input('type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Address.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Address.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Customer Addresses'), array('controller' => 'customer_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer Address'), array('controller' => 'customer_addresses', 'action' => 'add')); ?> </li>
	</ul>
</div>
