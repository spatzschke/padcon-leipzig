<div class="offerMiddle">
				<?php
				
				if($carti != 'empty') {
					for($j = ($page - 1 ) * $productsPerPage; $j < $page * $productsPerPage; $j++) {


					if(!empty($this->data['CartProduct'][$j])) {
					
						$cartProduct = $this->data['CartProduct'][$j];


						$product = $this->requestAction('Products/getProduct/'.$cartProduct['product_id']);
						$color = $this->requestAction('Colors/getColor/'.$cartProduct['color_id']);
						$material = $this->requestAction('Materials/getMaterial/'.$product['Product']['material_id']);
						$features = $this->requestAction('Products/seperatFeatureList/'.$cartProduct['product_id']);
						
						$product_number_präfix = Configure::read('padcon.product.number.präfix');
						if($product['Product']['custom']) {$product_number_präfix = '';}

						echo '
						<div class="sheetItem">
							<div class="pos">'.($j+1).'</div>
							<div class="amount">'.$cartProduct['amount'].'</div>
							<div class="number">
								<p class=""><span class="productNumber">'.$product['Product']['product_number'].'-'.$color['Color']['code'].'</span></br>Fa. padcon</p>
							</div>
							<div class="content">
									<p class="productName col-md-12"><span >'.$product['Product']['name'].'</span></p>';
									foreach($features as $fea)	{
										echo '<span class="text col-md-12">'.$fea.' </span><br />';
									}
									echo '<span class="text col-md-12">Bezug: '.$material['Material']['name'].', Farbe: '.$color['Color']['name'].'</span>
								<div class="size"><span class="text col-md-12">'.Configure::read('padcon.product.size.präfix').': ';
								if(empty($product['Product']['size'])) {
			            			echo Configure::read('padcon.product.size.noSize');
			            		} else {
			            			echo $product['Product']['size'].Configure::read('padcon.product.size.suffix');
			            		}
								echo '</span></div>
								';
								if($this->request->params['controller'] != "Deliveries") {
								echo '<div class="price"><span type="text">'.number_format($product['Product']['retail_price'], 2, ",", ".").'</span> '.Configure::read('padcon.currency.symbol').'</div>
									<div class="sum_price">'.number_format(floatVal($product['Product']['retail_price'])*intVal($cartProduct['amount']), 2, ",", ".").' '.Configure::read('padcon.currency.symbol').'</div>';							
								}
								echo '</div>
						</div>

						';
						}
					}		
										
				?>	
		<?php }	?>
</div>