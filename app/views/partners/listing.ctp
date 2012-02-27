<div class="partners">
	<?php
		foreach ($partners as $partner):
		
			echo $this->element('partnerItem', array('partner' => $partner));
		
		endforeach; ?>
       
        <script>
		
		</script>
</div>