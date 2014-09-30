<?php

?>

<?php

	$name = $this->data['Customer']['salutation'].' '.$this->data['Customer']['title'].' '.$this->data['Customer']['first_name'].' '.$this->data['Customer']['last_name']; 
	$city = $this->data['Customer']['postal_code']. ' '.$this->data['Customer']['city'];
	
	if(!empty($this->data['Customer']['organisation'])) {
		for ($i = 0; $i <= $this->data['Customer']['organisation_count']-1; $i++) {
			echo $this->Html->div('col-md-12', $this->data['Customer']['organisation_'.$i]);
		}
	}
	if(!empty($this->data['Customer']['department'])) {
		for ($i = 0; $i <= $this->data['Customer']['department_count']-1; $i++) {
			echo $this->Html->div('col-md-12', $this->data['Customer']['department_'.$i]);
		}
	}
					
	echo $this->Html->div('col-md-12', $name);
	echo $this->Html->div('col-md-12', $this->data['Customer']['street']);
	echo $this->Html->div('col-md-12', $city);				
						
						
?>	


