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
					<?php echo Configure::read('padcon.product.material.präfix').': ';?>
					<?php echo $product['Material']['name'].', '.Configure::read('padcon.product.farbindex');?>
				</div>
			<?php }?>
	        <div class="catalogItemSize">
	        	<?php if(!empty($product['Product']['size'])) {	?>
	        		<?php echo Configure::read('padcon.product.size.präfix').': ';?><?php echo $product['Product']['size'].Configure::read('padcon.product.size.suffix'); ?>
	        	<?php }	else {
	        		if($this->data['Price']) {
	        			echo "<br />";
					}
	        	}?>
	        <div class="catalogItemPrice">
	        	<?php if($this->data['Price']) {
	        		echo $this->Number->currency($product['Product']['retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));
	        	} ?>
	        </div>
	        </div>
	        <div class="catalogItemNumber">
	    		<b><?php echo Configure::read('padcon.product.number.präfix');?><?php echo $product['Product']['product_number'];?></b>-xx
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