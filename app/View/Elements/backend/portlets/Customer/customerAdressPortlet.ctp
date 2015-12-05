<?php

?>

<?php
	
	if(!empty($this->data['Address']['organisation'])) {
		echo $this->Html->div('col-md-12', $this->data['Address']['organisation']);	
	}
	if(!empty($this->data['Address']['department'])) {
			echo $this->Html->div('col-md-12', $this->data['Address']['department']);
	}
					
	echo $this->Html->div('col-md-12', $this->data['Address']['name']);
	echo $this->Html->div('col-md-12', $this->data['Address']['street']);
	echo $this->Html->div('col-md-12', $this->data['Address']['city_combination']);				
						
						
?>	


