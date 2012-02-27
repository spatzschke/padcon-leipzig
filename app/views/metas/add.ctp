<div class="metas form">
<?php echo $this->Form->create('Meta');?>
	<fieldset>
		<legend><?php __('Add Meta'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Metas', true), array('action' => 'index'));?></li>
	</ul>
</div>