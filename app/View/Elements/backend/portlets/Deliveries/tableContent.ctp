<?php
	foreach ($data as $item):
	
		if(true) {				
?>
				<tr>
					<td>
						<?php echo $this->element('backend/helper/tableStatusHelper', array('status' => $item['Delivery']['status'], 'custom' => $item['Delivery']['custom']));	?>						
					</td>
					<td>
						<?php if(empty($item['Delivery']['delivery_number'])) {
							 echo '-'; 
							} else {
								if($item['Delivery']['custom']){
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Deliveries', 'action' => 'edit_individual', $item['Delivery']['id']), array('escape' => false));
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Deliveries', 'action' => 'view', $item['Delivery']['id']), array('escape' => false));
								}
								echo '&nbsp;&nbsp;';
								echo $item['Delivery']['delivery_number'];	
								if(strcmp($item['ConfirmationDelivery']['type'], 'full') == 0) {
									echo '&nbsp;&nbsp;&nbsp;';
									echo '<i class="Voll-Lieferschein"
										 data-trigger="hover"
									
									></i>';
								} else {
									echo '&nbsp;&nbsp;';
									echo '<i class="glyphicon glyphicon-duplicate" style="color: teal; cursor: pointer"
										 data-toggle="popover"
										 data-content="Teil-Lieferschein zu AB: '.$item['Confirmation']['confirmation_number'].'""
										 data-trigger="hover"
									
									></i>';
								}
								
							
							}
						?>
					</td>
					<td>
						<?php 						
						if(!is_null($item['Confirmation']['customer_id'])) {
							
							if(empty($item['Confirmation']['customer_id'])) { echo '-'; } else {
															
								echo $item['Confirmation']['customer_id'];	
								if(!is_null($item['Delivery']['address_id']) && $item['Delivery']['address_id'] != 0) {
									echo '&nbsp;';
									echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer"
										 data-toggle="popover"
										 data-content="';
										 	echo $item['Address']['organisation'].'<br>';
											if(!empty($item['Address']['department'])) {
												echo $item['Address']['department'].'<br>';
											}
										 	echo $item['Address']['name'].'<br>'.
										 '"
										 data-trigger="hover"
									
									></i>';
								}
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
												
						if(empty($item['Cart']['count'])) { echo '-'; } else {
							foreach ($item['Cart']['CartProduct'] as $cartProduct) {
								$cartProducts = $cartProducts . $cartProduct['amount'].'x '. $cartProduct['Information']['Product']['name'] . ' ( '.$cartProduct['Information']['Product']['product_number'].' )<br>';
							}
							echo $item['Cart']['count'];	
							echo '&nbsp;';
							echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer"
								 data-toggle="popover" 
								 data-content="'.
								 	$cartProducts.
								 '"
								 data-trigger="hover"
							
							></i>';
						} ?>
					</td>
					
					<td>
						
						
						<?php 
						if($item['Confirmation']['delivery_cost'] != '0' && $item['Delivery']['send_date'] == '0000-00-00' || empty($item['Delivery']['send_date']) && $item['Delivery']['status'] != 'cancel') {
							echo $this->Html->link('Verschickt', array('controller' => 'Deliveries', 'action' => 'trackingcode', 'admin' =>'true', $item['Delivery']['id']),
																array('class' => 'btn btn-default trackingcode_btn')); 	
						} else {
							if($item['Delivery']['send_date'] == '0000-00-00' || $item['Delivery']['send_date'] == '1970-01-01' || empty($item['Delivery']['send_date'])) {
									
								if($item['Confirmation']['delivery_cost'] == '0') {
									echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer" data-toggle="popover" 
									data-content="Selbst-Lieferung"
									data-trigger="hover"></i>';
									
								} else {
									echo '-';
								}
							} else {								
								if(!empty($item['Delivery']['trackingcode'])) {
									echo '<i class="glyphicon glyphicon-qrcode" style="color: teal; cursor: pointer"
										 data-toggle="popover" 
										 data-content="<u>Trackingcode:</u> <br>'.
										 	$item['Delivery']['trackingcode'].
										 '"
										 data-trigger="hover"
									
									></i>';
									echo '&nbsp;';
								}
								echo $this->Time->format($item['Delivery']['send_date'], '%d.%m.%Y'); 
							}
						}
						?>
					</td>
					<td>
						<?php 
						if(($item['Delivery']['send_date'] != '0000-00-00'|| $item['Confirmation']['delivery_cost'] == '0') && $item['Delivery']['deliver_date'] == '0000-00-00' || empty($item['Delivery']['deliver_date']) && $item['Delivery']['status'] != 'cancel') {
							echo $this->Html->link('Zugestellt', array('controller' => 'Deliveries', 'action' => 'delivered', 'admin' =>'true', $item['Delivery']['id']),
																array('class' => 'btn btn-default')); 	
						} else {
							if($item['Delivery']['deliver_date'] == '0000-00-00' || $item['Delivery']['deliver_date'] == '1970-01-01' || empty($item['Delivery']['deliver_date'])) {
								echo '-';
							} else {
								echo $this->Time->format($item['Delivery']['deliver_date'], '%d.%m.%Y'); 
							}
						}
						?>
					</td>
					<td> 
						<?php if(!isset($item['Delivery']['confirmation_number'])) {
							 echo '-'; 
							} else {
								if($item['Delivery']['custom']){
									echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
									data-content="'.$item['Confirmation']['confirmation_number'].'"
									data-trigger="hover"></i>',
									array('admin' => true, 'controller' => 'Confirmations', 'action' => 'edit_individual', $item['Confirmation']['id']), array('escape' => false));							
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
									data-content="'.$item['Confirmation']['confirmation_number'].'"
									data-trigger="hover"></i>',
									array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));							
								}
							}
						?>
					</td>
					<td>
						<?php 
							if($item['ConfirmationDelivery']['billing_id'] == 0) {								if($item['Confirmation']['pattern']) {									echo '<i class="glyphicon glyphicon-th" data-toggle="popover" style="color: teal; cursor: pointer"											data-content="Musterlieferung"											data-trigger="hover"></i>';								}elseif($item['Delivery']['custom']){
									echo $this->Html->link('Rechnung', array('controller' => 'Billings', 'action' => 'add_individual', 'admin' =>'true', $item['Confirmation']['id']),
																array('class' => 'btn btn-default')); 	
								} else {
									echo $this->Html->link('Rechnung', array('controller' => 'Billings', 'action' => 'convert', 'admin' =>'true', $item['Confirmation']['id']),
																array('class' => 'btn btn-default')); 							
								}
									
									
								
							} else {
								echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
								data-content="'.$item['Billing']['billing_number'].'"
								data-trigger="hover"></i>', 
								array('admin' => true, 'controller' => 'Billings', 'action' => 'view', $item['Confirmation']['billing_id']), array('escape' => false));
								
							}
							  
						 ?>
					</td>
					
					<td><?php echo $this->Time->format($item['Delivery']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $item['Delivery']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							
							if(!$item['Confirmation']['status']){
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Deliveries', 'action' => 'createPdf', $item['Delivery']['id']), array('escape' => false, 'target' => '_blank'));
								
								if(!empty($item['Delivery']['hash']))
									echo $this->Html->link('<i class="glyphicon glyphicon-link"></i>', '/Lieferung/'.$item['Delivery']['hash'], array('escape' => false, 'target' => '_blank'));
							}
							echo $this->Html->link('<i class="tableSetting_btn glyphicon glyphicon-cog"></i>', array('admin' => true, 'controller' => 'Deliveries', 'action' => 'table_setting', $item['Delivery']['id']), array('escape' => false));
							
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>