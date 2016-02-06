<div class="processes index">
	<h2><?php echo __('Processes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('offer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('confirmation_id'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_id'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_id'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('cart_id'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($processes as $process): ?>
	<tr>
		<td><?php echo h($process['Process']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($process['Offer']['id'], array('controller' => 'offers', 'action' => 'view', $process['Offer']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($process['Confirmation']['confirmation_number'], array('controller' => 'confirmations', 'action' => 'view', $process['Confirmation']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($process['Delivery']['id'], array('controller' => 'deliveries', 'action' => 'view', $process['Delivery']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($process['Billing']['id'], array('controller' => 'billings', 'action' => 'view', $process['Billing']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($process['Customer']['id'], array('controller' => 'customers', 'action' => 'view', $process['Customer']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($process['Cart']['id'], array('controller' => 'carts', 'action' => 'view', $process['Cart']['id'])); ?>
		</td>
		<td><?php echo h($process['Process']['type']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Process'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Offers'), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer'), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Confirmations'), array('controller' => 'confirmations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Confirmation'), array('controller' => 'confirmations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Deliveries'), array('controller' => 'deliveries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Delivery'), array('controller' => 'deliveries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Billings'), array('controller' => 'billings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing'), array('controller' => 'billings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carts'), array('controller' => 'carts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart'), array('controller' => 'carts', 'action' => 'add')); ?> </li>
	</ul>
</div>
