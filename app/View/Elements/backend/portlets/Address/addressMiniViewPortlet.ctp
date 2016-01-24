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


<div class="input-group address_dummy col-md-5 pull-left" style="margin-right: 10px">
    <span class="input-group-addon">
    <?php
    foreach ($address['Types'] as $key => $value) {
		$glyph = "";
		$pop = "";
		$popAcitve = 'data-toggle="popover" data-content="'.$value.'" data-trigger="hover" data-placement="left"';
		$style = 'color: grey; cursor: default';
		$styleAcitve = 'color: teal; cursor: pointer';
		
		if(strcmp($value, "Angebot") == 0) { $glyph = "glyphicon-file"; $pop = $popAcitve; $style = $styleAcitve; }	
		if(strcmp($value, "Auftragsbestätigung") == 0) { $glyph = "glyphicon-check"; $pop = $popAcitve; $style = $styleAcitve; }	
		if(strcmp($value, "Lieferschein") == 0) { $glyph = "glyphicon-qrcode"; $pop = $popAcitve; $style = $styleAcitve; }	
		if(strcmp($value, "Rechnung") == 0) { $glyph = "glyphicon-euro"; $pop = $popAcitve; $style = $styleAcitve; }	
		
    	echo '<i class="glyphicon '.$glyph.'" style="'.$style.'" '.$pop.'></i><br><br>';
	}
    	
	if(isset($address['organisation'])) {$orga = $address['organisation'].'&#13;';}
	if(isset($address['department'])) {$dept = $address['department'].'&#13;';}
	if(isset($address['name'])) {$name = $address['name'].'&#13;';}
									 
	?>
	</span>
    <textarea rows="6" cols="35" readonly="readonly" style="border: 1px solid lightgrey"><?php echo $orga.$dept.$name.$address['street'].'&#13;'.$address['city_combination']; ?>
    </textarea>
    <?php 
    if(isset($count)) {
    	echo $this->Form->input('Address.'.$count.'.id', array('hidden' => true, 'value' => $address['id']));	
    }
    ?>	
     <span class="input-group-addon">
    
	</span>
</div>