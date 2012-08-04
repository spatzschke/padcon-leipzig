<div class="metas form">
<?php echo $this->Form->create('Meta');?>
	<fieldset>
		<legend><?php __('Edit Meta'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('action');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('keyword');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Meta.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Meta.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Metas', true), array('action' => 'index'));?></li>
	</ul>
</div>