<?php 
	$präfix_number = 'PD-';
	$präfix_material = 'Material';
	$präfix_color = 'Farbe';
	$präfix_size = 'Maße';
	$productItemFeaturesHeader = 'Eigenschaften';
?>		

<div id="p<?php echo $product['Product']['product_number'];?>" class="productListItem productListItem-<?php echo $product['Category']['short'];?>">
	<div class="productItemHeader"></div>
    <div class="productItemCenter">
    	<div class="loader"><img src="<?php echo $this->webroot.'img/ajax.gif'; ?>" alt="Ladevorgang"/></div>
    	<div class="productItemImage">	
        	<?php if(count($product['Image']) == 0) {
					if(isset($auth)) {
						echo '<a class="mediaURL"  href="'.FULL_BASE_URL.'/media/index.php?p='.$product['Product']['product_number'].'&c=99"><img src="'.$this->webroot.'img/no_pic.png" alt="'.$product['Product']['name'].'" /></a>';
					} else {
						echo '<img src="'.$this->webroot.'img/no_pic.png" alt="'.$product['Product']['name'].'" />';
					}
				} else {
					if(isset($auth)) {
						echo '<a class="mediaURL"  href="'.FULL_BASE_URL.'/media/index.php?p='.$product['Product']['product_number'].'&c=99"><img class="lazy" src="'.$product['Image'][0]['path'].'t.'.$product['Image'][0]['ext'].'" alt="'.$product['Product']['name'].'" image-rel="'.$product['Image'][0]['path'].'.'.$product['Image'][0]['ext'].'" /></a>';
					} else {
						echo'<a class="mediaURL"><img class="lazy" src="'.$this->webroot.'img/lazyload.gif" data-original="'.$product['Image'][0]['path'].'t.'.$product['Image'][0]['ext'].'" alt="'.$product['Product']['name'].'" image-rel="'.$product['Image'][0]['path'].'.'.$product['Image'][0]['ext'].'" /></a>';
					}
				}
			?>
        </div>
    	<div class="productItemContent">
            <div class="productItemNumber"><?php echo $präfix_number;?><?php echo $product['Product']['product_number'];?></div>
            <div class="productItemName"><?php echo $product['Product']['name'];?></div>
            <?php if(!empty($product['Material']['name'])) {?>
	            <div class="productItemMaterial">
					<label><?php echo $präfix_material;?>:</label> 
					<?php echo $product['Material']['name'];?></div>
	            <div class="productItemColor">
					<label class="color"><?php echo $präfix_color;?>:</label>
						<div class="colorSliderShadow"></div>
						<ul id="colorCarousel<?php echo $product['Product']['product_number'];?>" >
							<?php echo $this->element('productItemColorSlider', array('material_id' => $product['Material']['id'])); ?>
						</ul>
					
					<script type="text/javascript">
						$('#colorCarousel<?php echo $product['Product']['product_number'];?>').jcarousel({});
					</script>
				</div>
			<?php }?>
            <div class="productItemSize">
				<label><?php echo $präfix_size;?>:</label>
            	<?php $this->requestAction('Products/sizeBuilder/'.$product['Size']['id']); ?>
            </div>
        </div>
        <div class="productItemFeatures">
        	<div class="productItemFeaturesHeader"><?php echo $productItemFeaturesHeader;?>:</div>
            <ul>
            	<?php echo $product['Product']['featurelist'];?>
            </ul>
        </div>
    </div>
    <div class="message"></div>
    <div class="productItemFooter"></div>
	<?php echo $this->Html->link('Zum Warenkorb hinzufügen', array('controller' => 'Carts', 'action' => 'addToCart', $product['Product']['id']), array('escape' => false, 'class' => 'addToCart')); ?>
	
</div>