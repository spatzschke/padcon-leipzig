<div class="customerAddresses view">
<h2><?php echo __('Customer Address'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($customerAddress['Customer']['id'], array('controller' => 'customers', 'action' => 'view', $customerAddress['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo $this->Html->link($customerAddress['Address']['title'], array('controller' => 'addresses', 'action' => 'view', $customerAddress['Address']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Customer Address'), array('action' => 'edit', $customerAddress['CustomerAddress']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Customer Address'), array('action' => 'delete', $customerAddress['CustomerAddress']['id']), null, __('Are you sure you want to delete # %s?', $customerAddress['CustomerAddress']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Customer Addresses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer Address'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('controller' => 'addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
	</ul>
</div>
