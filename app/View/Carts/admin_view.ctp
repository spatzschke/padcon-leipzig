<div class="carts view">
<h2><?php  __('Cart');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cart['Cart']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cart['Cart']['session_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cart['Cart']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cart['Cart']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cart', true), array('action' => 'edit', $cart['Cart']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Cart', true), array('action' => 'delete', $cart['Cart']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cart['Cart']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Carts', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cart Products', true), array('controller' => 'cart_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cart Product', true), array('controller' => 'cart_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php __('Related Offers');?></h3>
	<?php if (!empty($cart['Offer'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cart['Offer']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cart Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cart['Offer']['cart_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cart['Offer']['user_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cart['Offer']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cart['Offer']['modified'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Offer', true), array('controller' => 'offers', 'action' => 'edit', $cart['Offer']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php __('Related Cart Products');?></h3>
	<?php if (!empty($cart['CartProduct'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Cart Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($cart['CartProduct'] as $cartProduct):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $cartProduct['id'];?></td>
			<td><?php echo $cartProduct['cart_id'];?></td>
			<td><?php echo $cartProduct['product_id'];?></td>
			<td><?php echo $cartProduct['amount'];?></td>
			<td><?php echo $cartProduct['created'];?></td>
			<td><?php echo $cartProduct['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'cart_products', 'action' => 'view', $cartProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'cart_products', 'action' => 'edit', $cartProduct['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'cart_products', 'action' => 'delete', $cartProduct['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cartProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Cart Product', true), array('controller' => 'cart_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
