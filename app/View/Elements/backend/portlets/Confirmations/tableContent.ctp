<?php	
	foreach ($data as $item):
	
	
	
		if($item['Confirmation']['customer_id'] != 0) {
						
?>
				<tr>
					
					<td>
						<?php echo $this->element('backend/helper/tableStatusHelper', array('status' => $item['Confirmation']['status'], 'custom' => $item['Confirmation']['custom']));	?>	
					</td>
					<td>
						<?php if(empty($item['Confirmation']['confirmation_number'])) {
							 echo '-'; 
							} else {
								if(empty($item['Confirmation']['delivery_id'])) {
									if($item['Confirmation']['custom']){
										echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'edit_individual', $item['Confirmation']['id']), array('escape' => false));
									} else {
										echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'edit', $item['Confirmation']['id']), array('escape' => false));	
									}
									
								} else {
									
									if($item['Confirmation']['custom']){
										echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'edit_individual', $item['Confirmation']['id']), array('escape' => false));
									} else {		
										echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Confirmation']['id']), array('escape' => false));
									}
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
								if(!is_null($item['Address']['id'])) {
									echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer"
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
								echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer"
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
						
							if($item['Confirmation']['custom']){
								echo $this->Number->currency($item['Confirmation']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
							} else {
								if(is_null($item['Confirmation']['confirmation_price'])) { echo '-'; } else {
									echo $this->Number->currency($item['Confirmation']['confirmation_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
									echo '&nbsp;';
									echo '<i class="glyphicon glyphicon-info-sign" style="color: teal; cursor: pointer"
										 data-toggle="popover" 
										 data-content="'.
										 	$priceInfo.
										 '"
										 data-trigger="hover"
									
									></i>';
								}
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
					<td style="width: 0">
						<?php 
							
							if($item['Confirmation']['order_date'] == '0000-00-00' || empty($item['Confirmation']['customer_id']) || empty($item['Confirmation']['confirmation_price'])) {
								echo '-';
							} else {
								if(sizeof($item['Process']) == 1) {									
									if(!$item['Process'][0]['delivery_id'] && $item['Process'][0]['billing_id']) {
										echo '<i class="glyphicon glyphicon-briefcase" data-toggle="popover" style="color: teal; cursor: pointer"
											data-content="Lieferung durch den Hersteller"
											data-trigger="hover"></i>';
									} else {
										
										if(!$item['Confirmation']['delivery_id']) {											
											if($item['Confirmation']['custom']){
												$linkLieferschein = $this->Html->link('Lieferschein erstellen', '/admin/Deliveries/add_individual/'.$item['Confirmation']['id'], array('escape' => false, 'class' => 'btn btn-default'));	
												$linkLieferscheinDurchHersteller = $this->Html->link('Lieferung durch Hersteller', '/admin/Billings/add_individual/'.$item['Confirmation']['id'], array('escape' => false, 'class' => 'btn btn-default'));	
											} else {
												$linkLieferschein = $this->Html->link('Lieferschein erstellen', '/admin/Deliveries/convert/'.$item['Confirmation']['id'], array('escape' => false, 'class' => 'btn btn-default'));	
												$linkLieferscheinDurchHersteller = $this->Html->link('Lieferung durch Hersteller', '/admin/Billings/convert/'.$item['Confirmation']['id'], array('escape' => false, 'class' => 'btn btn-default'));													
											}
											
											echo '
											<div id="delivery_drop_btn" class="input-group">
											
											<a id="dLabel" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="btn btn-default">
												Lieferschein
											    <span class="caret"></span>
											</a>
									
											<ul class="dropdown-menu" aria-labelledby="dLabel" style="top: -3px; left: 101%; padding: 5px 5px 0 5px">';

													echo $this->element('backend/helper/sheetButtonHelper', array(
														"id" => 'createDelivery',
														"icon" => "file",
														"href" => $linkLieferschein));
												
										
													echo $this->element('backend/helper/sheetButtonHelper', array(
														"id" => 'createBilling',
														"icon" => "briefcase",
														"href" => $linkLieferscheinDurchHersteller));
											echo '</ul></div>';
										} else {
											echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
											data-content="'.$item['Delivery']['delivery_number'].'"
											data-trigger="hover"></i>', 
											array('admin' => true, 'controller' => 'Deliveries', 'action' => 'view', $item['Confirmation']['delivery_id']), array('escape' => false));
										}
									}
								} else {
									
									if(sizeof($item['Process']) > 1) {
										
										$deliveryNumbers = '';
										foreach($item['Process'] as $key => $del) {											
											if(is_array($del) && $del['delivery_id'] != '0' ){
												$deliveryNumbers .= 'Teillieferschein: '.$del['delivery_number'].'<br>';
											}
										}
										
										echo '<i class="glyphicon glyphicon-duplicate" data-toggle="popover" style="color: teal; cursor: pointer"
											data-content="Mehrere Teil-Lieferscheine vorhanden. <br>'.$deliveryNumbers.'"
											data-trigger="hover"></i>';
																			
										
									} else {
										if($item['Process'][0]['type'] == 'part') {
											echo '<i class="glyphicon glyphicon-duplicate" data-toggle="popover" style="color: teal; cursor: pointer"
											data-content="Erster Teil-Lieferscheine vorhanden."
											data-trigger="hover"></i>';
										} elseif($item['Confirmation']['custom']){
											echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
											data-content="'.$item['Delivery']['delivery_number'].'"
											data-trigger="hover"></i>', 
											array('admin' => true, 'controller' => 'Deliveries', 'action' => 'edit_individual', $item['Confirmation']['delivery_id']), array('escape' => false));
										} elseif(!$item['Process'][0]['delivery_id']) {
											echo '<i class="glyphicon glyphicon-briefcase" data-toggle="popover" style="color: teal; cursor: pointer"
											data-content="Lieferung durch den Hersteller"
											data-trigger="hover"></i>';
										} else {
											echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
											data-content="'.$item['Delivery']['delivery_number'].'"
											data-trigger="hover"></i>', 
											array('admin' => true, 'controller' => 'Deliveries', 'action' => 'view', $item['Confirmation']['delivery_id']), array('escape' => false));
										}	
									}
								}
									
								
							}
							  
						 ?>
					</td>
					<td><?php echo $this->Time->format($item['Confirmation']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $item['Confirmation']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							if(!$item['Confirmation']['custom']){
								if(!empty($item['Confirmation']['offer_number']))
									echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'createPdf', $item['Confirmation']['id']), array('escape' => false, 'target' => '_blank'));
								
								if(!empty($item['Confirmation']['hash']))
									echo $this->Html->link('<i class="glyphicon glyphicon-link" ></i>', '/Auftrag/'.$item['Confirmation']['hash'], array('class' => 'clipboard', 'escape' => false, 'target' => '_blank'));
							
								if(!empty($item['Confirmation']['hash']))
									echo $this->Html->link('<i class="glyphicon glyphicon-envelope"></i>', '/Auftrag/'.$item['Confirmation']['hash'], array('class' => 'mail', 'escape' => false, 'target' => '_blank'));
							}
							
							echo $this->Html->link('<i class="tableSetting_btn glyphicon glyphicon-cog"></i>', array('admin' => true, 'controller' => 'Confirmations', 'action' => 'table_setting', $item['Confirmation']['id']), array('escape' => false));
							
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>