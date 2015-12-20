<?php  
?>

<script>

$(document).ready(function() {
	
									
});

function saveAndReloadOfferHeader(id) {
		
	xhr = $.ajax({
				 type: 'POST',
				 url: '<?php echo FULL_BASE_URL.$this->base;?>\/Offers\/updateOffer\/'+id+'/<?php echo $this->data['Offer']['id'];?>',
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
				
				echo '<div class="controls col-md-12 offerNumber">';
				
				echo '<label for="OfferOfferNumber" class="col-md-4">Nummer:</label>';
				echo $this->Form->input('offer_number', array('label' => false, 'data-model' => 'Offer', 'data-field' => 'offer_number', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));	
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label for="OfferModified" class="col-md-4">Datum:</label>';
					
					if(isset($this->data['Offer'])) {		
						$this->request->data['Offer']['modified'] = $this->Time->format($this->data['Offer']['modified'], '%d.%m.%Y');
					}
					
					echo $this->Form->input('modified', array('type' => 'text', 'label' => false, 'data-model' => 'Offer', 'data-field' => 'modified', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label for="OfferCustomer" class="col-md-4">Kunde:</label>';
					echo $this->Form->input('customer_id', array('type' => 'text', 'label' => false, 'data-model' => 'Offer', 'data-field' => 'customer_id', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
							
				echo '<label for="OfferAgent" class="col-md-4">Bearbeiter:</label>';
				echo $this->Form->input('agent', array('label' => false, 'data-model' => 'Offer', 'data-field' => 'agent', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label class="col-md-4"> Seite: </label>';
					echo '<p class="col-md-8 pageNumber">'.$page.' von <span class="maxPage">'.$maxPage.'</span></p>';
				echo '</div>';
			?>	

		</div><!-- end of .tab_container -->

	<script>





</script>


