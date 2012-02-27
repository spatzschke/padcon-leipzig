<div class="materials view">
<h2><?php  __('Material');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $material['Material']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $material['Material']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Path'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $material['Material']['image_path']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $material['Material']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $material['Material']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Material', true), array('action' => 'edit', $material['Material']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Material', true), array('action' => 'delete', $material['Material']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $material['Material']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Materials', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors', true), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color', true), array('controller' => 'colors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Colors');?></h3>
	<?php if (!empty($material['Color'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Code'); ?></th>
		<th><?php __('Rgb'); ?></th>
		<th><?php __('Cmyk'); ?></th>
		<th><?php __('Material Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($material['Color'] as $color):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $color['id'];?></td>
			<td><?php echo $color['name'];?></td>
			<td><?php echo $color['code'];?></td>
			<td><?php echo $color['rgb'];?></td>
			<td><?php echo $color['cmyk'];?></td>
			<td><?php echo $color['material_id'];?></td>
			<td><?php echo $color['created'];?></td>
			<td><?php echo $color['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'colors', 'action' => 'view', $color['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'colors', 'action' => 'edit', $color['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'colors', 'action' => 'delete', $color['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $color['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Color', true), array('controller' => 'colors', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Products');?></h3>
	<?php if (!empty($material['Product'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Category Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Product Number'); ?></th>
		<th><?php __('Featurelist'); ?></th>
		<th><?php __('Material Id'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Size Id'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('New'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($material['Product'] as $product):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $product['id'];?></td>
			<td><?php echo $product['category_id'];?></td>
			<td><?php echo $product['name'];?></td>
			<td><?php echo $product['description'];?></td>
			<td><?php echo $product['product_number'];?></td>
			<td><?php echo $product['featurelist'];?></td>
			<td><?php echo $product['material_id'];?></td>
			<td><?php echo $product['price'];?></td>
			<td><?php echo $product['size_id'];?></td>
			<td><?php echo $product['active'];?></td>
			<td><?php echo $product['new'];?></td>
			<td><?php echo $product['created'];?></td>
			<td><?php echo $product['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'products', 'action' => 'view', $product['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'products', 'action' => 'edit', $product['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'products', 'action' => 'delete', $product['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
