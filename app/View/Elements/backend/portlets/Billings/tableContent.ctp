<?php	
	foreach ($data as $item):
	
		if(true) {
			
		$datetime1 = new DateTime();
		$datetime2 = new DateTime($item['Billing']['payment_target']);
		$interval = $datetime1->diff($datetime2);		
		
			
?>
				<tr>
					<td>
						<?php echo $this->element('backend/helper/tableStatusHelper', array('status' => $item['Billing']['status'], 'custom' => $item['Billing']['custom']));	?>
					</td>
					<td>
						<?php if(empty($item['Billing']['billing_number'])) {
							 echo '-'; 
							} else {
								
								if($item['Billing']['custom']){
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Billings', 'action' => 'edit_individual', $item['Billing']['id']), array('escape' => false));
									echo '&nbsp;&nbsp;&nbsp;';
									echo $item['Billing']['billing_number'];
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Billings', 'action' => 'view', $item['Billing']['id']), array('escape' => false));
									echo '&nbsp;&nbsp;&nbsp;';
									echo $item['Billing']['billing_number'];
								}
							}
						?>
					</td>
					<td>
						<?php 						
						if(!is_null($item['Confirmation']['customer_id'])) {
							
							if(empty($item['Confirmation']['customer_id'])) { echo '-'; } else {
								echo $item['Confirmation']['customer_id'];	
								if(!is_null($item['Billing']['address_id']) && $item['Billing']['address_id'] != 0) {
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
					<td>
						<?php 
						$cartProducts = "";
						
	
						if(empty($item['Cart']['count'])) {
							 
							if($item['Billing']['status'] && !empty($item['Confirmation']['customer_id'])){
								echo $this->Number->currency($item['Confirmation']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
							} else {
								echo '-'; 							
							}
						} else {
							
							foreach ($item['Cart']['CartProduct'] as $cartProduct) {
								$cartProducts = $cartProducts . $cartProduct['amount'].'x '. $cartProduct['Information']['Product']['name'] . ' ( '.$cartProduct['Information']['Product']['product_number'].' )<br>';
							}					
	
							$priceInfo = 'Gesamtpreis: '.$this->Number->currency($item['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
										 $item['Confirmation']['discount'].'% Rabatt: '.$this->Number->currency($item['Billing']['discount_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
										 'Versandkostenvorteil: '.$this->Number->currency($item['Billing']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
										 'Zwischensumme: '.$this->Number->currency($item['Billing']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
										 '+'.$item['Confirmation']['vat'].'% Mehrwertsteuer: '.$this->Number->currency($item['Billing']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
										 'Rechnungswert: '.$this->Number->currency($item['Billing']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));					
							
							
							echo $this->Number->currency($item['Billing']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
							echo '&nbsp;';
							echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer"
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
						if($item['Billing']['payment_target'] == '0000-00-00' || $item['Billing']['payment_target'] == '1970-01-01' || empty($item['Billing']['payment_target'])) {
							echo '-';
						} else {
							
							//Zahlungsziel nähert sich an
							if(strcmp($interval->format('%R'),'+') == 0 && $interval->format('%a') < 7 && strpos($item['Billing']['status'], 'open') !== FALSE) {							
								echo '<i class="glyphicon glyphicon-exclamation-sign" style="color: orange; cursor: pointer"
									 data-toggle="popover" 
									 data-content="Zahlungsziel in '.$interval->format('%a').' Tag(en) erreicht!"
									 data-trigger="hover"								
								></i>';
							}
							//Zahlungsziel überschritten
							if(strcmp($interval->format('%R'),'-') == 0 && strpos($item['Billing']['status'], 'open') !== FALSE) {
								
								echo '<i class="glyphicon glyphicon-alert" style="color: red; cursor: pointer"
									 data-toggle="popover" 
									 data-content="Zahlungsziel um '.$interval->format('%a').' Tag(e) überschritten! Mahnen?"
									 data-trigger="hover"
								
								></i>';
							}
							echo '&nbsp;';							
							echo $this->Time->format($item['Billing']['payment_target'], '%d.%m.%Y'); 
						}
						?>
					</td>
					<td>
						<?php 
						if($item['Billing']['payment_date'] == '0000-00-00' || empty($item['Billing']['payment_date']) && $item['Billing']['status'] != 'cancel' ) {
							echo $this->Html->link('Gezahlt', array('controller' => 'Billings', 'action' => 'payed', 'admin' =>'true', $item['Billing']['id']),
																array('class' => 'btn btn-default')); 	
						} else {
							if($item['Billing']['payment_date'] == '0000-00-00' || $item['Billing']['payment_date'] == '1970-01-01' || empty($item['Billing']['payment_date']) ) {
								echo '-';
							} else {
								echo $this->Time->format($item['Billing']['payment_date'], '%d.%m.%Y'); 
							}
						}
						?>
					</td>
					<!--<td><?php echo $item['Confirmation']['discount']; ?>&nbsp;</td>
					<td><?php echo $item['Confirmation']['delivery_cost']; ?>&nbsp;</td>-->
					
					<!-- Auftragsbestätigung-Nummer -->
					<td>
						<?php 
							
							if($item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['confirmation_price'])) {
								echo '-';
							} else {
								
								if($item['Billing']['status']){
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
					<!-- Lieferschein-Nummer -->
					<td>
						<?php 
							if($item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['confirmation_price'])) {
								echo '-';
							} else {
								
								if($item['Billing']['status']){
									echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
									data-content="'.$item['Billing']['delivery_number'].'"
									data-trigger="hover"
									></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'edit_individual', $item['Confirmation']['id']), array('escape' => false));
								
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
									data-content="'.$item['Billing']['delivery_number'].'"
									data-trigger="hover"
									></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));
								
								}
								
								
								
								
							}
							  
						 ?>
					</td>
					
					<td><?php echo $this->Time->format($item['Billing']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $item['Confirmation']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							if(!$item['Billing']['status']){
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Billings', 'action' => 'createPdf', $item['Confirmation']['id']), array('escape' => false, 'target' => '_blank'));
								
								if(!empty($item['Billing']['hash']))
									echo $this->Html->link('<i class="glyphicon glyphicon-link"></i>', '/Rechnung/'.$item['Billing']['hash'], array('escape' => false, 'target' => '_blank'));
							}
							echo $this->Html->link('<i class="tableSetting_btn glyphicon glyphicon-cog"></i>', array('admin' => true, 'controller' => 'Billings', 'action' => 'table_setting', $item['Billing']['id']), array('escape' => false));
							
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>