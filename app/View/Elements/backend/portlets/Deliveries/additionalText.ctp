
	<div class="additionalContent">
		<?php
			if($this->data['Confirmation']['pattern']) {
				echo Configure::read('padcon.Lieferschein.additional_text.pattern');
				echo '<br><br>';
			}
		?>
		
		Erhalten:
	</div>
