<?php
		$dept = '';
		$orga = '';

		
		
		if(!isset($address)) {
			$address = $this->data['Address'];
		}
	
		if(!empty($address['organisation_count'])) {
			for ($i = 0; $i <= $address['organisation_count']-1; $i++) {
				$orga = $orga .''. $address['organisation_'.$i];
			}
		}
		if(!empty($address['department_count'])) {
			for ($i = 0; $i <= $address['department_count']-1; $i++) {
				$dept = $dept .''. $address['department_'.$i];
			}
		}	

	?>		


<div class="input-group address_dummy">
    <span class="input-group-addon"><i class="glyphicon" data-toggle="popover"
									 data-content=" <?php echo $addressTypes[$address['type']]; ?>"
									 data-trigger="hover"><?php echo substr($addressTypes[$address['type']],0,1); ?></i></span>
    <textarea rows="6" cols="35" readonly="readonly"><?php echo $orga.'&#13;'.$dept.'&#13;'.$address['name'].'&#13;'.$address['street'].'&#13;'.$address['city_combination']; ?>
    </textarea>
    <?php 
    if(isset($count)) {
    	echo $this->Form->input('Address.'.$count.'.id', array('hidden' => true));	
    }
    ?>	
</div>