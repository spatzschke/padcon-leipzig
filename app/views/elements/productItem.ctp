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
        	<a class="mediaURL" href="<?php e($product['Image'][0]['path'].'.'.$product['Image'][0]['ext']);?>">
            	<img src="<?php if(count($product['Image']) == 0) {
					e($this->webroot.'img/no_pic.png');
				} else {
					e($product['Image'][0]['path'].'t.'.$product['Image'][0]['ext']);
				}
				?>" alt="<?php e($product['Product']['name']);?>" />
        	</a>
        </div>
    	<div class="productItemContent">
            <div class="productItemNumber"><?php e($präfix_number);?><?php e($product['Product']['product_number']);?></div>
            <div class="productItemName"><?php e($product['Product']['name']);?></div>
            <div class="productItemMaterial">
				<label><?php e($präfix_material);?>:</label> 
				<?php e($product['Material']['name']);?></div>
            <div class="productItemColor">
				<label class="color"><?php e($präfix_color);?>:</label>
				<?php e($this->element('productItemColorSlider', array('material_id' => $product['Material']['id']))); ?></div>
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