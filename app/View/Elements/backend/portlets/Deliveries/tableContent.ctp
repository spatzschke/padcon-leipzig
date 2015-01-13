<?php	
	foreach ($data as $item):
	
		if($item['Confirmation']['cart_id'] != 0) {				
?>
				<tr>
					<td>
					<?php 
						if($item['Confirmation']['status'] == "open") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Offen"
								 data-trigger="hover"
							></i>';
						} 
						elseif($item['Confirmation']['status'] == "close") {
							echo '<i class="glyphicon glyphicon-lock" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Abgeschlossen"
								 data-trigger="hover"
							></i>';
						}
						elseif($item['Confirmation']['status'] == "active") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Aktiv"
								 data-trigger="hover"
							></i>';
						}elseif($item['Confirmation']['status'] == "") {
							echo '<i class="glyphicon glyphicon-ban-circle" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Unvollständig"
								 data-trigger="hover"
							></i>';
						}
					?>
						
					</td>
					<td>
						<?php if(empty($item['Confirmation']['confirmation_number'])) {
							 echo '-'; 
							} else {
								
								echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));
								
								echo '&nbsp;&nbsp;&nbsp;';
								echo $item['Confirmation']['confirmation_number'];	
							
							}
						?>
					</td>
					<td>
						<?php 						
						if(!is_null($item['Customer']['id'])) {
							
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
									 	echo 		 $item['Customer']['name'].'<br>'.
													 $item['Customer']['phone'].'<br>'.
													 $item['Customer']['email'].
									 '"
									 data-trigger="hover"
								
								></i>';
							}
						} else { echo '-'; } 
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
					<!--<td><?php echo $item['Confirmation']['discount']; ?>&nbsp;</td>
					<td><?php echo $item['Confirmation']['delivery_cost']; ?>&nbsp;</td>-->
					<td> 
						<?php if(!isset($item['Confirmation']['offer_number'])) {
							 echo '-'; 
							} else {
								
								echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'view', $item['Confirmation']['offer_id']), array('escape' => false));
								
								echo '&nbsp;&nbsp;&nbsp;';
								echo $item['Confirmation']['offer_number'];	
							
							}
						?>
					</td>
					<td>
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
					</td>
					
					<td><?php echo $this->Time->format($item['Confirmation']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $item['Confirmation']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							
							if(!empty($item['Confirmation']['offer_number']))
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'createPdf', $item['Confirmation']['id']), array('escape' => false, 'target' => '_blank'));
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>