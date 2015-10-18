<?php	
	foreach ($offers as $item):
	
		if($item['Offer']['cart_id'] != 0) {	
?>
				<tr>
					<td>
					<?php 
						if($item['Offer']['status'] == "open") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Offen"
								 data-trigger="hover"
							></i>';
						} 
						elseif($item['Offer']['status'] == "close") {
							echo '<i class="glyphicon glyphicon-lock" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Abgeschlossen"
								 data-trigger="hover"
							></i>';
						}
						elseif($item['Offer']['status'] == "active") {
							echo '<i class="glyphicon glyphicon-asterisk" style="color: green; font-size: 20px; margin-left: -3px; cursor: pointer"
								 data-toggle="popover"
								 data-content="Aktiv"
								 data-trigger="hover"
							></i>';
						}elseif($item['Offer']['status'] == "") {
							echo '<i class="glyphicon glyphicon-ban-circle" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Unvollständig"
								 data-trigger="hover"
							></i>';
						}
					?>
						
					</td>
					<td>
						<?php if(empty($item['Offer']['offer_number'])) {
							 echo '-'; 
							} else {
								if($item['Offer']['status'] == "active") {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'active'), array('escape' => false));
								} elseif($item['Offer']['status'] != "") {
									echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'edit', $item['Offer']['id']), array('escape' => false));
								}
								echo '&nbsp;&nbsp;&nbsp;';
								echo $item['Offer']['offer_number'];	
							
							}
						?>
					</td>
					<td>
						<?php 						
						if(!is_null($item['Customer']['id'])) {
							
							if(empty($item['Offer']['customer_id'])) { echo '-'; } else {
								echo $item['Offer']['customer_id'];	
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
									 '"
									 data-trigger="hover"
								
								></i>';
							}
						} else { echo '-'; } 
						 ?>
					</td>
					<td>
						<?php 
						if($item['Offer']['request_date'] == '0000-00-00') {
							echo '-';
						} else {
							echo $this->Time->format($item['Offer']['request_date'], '%d.%m.%Y'); 
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
					<!--<td><?php echo $item['Offer']['discount']; ?>&nbsp;</td>
					<td><?php echo $item['Offer']['delivery_cost']; ?>&nbsp;</td>-->
					<td style="text-align: right; width: 130px">
						
						<?php 
						$priceInfo = 'Gesamtpreis: '.$this->Number->currency($item['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 $item['Offer']['discount'].'% Rabatt: '.$this->Number->currency($item['Offer']['discount_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Versandkostenvorteil: '.$this->Number->currency($item['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Zwischensumme: '.$this->Number->currency($item['Offer']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 '+'.$item['Offer']['vat'].'% Mehrwertsteuer: '.$this->Number->currency($item['Offer']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Angebotswert: '.$this->Number->currency($item['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));					
						if(empty($item['Cart']['count'])) { echo '-'; } else {
							echo $this->Number->currency($item['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
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
						<?php 
							
							if(empty($item['Cart']['count'])  || empty($item['Offer']['customer_id']) || empty($item['Offer']['offer_number']) || empty($item['Offer']['offer_price'])) {
								echo '-';
							} else {
								if(empty($item['Offer']['confirmation_id'])) {
									echo $this->Html->link('AB hinzufügen', array('controller' => 'Confirmations', 'action' => 'convert', 'admin' =>'true', $item['Offer']['id']),
																	array('class' => 'btn btn-default')); 	
								} else {
									echo $this->Html->link('<i class="glyphicon glyphicon-search" data-toggle="popover" 
									data-content="'.$item['Confirmation']['confirmation_number'].'"
									data-trigger="hover"></i>', 
									array('admin' => true, 'controller' => 'Confirmations', 'action' => 'view', $item['Offer']['confirmation_id']), array('escape' => false));
								}
									
								
							}
							  
						 ?>
					</td>
					<td><?php echo $this->Time->format($item['Offer']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $item['Offer']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							
							if(!empty($item['Offer']['offer_number']))
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'createPdf', $item['Offer']['id']), array('escape' => false, 'target' => '_blank'));
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>