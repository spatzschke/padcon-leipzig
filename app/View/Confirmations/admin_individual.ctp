<?php 
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);
?>

<script>

$(document).ready(function() {
			
	$(".module form").liveValidation({
						url: '<?php echo FULL_BASE_URL.$this->base;?>\/Confirmations\/liveValidate\/',
						urlBase: '<?php echo FULL_BASE_URL.$this->base;?>',
						autoSave: false,});
						
	$("img.lazy").lazyload();
	
	$('#ConfirmationCustom').bind('click', function() {
		
		if($(this).is(':checked')) {
			loadCustomConfirmationNumber();
		} else {
			$('#ConfirmationConfirmationNumber').val('');
		}
		
		
	});
	
	 $("[name='delivery-cb']").bootstrapSwitch({
			size: "large",
			onText: "Paket", 
			offText: "Päckchen",
			handleWidth: "70px",
			state: <?php 
				if($this->data['Confirmation']['delivery_cost'] == Configure::read('padcon.delivery_cost.paket')) {
					echo "true";
					$delivery = Configure::read('padcon.delivery_cost.paeckchen');
				} else {
					echo "false";
					$delivery = Configure::read('padcon.delivery_cost.paket');
				}
			
			?>,
			onSwitchChange: function(event, state) {
			if(state) {
				//Packet 9,00€
				$("#deliveryCost").attr('value','<?php echo Configure::read('padcon.delivery_cost.paket');?>')
			} else {
				//Päckchen 6,00€
				$("#deliveryCost").attr('value','<?php echo Configure::read('padcon.delivery_cost.paeckchen');?>')
			}
			var str = $('#ConfirmationAdditionalText').val();
			var res = "";
			if(str.indexOf('<?php echo Configure::read('padcon.delivery_cost.paket');?>,00') !== -1) {
				res = str.replace('<?php echo Configure::read('padcon.delivery_cost.paket');?>,00', '<?php echo Configure::read('padcon.delivery_cost.paeckchen');?>,00')
			} else {
				res = str.replace('<?php echo Configure::read('padcon.delivery_cost.paeckchen');?>,00', '<?php echo Configure::read('padcon.delivery_cost.paket');?>,00')	
			}
			$('#ConfirmationAdditionalText').html(res);			
			return event.isDefaultPrevented();
			}
		});
		
		$("[name='deliveryfree-cb']").bootstrapSwitch({
			size: "large",
			onText: "Ja", 
			offText: "Nein",
			handleWidth: "70px",
			state: <?php 
				$string = $this->data['Confirmation']['additional_text'];
				if(strpos($string,"frei Haus.")!==false) {
					echo "true";
					$delivery = Configure::read('padcon.delivery_cost.frei');
				} else {
					echo "false";
				}
			
			?>,
			onInit: function(event, state) {},
			onSwitchChange: function(event, state) {
				console.log(state);
				if(state) {
					//Versandkostenfrei
					res = '<?php echo Configure::read('padcon.Auftragsbestaetigung.additional_text.deliveryFree');?>'
					$('#ConfirmationAdditionalText').html(res);
					$("#deliveryCost").attr('value','<?php echo Configure::read('padcon.delivery_cost.frei');?>')
				} else {
					$("[name='delivery-cb']").bootstrapSwitch('state', true);
					var res = '<?php echo Configure::read('padcon.Auftragsbestaetigung.additional_text.default');?>'
					$('#ConfirmationAdditionalText').html(res);
					console.log(res)
					$("#deliveryCost").attr('value','<?php echo Configure::read('padcon.delivery_cost.paket');?>')
				}	
				return event.isDefaultPrevented();
			}
		});
			
});

function loadCustomConfirmationNumber() {
	var obj = $('this');
	
	 $.ajax({
		 type: 'POST',
		 url:'<?php echo FULL_BASE_URL.$this->base;?>\/Confirmations\/getNextCustomConfirmationNumber\/',
		 data: '',
		 success:function (data, textStatus) {
				$('#ConfirmationConfirmationNumber').val(data);
		 } 
		 
		
	 }); 

	
}
</script>

<div class="container"> 
	
	 <?php
	 
 echo $this->Form->create('Confirmation', array(
					'class' => 'form-horizontal' ,
					'style' => 'width: 100%'
				));  
	
?>  

<?php ?>

<script>
$(document).ready(function() {
})

</script>

