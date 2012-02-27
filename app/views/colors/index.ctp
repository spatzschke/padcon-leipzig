<div class="colors index">
	<h2><?php __('Colors');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('code');?></th>
			<th><?php echo $this->Paginator->sort('rgb');?></th>
			<th><?php echo $this->Paginator->sort('cmyk');?></th>
			<th><?php echo $this->Paginator->sort('material_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($colors as $color):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $color['Color']['id']; ?>&nbsp;</td>
		<td><?php echo $color['Color']['name']; ?>&nbsp;</td>
		<td><?php echo $color['Color']['code']; ?>&nbsp;</td>
		<td><?php echo $color['Color']['rgb']; ?>&nbsp;</td>
		<td><?php echo $color['Color']['cmyk']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($color['Material']['name'], array('controller' => 'materials', 'action' => 'view', $color['Material']['id'])); ?>
		</td>
		<td><?php echo $color['Color']['created']; ?>&nbsp;</td>
		<td><?php echo $color['Color']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $color['Color']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $color['Color']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $color['Color']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $color['Color']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Color', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Materials', true), array('controller' => 'materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material', true), array('controller' => 'materials', 'action' => 'add')); ?> </li>
	</ul>
</div>