<div class="partnerCategories index">
	<h2><?php __('Partner Categories');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('image_path');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($partnerCategories as $partnerCategory):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $partnerCategory['PartnerCategory']['id']; ?>&nbsp;</td>
		<td><?php echo $partnerCategory['PartnerCategory']['name']; ?>&nbsp;</td>
		<td><?php echo $partnerCategory['PartnerCategory']['image_path']; ?>&nbsp;</td>
		<td><?php echo $partnerCategory['PartnerCategory']['active']; ?>&nbsp;</td>
		<td><?php echo $partnerCategory['PartnerCategory']['created']; ?>&nbsp;</td>
		<td><?php echo $partnerCategory['PartnerCategory']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $partnerCategory['PartnerCategory']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $partnerCategory['PartnerCategory']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $partnerCategory['PartnerCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $partnerCategory['PartnerCategory']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Partner Category', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Partners', true), array('controller' => 'partners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner', true), array('controller' => 'partners', 'action' => 'add')); ?> </li>
	</ul>
</div>