<?php 
 
?>

<script>

$(document).ready(function() {
	
									
});

function saveAndReloadDeliveryHeader(id) {
		
	xhr = $.ajax({
				 type: 'POST',
				 url: '<?php echo FULL_BASE_URL.$this->base;?>\/Deliverys\/updateDelivery\/'+id+'/<?php echo $this->data['Delivery']['id'];?>',
				 data: '',
				 success:function (data, textStatus) {
				 
				 		data = jQuery.parseJSON(data);
				 
				 		$(data).each(function(i,val){
						    $.each(val,function(k,v){
						    	$('.DeliveryInfo').find('input').each(function() {
							    	
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
		
			<h1> Lieferschein </h1>
		
			<?php 
				echo $this->Form->create('Delivery', array('div'=>false, 'data-model' => 'Delivery'));
			?>
					
			<?php
				echo $this->Form->input('id');
				
				echo '<div class="controls col-md-12 offerNumber">';
				
				echo '<label for="DeliveryDeliveryNumber" class="col-md-4">Nummer:</label>';
				echo $this->Form->input('delivery_number', array('label' => false, 'data-model' => 'Delivery', 'data-field' => 'delivery_number', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));	
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label for="DeliveryModified" class="col-md-4">Datum:</label>';
					
					if(isset($this->data['Delivery'])) {		
						$this->request->data['Delivery']['modified'] = $this->Time->format($this->data['Delivery']['modified'], '%d.%m.%Y');
					}
					
					echo $this->Form->input('modified', array('type' => 'text', 'label' => false, 'data-model' => 'Delivery', 'data-field' => 'modified', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
				
					echo '<label for="DeliveryCustomer" class="col-md-4">Kunde:</label>';
					echo $this->Form->input('customer_id', array('value' => $this->request->data['Confirmation']['customer_id'], 'type' => 'text', 'label' => false, 'data-model' => 'Confirmation', 'data-field' => 'customer_id', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12">';
							
				echo '<label for="DeliveryAgent" class="col-md-4">Bearbeiter:</label>';
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


