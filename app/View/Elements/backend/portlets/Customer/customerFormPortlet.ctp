<?php echo $this->Form->create('Address', array('div'=>false, 'data-model' => 'Address'));?>

<?php
	echo $this->Form->input('id', array('disabled'=> 'disabled', 'label' => false, 'placeholder' => 'id', 'data-model' => 'Customer', 'data-field' => 'id', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
	if(!empty($this->data['Address']['organisation'])) {
		echo $this->Form->input('organisation', array('type' => 'text', 'disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Organisation', 'data-model' => 'Customer', 'data-field' => 'organisation', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
	}
	if(!empty($this->data['Address']['department'])) {
		echo $this->Form->input('department', array('type' => 'text', 'disabled'=> 'disabled', 'label' => false, 'placeholder' => 'Abteilung', 'data-model' => 'Customer', 'data-field' => 'department', 'autoComplete' => true, 'div' => false, 'class' => 'noValid col-md-12'));
	}
	if(!empty($this->data['Address']['name'])){
																
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
			
