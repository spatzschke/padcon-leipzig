<?php 
$ajax = 1;

foreach ($products as $product):?>	
				<tr>
					<?php					
					echo '<td>';
						echo $this->Html->link('', array('admin' => true, 'controller' => 'Carts', 'action' => 'addToCart', $product['Product']['id']), array('escape' => false, 'class' => 'addToCart'));
						echo $this->Html->div('addToCart', '<i class="glyphicon glyphicon-open"></i>', array(
						 	'pdid' => $product['Product']['id']
						 ));
					echo '</td>';	
					?>
				<!--<td><?php echo $product['Product']['id']; ?>&nbsp;</td>-->
					<td><?php echo $product['Product']['product_number']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['name']; ?>&nbsp;</td>
				<!--<td><?php echo $product['Product']['description']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['featurelist']; ?>&nbsp;</td>-->
					<!-- <td><?php echo $product['Category']['name']; ?>&nbsp;</td> -->
					<td><?php echo $product['Material']['name']; ?>&nbsp;</td>
					<td><?php 
						if($product['Product']['size'] != "") {
							echo $product['Product']['size'].Configure::read('padcon.product.size.suffix');
						}
					?>&nbsp;</td>
				<!--<td><?php echo $product['Product']['price']; ?>&nbsp;�</td>
					<td><?php echo $product['Product']['new']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['active']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['created']; ?>&nbsp;</td>
					<td><?php echo $product['Product']['modified']; ?>&nbsp;</td>-->	
					<th><?php __('');?></th>		
				</tr> 
				<?php endforeach; ?>

