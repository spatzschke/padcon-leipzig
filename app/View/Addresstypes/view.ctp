<div class="addresstypes view">
<h2><?php echo __('Addresstype'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($addresstype['Addresstype']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($addresstype['Addresstype']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($addresstype['Addresstype']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($addresstype['Addresstype']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Addresstype'), array('action' => 'edit', $addresstype['Addresstype']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Addresstype'), array('action' => 'delete', $addresstype['Addresstype']['id']), null, __('Are you sure you want to delete # %s?', $addresstype['Addresstype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresstypes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Addresstype'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('controller' => 'addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Addresses'); ?></h3>
	<?php if (!empty($addresstype['Address'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Salutation'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th><?php echo __('Organisation'); ?></th>
		<th><?php echo __('Department'); ?></th>
		<th><?php echo __('Street'); ?></th>
		<th><?php echo __('Postal Code'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Fax'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($addresstype['Address'] as $address): ?>
		<tr>
			<td><?php echo $address['id']; ?></td>
			<td><?php echo $address['salutation']; ?></td>
			<td><?php echo $address['title']; ?></td>
			<td><?php echo $address['first_name']; ?></td>
			<td><?php echo $address['last_name']; ?></td>
			<td><?php echo $address['organisation']; ?></td>
			<td><?php echo $address['department']; ?></td>
			<td><?php echo $address['street']; ?></td>
			<td><?php echo $address['postal_code']; ?></td>
			<td><?php echo $address['city']; ?></td>
			<td><?php echo $address['email']; ?></td>
			<td><?php echo $address['phone']; ?></td>
			<td><?php echo $address['fax']; ?></td>
			<td><?php echo $address['created']; ?></td>
			<td><?php echo $address['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'addresses', 'action' => 'view', $address['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'addresses', 'action' => 'edit', $address['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'addresses', 'action' => 'delete', $address['id']), null, __('Are you sure you want to delete # %s?', $address['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
