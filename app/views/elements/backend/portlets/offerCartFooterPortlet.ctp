	
	<?php 
		$cart = $this->requestAction('Carts/get_active_cart/');
		$price = floatVal($cart['Cart']['sum_retail_price']);
		$vat = $price * 0.19;
		$offerPrice = $price + $vat;	
		
		
	?>

			
				
		 	<tr class="offerFooter"> 
				<td colspan="5"><?php __('Gesamtpreis');?></td>
				<td class="sum_price"><?php echo number_format($price, 2, ",", ".");?> €
				</td>
			</tr> 
			<tr class="offerFooter"> 
				<td colspan="5"><?php __('+19% Mehrwertsteuer:');?></td>
				<td class="sum_price"><?php echo number_format($vat, 2, ",", ".");?> €</td>
			</tr>
			<tr class="offerFooter"> 
				<td colspan="5"><?php __('Angebotswert');?></td>
				<td class="sum_price"><span class="double"><?php echo number_format($offerPrice, 2, ",", ".");?> €</span></td>
			</tr>
		
	

		
