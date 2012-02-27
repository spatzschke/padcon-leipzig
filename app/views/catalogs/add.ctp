<div class="catalogs form">
<?php echo $this->Form->create('Catalog');?>
	<fieldset>
		<legend><?php __('Add Catalog'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('catalog_path');
		echo $this->Form->input('catalog_date');
		echo $this->Form->input('category_id');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Catalogs', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Categories', true), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category', true), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>