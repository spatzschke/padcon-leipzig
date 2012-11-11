<?php 
	echo $this->Html->script('jquery.bootstrap.tooltip', false);
	echo $this->Html->script('jquery.bootstrap.popover', false);
	echo $this->Html->css('productItem');
	
	echo $this->Html->script('jquery.caret.1.02.min', false);
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);

?>

<script>

$(document).ready(function() {
			
	$(".module form").liveValidation({
						url: '<?php echo FULL_BASE_URL.$this->base;?>\/Customers\/liveValidate\/',
						urlBase: '<?php echo FULL_BASE_URL.$this->base;?>',
						autoSave: false,
						});
									
});

</script>


<article class="module width_full customerPortlet">
		<header>
			
				<h3 class=""><?php __('Kunde hinzufügen');?></h3>
			
				
		</header>
		<div class="module_content row-fluid">
					<?php echo $this->Form->create('Customer', array('data-model' => 'Customer'));?>
					
					<div class="span4">
					
					<?php
						echo $this->Form->input('id');
						
						$options = array('Herr' => 'Herr', 'Frau' => 'Frau');
						
						echo $this->Form->select('salutation', $options, array('label' => 'Anrede', 'data-model' => 'Customer', 'data-field' => 'salutation', 'autoComplete' => true));
						echo $this->Form->input('title', array('label' => 'Titel', 'data-model' => 'Customer', 'data-field' => 'title', 'autoComplete' => true));
						echo $this->Form->input('first_name', array('label' => 'Vorname', 'data-model' => 'Customer', 'data-field' => 'first_name', 'autoComplete' => true));
						echo $this->Form->input('last_name', array('label' => 'Nachname', 'data-model' => 'Customer', 'data-field' => 'last_name', 'autoComplete' => true));
						
					?>
					</div>
					<div class="span4">
					<?php	
						echo $this->Form->input('organisation', array('label' => 'Organisation', 'data-model' => 'Customer', 'data-field' => 'organisation', 'autoComplete' => true));	
						echo $this->Form->input('department', array('label' => 'Abteilung', 'data-model' => 'Customer', 'data-field' => 'department', 'autoComplete' => true));				
						echo $this->Form->input('street', array('label' => 'Straße / Nr.', 'data-model' => 'Customer', 'data-field' => 'street', 'autoComplete' => true));
						echo $this->Form->input('postal_code', array('label' => 'PLZ', 'data-model' => 'Customer', 'data-field' => 'postal_code', 'autoComplete' => true));
						echo $this->Form->input('city', array('label' => 'Stadt', 'data-model' => 'Customer', 'data-field' => 'city', 'autoComplete' => true));
					?>
					
					</div>
					<div class="span3 imageBox">
						
					<?php 	
										
						echo $this->Form->input('email', array('label' => 'eMail', 'data-model' => 'Customer', 'data-field' => 'email', 'autoComplete' => true));
						echo $this->Form->input('phone', array('label' => 'Telefon', 'data-model' => 'Customer', 'data-field' => 'phone', 'autoComplete' => true));
						echo $this->Form->input('fax', array('label' => 'Fax', 'data-model' => 'Customer', 'data-field' => 'fax', 'autoComplete' => true));
					?>
					</div>
					<div class="span10">
					
						<?php echo $this->Form->end(__('Speichern', true));?>	
					
					</div>
					

		</div><!-- end of .tab_container -->
	</article><!-- end of stats article -->
	<script>





</script>


