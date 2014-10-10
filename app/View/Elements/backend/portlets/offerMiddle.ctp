<div class="offerMiddle">
				<?php
				if($carti != 'empty') {
					for($j = ($page - 1 ) * $productsPerPage; $j < $page * $productsPerPage; $j++) {

					if(!empty($cart['CartProduct'][$j])) {
					
						$cartProduct = $cart['CartProduct'][$j];

						$product = $this->requestAction('Products/getProduct/'.$cartProduct['product_id']);
						$color = $this->requestAction('Colors/getColor/'.$cartProduct['color_id']);
						$material = $this->requestAction('Materials/getMaterial/'.$product['Product']['material_id']);
						$size = $this->requestAction('Sizes/getSize/'.$product['Product']['size_id']);
						$features = $this->requestAction('Products/seperatFeatureList/'.$cartProduct['product_id']);

						echo '
						<div class="sheetItem">
							<div class="pos">'.($j+1).'</div>
							<div class="amount">'.$cartProduct['amount'].'</div>
							<div class="number">
								<input type="text" class="productNumber col-md-12" value="pd-'.$product['Product']['product_number'].'-'.$color['Color']['code'].'" /> </br><input type="text" value="Fa. padcon" class="col-md-12"/>
							</div>
							<div class="content">
									<input class="productName text col-md-12" type="text" value="'.$product['Product']['name'].'" /><br />';
									foreach($features as $fea)	{
										echo '<input class="text col-md-12" type="text" value="'.$fea.'" /><br />';
									}
									echo '<input class="text col-md-12" type="text" value="Bezug: '.$material['Material']['name'].', Farbe: '.$color['Color']['name'].'" />
								<div class="size"><input type="text" value="Maße: '.$size['Size']['name'].'" /></div>
								<div class="price"><input type="text" value="'.number_format($product['Product']['retail_price'], 2, ",", ".").'" /> €</div>
								<div class="sum_price">'.number_format(floatVal($product['Product']['retail_price'])*intVal($cartProduct['amount']), 2, ",", ".").' €</div>
							</div>
						</div>

						';
						}
					}		
										
				?>	
		<?php }	?>
		</div>