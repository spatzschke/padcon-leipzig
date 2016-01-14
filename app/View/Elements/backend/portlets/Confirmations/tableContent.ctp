<?php	
	foreach ($data as $item):
	
		if($item['Confirmation']['customer_id'] != 0) {				
?>
				<tr>
					<td>
						<?php echo $this->element('backend/helper/tableStatusHelper', array('status' => $item['Confirmation']['status']));	?>	
					</td>
					<td>
						<?php if(empty($item['Confirmation']['confirmation_number'])) {
							 echo '-'; 
							} else {
								if(empty($item['Confirmation']['delivery_id'])) {
									echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'edit', $item['Confirmation']['id']), array('escape' => false));
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));
								}
								echo '&nbsp;&nbsp;&nbsp;';
								echo $item['Confirmation']['confirmation_number'];	
							
							}
						?>
					</td>
					<td>
						<?php 						
							
							if(empty($item['Confirmation']['customer_id'])) { echo '-'; } else {
							
								echo $item['Confirmation']['customer_id'];	
								echo '&nbsp;';
								if(!is_null($item['Customer']['id'])) {
									echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
										 data-toggle="popover"
										 data-content="';
										 	echo $item['Address']['organisation'].'<br>';
											echo $item['Address']['department'].'<br>';
										 	echo $item['Customer']['name'].'<br>'.
										 '"
										 data-trigger="hover"
									
									></i>';
								}
							}
						 ?>
					</td>
					<td>
						<?php 
						if($item['Confirmation']['order_date'] == null) {
							echo '-';
						} else {
							echo $this->Time->format($item['Confirmation']['order_date'], '%d.%m.%Y'); 
						}
						?>
					</td>
					<td>
						<?php 
						if($item['Confirmation']['cart_id'] != 0) {	
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
							} 
						} else { echo '-'; }?>
					</td>
					<!--<td><?php echo $item['Confirmation']['discount']; ?>&nbsp;</td>
					<td><?php echo $item['Confirmation']['delivery_cost']; ?>&nbsp;</td>-->
					<td style="text-align: right; width: 130px">
						
						<?php 
						$priceInfo = 'Gesamtpreis: '.$this->Number->currency($item['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 $item['Confirmation']['discount'].'% Rabatt: '.$this->Number->currency($item['Confirmation']['discount_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Versandkostenvorteil: '.$this->Number->currency($item['Confirmation']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Zwischensumme: '.$this->Number->currency($item['Confirmation']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 '+'.$item['Confirmation']['vat'].'% Mehrwertsteuer: '.$this->Number->currency($item['Confirmation']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Auftragswert: '.$this->Number->currency($item['Confirmation']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));					
						
							echo $this->Number->currency($item['Confirmation']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
							
							if(empty($item['Cart']['count'])) { echo '-'; } else {
								echo '&nbsp;';
								echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
									 data-toggle="popover" 
									 data-content="'.
									 	$priceInfo.
									 '"
									 data-trigger="hover"
								
								></i>';
							}
						 ?>	
					</td>
					<td> 
						<?php if(!isset($item['Confirmation']['offer_number'])) {
							 echo '-'; 
							} else {	
								echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
								data-content="'.$item['Confirmation']['offer_number'].'"
								data-trigger="hover"></i>', 
								array('admin' => true, 'controller' => 'Offers', 'action' => 'view', $item['Confirmation']['offer_id']), array('escape' => false));
							}
						?>
					</td>
					<!-- <td>
						<?php 
							
							if(empty($item['Cart']['count']) || $item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['confirmation_price'])) {
								echo '-';
							} else {
								if(empty($item['Confirmation']['billing_id'])) {
									echo $this->Html->link('Rechnung', array('controller' => 'Billings', 'action' => 'convert', 'admin' =>'true', $item['Confirmation']['id']),
																	array('class' => 'btn btn-default')); 	
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Billings', 'action' => 'view', $item['Confirmation']['billing_id']), array('escape' => false));
									echo $item['Billing']['billing_number'];
								}
									
								
							}
							  
						 ?>
					</td> -->
					<td>
						<?php 
							
							if(empty($item['Cart']['count']) || $item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['confirmation_price'])) {
								echo '-';
							} else {
								if(empty($item['Confirmation']['delivery_id'])) {
									echo $this->Html->link('Lieferschein', array('controller' => 'Deliveries', 'action' => 'convert', 'admin' =>'true', $item['Confirmation']['id']),
																	array('class' => 'btn btn-default')); 	
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
									data-content="'.$item['Delivery']['delivery_number'].'"
									data-trigger="hover"></i>', 
									array('admin' => true, 'controller' => 'Deliveries', 'action' => 'view', $item['Confirmation']['delivery_id']), array('escape' => false));
								}
									
								
							}
							  
						 ?>
					</td>
					<td><?php echo $this->Time->format($item['Confirmation']['modified'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $item['Confirmation']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							
							if(!empty($item['Confirmation']['offer_number']))
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'createPdf', $item['Confirmation']['id']), array('escape' => false, 'target' => '_blank'));
							
							if(!empty($item['Confirmation']['hash']))
								echo $this->Html->link('<i class="glyphicon glyphicon-link" ></i>', '/Auftrag/'.$item['Confirmation']['hash'], array('class' => 'clipboard', 'escape' => false, 'target' => '_blank'));
							
							if(!empty($item['Confirmation']['hash']))
								echo $this->Html->link('<i class="glyphicon glyphicon-envelope"></i>', '/Auftrag/'.$item['Confirmation']['hash'], array('class' => 'mail', 'escape' => false, 'target' => '_blank'));
							
							echo $this->Html->link('<i id="tableSetting_btn" class="glyphicon glyphicon-cog"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'table_setting', $item['Confirmation']['id']), array('escape' => false));
							
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>