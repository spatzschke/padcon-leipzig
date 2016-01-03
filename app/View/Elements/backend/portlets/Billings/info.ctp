<?php 
 
?>

<script>

$(document).ready(function() {
	
									
});

function saveAndReloadBillingHeader(id) {
		
	xhr = $.ajax({
				 type: 'POST',
				 url: '<?php echo FULL_BASE_URL.$this->base;?>\/Billings\/updateBilling\/'+id+'/<?php echo $this->data['Billing']['id'];?>',
				 data: '',
				 success:function (data, textStatus) {
				 
				 		data = jQuery.parseJSON(data);
				 
				 		$(data).each(function(i,val){
						    $.each(val,function(k,v){
						    	$('.BillingInfo').find('input').each(function() {
							    	
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
		
			<h1> Rechnung </h1>
		
			<?php 
				echo $this->Form->create('Billing', array('div'=>false, 'data-model' => 'Billing'));
			?>
					
			<?php
				echo $this->Form->input('id');
				
				echo '<div class="controls col-md-12 offerNumber">';
				
				echo '<label for="BillingBillingNumber" class="col-md-4">Nummer:</label>';
				echo $this->Form->input('billing_number', array('label' => false, 'data-model' => 'Billing', 'data-field' => 'billing_number', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));	
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label for="BillingModified" class="col-md-4">Datum:</label>';
					
					if(isset($this->data['Billing'])) {		
						$this->request->data['Billing']['modified'] = $this->Time->format($this->data['Billing']['modified'], '%d.%m.%Y');
					}
					
					echo $this->Form->input('modified', array('value' => $this->request->data['Billing']['modified'], 'type' => 'text', 'label' => false, 'data-model' => 'Billing', 'data-field' => 'modified', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label for="BillingCustomer" class="col-md-4">Kunde:</label>';
					echo $this->Form->input('customer_id', array('value' => $this->request->data['Confirmation']['customer_id'], 'type' => 'text', 'label' => false, 'data-model' => 'Confirmation', 'data-field' => 'customer_id', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
							
				echo '<label for="BillingAgent" class="col-md-4">Bearbeiter:</label>';
				echo $this->Form->input('agent', array('value' => $this->request->data['Confirmation']['agent'], 'label' => false, 'data-model' => 'Confirmation', 'data-field' => 'agent', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label class="col-md-4"> Seite: </label>';
					echo '<p class="col-md-8 pageNumber">'.$page.' von <span class="maxPage">'.$maxPage.'</span></p>';
				echo '</div>';
			?>	

		</div><!-- end of .tab_container -->

	<script>





</script>


