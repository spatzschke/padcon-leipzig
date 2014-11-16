<script>
	$(document).ready(function() {
	
		$('#saveSettings').on('click', function(){
			
			<?php 
			
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
								<label class="col-md-12">Auftragsdatum</label>
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
									    startDate: 'd',
									    format: "dd.mm.yyyy",
									    language: "de",
									    calendarWeeks: true,
									    autoclose: true,
									    todayHighlight: true
									    });
								</script>
								
	                            <label class="col-md-12">Rabatt</label>
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
	                             <div class="input-group">
	                                <?php echo $this->Form->input('additional_text', array(
									    'label' => array(
									    	'text' => 'Angebotstext',
									    	'class' => 'col-md-12'
									    ),
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