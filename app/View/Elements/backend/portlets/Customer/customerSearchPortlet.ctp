<?php
	
	// echo $this->Html->script('jquery.caret.1.02.min', false);
	// echo $this->Html->script('jquery.liveValidation', false);
	
	
	$addressTypeName = "Angebotsadresse";
	
?>

<script>
	$(document).ready(function() {
		// $('#addAddress').find('a').click(function() {
			// $('#addAddress_modal .modal-body').load("<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Addresses\/add\/0\/1\/<?php echo $this->data['Customer']['id'];?>");
			// $('#addAddress_modal').modal('show');
			// return false;
		// });
	
		$("body").on("hidden", "#add_to_customer_modal", function(){ $(this).removeData("modal");});
	});

</script>

<div class="modal" id="addAddress_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog offer-dialog">
	 	<div class="modal-content">
			<div class="modal-body">
				<?php echo $this->element('backend/helper/loadingHelper', array("size" => "large")); ?>	
			</div>
		</div>
	</div>
</div>
			<?php
			 	if(is_null($this->data['Customer']['id'])) {
			 		
			 	}	else {
			 		
			 	
				if(!isset($this->data['Address'])) {
					
					echo'<div class="alert alert-danger" role="alert">';
						echo 'Es exisitert keine '.$addressTypeName.' für den Kunden: </br>';
						echo '</br>';
						if(!empty($this->data['Customer']['last_name'])) {
							echo '<b>'.$this->data['Customer']['salutation'].' '.$this->data['Customer']['title'].' '.$this->data['Customer']['first_name'].' '.$this->data['Customer']['last_name'].' '.'</b></br>';
						}
						if(!empty($this->data['Customer']['organisation'])) {
							echo '<b>'.$this->data['Customer']['organisation'].'</b></br>';
						}
						if(!empty($this->data['Customer']['department'])) {
							echo '<b>'.$this->data['Customer']['department'].'</b></br>';
						}
						echo '<b>'.$this->data['Customer']['email'].'</b></br></br>';
						echo '<div id="addAddress" class="input-group">';
						echo $this->Html->link(
								    'Adresse hinzufügen',
								    '#',
								    array(
								        'class' => 'btn btn-default',
								        'id' => 'addAddress'
								    )
								);
						echo '</div>';
					echo '</div>';
				} else {
				
			?>

					<?php echo $this->Form->create('Address', array('div'=>false, 'data-model' => 'Address'));?>
					
					<?php					
						echo $this->Form->input('id', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'id', 'data-model' => 'Customer', 'data-field' => 'id', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
						
						for ($i = 0; $i <= $this->data['Address']['organisation_count']-1; $i++) {
							echo $this->Form->input('organisation_'.$i, array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'department_1', 'data-model' => 'Customer', 'data-field' => 'department_1', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
						
						}
						
						for ($i = 0; $i <= $this->data['Address']['department_count']-1; $i++) {
							echo $this->Form->input('department_'.$i, array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'department_1', 'data-model' => 'Customer', 'data-field' => 'department_1', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
						
						}
						if($this->data['Address']['name'] != ' '){													
							echo '<div class="controls controls-row">';
							
								/*$options = array('Herr' => 'Herr', 'Frau' => 'Frau');
							
								echo $this->Form->input('salutation', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Anrede', 'data-model' => 'Customer', 'data-field' => 'salutation', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span3'));
							
								echo $this->Form->input('title', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Titel', 'data-model' => 'Customer', 'data-field' => 'title', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span3'));
								echo $this->Form->input('first_name', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Vorname', 'data-model' => 'Customer', 'data-field' => 'first_name', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span6'));
								echo $this->Form->input('last_name', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Nachname', 'data-model' => 'Customer', 'data-field' => 'last_name', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span6'));
							*/
								echo $this->Form->input('name', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Name', 'data-model' => 'Customer', 'data-field' => 'last_name', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
							
							echo '</div>';
						}
						echo $this->Form->input('street', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Straße / Nr.', 'data-model' => 'Customer', 'data-field' => 'street', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));

						echo '<div class="controls controls-row">';
						/*
							echo $this->Form->input('postal_code', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'PLZ', 'data-model' => 'Customer', 'data-field' => 'postal_code', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span4'));
							echo $this->Form->input('city', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Stadt', 'data-model' => 'Customer', 'data-field' => 'city', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span8'));
						*/
							echo $this->Form->input('city_combination', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Stadt', 'data-model' => 'Customer', 'data-field' => 'postal_code', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
							
						echo '</div>';
					?>	
			<?php 					
				} 
			}		
			?>
	<script>





</script>


