<div class="partners view">
<h2><?php  __('Partner');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Partner Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($partner['PartnerCategory']['name'], array('controller' => 'partner_categories', 'action' => 'view', $partner['PartnerCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Partner Logo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['partner_logo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partner['Partner']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Partner', true), array('action' => 'edit', $partner['Partner']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Partner', true), array('action' => 'delete', $partner['Partner']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $partner['Partner']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Partners', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Partner Categories', true), array('controller' => 'partner_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner Category', true), array('controller' => 'partner_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
