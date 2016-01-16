 <?php 


?>	

<script>
	function save() {
		<?php			
			$data = $this->Js->get('#ConfirmationAdminTableSettingForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
		?>
		
		var xhr = null,
		obj = $(this);			
		obj.addClass('loading');
			xhr = $.ajax({
				 type: 'POST',
				 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/table_setting/<?php echo $this->data['Confirmation']['id'];?>',
				 data: <?php echo $data ?>,
				 success:function (data, textStatus) {
				 	obj.removeClass('loading');
				 	window.location = '<?php echo FULL_BASE_URL.$this->base;?>/admin/<?php echo $controller_name;?>/index/';
				 } 
			 }); 
			
	}

	$(document).ready(function() {
	
		$('#saveSettings').on('click', function(){
			
			save();
			return false;
		});	
	
		$('#status').on('click', function(){
		
			$('#ConfirmationStatus').val($(this).attr('data-status'));
			save();
			
			return false;	
		});
	
			
	});

</script>

<article class="module width_full settingsPortlet">
		
		<?php echo $this->Session->flash(); ?>
		
		<div class="module_content row-fluid">
					
					<?php echo $this->Form->create('Confirmation');?>
					

					<div class="col-md-12">
						<?php echo $this->Form->input('id');?>
						<?php echo $this->Form->input('status', array('type' => 'hidden'));?>
						<div class="panel panel-info" >
                    		<div class="panel-body" >
								<label class="col-md-6">AB-Nummer</label>
                               	<div class="input-group number">     	
	                                <span class="input-group-addon"><i class="">#</i></span>
	                                <?php echo $this->Form->input('confirmation_number', array(
									    'label' => false,
									    'div' => false,
									    'type' => 'text',
										'class' => 'form-control span12'));
									
									?> 	
								</div>
								<label class="col-md-6">AB-Datum</label>
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
							</div>
						</div>
					</div>						
					
					<div class="modal-footer">
						<?php
							if(strpos($this->data['Confirmation']['status'], 'cancel') !== FALSE){
								if(!empty($this->data['Confirmation']['delivery_id'])) {
									echo '<button type="button" id="status" class="btn btn-success pull-left" data-status="close" data-dismiss="modal">Reaktivieren</button>';
								} else {
									echo '<button type="button" id="status" class="btn btn-success pull-left" data-status="open" data-dismiss="modal">Reaktivieren</button>';
								}
							} else {
								echo '<button type="button" id="status" class="btn btn-danger pull-left" data-status="cancel" data-dismiss="modal">Stornieren</button>';
							}
						?>
				        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
				        <button type="button" id="saveSettings" class="btn btn-primary">Speichern</button>
				      </div>
					

		</div><!-- end of .tab_container --> 
	</article><!-- end of stats article -->
