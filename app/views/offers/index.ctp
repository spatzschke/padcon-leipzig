<div class="offers index">
	<h2><?php __('Offers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('cart_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($offers as $offer):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $offer['Offer']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($offer['Cart']['id'], array('controller' => 'carts', 'action' => 'view', $offer['Cart']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($offer['User']['title'], array('controller' => 'users', 'action' => 'view', $offer['User']['id'])); ?>
		</td>
		<td><?php echo $offer['Offer']['created']; ?>&nbsp;</td>
		<td><?php echo $offer['Offer']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $offer['Offer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $offer['Offer']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $offer['Offer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $offer['Offer']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Offer', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Carts', true), array('controller' => 'carts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart', true), array('controller' => 'carts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>