
	<div class="additionalContent">
		<?php 
		
		if(isset($this->data['Billing']['additional_text'])) {
			echo $this->data['Billing']['additional_text']; 
			echo '<br \><br \>';
		} else {
			Configure::read('padcon.Rechnung.additional_text.default');

		}?>
		Ich bedanke mich für Ihren Auftrag.
	</div>
