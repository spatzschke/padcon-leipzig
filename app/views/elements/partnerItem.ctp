<?php 
	$präfix_number = 'PD-';
	$präfix_material = 'Material';
	$präfix_color = 'Farbe';
	$präfix_size = 'Maße';
	$productItemFeaturesHeader = 'Eigenschaften';
	
?>		

<div id="p<?php e($partner['Partner']['id']);?>" class="partnerListItem">
    <div class="partnerItemCenter">
    	<div class="partnerItemImage">	
        	<a href="<?php e($partner['Partner']['url']);?>">
            	<img src="<?php e($partner['Partner']['partner_logo']);?>" alt="<?php e($partner['Partner']['name']);?>" />
        	</a>
        </div>
    	<div class="partnerItemContent">
            <div class="partnerItemName"><?php e($partner['Partner']['name']);?></div>
            <div class="partnerItemDescription">
            	<?php e($partner['Partner']['description']); ?>
            </div>
        </div>
        <div class="partnerItemLink">
        	<a href="<?php e($partner['Partner']['url']);?>" target="_blank">
				Zum Partner
        	</a>
        </div>
    </div>
    <div class="message"></div>
 </div>