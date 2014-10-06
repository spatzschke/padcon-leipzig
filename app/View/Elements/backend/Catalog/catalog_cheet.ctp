<?php
	
	$catalog = $this->data['Catalog'];
	
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
		echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'information'));
		$page++;
		echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'lagerung'));
		$page++;
		// echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'agb'));
		// $page++; $page++; $page++;
		echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page + $Anzahl_Sonderseiten, 'type' => 'waschanleitung'));
		$page++;
		
		foreach ($catalog['Products'] as $catalogi) {
				
			if(($i % $productsPerPage) == 0 ) {	
				$page++;
?>

	<article class="module width_full sheet noInput<?php if((ceil($catalog['count'] / $productsPerPage)) == $page) { echo ' last';}?>">
		
		<div class="sheetHeader">	
			<div class="logo"><?php echo $this->Html->image('backend/backend_logo.png', array('alt' => 'Adminbereich'))?></div>
			<div class="bandage" style="background-color: #<?php echo $this->data['Category']['color'];?>; border-color: #<?php echo $this->data['Category']['color'];?>"></div>
		</div>

		
		<div class="sheetContent">
			<?php

			if($catalogi != 'empty') {
				for($j = ($page - 1 ) * $productsPerPage; $j < $page * $productsPerPage; $j++) {

				if(!empty($catalog['Products'][$j])) {
				
						$catalogProduct = $catalog['Products'][$j];
						$catalogProduct['Category'] = $this->data['Category'];

						echo $this->element('backend/Catalog/catalogItem', array('product' => $catalogProduct));;
					}
				}		
			}
									
			?>	
		</div>
		<div class="sheetFooter">	
			<div class="bandage">
				<span><?php echo $page; ?></span>
			</div>
		</div>
	</article>

<?php 
		}
		$i++;
	}
}
	echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page, 'type' => 'color'));
	$page++;
	echo $this->element('backend/Catalog/sonderseiten_cheet', array('page' => $page, 'type' => 'material'));
	$page++;

	echo $this->element('backend/Catalog/ruckseite_cheet', array('page' => $page, 'color' => $this->data['Category']['color'], 'categories' => $this->data['Categories'], 'category_id' => $this->data['Category']['id']));
		
?>