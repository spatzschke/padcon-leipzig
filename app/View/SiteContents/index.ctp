<div class="siteContents index">
	<h2><?php __('Site Contents');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('controller');?></th>
			<th><?php echo $this->Paginator->sort('action');?></th>
			<th><?php echo $this->Paginator->sort('param');?></th>
			<th><?php echo $this->Paginator->sort('content_paragraph');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($siteContents as $siteContent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $siteContent['SiteContent']['id']; ?>&nbsp;</td>
		<td><?php echo $siteContent['SiteContent']['controller']; ?>&nbsp;</td>
		<td><?php echo $siteContent['SiteContent']['action']; ?>&nbsp;</td>
		<td><?php echo $siteContent['SiteContent']['param']; ?>&nbsp;</td>
		<td><?php echo $siteContent['SiteContent']['content_paragraph']; ?>&nbsp;</td>
		<td><?php echo $siteContent['SiteContent']['active']; ?>&nbsp;</td>
		<td><?php echo $siteContent['SiteContent']['created']; ?>&nbsp;</td>
		<td><?php echo $siteContent['SiteContent']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $siteContent['SiteContent']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $siteContent['SiteContent']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $siteContent['SiteContent']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $siteContent['SiteContent']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Site Content', true), array('action' => 'add')); ?></li>
	</ul>
</div>