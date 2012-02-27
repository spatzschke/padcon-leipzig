<div id="partnerCategories">
	<?php
		$i = 0;
		foreach ($categories as $category):
		
			if ($i++ % 2 == 0) {
				$itemAlign = ' categoryItemLeft';
			} else {
				$itemAlign = ' categoryItemRight';
			}
		
			echo $this->Html->link('<div id="c'.$category['PartnerCategory']['id'].'" class="categoryItem'.$itemAlign.' categoryItem-'.$category['PartnerCategory']['short'].'"><div class="text">'.$category['PartnerCategory']['name'].'</div></div>','/Fachhandel-'.Inflector::camelize($category['PartnerCategory']['name']), array('escape'=>false));
		
		endforeach; ?>
</div>