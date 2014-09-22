<div class="catalogs index">
	<h2><?php __('Catalogs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('catalog_path');?></th>
			<th><?php echo $this->Paginator->sort('catalog_date');?></th>
			<th><?php echo $this->Paginator->sort('category_id');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($catalogs as $catalog):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $catalog['Catalog']['id']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['name']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['catalog_path']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['catalog_date']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($catalog['Category']['name'], array('controller' => 'categories', 'action' => 'view', $catalog['Category']['id'])); ?>
		</td>
		<td><?php echo $catalog['Catalog']['active']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['created']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $catalog['Catalog']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $catalog['Catalog']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $catalog['Catalog']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $catalog['Catalog']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Catalog', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories', true), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category', true), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>