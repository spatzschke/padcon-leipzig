<?php 
	$präfix_number = 'PD-';
	$präfix_material = 'Material';
	$präfix_color = 'Farbe';
	$präfix_size = 'Maße';
	$productItemFeaturesHeader = 'Eigenschaften';
	
?>		

<div id="p<?php echo $partner['Partner']['id'];?>" class="partnerListItem">
    <div class="partnerItemCenter">
    	<div class="partnerItemImage">	
        	<a href="<?php echo $partner['Partner']['url'];?>">
            	<img src="<?php echo $partner['Partner']['partner_logo'];?>" alt="<?php echo $partner['Partner']['name'];?>" />
        	</a>
        </div>
    	<div class="partnerItemContent">
            <div class="partnerItemName"><?php echo $partner['Partner']['name'];?></div>
            <div class="partnerItemDescription">
            	<?php echo $partner['Partner']['description']; ?>
            </div>
        </div>
        <div class="partnerItemLink">
        	<a href="<?php echo $partner['Partner']['url'];?>" target="_blank">
				Zum Partner
        	</a>
        </div>
    </div>
    <div class="message"></div>
 </div>