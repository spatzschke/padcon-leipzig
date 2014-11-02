<?php

?>

<?php
	
	if(!empty($this->data['Address']['organisation_count'])) {
		for ($i = 0; $i <= $this->data['Address']['organisation_count']-1; $i++) {
			echo $this->Html->div('col-md-12', $this->data['Address']['organisation_'.$i]);
		}
	}
	if(!empty($this->data['Address']['department_count'])) {
		for ($i = 0; $i <= $this->data['Address']['department_count']-1; $i++) {
			echo $this->Html->div('col-md-12', $this->data['Address']['department_'.$i]);
		}
	}
					
	echo $this->Html->div('col-md-12', $this->data['Address']['name']);
	echo $this->Html->div('col-md-12', $this->data['Address']['street']);
	echo $this->Html->div('col-md-12', $this->data['Address']['city_combination']);				
						
						
?>	


