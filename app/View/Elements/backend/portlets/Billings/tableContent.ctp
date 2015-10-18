<?php	
	foreach ($data as $item):
	
		if($item['Confirmation']['cart_id'] != 0) {				
?>
				<tr>
					<td>
					<?php 
						if($item['Billing']['status'] == "open") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Offen"
								 data-trigger="hover"
							></i>';
						} 
						elseif($item['Billing']['status'] == "close") {
							echo '<i class="glyphicon glyphicon-lock" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Abgeschlossen"
								 data-trigger="hover"
							></i>';
						}
						elseif($item['Billing']['status'] == "active") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Aktiv"
								 data-trigger="hover"
							></i>';
						}elseif($item['Billing']['status'] == "") {
							echo '<i class="glyphicon glyphicon-ban-circle" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Unvollständig"
								 data-trigger="hover"
							></i>';
						}
					?>
						
					</td>
					<td>
						<?php if(empty($item['Billing']['billing_number'])) {
							 echo '-'; 
							} else {
								
								echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Billings', 'action' => 'view', $item['Billing']['id']), array('escape' => false));
								
								echo '&nbsp;&nbsp;&nbsp;';
								echo $item['Billing']['billing_number'];	
							
							}
						?>
					</td>
					<td>
						<?php 
												
						if(!is_null($item['Customer'])) {
							
							if(empty($item['Confirmation']['customer_id'])) { echo '-'; } else {
																	
								echo $item['Confirmation']['customer_id'];	
								echo '&nbsp;';
								echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
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
						} else { echo '-'; } 
						 ?>
					</td>
					<td>
						<?php 
						$cartProducts = "";
						foreach ($item['Cart']['CartProduct'] as $cartProduct) {
							$cartProducts = $cartProducts . $cartProduct['amount'].'x '. $cartProduct['Information']['Product']['name'] . ' ( '.$cartProduct['Information']['Product']['product_number'].' )<br>';
						}					

						$priceInfo = 'Gesamtpreis: '.$this->Number->currency($item['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 $item['Confirmation']['discount'].'% Rabatt: '.$this->Number->currency($item['Billing']['discount_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Versandkostenvorteil: '.$this->Number->currency($item['Billing']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Zwischensumme: '.$this->Number->currency($item['Billing']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 '+'.$item['Confirmation']['vat'].'% Mehrwertsteuer: '.$this->Number->currency($item['Billing']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Rechnungswert: '.$this->Number->currency($item['Billing']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));					
						
	
						if(empty($item['Cart']['count'])) { echo '-'; } else {
							echo $this->Number->currency($item['Billing']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
							echo '&nbsp;';
							echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
								 data-toggle="popover" 
								 data-content="'.
								 	$cartProducts.'
								 --------------- <br />
								 '.$priceInfo.'"
								 data-trigger="hover"
							
							></i>';
						} ?>
					</td>
					<td>
						<?php 
						if($item['Billing']['payment_target'] == '0000-00-00' || empty($item['Billing']['payment_target'])) {
							echo '-';
						} else {
							echo $this->Time->format($item['Billing']['payment_target'], '%d.%m.%Y'); 
						}
						?>
					</td>
					<td>
						<?php 
						if($item['Billing']['payment_date'] == '0000-00-00' || empty($item['Billing']['payment_date'])) {
							echo '-';
						} else {
							echo $this->Time->format($item['Billing']['payment_date'], '%d.%m.%Y'); 
						}
						?>
					</td>
					<!--<td><?php echo $item['Confirmation']['discount']; ?>&nbsp;</td>
					<td><?php echo $item['Confirmation']['delivery_cost']; ?>&nbsp;</td>-->
					
					<!-- Auftragsbestätigung-Nummer -->
					<td>
						<?php 
							
							if(empty($item['Cart']['count']) || $item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['confirmation_price'])) {
								echo '-';
							} else {
								 echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
								 data-content="'.$item['Confirmation']['confirmation_number'].'"
								 data-trigger="hover"></i>', 
								 array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));
								
							}
							  
						 ?>
					</td>
					<!-- Lieferschein-Nummer -->
					<td>
						<?php 
							if(empty($item['Cart']['count']) || $item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['confirmation_price'])) {
								echo '-';
							} else {
								 echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
								 data-content="'.$item['Billing']['delivery_number'].'"
								 data-trigger="hover"
							
							></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));
								
								
								
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