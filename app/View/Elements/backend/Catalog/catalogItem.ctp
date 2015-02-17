<?php 
	$präfix_number = 'PD-';
	$präfix_material = 'Bezug: ';
	$präfix_color = 'Farbe';
	$präfix_size = 'Maße: ';
	$catalogItemFeaturesHeader = 'Eigenschaften';
?>		

<div id="p<?php echo $product['Product']['product_number'];?>" class="catalogListItem catalogListItem-<?php echo $product['Category']['short'];?> col-md-12">
    
    	<div class="col-md-3">
    		&nbsp;
    	</div>
    	<div class="catalogItemContent col-md-6"> 
	        <div class="catalogItemName"><?php echo $product['Product']['name'];?></div>
			<div class="catalogItemFeatures">
	        	<ul>
	            	<?php echo $product['Product']['featurelist'];?>
	            </ul>
	        </div>
	        <?php if(!empty($product['Material']['name'])) {?>
	            <div class="catalogItemMaterial">
					<?php echo $präfix_material;?>
					<?php echo $product['Material']['name'];?>
					 Farbe laut Farben-Index
				</div>
			<?php }?>
	        <div class="catalogItemSize">
	        	<?php echo $präfix_size;?><?php echo $product['Product']['size']; ?>
	        
	        <div class="catalogItemPrice">
	        	<?php if($this->data['Price']) {
	        		echo $this->Number->currency($product['Product']['retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));
	        	} ?>
	        </div>
	        </div>
	        <div class="catalogItemNumber">
	    		<b><?php echo $präfix_number;?><?php echo $product['Product']['product_number'];?></b>-xx
	    	</div>
        </div>
        
        <div class="catalogItemImage col-md-3">	
        	
        	
        	<?php 
        	if(empty($product["Image"])) {
				echo '<img src="'.$this->webroot.'img/no_pic.png" alt="'.$product['Product']['name'].'"  style="border-color: #'.$product['Category']['color'].'"/>';
			} else {
				echo '<img src="'.$product["Image"][0]["path"].'.'.$product["Image"][0]["ext"].'" alt="'.$product['Product']['name'].'" style="border-color: #'.$product['Category']['color'].'" />'; 
			} ?>
        	
        	</div>
        

	
</div>