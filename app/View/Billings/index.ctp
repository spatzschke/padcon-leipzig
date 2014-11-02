<div class="billings index">
	<h2><?php echo __('Billings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('billing_number'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($billings as $billing): ?>
	<tr>
		<td><?php echo h($billing['Billing']['id']); ?>&nbsp;</td>
		<td><?php echo h($billing['Billing']['billing_number']); ?>&nbsp;</td>
		<td><?php echo h($billing['Billing']['status']); ?>&nbsp;</td>
		<td><?php echo h($billing['Billing']['created']); ?>&nbsp;</td>
		<td><?php echo h($billing['Billing']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $billing['Billing']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $billing['Billing']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $billing['Billing']['id']), null, __('Are you sure you want to delete # %s?', $billing['Billing']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Billing'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Offers'), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer'), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>
