 <?php 


?>	

<script>
	
	$(document).ready(function() {
	
		$('#saveSettings').on('click', function(){
			
			<?php			
				$data = $this->Js->get('#DeliveryAdminTrackingcodeForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
			?>
			
			var xhr = null,
			obj = $(this);			
			obj.addClass('loading');
				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/sended/<?php echo $this->data['Delivery']['id'];?>',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	obj.removeClass('loading');
					 	
						window.location = '<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/index/';
					 } 
				 }); 
				return false;
			});	
	});
</script>

<article class="module width_full settingsPortlet">
		
		<?php echo $this->Session->flash(); ?>
		
		<div class="module_content row-fluid">
					
					<?php echo $this->Form->create('Delivery');?>
					

					<div class="col-md-12">
						<?php echo $this->Form->input('id');?>
						<?php echo $this->Form->input('status', array('type' => 'hidden'));?>
						<div class="panel panel-info" >
                    		<div class="panel-body" >
								<label class="col-md-6">Lieferschein-Nummer</label>
                               	<div class="input-group number">     	
	                                <span class="input-group-addon"><i class="">#</i></span>
	                                <?php echo $this->Form->input('delivery_number', array(
									    'label' => false,
									    'div' => false,
									    'type' => 'text',
										'class' => 'form-control span12',
										'readonly' => 'readonly'));
									
									?> 	
								</div>
								<label class="col-md-6">Versendet am</label>
                               	<div class="input-group date">     	
			                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                        <?php echo $this->Form->input('send_date', array(
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
								<label class="col-md-6">Trackingcode</label>
                               	<div class="input-group number">     	
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-qrcode"></i></span>
	                                <?php echo $this->Form->input('trackingcode', array(
									    'label' => false,
									    'div' => false,
									    'type' => 'text',
										'class' => 'form-control span12'));
									
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
