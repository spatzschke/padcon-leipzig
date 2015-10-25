<?php
	
	// echo $this->Html->script('jquery.caret.1.02.min', false);
	// echo $this->Html->script('jquery.liveValidation', false);
	
	
	$addressTypeName = ""; $addressTypeId = "";
	$controller = ucfirst($this->request->params['controller']);

	if($controller == "Offers"){ $addressTypeName = "Angebotsadresse"; $addressTypeId = 1;}
	if($controller == "Confirmations"){ $addressTypeName = "Auftragsbestätigungsadresse"; $addressTypeId = 2;}
	if($controller == "Deliveries"){ $addressTypeName = "Lieferscheinaddresse"; $addressTypeId = 3;}
	if($controller == "Billings"){ $addressTypeName = "Rechnungsadresse"; $addressTypeId = 4;}
	
?>

<script>
	$(document).ready(function() {
		$('#addAddress').click(function() {
			$('#addAddress_modal .modal-body').load("<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Addresses\/add\/0\/<?php echo $this->data['Customer']['id'];?>\/<?php echo $addressTypeId;?>");
			$('#addAddress_modal').modal('show');
			return false;
		});
	
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
<div id="customerAddressBox">
			<?php			
			 	if(is_null($this->data['Customer']['id'])) {
			 		
			 	}	else {
			 					 	
				if(!isset($this->data['Address']['street'])) {
					
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
						echo '<br /><br />';
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

					<?php echo $this->element('backend/portlets/Customer/customerFormPortlet'); ?>
			<?php 					
				} 
			}		
			?>
</div>
	<script>





</script>


