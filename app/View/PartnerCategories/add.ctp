<div class="partnerCategories form">
<?php echo $this->Form->create('PartnerCategory');?>
	<fieldset>
		<legend><?php __('Add Partner Category'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('image_path');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Partner Categories', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Partners', true), array('controller' => 'partners', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Partner', true), array('controller' => 'partners', 'action' => 'add')); ?> </li>
	</ul>
</div>