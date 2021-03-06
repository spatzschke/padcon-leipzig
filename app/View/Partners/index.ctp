<div class="partners index">
	<h2><?php __('Partners');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('partner_category_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('url');?></th>
			<th><?php echo $this->Paginator->sort('partner_logo');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($partners as $partner):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $partner['Partner']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($partner['PartnerCategory']['name'], array('controller' => 'partner_categories', 'action' => 'view', $partner['PartnerCategory']['id'])); ?>
		</td>
		<td><?php echo $partner['Partner']['name']; ?>&nbsp;</td>
		<td><?php echo $partner['Partner']['description']; ?>&nbsp;</td>
		<td><?php echo $partner['Partner']['url']; ?>&nbsp;</td>
		<td><?php echo $partner['Partner']['partner_logo']; ?>&nbsp;</td>
		<td><?php echo $partner['Partner']['active']; ?>&nbsp;</td>
		<td><?php echo $partner['Partner']['created']; ?>&nbsp;</td>
		<td><?php echo $partner['Partner']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $partner['Partner']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $partner['Partner']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $partner['Partner']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $partner['Partner']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Partner', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Partner Categories', true), array('controller' => 'partner_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner Category', true), array('controller' => 'partner_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>