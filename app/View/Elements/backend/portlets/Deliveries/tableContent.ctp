<?php
	foreach ($data as $item):
	
		if($item['Confirmation']['cart_id'] != 0) {				
?>
				<tr>
					<td>
					<?php 
						if($item['Delivery']['status'] == "open") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Offen"
								 data-trigger="hover"
							></i>';
						} 
						elseif($item['Delivery']['status'] == "close") {
							echo '<i class="glyphicon glyphicon-lock" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Abgeschlossen"
								 data-trigger="hover"
							></i>';
						}
						elseif($item['Delivery']['status'] == "active") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Aktiv"
								 data-trigger="hover"
							></i>';
						}elseif($item['Delivery']['status'] == "") {
							echo '<i class="glyphicon glyphicon-ban-circle" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Unvollständig"
								 data-trigger="hover"
							></i>';
						}
					?>
						
					</td>
					<td>
						<?php if(empty($item['Delivery']['delivery_number'])) {
							 echo '-'; 
							} else {
								
								echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Deliveries', 'action' => 'view', $item['Delivery']['id']), array('escape' => false));
								
								echo '&nbsp;&nbsp;&nbsp;';
								echo $item['Delivery']['delivery_number'];	
							
							}
						?>
					</td>
					<td>
						<?php 						
						if(!is_null($item['Confirmation']['customer_id'])) {
							
							if(empty($item['Confirmation']['customer_id'])) { echo '-'; } else {
								echo $item['Confirmation']['customer_id'];	
								echo '&nbsp;';
								echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
									 data-toggle="popover"
									 data-content="';
									 	if(!empty($item['Customer']['organisation_count'])) {
											for ($i = 0; $i < $item['Customer']['organisation_count']; $i++) {
												echo $item['Customer']['organisation_'.$i].'<br>';
											}
										}
										if(!empty($item['Customer']['department_count'])) {
											for ($i = 0; $i < $item['Customer']['department_count']; $i++) {
												echo $item['Customer']['department_'.$i].'<br>';
											}
										}
										if(!empty($item['Customer']['name'])) {
											echo $item['Customer']['name'].'<br>';
										}
										if(!empty($item['Customer']['phone'])) {
											echo $item['Customer']['phone'].'<br>';
										}
										if(!empty($item['Customer']['email'])) {
											echo $item['Customer']['email'].'<br>';
										}
									 	
									 echo '"
									 data-trigger="hover"
								
								></i>';
							}
						} else { echo '-'; } 
						 ?>
					</td>
					<!-- <td>
						<?php 
						if($item['Delivery']['order_date'] == null) {
							echo '-';
						} else {
							echo $this->Time->format($item['Delivery']['order_date'], '%d.%m.%Y'); 
						}
						?>
					</td> -->
					<td>
						<?php 
						$cartProducts = "";
						foreach ($item['Cart']['CartProduct'] as $cartProduct) {
							$cartProducts = $cartProducts . $cartProduct['amount'].'x '. $cartProduct['Information']['Product']['name'] . ' ( '.$cartProduct['Information']['Product']['product_number'].' )<br>';
						}						
						if(empty($item['Cart']['count'])) { echo '-'; } else {
							echo $item['Cart']['count'];	
							echo '&nbsp;';
							echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
								 data-toggle="popover" 
								 data-content="'.
								 	$cartProducts.
								 '"
								 data-trigger="hover"
							
							></i>';
						} ?>
					</td>
					<!--<td><?php echo $item['Delivery']['discount']; ?>&nbsp;</td>
					<td><?php echo $item['Delivery']['delivery_cost']; ?>&nbsp;</td>-->
					<td> 
						<?php if(!isset($item['Delivery']['confirmation_number'])) {
							 echo '-'; 
							} else {
								
								echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
								data-content="'.$item['Confirmation']['confirmation_number'].'"
								data-trigger="hover"></i>',
								array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));							
							}
						?>
					</td>
					<td>
						<?php 
							
							if(empty($item['Confirmation']['billing_id'])) {
								echo $this->Html->link('Rechnung', array('controller' => 'Billings', 'action' => 'convert', 'admin' =>'true', $item['Confirmation']['id']),
																array('class' => 'btn btn-default')); 	
							} else {
								echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
								data-content="'.$item['Delivery']['billing_number'].'"
								data-trigger="hover"></i>', 
								array('admin' => true, 'controller' => 'Billings', 'action' => 'view', $item['Confirmation']['billing_id']), array('escape' => false));
								
							}
							  
						 ?>
					</td>
					
					<td><?php echo $this->Time->format($item['Delivery']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $item['Delivery']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							
							if(!empty($item['Delivery']['offer_number']))
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'createPdf', $item['Delivery']['id']), array('escape' => false, 'target' => '_blank'));
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>