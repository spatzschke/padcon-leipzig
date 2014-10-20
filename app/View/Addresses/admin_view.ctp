<div class="addresses view">
<h2><?php echo __('Address'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($address['Address']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Salutation'); ?></dt>
		<dd>
			<?php echo h($address['Address']['salutation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($address['Address']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($address['Address']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($address['Address']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Organisation'); ?></dt>
		<dd>
			<?php echo h($address['Address']['organisation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Department'); ?></dt>
		<dd>
			<?php echo h($address['Address']['department']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street'); ?></dt>
		<dd>
			<?php echo h($address['Address']['street']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($address['Address']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($address['Address']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($address['Address']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($address['Address']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($address['Address']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Address'), array('action' => 'edit', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Address'), array('action' => 'delete', $address['Address']['id']), null, __('Are you sure you want to delete # %s?', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customer Addresses'), array('controller' => 'customer_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer Address'), array('controller' => 'customer_addresses', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Customer Addresses'); ?></h3>
	<?php if (!empty($address['CustomerAddress'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Address Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($address['CustomerAddress'] as $customerAddress): ?>
		<tr>
			<td><?php echo $customerAddress['id']; ?></td>
			<td><?php echo $customerAddress['customer_id']; ?></td>
			<td><?php echo $customerAddress['address_id']; ?></td>
			<td><?php echo $customerAddress['created']; ?></td>
			<td><?php echo $customerAddress['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'customer_addresses', 'action' => 'view', $customerAddress['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'customer_addresses', 'action' => 'edit', $customerAddress['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'customer_addresses', 'action' => 'delete', $customerAddress['id']), null, __('Are you sure you want to delete # %s?', $customerAddress['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Customer Address'), array('controller' => 'customer_addresses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
