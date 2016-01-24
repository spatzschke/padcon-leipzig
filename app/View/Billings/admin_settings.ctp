 <?php 


?>	

<script>
	$(document).ready(function() {
		
		$("#BillingAdditionalText").keyup(function() {
			
			var text = $(this).val();
			var spliting = text.split('Tage');
			
			var nettoDays = spliting[0].split('bedingung:')[1].trim();
			var skontoDays = spliting[1].split('oder ')[1].trim();
			var skonto = spliting[1].split('%')[0].trim();
			
			$("#BillingNettoDays").attr('value',nettoDays);
			$("#BillingSkontoDays").val(skontoDays);
			$("#BillingSkonto").val(skonto);			
		})
		
		$("#BillingNettoDays").change(function() {
			var text = $('#BillingAdditionalText').val();
			var spliting = text.split('Tage')
			var days = spliting[0].split('bedingung:')[1].trim();
			var newText = text.replace(": "+days+" Tage", ": "+$(this).val()+" Tage")			
			$("#BillingAdditionalText").html(newText.trim());
		})
		
		$("#BillingSkontoDays").change(function() {
			var text = $('#BillingAdditionalText').val();
			var spliting = text.split('Tage')
			var days = spliting[1].split('oder ')[1].trim();
			var newText = text.replace("oder "+days+" Tage", "oder "+$(this).val()+" Tage")			
			$("#BillingAdditionalText").html(newText.trim());
		})
		
		$("#BillingSkonto").change(function() {
			var text = $('#BillingAdditionalText').val();
			var spliting = text.split('Tage')
			var skonto = spliting[1].split('%')[0].trim();
			var newText = text.replace(skonto+"%", $(this).val()+"%")			
			$("#BillingAdditionalText").html(newText.trim());
		})
		
		
	
		$('#saveSettings').on('click', function(){
			
			<?php 
			
				$data = $this->Js->get('#BillingAdminSettingsForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
			?>
			
			var xhr = null,
			obj = $(this);			
			obj.addClass('loading');
				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/settings',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
						window.location = '<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/view/<?php echo $controller_id;?>';
					 } 
				 }); 
				
			

			
			return false;
		});
		
		 
		
	});

</script>

<div class="offer form">

<article class="module width_full settingsPortlet">
		
		<?php echo $this->Session->flash(); ?>
		
		<div class="module_content row-fluid">
					
					<?php echo $this->Form->create('Billing');
					
					echo $this->Form->input('id');
					?>
					
					<div class="col-md-7 productTable">
						
								<label class="col-md-6">Rechnungs-Datum</label>
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
								<label class="col-md-6">Netto in Tage</label>
                               	<div class="input-group">   
                               		
	                                <?php echo $this->Form->input('nettoDays', array(
									    'label' => false,
									    'div' => false,
									    'type' => 'number',
										'class' => 'form-control span2',
										'min' => 0));
									?>
									<span class="input-group-addon"><i>Tage</i></span>   	
	                                
								</div>
								<label class="col-md-6">Skonto in %</label>
                               	<div class="input-group">     	
	                                
	                                <?php echo $this->Form->input('skonto', array(
									    'label' => false,
									    'div' => false,
									    'type' => 'number',
										'class' => 'form-control span12',
										'min' => 0));
									
									?> 	
									<span class="input-group-addon"><b>%</b></span>
								</div>
								<label class="col-md-6">Skonto in Tage</label>
                               	<div class="input-group">   
                               		
	                                <?php echo $this->Form->input('skontoDays', array(
									    'label' => false,
									    'div' => false,
									    'type' => 'number',
										'class' => 'form-control span2',
										'min' => 0));
									?>
									<span class="input-group-addon"><i>Tage</i></span>   	
	                                
								</div>
							
	                          
					</div>
					<div class="col-md-5">
								<div class="input-group">
			                                <?php echo $this->Form->input('additional_text', array(
											    'label' => array(
											    	'text' => 'Rechnungstext',
											    	
											    ),
											    'cols' => '41'
												));
											?>                                     
	                             	</div>
	                           
					</div>
	
					
					
					
					<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
				        <button type="button" id="saveSettings" class="btn btn-primary">Speichern</button>
				      </div>
					

		</div><!-- end of .tab_container --> 
	</article><!-- end of stats article -->



</div>