<?php 
	$cart = $this->requestAction('Carts/get_active_cart/');
	$page = 0;
	$productsPerPage = 2;
	$i = 0;
?>
<?php 
	foreach ($cart['CartProduct'] as $carti) { 
		
		if(($i % $productsPerPage) == 0 ) {	
			$page++;
?>


	<article class="module width_full offer">
		
		<div class="sheetHeader module_content row-fluid">	
			<div class="title span8">	
				padcon Leipzig-Ralf Patzschke <br />
				<span class="small">Fachhandel und Service für medizinische Einrichtungen</span>
			</div>
			<div class="logo span4">	
				<?php echo $this->Html->image('backend/backend_logo.png', array('alt' => 'padcon Leipzig'))?>
			</div>
		</div>

		<div class="customerData module_content row-fluid">

			<div class="firstItem span6">	
				<div class="addressHeader">padcon Leipzig • Holunderweg 4 • 04416 Markkleeberg</div>
				<?php e($this->element('backend/portlets/customerSearchPortlet')); ?>
			</div>
			<div class="span6">	
				<?php e($this->element('backend/portlets/offerInfoPortlet', array('page' => $page, 'maxPage' => ceil($cart['Cart']['count'] / $productsPerPage)))); ?>
			</div>
		</div>
		<div class="module_content row-fluid">
		
			<div class="offerHeader">
				<div class="pos"><?php __('POS');?></div>
				<div class="amount"><?php __('STÜCK');?></div>	
				<div class="number"><?php __('BEST.NR.');?></div>	
				<div class="content"><?php __('ARTIKEL');?></div>	
				<div class="price"><?php __('PREIS');?></div>	
				<div class="sum_price"><?php __('GESAMTPREIS');?></div>	
			</div>
			<p class="offerText"><input type="text" class="text" value="Bezug nehmend auf Ihre Anfrage vom 06.09.2012 unterbreiten wir Ihnen folgendes Angebot:" /> </p>
			<div class="offerMiddle">
				<?php

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
								<input type="text" class="productNumber span12" value="pd-'.$product['Product']['product_number'].'-'.$color['Color']['code'].'" /> </br><input type="text" value="Fa. padcon" class="span12"/>
							</div>
							<div class="content">
									<input class="productName text span12" type="text" value="'.$product['Product']['name'].'" /><br />';
									foreach($features as $fea)	{
										echo '<input class="text span12" type="text" value="'.$fea.'" /><br />';
									}
									echo '<input class="text span12" type="text" value="Bezug: '.$material['Material']['name'].', Farbe: '.$color['Color']['name'].'" />
								<div class="size"><input type="text" value="Maße: '.$size['Size']['name'].'" /></div>
								<div class="price"><input type="text" value="'.number_format($product['Product']['retail_price'], 2, ",", ".").'" /> €</div>
								<div class="sum_price">'.number_format(floatVal($product['Product']['retail_price'])*intVal($cartProduct['amount']), 2, ",", ".").' €</div>
							</div>
						</div>

						';
						}
					}		
										
				?>	
			</div>
			<div class="offerFooter"> 

				<?php 
					$price = floatVal($cart['Cart']['sum_retail_price']);
					$vat = $price * 0.19;
					$offerPrice = $price + $vat;	
				?>

				<div>
					<label><?php __('Gesamtpreis');?></label>
					<p class="sum_price"><?php echo number_format($price, 2, ",", ".");?> €</p>
				</div>
				<div>
					<label><?php __('+19% Mehrwertsteuer:');?></label>
					<p class="sum_price"><?php echo number_format($vat, 2, ",", ".");?> €</p>
				</div>
				<div>
					<label><?php __('Angebotswert');?></label>
					<p class="sum_price"><span class="double"><?php echo number_format($offerPrice, 2, ",", ".");?> €</span></p>
				</div>
			</div>

			<div class="aditionalContent">
				<textarea value="">
				</textarea>
			</div>

		</div>
		<div class="sheetFooter row-fluid">
			
			<div class="span3">
				padcon Leipzig<br />
				Holunderweg 4 <br />
				04416 Markkleeberg<br />
				<br />
			</div>
			<div class="span3">
				Tel.: 03 41 – 3 58 18 02<br />
				Fax: 03 41 – 3 58 18 95<br />
				Mobil: 01 72 – 9 37 74 44<br />
				e-mail: info@padcon-leipzig.de<br />
				www.padcon-leipzig.de
			</div>
			<div class="span3">
				Sparkasse Leipzig<br />
				BLZ 860 555 92<br />
				Kto.-Nr.: 1100 518 130<br />
				<br />
			</div>
			<div class="span3">
				St.-Nr. 235 255/01558<br />
				USt-IdNr. DE227327400<br />
				<br />
				<br />
			</div>

		</div>
	</article>

<?php 
		}
		$i++;
	}
?>
