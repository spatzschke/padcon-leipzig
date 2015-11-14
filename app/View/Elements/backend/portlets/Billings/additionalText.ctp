
	<div class="additionalContent">
		<?php 
		
		if(isset($this->data['Billing']['additional_text'])) {
			echo $this->data['Billing']['additional_text']; 
		} else {
			Configure::read('padcon.Rechnung.additional_text.default');
		}?>
		<br \>
		<br \>
		Ich bedanke mich für Ihren Auftrag.
	</div>
