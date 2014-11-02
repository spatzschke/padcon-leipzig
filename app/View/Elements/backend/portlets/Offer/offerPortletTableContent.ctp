<?php	
	foreach ($offers as $offerItem):
	
		if($offerItem['Offer']['cart_id'] != 0) {	
?>
				<tr>
					<td>
					<?php 
						if($offerItem['Offer']['status'] == "open") {
							echo '<i class="glyphicon glyphicon-open"  style="color: grey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Offen"
								 data-trigger="hover"
							></i>';
						} 
						elseif($offerItem['Offer']['status'] == "close") {
							echo '<i class="glyphicon glyphicon-lock" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Abgeschlossen"
								 data-trigger="hover"
							></i>';
						}
						elseif($offerItem['Offer']['status'] == "active") {
							echo '<i class="glyphicon glyphicon-asterisk" style="color: green; font-size: 20px; margin-left: -3px; cursor: pointer"
								 data-toggle="popover"
								 data-content="Aktiv"
								 data-trigger="hover"
							></i>';
						}elseif($offerItem['Offer']['status'] == "") {
							echo '<i class="glyphicon glyphicon-ban-circle" style="color: lightgrey; cursor: pointer"
								 data-toggle="popover"
								 data-content="Unvollständig"
								 data-trigger="hover"
							></i>';
						}
					?>
						
					</td>
					<td>
						<?php if(empty($offerItem['Offer']['offer_number'])) {
							 echo '-'; 
							} else {
								if($offerItem['Offer']['status'] == "active") {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'active'), array('escape' => false));
								} elseif($offerItem['Offer']['status'] != "") {
									echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'view', $offerItem['Offer']['id']), array('escape' => false));
								}
								echo '&nbsp;&nbsp;&nbsp;';
								echo $offerItem['Offer']['offer_number'];	
							
							}
						?>
					</td>
					<td>
						<?php 						
						if(!is_null($offerItem['Customer']['id'])) {
							
							if(empty($offerItem['Offer']['customer_id'])) { echo '-'; } else {
								echo $offerItem['Offer']['customer_id'];	
								echo '&nbsp;';
								echo '<i class="glyphicon glyphicon-info-sign" style="color: lightblue; cursor: pointer"
									 data-toggle="popover"
									 data-content="';
									 	if(!empty($offerItem['Customer']['organisation_count'])) {
											for ($i = 0; $i < $offerItem['Customer']['organisation_count']; $i++) {
												echo $offerItem['Customer']['organisation_'.$i].'<br>';
											}
										}
										if(!empty($offerItem['Customer']['department_count'])) {
											for ($i = 0; $i < $offerItem['Customer']['department_count']; $i++) {
												echo $offerItem['Customer']['department_'.$i].'<br>';
											}
										}
									 	echo 		 $offerItem['Customer']['name'].'<br>'.
													 $offerItem['Customer']['phone'].'<br>'.
													 $offerItem['Customer']['email'].
									 '"
									 data-trigger="hover"
								
								></i>';
							}
						} else { echo '-'; } 
						 ?>
					</td>
					<td>
						<?php 
						if($offerItem['Offer']['request_date'] == '0000-00-00') {
							echo '-';
						} else {
							echo $this->Time->format($offerItem['Offer']['request_date'], '%d.%m.%Y'); 
						}
						?>
					</td>
					<td>
						<?php 
						$cartProducts = "";
						foreach ($offerItem['Cart']['CartProduct'] as $cartProduct) {
							$cartProducts = $cartProducts . $cartProduct['amount'].'x '. $cartProduct['Information']['Product']['name'] . ' ( '.$cartProduct['Information']['Product']['product_number'].' )<br>';
						}						
						if(empty($offerItem['Cart']['count'])) { echo '-'; } else {
							echo $offerItem['Cart']['count'];	
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
					<!--<td><?php echo $offerItem['Offer']['discount']; ?>&nbsp;</td>
					<td><?php echo $offerItem['Offer']['delivery_cost']; ?>&nbsp;</td>-->
					<td style="text-align: right; width: 130px">
						
						<?php 
						$priceInfo = 'Gesamtpreis: '.$this->Number->currency($offerItem['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 $offerItem['Offer']['discount'].'% Rabatt: '.$this->Number->currency($offerItem['Offer']['discount_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Versandkostenvorteil: '.$this->Number->currency($offerItem['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Zwischensumme: '.$this->Number->currency($offerItem['Offer']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 '+'.$offerItem['Offer']['vat'].'% Mehrwertsteuer: '.$this->Number->currency($offerItem['Offer']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ',')).'<br>'.
									 'Angebotswert: '.$this->Number->currency($offerItem['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));					
						if(empty($offerItem['Cart']['count'])) { echo '-'; } else {
							echo $this->Number->currency($offerItem['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));	
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
							
							if(empty($offerItem['Cart']['count']) || $offerItem['Offer']['request_date'] == '0000-00-00' || empty($offerItem['Offer']['customer_id']) || empty($offerItem['Offer']['offer_number']) || empty($offerItem['Offer']['offer_price'])) {
								echo '-';
							} else {
								echo $this->Html->link('Auftragsbestätigung hinzufügen', array('controller' => 'Confirmations', 'action' => 'convertOffer', 'admin' =>'true', $offerItem['Offer']['id']),
																	array('class' => 'btn btn-default')); 
							}
							  
						 ?>
					</td>
					<td><?php echo $this->Time->format($offerItem['Offer']['created'], '%d.%m.%Y'); ?></td>
					<!-- <td><?php echo $offerItem['Offer']['modified']; ?>&nbsp;</td> -->
					
					
					<?php
						
							echo '<td class="actions">';
							
							if(!empty($offerItem['Offer']['offer_number']))
								echo $this->Html->link('<i class="glyphicon glyphicon-print"></i>', array('admin' => true, 'controller' => 'Offers', 'action' => 'createPdf', $offerItem['Offer']['id']), array('escape' => false, 'target' => '_blank'));
							
							echo '</td>';
						
						
					?>
									
				</tr> 
				<?php } endforeach; ?>