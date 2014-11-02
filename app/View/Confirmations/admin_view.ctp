<div class="orderConfirmations view">
<h2><?php echo __('Order Confirmation'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderConfirmation['Customer']['id'], array('controller' => 'customers', 'action' => 'view', $orderConfirmation['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order Confirmation Number'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['order_confirmation_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Agent'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['agent']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order Date'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['order_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order Number'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['order_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vat'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['vat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['discount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery Cost'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['delivery_cost']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order Confirmation Price'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['order_confirmation_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Additional Text'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['additional_text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderConfirmation['Billing']['id'], array('controller' => 'billings', 'action' => 'view', $orderConfirmation['Billing']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivery'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderConfirmation['Delivery']['id'], array('controller' => 'deliveries', 'action' => 'view', $orderConfirmation['Delivery']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($orderConfirmation['OrderConfirmation']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Confirmation'), array('action' => 'edit', $orderConfirmation['OrderConfirmation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Confirmation'), array('action' => 'delete', $orderConfirmation['OrderConfirmation']['id']), null, __('Are you sure you want to delete # %s?', $orderConfirmation['OrderConfirmation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Confirmations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Confirmation'), array('action' => 'add')); ?> </li>
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
	<div class="related">
		<h3><?php echo __('Related Carts'); ?></h3>
	<?php if (!empty($orderConfirmation['cart_id'])): ?>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Session Id'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['session_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Count'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['count']; ?>
&nbsp;</dd>
		<dt><?php echo __('Sum Base Price'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['sum_base_price']; ?>
&nbsp;</dd>
		<dt><?php echo __('Sum Retail Price'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['sum_retail_price']; ?>
&nbsp;</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['active']; ?>
&nbsp;</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['created']; ?>
&nbsp;</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
	<?php echo $orderConfirmation['cart_id']['modified']; ?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Cart Id'), array('controller' => 'carts', 'action' => 'edit', $orderConfirmation['cart_id']['id'])); ?></li>
			</ul>
		</div>
	</div>
	