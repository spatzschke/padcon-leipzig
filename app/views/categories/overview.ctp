<div id="categories">
	<?php
		$i = 0;
		foreach ($categories as $category):
		
			if ($i++ % 2 == 0) {
				$itemAlign = ' categoryItemLeft';
			} else {
				$itemAlign = ' categoryItemRight';
			}
		
			echo $this->Html->link('<div id="c'.$category['Category']['id'].'" class="categoryItem'.$itemAlign.' categoryItem-'.$category['Category']['short'].'"><div class="text">'.$category['Category']['name'].'</div></div>','/Produkte-'.Inflector::camelize($category['Category']['name']), array('escape'=>false));
		
		endforeach; ?>
</div>