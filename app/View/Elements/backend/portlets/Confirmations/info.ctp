<?php 
 
?>

<script>

$(document).ready(function() {
	
									
});



</script>

		<div class="offerInfo">
		
			<h1> Auftragsbestätigung </h1>
		
			<?php 
				echo $this->Form->create('Confirmation', array('div'=>false, 'data-model' => 'Confirmation'));
			?>
					
			<?php
				echo $this->Form->input('id');
				
				echo '<div class="controls col-md-12 offerNumber  col-sm-12">';
				
				echo '<label for="ConfirmationConfirmationNumber" class="col-md-4  col-sm-4">Nummer:</label>';
				echo $this->Form->input('confirmation_number', array('label' => false, 'data-model' => 'Confirmation', 'data-field' => 'confirmation_number', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8  col-sm-8'));	
				
				echo '</div>';
				echo '<div class="controls col-md-12 col-sm-12">';
				
					echo '<label for="ConfirmationCreated" class="col-md-4  col-sm-4">Datum:</label>';
					
					if(isset($this->data['Confirmation'])) {		
						$this->request->data['Confirmation']['created'] = $this->Time->format($this->data['Confirmation']['created'], '%d.%m.%Y');
					}
					
					echo $this->Form->input('created', array('type' => 'text', 'label' => false, 'data-model' => 'Confirmation', 'data-field' => 'created', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8  col-sm-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12 col-sm-12">';
				
					echo '<label for="ConfirmationCustomer" class="col-md-4  col-sm-4">Kunde:</label>';
					echo $this->Form->input('customer_id', array('type' => 'text', 'label' => false, 'data-model' => 'Confirmation', 'data-field' => 'customer_id', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8  col-sm-8'));
				
				echo '</div>';
				echo '<div class="controls col-md-12 col-sm-12">';
							
				echo '<label for="ConfirmationAgent" class="col-md-4 col-sm-4">Bearbeiter:</label>';
				echo $this->Form->input('agent', array('label' => false, 'data-model' => 'Confirmation', 'data-field' => 'agent', 'autoComplete' => false, 'div' => false, 'class' => 'noValid col-md-8  col-sm-8'));
				echo '</div>';
				echo '<div class="controls col-md-12 col-sm-12">';
				
					echo '<label class="col-md-4 col-sm-4"> Seite: </label>';
					echo '<p class="col-md-8 col-sm-8 pageNumber">'.$page.' von <span class="maxPage">'.$maxPage.'</span></p>';
				echo '</div>';
			?>	

		</div><!-- end of .tab_container -->

	<script>





</script>


