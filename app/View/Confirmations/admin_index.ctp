<div class="orderConfirmations index">
	<h2><?php echo __('Order Confirmations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('order_confirmation_number'); ?></th>
			<th><?php echo $this->Paginator->sort('agent'); ?></th>
			<th><?php echo $this->Paginator->sort('order_date'); ?></th>
			<th><?php echo $this->Paginator->sort('order_number'); ?></th>
			<th><?php echo $this->Paginator->sort('vat'); ?></th>
			<th><?php echo $this->Paginator->sort('discount'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_cost'); ?></th>
			<th><?php echo $this->Paginator->sort('order_confirmation_price'); ?></th>
			<th><?php echo $this->Paginator->sort('additional_text'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_id'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($orderConfirmations as $orderConfirmation): ?>
	<tr>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($orderConfirmation['Customer']['id'], array('controller' => 'customers', 'action' => 'view', $orderConfirmation['Customer']['id'])); ?>
		</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['order_confirmation_number']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['agent']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['order_date']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['order_number']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['vat']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['discount']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['delivery_cost']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['order_confirmation_price']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['additional_text']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($orderConfirmation['Billing']['id'], array('controller' => 'billings', 'action' => 'view', $orderConfirmation['Billing']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderConfirmation['Delivery']['id'], array('controller' => 'deliveries', 'action' => 'view', $orderConfirmation['Delivery']['id'])); ?>
		</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['status']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['created']); ?>&nbsp;</td>
		<td><?php echo h($orderConfirmation['OrderConfirmation']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $orderConfirmation['OrderConfirmation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $orderConfirmation['OrderConfirmation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $orderConfirmation['OrderConfirmation']['id']), null, __('Are you sure you want to delete # %s?', $orderConfirmation['OrderConfirmation']['id'])); ?>
		</td>
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
		<li><?php echo $this->Html->link(__('New Order Confirmation'), array('action' => 'add')); ?></li>
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
