<script>
	$(document).ready(function() {
	
		$('#saveSettings').on('click', function(){
			
			<?php 
				$delivery = 0;
			
				$data = $this->Js->get('#OfferAdminSettingsForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
			?>
			
			var xhr = null,
			obj = $(this);			
			obj.addClass('loading');
				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/offers/settings',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	obj.removeClass('loading');
					 	
						$("#offerSettigs_modal .modal-body").html(data);
						$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/<?php echo $controller_name;?>/reloadSheet/<?php echo $controller_id;?>');
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
				if($this->data['Offer']['delivery_cost'] == Configure::read('padcon.delivery_cost.paket')) {
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
			var str = $('#OfferAdditionalText').val();
			var res = "";
			if(str.indexOf('<?php echo Configure::read('padcon.delivery_cost.paket');?>,00') !== -1) {
				res = str.replace('<?php echo Configure::read('padcon.delivery_cost.paket');?>,00', '<?php echo Configure::read('padcon.delivery_cost.paeckchen');?>,00')
			} else {
				res = str.replace('<?php echo Configure::read('padcon.delivery_cost.paeckchen');?>,00', '<?php echo Configure::read('padcon.delivery_cost.paket');?>,00')	
			}
			$('#OfferAdditionalText').html(res);			
			return event.isDefaultPrevented();
			}
		});
		
		$("[name='deliveryfree-cb']").bootstrapSwitch({
			size: "large",
			onText: "Ja", 
			offText: "Nein",
			handleWidth: "70px",
			state: <?php 
				$string = $this->data['Offer']['additional_text'];
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
					res = '<?php echo Configure::read('padcon.Angebot.additional_text.deliveryFree');?>'
					$('#OfferAdditionalText').html(res);
					$("#deliveryCost").attr('value','<?php echo Configure::read('padcon.delivery_cost.frei');?>')
				} else {
					$("[name='delivery-cb']").bootstrapSwitch('state', true);
					var res = '<?php echo Configure::read('padcon.Angebot.additional_text.default');?>'
					$('#OfferAdditionalText').html(res);
					$("#deliveryCost").attr('value','<?php echo Configure::read('padcon.delivery_cost.paket');?>')
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
			
			
			
					<?php echo $this->Form->create('Offer');?>
					
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
								<label class="col-md-6">Auftragsdatum</label>
                               	<div class="input-group date">     	
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                <?php echo $this->Form->input('request_date', array(
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
									    todayHighlight: true, 
									    });
								</script>
								
								 <!-- Auftragsnummer -->
	                            <label class="col-md-6">Anfragenummer</label>
	                            <div class="input-group">
	                             	
	                                <span class="input-group-addon"><b>#</b></span>
	                                <?php echo $this->Form->input('request_number', array(
									    'label' => false,
									    'div' => false,
									    'class'=> 'form-control span12'));
									?>                                     
	                             </div>
								
								 <!-- Rabatt -->
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
										'label' => false, 
										'value' => $delivery));
									?>                                 
	                             </div>
	                             
	                             <div class="input-group">
	                                <?php echo $this->Form->input('additional_text', array(
									    'label' => array(
									    	'text' => 'Angebotstext',
									    	'class' => 'col-md-8'
									    ),
									    'cols' => '41'
										));
									?>                                     
	                             </div>

							</div>
						</div>					
					</div>
					
					<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
				        <button type="button" id="saveSettings" class="btn btn-primary">Speichern</button>
				      </div>
					

		</div><!-- end of .tab_container --> 
	</article><!-- end of stats article -->



</div>