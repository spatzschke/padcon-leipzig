<div class="billings view">
<h2><?php echo __('Billing'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($billing['Billing']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Billing Number'); ?></dt>
		<dd>
			<?php echo h($billing['Billing']['billing_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($billing['Billing']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($billing['Billing']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($billing['Billing']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Billing'), array('action' => 'edit', $billing['Billing']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Billing'), array('action' => 'delete', $billing['Billing']['id']), null, __('Are you sure you want to delete # %s?', $billing['Billing']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Billings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers'), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer'), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php echo __('Related Offers'); ?></h3>
	<?php if (!empty($billing['Offer'])): ?>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Cart Id'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['cart_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Customer Id'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['customer_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Offer Number'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['offer_number']; ?>
&nbsp;</dd>
		<dt><?php echo __('Agent'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['agent']; ?>
&nbsp;</dd>
		<dt><?php echo __('Request Date'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['request_date']; ?>
&nbsp;</dd>
		<dt><?php echo __('Vat'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['vat']; ?>
&nbsp;</dd>
		<dt><?php echo __('Discount'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['discount']; ?>
&nbsp;</dd>
		<dt><?php echo __('Delivery Cost'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['delivery_cost']; ?>
&nbsp;</dd>
		<dt><?php echo __('Offer Price'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['offer_price']; ?>
&nbsp;</dd>
		<dt><?php echo __('Additional Text'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['additional_text']; ?>
&nbsp;</dd>
		<dt><?php echo __('Billing Id'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['billing_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Delivery Id'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['delivery_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['status']; ?>
&nbsp;</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['created']; ?>
&nbsp;</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
	<?php echo $billing['Offer']['modified']; ?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Offer'), array('controller' => 'offers', 'action' => 'edit', $billing['Offer']['id'])); ?></li>
			</ul>
		</div>
	</div>
	