<?php 
	$cart = $this->requestAction('Carts/get_active_cart/');
?>

		
	
<?php 
	$i = 0;

	foreach($cart['CartProduct'] as $cartProduct) {
		
		$i++;
		
		$product = $this->requestAction('Products/getProduct/'.$cartProduct['product_id']);
		$color = $this->requestAction('Colors/getColor/'.$cartProduct['color_id']);
		$material = $this->requestAction('Materials/getMaterial/'.$product['Product']['material_id']);
		$size = $this->requestAction('Sizes/getSize/'.$product['Product']['size_id']);
		$features = $this->requestAction('Products/seperatFeatureList/'.$cartProduct['product_id']);


		
		echo '<tr class="cartProductHeader"> 
			<td class="pos">'.$i.'</td>
			<td class="amount">'.$cartProduct['amount'].'</td>
			<td class="number"><input type="text" class="productNumber" value="pd-'.$product['Product']['product_number'].'-'.$color['Color']['code'].'" /> </br><input type="text" value="Fa. padcon" /></td>
			<td colspan="4">
				<input class="productName text" type="text" value="'.$product['Product']['name'].'" /><br />';
				
			foreach($features as $fea)	{
			
				echo '<input class="text" type="text" value="'.$fea.'" /><br />';
			
			}
				
				
		echo '
				<input class="text" type="text" value="Bezug: '.$material['Material']['name'].', Farbe: '.$color['Color']['name'].'" />
			</td>
		</tr>';
		echo '<tr class="cartProductFooter"> 
			<td colspan="3">&nbsp;</td>
			
			<td><input type="text" value="Maße: '.$size['Size']['name'].'" /></td>
			<td class="price"><input type="text" value="'.number_format($product['Product']['retail_price'], 2, ",", ".").'" /> €</td>
			<td class="sum_price">'.number_format(floatVal($product['Product']['retail_price'])*intVal($cartProduct['amount']), 2, ",", ".").' €</td>
		</tr>';
	}				
							
?>								
			