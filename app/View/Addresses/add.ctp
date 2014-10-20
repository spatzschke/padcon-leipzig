<div class="addresses form">
<?php echo $this->Form->create('Address'); ?>
	<fieldset>
		<legend><?php echo __('Add Address'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Addresses'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Customer Addresses'), array('controller' => 'customer_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer Address'), array('controller' => 'customer_addresses', 'action' => 'add')); ?> </li>
	</ul>
</div>
