<div class="cartProducts index">
	<h2><?php __('Cart Products');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('cart_id');?></th>
			<th><?php echo $this->Paginator->sort('product_id');?></th>
			<th><?php echo $this->Paginator->sort('amount');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($cartProducts as $cartProduct):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $cartProduct['CartProduct']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($cartProduct['Cart']['id'], array('controller' => 'carts', 'action' => 'view', $cartProduct['Cart']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($cartProduct['Product']['name'], array('controller' => 'products', 'action' => 'view', $cartProduct['Product']['id'])); ?>
		</td>
		<td><?php echo $cartProduct['CartProduct']['amount']; ?>&nbsp;</td>
		<td><?php echo $cartProduct['CartProduct']['created']; ?>&nbsp;</td>
		<td><?php echo $cartProduct['CartProduct']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $cartProduct['CartProduct']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $cartProduct['CartProduct']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $cartProduct['CartProduct']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cartProduct['CartProduct']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Cart Product', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Carts', true), array('controller' => 'carts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart', true), array('controller' => 'carts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>