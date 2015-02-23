<?php
	
	$catalogs = $this->data['Catalogs'];
		
	$Anzahl_Sonderseiten = 1;
	$page = 0 - $Anzahl_Sonderseiten;
	$productsPerPage = 31;
	$i = 0;
	
	$empty_Field_String = 'siehe Katalog';
		
?>
<?php 

	if(!empty($catalogs)) {
		
		//Sonderseiten
		echo $this->element('backend/Catalog/deckblatt_priceList', array('page' => $page + $Anzahl_Sonderseiten));
		$page++;
 
		$sonderseite = $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'information'));
		$sonderseite = split("Stand:", $sonderseite);		
		setlocale(LC_ALL, 'de_DE', 'German_Germany.1252');
		echo $sonderseite[0]."Stand: ".utf8_encode(strftime("%B %Y")).$sonderseite[1];
		
		$page++;
		// echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'lagerung'));
		// $page++;
		// echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'agb'));
		// $page++; $page++; $page++;
		// echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'waschanleitung'));
		// $page++;

	foreach($catalogs as $catalog) {
		
		$categoryPage = 0;
			
		foreach ($catalog['Products'] as $catalogi) {
				
			if(($i % $productsPerPage) == 0 ) {	
				$categoryPage++;
				$page++;
	?>
	
		<article class="module width_full sheet priceList noInput<?php if((ceil($catalog['Catalog']['count'] / $productsPerPage)) == $page) { echo ' last';}?>">
			
			<div class="sheetHeader">	
				<div class="content"><?php echo $catalog['Catalog']['name']; ?></div>
				<div class="logo"><?php echo $this->Html->image('backend/backend_logo.png', array('alt' => 'Adminbereich'))?></div>
				<div class="bandage" style="background-color: #<?php echo $catalog['Category']['color'];?>; border-color: #<?php echo $catalog['Category']['color'];?>"></div>
			</div>
	
			
			<div class="sheetContent">
				
				<div class="tableHead">
	   					
	    			<!--<th><?php __('ID');?></th>-->
						<div class="number"><?php echo('pd-#');?></div>
						<div class="name"><?php echo('Name');?></div>
					<!--<th><?php __('Beschreibung');?></th>
						<th><?php __('Featurelist');?></th>-->
						<div class="material"><?php echo('Material');?></div>
						<div class="size"><?php echo('Größe im cm');?></div>
						<div class="price"><?php echo('Preis');?></div>
					<!--<th><?php __('Neu');?></th>
						<th><?php __('Aktiv');?></th>
						<th><?php __('Erstellt');?></th>
						<th><?php __('Bearbeitet');?></th>-->
				</div> 
				<div class="tableContent">
				<?php
	
				if($catalogi != 'empty') {
					
					for($j = ($categoryPage -1) * $productsPerPage; $j < ($categoryPage) * $productsPerPage; $j++) {
	
					if(!empty($catalog['Products'][$j])) {
					
							$product = $catalog['Products'][$j];
							$product['Category'] = $catalog['Category'];
	
							?>
							<div class="tableEntry">
						<!--<td><?php echo $product['Product']['id']; ?>&nbsp;</td> -->
							<div class="number">PD-<?php echo $product['Product']['product_number']; ?>&nbsp;</div>
							<div class="name"><?php echo $product['Product']['name']; ?>&nbsp;</div>
						<!--<td><?php echo $product['Product']['description']; ?>&nbsp;</td>
							<td><?php echo $product['Product']['featurelist']; ?>&nbsp;</td>-->
						<!--<td><?php echo $product['Category']['name']; ?>&nbsp;</td> -->
						
							<?php
								$material = $product['Material']['name'];							
								if(empty($material)) {
									$material = $empty_Field_String;
								}
							
							?>

						
							<div class="material"><?php echo $material; ?>&nbsp;</div>
							
							<?php
							
								$size = $product['Product']['size'];
								$size = str_replace('cm', '', $size);
								$size = str_replace('Höhe', 'H', $size);
								
								if(empty($size)) {
									$size = $empty_Field_String;
								}
							
							?>
							
							<div class="size"><?php echo $size; ?>&nbsp;</div>
							<div class="price"><?php echo $this->Number->currency($product['Product']['retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></div>
						<!--	<td><?php echo $product['Product']['new']; ?>&nbsp;</td>
							<td><?php echo $product['Product']['active']; ?>&nbsp;</td>
							<td><?php echo $product['Product']['created']; ?>&nbsp;</td>
							<td><?php echo $product['Product']['modified']; ?>&nbsp;</td>-->
							</div>	
							<?php
							
						}
					}		
				}
				
										
				?>	
				</div> 
			</div>
			<div class="sheetFooter">	
				<div class="bandage">
					<span><?php echo $page + $Anzahl_Sonderseiten - 1; ?></span>
				</div>
			</div>
		</article>
	
	<?php 
			}
			$i++;
		}
	}
}
	$page += $Anzahl_Sonderseiten;
	// echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page, 'type' => 'color'));
	// $page++;
	// echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page, 'type' => 'material'));
	// $page++;

	// echo $this->element('backend/Catalog/ruckseite_cheet', array('page' => $page, 'color' => $this->data['Category']['color'], 'categories' => $this->data['Categories'], 'category_id' => $this->data['Category']['id']));
		
?>
