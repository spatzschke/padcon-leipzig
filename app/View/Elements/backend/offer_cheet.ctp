<?php 
	$cart = $this->requestAction('Carts/get_active_cart/');

	$page = 0;
	$productsPerPage = 2;
	$i = 0;
	
?>
<?php 

	if(!empty($cart)) {
		
		if(empty($cart['CartProduct'])) {
			$cart['CartProduct'] = array('empty');	
		}
		
		foreach ($cart['CartProduct'] as $carti) {
				
			if(($i % $productsPerPage) == 0 ) {	
				$page++;
?>


	<article class="module width_full offer noInput<?php if((ceil($cart['Cart']['count'] / $productsPerPage)) == $page) { echo ' last';}?>">
		
		<div class="sheetHeader module_content row">	
			<div class="title col-md-8">	
				padcon Leipzig-Ralf Patzschke <br />
				<span class="small">Fachhandel und Service für medizinische Einrichtungen</span>
			</div>
			<div class="logo col-md-2">	
				<?php  echo $this->Html->image('backend/backend_logo.png', array('alt' => 'padcon Leipzig'))?>
			</div>
		</div>

		<div class="customerData module_content row-fluid">

			<div class="firstItem col-md-6">	
				<div class="addressHeader">padcon Leipzig • Holunderweg 4 • 04416 Markkleeberg</div>
				<?php 
				if(isset($this->data['Offer']['customer_id'])) 
				{
						if(isset($pdf)) {
							echo $this->element('backend/portlets/customerAdressPortlet');
						}else {
							echo $this->element('backend/portlets/customerSearchPortlet');
						}
				} 
					
				?>
			</div>
			<div class="col-md-6">	
				<?php 
					$maxPage = round(ceil($cart['Cart']['count'] / $productsPerPage),0,PHP_ROUND_HALF_UP);
					if($maxPage < 1) {$maxPage = 1;}
				
					 echo $this->element('backend/portlets/offerInfoPortlet', array('page' => $page, 'maxPage' => $maxPage));
					
				?>
			</div>
		</div>
		<div class="module_content row-fluid">
		
			<div class="offerHeader">
				<div class="pos"><?php echo 'POS';?></div>
				<div class="amount"><?php echo 'STÜCK';?></div>	
				<div class="number"><?php echo 'BEST.NR.';?></div>	
				<div class="content"><?php echo 'ARTIKEL';?></div>	
				<div class="price"><?php echo 'PREIS';?></div>	
				<div class="sum_price"><?php echo 'GESAMTPREIS';?></div>	
			</div>
			<?php 
			if(isset($this->data['Offer'])) {
				echo '<p class="offerText"><input type="text" class="text" value="Bezug nehmend auf Ihre Anfrage vom '.$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y').' unterbreiten wir Ihnen folgendes Angebot:" /> </p>';
			}
			?>
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
			</div>
			<?php if(!empty($this->data['Cart'])) { ?>
				
			<div class="offerFooter"> 

				<!-- Gesamtpreis -->
				<div>
					<label><?php echo 'Gesamtpreis:';?></label>
					<p class="sum_price"><?php echo $this->Number->currency($this->data['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
				</div>
				
				<!-- Rabatt -->
				<?php if(isset($this->data['Offer']['discount']) && $this->data['Offer']['discount'] != 0) { ?>
					<div>
						<label><?php echo '-'.$this->data['Offer']['discount'].'% Rabatt:';?></label>
						<p class="discount"><?php echo $this->Number->currency($this->data['Offer']['discount_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
					</div>
				<?php } ?>
				
				<!-- Versandkostenanteil -->
				<div>
					<label><?php echo 'Versandkostenanteil:';?></label>
					<p class="delivery_cost"><?php echo $this->Number->currency($this->data['Offer']['delivery_cost'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
				</div>
				
				<!-- Zwischensumme -->
				<div>
					<label><?php echo 'Zwischensumme:';?></label>
					<p class="part_price"><?php echo $this->Number->currency($this->data['Offer']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
				</div>
				
				<!-- Zwischensumme -->
				<div>
					<label><?php echo '+'.$this->data['Offer']['vat'].'% Mehrwertsteuer:';?></label>
					<p class="vat"><?php echo $this->Number->currency($this->data['Offer']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
				</div>
				
				<!-- Zwischensumme -->
				<div>
					<label><?php echo 'Angebotswert';?></label>
					<p class="sum_price"><span class="double"><?php echo $this->Number->currency($this->data['Offer']['offer_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></span></p>
				</div>
				
			</div>

			<?php } ?>
		
		<?php if(!empty($this->data['Offer']['additional_text'])) { ?>
			<div class="additionalContent">
				<?php echo $this->data['Offer']['additional_text']; ?>
				<br \>
				<br \>
				Über Ihren Auftrag würde ich mich sehr freuen.
			</div>
		<?php } ?>

		<?php
		// END carti IF 
			}
		?>
		</div>
		<div class="sheetFooter row-fluid">
			
			<div class="col-md-2">
				padcon Leipzig<br />
				Holunderweg 4 <br />
				04416 Markkleeberg<br />
				<br />
			</div>
			<div class="col-md-3">
				Tel.: 03 41 – 3 58 18 02<br />
				Fax: 03 41 – 3 58 18 95<br />
				Mobil: 01 72 – 9 37 74 44<br />
				e-mail: info@padcon-leipzig.de<br />
				www.padcon-leipzig.de
			</div>
			<div class="col-md-3">
				Sparkasse Leipzig<br />
				BLZ 860 555 92<br />
				Kto.-Nr.: 1100 518 130<br />
				SWIFT-BIC: WELADE8LXXX<br />
				IBAN: DE40860555921100518130<br />
				<br />
			</div>
			<div class="col-md-3">
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
}
?>
