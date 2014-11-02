<div class="billings form">
<?php echo $this->Form->create('Billing'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Billing'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('billing_number');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Billing.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Billing.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Billings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Offers'), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer'), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>
