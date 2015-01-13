<?php
	
	$catalog = $this->data['Catalogs'][0]['Catalog'];
	
	$Anzahl_Sonderseiten = 4;
	$page = 0 - $Anzahl_Sonderseiten;
	$productsPerPage = 5;
	$i = 0;
			
?>
<?php 

	if(!empty($catalog)) {
		
		//Sonderseiten
		echo $this->element('backend/Catalog/deckblatt_cheet', array('page' => $page + $Anzahl_Sonderseiten));
		$page++;
		
		$sonderseite = $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'information'));
		$sonderseite = split("Stand:", $sonderseite);
		setlocale(LC_ALL, 'de_DE', 'German_Germany.1252');
		echo $sonderseite[0]."Stand: ".utf8_encode(strftime("%B %Y")).$sonderseite[1];
		
		$page++;
		echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'lagerung'));
		$page++;
		// echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'agb'));
		// $page++; $page++; $page++;
		echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'waschanleitung'));
		$page++;
		
		foreach($this->data['Catalogs'][0]['Products'] as $catalogi) {
				
			if(($i % $productsPerPage) == 0 ) {	
				$page++;
?>

	<article class="module width_full sheet noInput<?php if((ceil($catalog['count'] / $productsPerPage)) == $page) { echo ' last';}?>">
		
		<div class="sheetHeader">	
			<div class="logo"><?php echo $this->Html->image('backend/backend_logo.png', array('alt' => 'Adminbereich'))?></div>
			<div class="bandage" style="background-color: #<?php echo $this->data['Catalogs'][0]['Category']['color'];?>; border-color: #<?php echo $this->data['Catalogs'][0]['Category']['color'];?>"></div>
		</div>

		
		<div class="sheetContent">
			<?php

			if($catalogi != 'empty') {
				for($j = ($page - 1 ) * $productsPerPage; $j < $page * $productsPerPage; $j++) {

				if(!empty($this->data['Catalogs'][0]['Products'][$j])) {
				
						$catalogProduct = $this->data['Catalogs'][0]['Products'][$j];
						$catalogProduct['Category'] = $this->data['Catalogs'][0]['Category'];

						echo $this->element('backend/Catalog/catalogItem', array('product' => $catalogProduct));;
					}
				}		
			}
									
			?>	
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
	$page += $Anzahl_Sonderseiten;
	echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page, 'type' => 'color'));
	$page++;
	echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page, 'type' => 'material'));
	$page++;

	echo $this->element('backend/Catalog/ruckseite_cheet', array('page' => $page, 'color' => $this->data['Catalogs'][0]['Category']['color'], 'categories' => $this->data['Categories'], 'category_id' => $this->data['Catalogs'][0]['Category']['id']));
		
?>