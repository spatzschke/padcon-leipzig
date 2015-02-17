<?php 
$ajax = 1;

foreach ($products as $product):?>
	<tr>
		<th><?php __('');?></th>
	<!--<td><?php echo $product['Product']['id']; ?>&nbsp;</td>-->
		<td><?php echo $product['Product']['product_number']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['name']; ?>&nbsp;</td>
	<!--<td><?php echo $product['Product']['description']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['featurelist']; ?>&nbsp;</td>-->
		<td><?php echo $product['Category']['name']; ?>&nbsp;</td>
		<td><?php echo $product['Material']['name']; ?>&nbsp;</td>
		<td><?php echo $product['Size']['name']; ?>&nbsp;</td>
	<!--<td><?php echo $product['Product']['price']; ?>&nbsp;�</td>
		<td><?php echo $product['Product']['new']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['active']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['created']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['modified']; ?>&nbsp;</td>-->
		
		<?php
		echo '<td class="actions">';
		echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Products', 'action' => 'view', $product['Product']['id']), array('escape' => false));
		echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('admin' => true, 'controller' => 'Products', 'action' => 'edit', $product['Product']['id']), array('escape' => false));
		echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('controller' => 'Products', 'action' => 'delete', $product['Product']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id']));
		echo '</td>';
		?>
						
	</tr> 
<?php endforeach; ?>

