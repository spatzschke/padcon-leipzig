<?php  ?>

<div id="p<?php echo $product['Product']['product_number'];?>" class="productListItem productListItem-<?php echo $product['Category']['short'];?>">
	<div class="productItemHeader"></div>
    <div class="productItemCenter">
    	<div class="loader"><img src="<?php echo $this->webroot.'img/ajax.gif'; ?>" alt="Ladevorgang"/></div>
    	<div class="productItemImage">	
        	<?php if(count($product['Image']) == 0) {
						echo '<img class="lazy" src="'.$this->webroot.'img/no_pic.png" alt="'.$product['Product']['name'].'" />';
				} else {
						echo'<img class="lazy" src="'.$this->webroot.'img/lazyload.gif" data-original="'.$product['Image'][0]['path'].'t.'.$product['Image'][0]['ext'].'" alt="'.$product['Product']['name'].'" image-rel="'.$product['Image'][0]['path'].'.'.$product['Image'][0]['ext'].'" />';
				}
			?>
        </div>
    	<div class="productItemContent">
            <div class="productItemNumber"><?php //echo Configure::read('padcon.product.number.präfix'); ?><?php echo $product['Product']['product_number'];?></div>
            <div class="productItemName"><?php echo $product['Product']['name'];?></div>
            <?php if(!empty($product['Product']['core_name'])) {?>
	            <div class="productItemCore">
					<label><?php echo Configure::read('padcon.product.core.präfix');?>:</label> 
					<?php echo $product['Product']['core_name'];?></div>			
			<?php }?>
            <?php if(!empty($product['Material']['name'])) {?>
	            <div class="productItemMaterial">
					<label><?php echo Configure::read('padcon.product.material.präfix');?>:</label> 
					<?php echo $product['Material']['name'];?></div>
	            <?php if($product['Material']['name'] != "ohne Bezug") {?>
	            <div class="productItemColor">
					<label class="color"><?php echo Configure::read('padcon.product.color.präfix');?>:</label>
					<?php echo $this->element('productItemColorSlider', array('product' => $product)); ?>	
				</div>
				<?php }?>				
			<?php }?>
            <div class="productItemSize">
				<label><?php echo Configure::read('padcon.product.size.präfix')?>:</label>
            	<?php
            		if(empty($product['Product']['size'])) {
            			echo Configure::read('padcon.product.size.noSize');
            		} else {
            			echo $product['Product']['size'].Configure::read('padcon.product.size.suffix');
            		}
            		 ?>
            </div>
        </div>
        <div class="productItemFeatures">
        	<div class="productItemFeaturesHeader"><?php echo Configure::read('padcon.product.feature.präfix');?>:</div>
            <ul>
            	<?php 
            	$features = explode(PHP_EOL, $product['Product']['featurelist']);
            	foreach($features as $fea)	{
            		if((strpos($fea, '<u>') !== FALSE) ) {
	            		$fea = str_replace("<li>", "", $fea);
						$fea = str_replace("</li>", "", $fea);
						echo '<div class="featureTitle">'.$fea.'</div>';
					} else {
						echo $fea;
					}
				}
            	?>
            </ul>
        </div>
    </div>
    <div class="message"></div>
    <div class="productItemFooter"></div>
	<?php //echo $this->Html->link('Zum Warenkorb hinzufügen', array('controller' => 'Carts', 'action' => 'addToCart', $product['Product']['id']), array('escape' => false, 'class' => 'addToCart')); ?>
	
</div>