<div class="mainbox col-md-12 col-md-offset-0 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title"><?php echo $title_for_panel; ?></div>
                
            </div>

            <div class="panel-body form-horizontal" >

               	<?php 
               		if(isset($errors)) {
               			echo '
               				<div class="row alert-row">
								<div class="alert alert-danger col-md-12" role="alert" style="margin-bottom: 0;">
								  Folgende Fehler sind aufgetreten
								  <br /><br />
								  <ul>
								  ';
								  foreach($errors as $error) {
								  	echo '<li>'.$error[0].'</li>';
								  }
						echo '
								</ul>
								</div>
							</div>
               			';
               		} else {
               			echo $this->Session->flash();
               		}
               		 ?>
                    
           		<?php echo $this->Form->input('id');?>   
                
				 
				<!-- Links -->
			
				<div class="col-md-4">
				<?php if($this->request->params['action'] == "admin_edit_individual") {
					$readonly = "readonly";
				} else {
					$readonly = "";
				} ?>
					<div class="input-group">
                        <span class="input-group-addon"><b>#</b></span>
                        <?php  echo $this->Form->input('confirmation_number', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Confirmation',
							'placeholder' => 'AB-Nummer',
							'data-field' => 'confirmation_number', 
							'autoComplete' => true,
  							'type' => 'text',
  							'readonly' => $readonly
						));
						?>                                      
                    </div> 
                    
    
	
		
	
                
                <?php if($this->request->params['action'] == "admin_edit_individual") { ?>   
                  
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <?php echo $this->Form->input('customer_id', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Confirmation',
							'placeholder' => 'Kunde',
							'data-field' => 'customer_id', 
							'autoComplete' => true,
							'type' => 'text',
						));
						?>              
                     </div>
                    
                   	<div class="input-group date">     	
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <?php echo $this->Form->input('created', array(
						    'label' => false,
						    'div' => false,
						    'type' => 'text',
							'class' => 'form-control span12'));
						
						?> 						 	
					</div>
					   
					<script type="text/javascript">
						    $('.date').datepicker({
						    format: "dd.mm.yyyy",
						    language: "de",
						    calendarWeeks: true,
						    autoclose: true,
						    todayHighlight: true
						    });
					</script> 				
					
					
					<!-- Versandkostenfrei -->
                     <label class="col-md-6">Versandkostenfrei</label>
                     <div class="input-group">
                        <input type="checkbox" name="deliveryfree-cb" checked>    
                        <?php echo $this->Form->input('deliveryFree', array(
						    'hidden' => true,
							'id' => "deliveryFree",
							'label' => false));
						?>                                 
                     </div>
                     
                     <!-- PAKET/PÄCKCHEN -->
                     <label class="col-md-6">Packetgröße</label>
                     <div class="input-group">
                        <input type="checkbox" name="delivery-cb" checked>    
                        <?php echo $this->Form->input('deliveryCost', array(
						    'hidden' => true,
							'id' => "deliveryCost",
							'label' => false));
						?>                                 
                     </div>
				</div>
				
				 <!-- Mitte -->
				<div class="col-md-4">
					<div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
                        <?php echo $this->Form->input('discount', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Confirmation',
							'placeholder' => 'Rabatt',
							'data-field' => 'discount', 
							'autoComplete' => true,
						));
						?> 
					</div>
					 
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                        <?php  echo $this->Form->input('confirmation_price', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Confirmation',
							'placeholder' => 'AB-Gesamtsumme',
							'data-field' => 'confirmation_price', 
							'autoComplete' => true,
  							'type' => 'text',
						));
						?>                                      
                    </div>  
                     <div class="input-group">
	                    <span class="input-group-addon"><i class="glyphicon  glyphicon-screenshot"></i></span>
	                    <?php echo $this->Form->input('additional_text', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Confirmation',
							'placeholder' => 'Zusatztext',
							'data-field' => 'additional_text', 
							'autoComplete' => true, 
							'type' => 'textarea'
						));
						?>                                      
	                 </div>
	          <?php } ?>   
                     
                </div>
                
                 <!-- Rechts -->
                 <div class="col-md-4">
                 	
                 </div>
          	</div>
          	
		</div> 
		                        
	</div> 
	<div class="col-sm-12 controls">                          
		<?php 		
				echo '<input type="submit" value="'.$primary_button.'" class="btn btn-success form-control">';
		?>
	</div>
</form>
</div>