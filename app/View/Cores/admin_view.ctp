<div class="cores view">
<h2><?php echo __('Core'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($core['Core']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($core['Core']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($core['Core']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($core['Core']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Core'), array('action' => 'edit', $core['Core']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Core'), array('action' => 'delete', $core['Core']['id']), null, __('Are you sure you want to delete # %s?', $core['Core']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cores'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Core'), array('action' => 'add')); ?> </li>
	</ul>
</div>
