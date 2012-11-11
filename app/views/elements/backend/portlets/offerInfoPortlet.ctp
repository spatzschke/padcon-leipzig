<?php ?>

<script>

$(document).ready(function() {
	
									
});

function saveAndReloadOfferHeader(id) {
		
	xhr = $.ajax({
				 type: 'POST',
				 url: '<?php echo FULL_BASE_URL.$this->base;?>\/Offers\/updateOffer\/'+id+'/<?php echo $offer['Offer']['id'];?>',
				 data: '',
				 success:function (data, textStatus) {
				 
				 		data = jQuery.parseJSON(data);
				 
				 		$(data).each(function(i,val){
						    $.each(val,function(k,v){
						    	$('.offerInfo').find('input').each(function() {
							    	
							    	if(k == $(this).attr('data-field')) {
								       
								       $(this).val(v);
								       
								       
							        } 
							    	
						    	});
						        
							});
						});
					} 
			 }); 
	
}


</script>


		
		<div class="offerInfo">
		
			<h1> Angebot </h1>
		
			<?php 
				echo $this->Form->create('Offer', array('div'=>false, 'data-model' => 'Offer'));
			?>
					
			<?php
				echo $this->Form->input('id');
				
				echo '<div class="controls span12">';
				
				echo '<label for="OfferOfferNumber" class="span4">Nummer:</label>';
				echo $this->Form->input('offer_number', array('label' => false, 'data-model' => 'Offer', 'data-field' => 'offer_number', 'autoComplete' => false, 'div' => false, 'class' => 'noValid span8'));	
				
				echo '</div>';
				echo '<div class="controls span12">';
				
					echo '<label for="OfferModified" class="span4">Datum:</label>';
					echo $this->Form->input('modified', array('type' => 'text', 'label' => false, 'data-model' => 'Offer', 'data-field' => 'modified', 'autoComplete' => false, 'div' => false, 'class' => 'noValid span8'));
				
				echo '</div>';
				echo '<div class="controls span12">';
				
					echo '<label for="OfferCustomer" class="span4">Kunde:</label>';
					echo $this->Form->input('customer_id', array('type' => 'text', 'label' => false, 'data-model' => 'Offer', 'data-field' => 'customer_id', 'autoComplete' => false, 'div' => false, 'class' => 'noValid span8'));
				
				echo '</div>';
				echo '<div class="controls span12">';
							
				echo '<label for="OfferAgent" class="span4">Bearbeiter:</label>';
				echo $this->Form->input('agent', array('label' => false, 'data-model' => 'Offer', 'data-field' => 'agent', 'autoComplete' => false, 'div' => false, 'class' => 'noValid span8'));
				echo '</div>';
				echo '<div class="controls span12">';
				
					echo 'Seite: ';
					echo $this->Form->input('status', array('label' => false, 'data-model' => 'Offer', 'data-field' => 'status', 'autoComplete' => false, 'div' => false, 'class' => 'noValid span8', 'type' => 'hidden'));
				
				echo '</div>';
			?>	

		</div><!-- end of .tab_container -->

	<script>





</script>


