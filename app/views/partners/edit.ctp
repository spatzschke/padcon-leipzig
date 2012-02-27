<div class="partners form">
<?php echo $this->Form->create('Partner');?>
	<fieldset>
		<legend><?php __('Edit Partner'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('partner_category_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('url');
		echo $this->Form->input('partner_logo');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Partner.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Partner.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Partners', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Partner Categories', true), array('controller' => 'partner_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner Category', true), array('controller' => 'partner_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>