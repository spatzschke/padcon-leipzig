<?php 


	$colors = $this->requestAction('Products/getColors/'.$material_id);

	
	foreach ($colors as $color):
		
			echo '<li class="colorItem" rel="'.$color['Color']['code'].'" style="background-color: #'.$color['Color']['rgb'].';">'.$html->image('color_overlay.png').'</li>';
		
	endforeach;

?>		

