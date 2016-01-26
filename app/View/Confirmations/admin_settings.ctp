 <?php 


?>	

<script>
	$(document).ready(function() {
	
		$('#saveSettings').on('click', function(){
			
			<?php 
			
				$data = $this->Js->get('#ConfirmationAdminSettingsForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
			?>
			
			var xhr = null,
			obj = $(this);			
			obj.addClass('loading');
				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/settings',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	obj.removeClass('loading');
					 	
						window.location = '<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/edit/<?php echo $controller_id;?>';
					 } 
				 }); 
			return false;
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
		
		$("[name='pattern-cb']").bootstrapSwitch({
			size: "large",
			onText: "Ja", 
			offText: "Nein",
			handleWidth: "70px",
			state: <?php 
				$string = $this->data['Confirmation']['additional_text'];
				if(strpos($string,"Muster")!==false) {
					echo "true";
				} else {
					echo "false";
				}
			
			?>,
			onInit: function(event, state) {},
			onSwitchChange: function(event, state) {
				if(state) {
					//Versandkostenfrei
					res = '<?php echo Configure::read('padcon.Auftragsbestaetigung.additional_text.pattern');?>'
					$('#ConfirmationAdditionalText').html(res);
					$("#pattern").attr('value','1')
				} else {
					$("[name='delivery-cb']").bootstrapSwitch('state', true);
					$("[name='deliveryfree-cb']").bootstrapSwitch('state', false);
					var res = '<?php echo Configure::read('padcon.Auftragsbestaetigung.additional_text.default');?>'
					$('#ConfirmationAdditionalText').html(res);
					console.log(res)
					$("#pattern").attr('value','0')
				}	
				return event.isDefaultPrevented();
			}
		});
		
	});

</script>

<div class="offer form">

<article class="module width_full settingsPortlet">
		
		<?php echo $this->Session->flash(); ?>
		
		<div class="module_content row-fluid">
					
					<?php echo $this->Form->create('Confirmation');?>
					
					<div class="col-md-7 productTable">
						<div class="panel panel-info" >
                    		<div class="panel-body" >
						<?php echo $this->element('backend/portlets/Product/settingsProductTable', array('controller' => $controller_name, 'controller_id' => $controller_id)); ?>
						</div>
						</div>
					</div>
					<div class="col-md-5">
						<?php echo $this->Form->input('id');?>
						<div class="panel panel-info" >
                    		<div class="panel-body" >
								<label class="col-md-6">Bestelldatum</label>
                               	<div class="input-group date">     	
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                <?php echo $this->Form->input('order_date', array(
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
							
								<label class="col-md-6">Bestellnummer</label>
	                            <div class="input-group">
	                             	
	                                <span class="input-group-addon"><b>#</b></span>
	                                <?php echo $this->Form->input('order_number', array(
									    'label' => false,
									    'div' => false,
									    'class'=> 'form-control span12'));
									?>                                     
	                            </div>
	                             
	                            <label class="col-md-6">Rabatt</label>
	                            <div class="input-group">
	                             	
	                                <span class="input-group-addon"><b>%</b></span>
	                                <?php echo $this->Form->input('discount', array(
									    'label' => false,
									    'div' => false,
									    'class'=> 'form-control span12',
										'min' => 0,
			    						'max' => 100,
										'default' => 0));
									?>                                     
	                             </div>
	                             
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
	                             
	                             <!-- Musterlieferung -->
	                             <label class="col-md-6">Musterlieferung</label>
	                             <div class="input-group">
	                                <input type="checkbox" name="pattern-cb" checked>    
	                                <?php echo $this->Form->input('pattern', array(
									    'hidden' => true,
										'label' => false));
									?>                                 
	                             </div>
	                             
	                             <!-- <label class="col-md-12">Zahlungsbedingung</label>
	                             
	                             <label class="col-md-6">Skontotage</label>
	                             <div class="input-group">
	                             	
	                                <?php echo $this->Form->input('skontotage', array(
									    'label' => false,
									    'div' => false,
									    'class'=> 'form-control span12',
										'min' => 0,
			    						'max' => 100,
										'default' => 0));
									?>                                     
	                             </div>
	                             <label class="col-md-6">Skontoprozent</label>
	                             <div class="input-group">
	                             	
	                                <?php echo $this->Form->input('skotoprozent', array(
									    'label' => false,
									    'div' => false,
									    'class'=> 'form-control span12',
										'min' => 0,
			    						'max' => 100,
										'default' => 0));
									?>                                     
	                             </div>
	                             <label class="col-md-6">Nettotage</label>
	                             <div class="input-group">
	                             	
	                                <?php echo $this->Form->input('nettotage', array(
									    'label' => false,
									    'div' => false,
									    'class'=> 'form-control span12',
										'min' => 0,
			    						'max' => 100,
										'default' => 0));
									?>                                     
	                             </div> -->
	                             
	                             <div class="input-group">
	                                <?php echo $this->Form->input('additional_text', array(
									    'label' => array(
									    	'text' => 'Zusatztext',
									    	'class' => 'col-md-12',
									    ),
									    'cols' => 41
										));
									?>                                     
	                             </div>

							</div>
						</div>					
					</div>
					
					<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
				        <button type="button" id="saveSettings" class="btn btn-primary">Speichern</button>
				      </div>
					

		</div><!-- end of .tab_container --> 
	</article><!-- end of stats article -->



</div>