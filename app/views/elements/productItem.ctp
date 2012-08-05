<?php 
	$präfix_number = 'PD-';
	$präfix_material = 'Material';
	$präfix_color = 'Farbe';
	$präfix_size = 'Maße';
	$productItemFeaturesHeader = 'Eigenschaften';
	
	
?>		

<div id="p<?php e($product['Product']['product_number']);?>" class="productListItem productListItem-<?php e($product['Category']['short']);?>">
	<div class="productItemHeader"></div>
    <div class="productItemCenter">
    	<div class="loader"><img src="<?php e($this->webroot.'img/ajax.gif'); ?>" alt="Ladevorgang"/></div>
    	<div class="productItemImage">	
        	<?php if(count($product['Image']) == 0) {
					if(isset($auth)) {
						e('<a class="mediaURL"  href="'.FULL_BASE_URL.'/media/index.php?p='.$product['Product']['product_number'].'&c=99"><img src="'.$this->webroot.'img/no_pic.png" alt="'.$product['Product']['name'].'" /></a>');
					} else {
						e('<img src="'.$this->webroot.'img/no_pic.png" alt="'.$product['Product']['name'].'" />');
					}
				} else {
					if(isset($auth)) {
						e('<a class="mediaURL"  href="'.FULL_BASE_URL.'/media/index.php?p='.$product['Product']['product_number'].'&c=99"><img class="lazy" src="'.$product['Image'][0]['path'].'t.'.$product['Image'][0]['ext'].'" alt="'.$product['Product']['name'].'" image-rel="'.$product['Image'][0]['path'].'.'.$product['Image'][0]['ext'].'" /></a>');
					} else {
						e('<a class="mediaURL"><img class="lazy" src="'.$this->webroot.'img/lazyload.gif" data-original="'.$product['Image'][0]['path'].'t.'.$product['Image'][0]['ext'].'" alt="'.$product['Product']['name'].'" image-rel="'.$product['Image'][0]['path'].'.'.$product['Image'][0]['ext'].'" /></a>');
					}
				}
			?>
        </div>
    	<div class="productItemContent">
            <div class="productItemNumber"><?php e($präfix_number);?><?php e($product['Product']['product_number']);?></div>
            <div class="productItemName"><?php e($product['Product']['name']);?></div>
            <div class="productItemMaterial">
				<label><?php e($präfix_material);?>:</label> 
				<?php e($product['Material']['name']);?></div>
            <div class="productItemColor">
				<label class="color"><?php e($präfix_color);?>:</label>
					<div class="colorSliderShadow"></div>
					<ul id="colorCarousel<?php e($product['Product']['product_number']);?>" >
						<?php e($this->element('productItemColorSlider', array('material_id' => $product['Material']['id']))); ?>
					</ul>
				
				<script type="text/javascript">
					$('#colorCarousel<?php e($product['Product']['product_number']);?>').jcarousel({});
				</script>
			</div>
            <div class="productItemSize">
				<label><?php e($präfix_size);?>:</label>
            	<?php $this->requestAction('Products/sizeBuilder/'.$product['Size']['id']); ?>
            </div>
        </div>
        <div class="productItemFeatures">
        	<div class="productItemFeaturesHeader"><?php e($productItemFeaturesHeader);?>:</div>
            <ul>
            	<?php e($product['Product']['featurelist']);?>
            </ul>
        </div>
    </div>
    <div class="message"></div>
    <div class="productItemFooter"></div>
	
    

</div>