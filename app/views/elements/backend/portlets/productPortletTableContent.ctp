<?php				foreach ($products as $product):
									
				?>
				<tr>
					<td></td>
				<!--<td><?php echo $product['Product']['id']; ?>&nbsp;</td>-->
					<td><?php echo $product['Product']['product_number']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['name']; ?>&nbsp;</td>
				<!--<td><?php echo $product['Product']['description']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['featurelist']; ?>&nbsp;</td>-->
					<td><?php echo $product['Category']['name']; ?>&nbsp;</td>
					<td><?php echo $product['Material']['name']; ?>&nbsp;</td>
					<td><?php echo $product['Size']['name']; ?>&nbsp;</td>
				<!--<td><?php echo $product['Product']['price']; ?>&nbsp;Û</td>
					<td><?php echo $product['Product']['new']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['active']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['created']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['modified']; ?>&nbsp;</td>-->
					<td class="actions">
						
						<?php echo $this->Html->link($html->image("backend/icn_edit.png"), array('controller' => 'Products', 'action' => 'edit', $product['Product']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link($html->image("backend/icn_trash.png"), array('controller' => 'Products', 'action' => 'delete', $product['Product']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?>
					</td>
				</tr> 
				<?php endforeach; ?>

