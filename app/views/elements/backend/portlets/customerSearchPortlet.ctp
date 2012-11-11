<?php
	
	echo $this->Html->script('jquery.caret.1.02.min', false);
	echo $this->Html->script('jquery.liveValidation', false);
	
?>

<script>

$(document).ready(function() {

	$('.module form').liveValidation({
		url: '<?php echo FULL_BASE_URL.$this->base;?>\/Customers\/liveValidate\/',
		urlBase: '<?php echo FULL_BASE_URL.$this->base;?>',
		autoSave: false,
		autoCompleteSuccess: function(id){
				saveAndReloadOfferHeader(id);
			}
		});									
});



</script>

					<?php echo $this->Form->create('Customer', array('div'=>false, 'data-model' => 'Customer'));?>
					
					<?php
						echo $this->Form->input('id', array('label' => false, 'placeholder' => 'id', 'data-model' => 'Customer', 'data-field' => 'id', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span12'));
						
						echo $this->Form->input('organisation', array('label' => false, 'placeholder' => 'Organisation', 'data-model' => 'Customer', 'data-field' => 'organisation', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span12 noHidden'));	
						
					
						
						echo $this->Form->input('department', array('label' => false, 'placeholder' => 'Abteilung', 'data-model' => 'Customer', 'data-field' => 'department', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span12'));	
						
						echo '<div class="controls controls-row">';
						
							$options = array('Herr' => 'Herr', 'Frau' => 'Frau');
						
							echo $this->Form->input('salutation', array('options' => $options, 'label' => false, 'placeholder' => 'Anrede', 'data-model' => 'Customer', 'data-field' => 'salutation', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span3'));
						
							echo $this->Form->input('title', array('label' => false, 'placeholder' => 'Titel', 'data-model' => 'Customer', 'data-field' => 'title', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span3'));
							echo $this->Form->input('last_name', array('label' => false, 'placeholder' => 'Nachname', 'data-model' => 'Customer', 'data-field' => 'last_name', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span6'));
						
						echo '</div>';

						echo $this->Form->input('street', array('label' => false, 'placeholder' => 'Straße / Nr.', 'data-model' => 'Customer', 'data-field' => 'street', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span12'));

						echo '<div class="controls controls-row">';
						
							echo $this->Form->input('postal_code', array('label' => false, 'placeholder' => 'PLZ', 'data-model' => 'Customer', 'data-field' => 'postal_code', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span4'));
							echo $this->Form->input('city', array('label' => false, 'placeholder' => 'Stadt', 'data-model' => 'Customer', 'data-field' => 'city', 'autoComplete' => true, 'div' => false, 'class' => 'noValid span8'));
						
						echo '</div>';
					?>	

	<script>





</script>


