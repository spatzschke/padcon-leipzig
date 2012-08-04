<div class="partnerCategories view">
<h2><?php  __('Partner Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partnerCategory['PartnerCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partnerCategory['PartnerCategory']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Path'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partnerCategory['PartnerCategory']['image_path']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partnerCategory['PartnerCategory']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partnerCategory['PartnerCategory']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $partnerCategory['PartnerCategory']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Partner Category', true), array('action' => 'edit', $partnerCategory['PartnerCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Partner Category', true), array('action' => 'delete', $partnerCategory['PartnerCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $partnerCategory['PartnerCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Partner Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner Category', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Partners', true), array('controller' => 'partners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner', true), array('controller' => 'partners', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Partners');?></h3>
	<?php if (!empty($partnerCategory['Partner'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Partner Category Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('Partner Logo'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($partnerCategory['Partner'] as $partner):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $partner['id'];?></td>
			<td><?php echo $partner['partner_category_id'];?></td>
			<td><?php echo $partner['name'];?></td>
			<td><?php echo $partner['description'];?></td>
			<td><?php echo $partner['url'];?></td>
			<td><?php echo $partner['partner_logo'];?></td>
			<td><?php echo $partner['active'];?></td>
			<td><?php echo $partner['created'];?></td>
			<td><?php echo $partner['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'partners', 'action' => 'view', $partner['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'partners', 'action' => 'edit', $partner['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'partners', 'action' => 'delete', $partner['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $partner['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Partner', true), array('controller' => 'partners', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
