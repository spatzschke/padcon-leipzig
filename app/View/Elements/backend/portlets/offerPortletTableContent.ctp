<?php	foreach ($offers as $product):?>
									
				
				<tr>
					<td>
					<?php 
						if($product['Offer']['status'] == "open") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Offen"
								 data-trigger="hover"
							></i>';
						} 
						elseif($product['Offer']['status'] == "close") {
							echo '<i class="glyphicon glyphicon-lock" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Abgeschlossen"
								 data-trigger="hover"
							></i>';
						}
						elseif($product['Offer']['status'] == "active") {
							echo '<i class="glyphicon glyphicon-asterisk" style="color: green; font-size: 20px; margin-left: -3px; cursor: pointer"
								 data-toggle="popover"
								 data-content="Aktiv"
								 data-trigger="hover"
							></i>';
						}elseif($product['Offer']['status'] == "") {
							echo '<i class="glyphicon glyphicon-ban-circle" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Unvollständig"
								 data-trigger="hover"
							></i>';
						}
					?>
						
					</td>
					<td>
						<?php if(empty($product['Offer']['offer_number'])) {
							 echo '-'; 
							} else {
								if($product['Offer']['status'] == "active") {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'active'), array('escape' => false));
								} elseif($product['Offer']['status'] != "") {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'view', $product['Offer']['id']), array('escape' => false));
								}
								echo '&nbsp;&nbsp;&nbsp;';
								echo $product['Offer']['offer_number'];	
							
							}
						?>
					</td>
					<td>
						<?php 
							
							$name = $product['Customer']['salutation'].' '.$product['Customer']['title'].' '.$product['Customer']['first_name'].' '.$product['Customer']['last_name']; 
							$city = $product['Customer']['postal_code']. ' '.$product['Customer']['city'];
						
						if(empty($product['Offer']['customer_id'])) { echo '-'; } else {
							echo $product['Offer']['customer_id'];	
							echo '&nbsp;';
							echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
								 data-toggle="popover"
								 data-content="'.
								 	$product['Customer']['organisation'].'<br>'.
								 	$product['Customer']['department'].'<br>'.
								 	$name.'<br>'.
									$product['Customer']['street'].'<br>'.
									$city.
								 '"
								 data-trigger="hover"
							
							></i>';
						} ?>
					</td>
					<td>
						<?php 
						if($product['Offer']['request_date'] == '0000-00-00') {
							echo '-';
						} else {
							echo $this->Time->format($product['Offer']['request_date'], '%d.%m.%Y'); 
						}
						?>
					</td>
					<td>
						<?php 
						$cartProducts = "";
						foreach ($product['Cart']['CartProduct'] as $cartProduct) {
							$cartProducts = $cartProducts . $cartProduct['amount'].'x '. $cartProduct['Information']['Product']['name'] . ' ( '.$cartProduct['Information']['Product']['product_number'].' )<br>';
						}						
						if(empty($product['Cart']['count'])) { echo '-'; } else {
							echo $product['Cart']['count'];	
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
					<!--<td><?php echo $product['Offer']['discount']; ?>&nbsp;</td>
					<td><?php echo $product['Offer']['delivery_cost']; ?>&nbsp;</td>-->
					<td style="text-align: right; width: 130px">
						
						<?php 
						$priceInfo = 'Gesamtpreis: '.$this->Number->currency($product['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Rabatt: '.$this->Number->currency($product['Offer']['discount'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Versandkostenvorteil: '.$this->Number->currency($product['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Zwischensumme: '.$this->Number->currency($product['Offer']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 '+'.$product['Offer']['vat'].'% Mehrwertsteuer: '.$this->Number->currency($product['Offer']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Angebotswert: '.$this->Number->currency($product['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));					
						if(empty($product['Cart']['count'])) { echo '-'; } else {
							echo $this->Number->currency($product['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
							echo '&nbsp;';
							echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
								 data-toggle="popover" 
								 data-content="'.
								 	$priceInfo.
								 '"
								 data-trigger="hover"
							
							></i>';
						} ?>	
					</td>
					<td>
						<?php if(empty($product['Offer']['billing_id'])) { echo '-'; } else { echo $product['Billing']['billing_number'];	} ?>
					</td>
					<td>
						<?php if(empty($product['Offer']['delivery_id'])) { echo '-'; } else { echo $product['Delivery']['delivery_number'];	} ?>
					</td>
					<td><?php echo $this->Time->format($product['Offer']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $product['Offer']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							
							if(!empty($product['Offer']['offer_number']))
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'createPdf', $product['Offer']['id']), array('escape' => false, 'target' => '_blank'));
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php endforeach; ?>