<?php 
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
						
	$('.glyphicon').popover({
            html:true
        });
									
});

</script>

<div class="container"> 
	<div class="modal fade" id="address_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
		 	<div class="modal-content">
				<div class="modal-body"></div>
			</div>
		</div>
	</div>   
    <div style="margin-top:50px;" class="mainbox col-md-8 col-md-offset-1 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
                 <div class="panel-heading">
                    <div class="panel-title"><?php echo $title_for_panel; ?></div>
                    
                </div>

                <div class="panel-body" >

                   	<?php echo $this->Session->flash(); ?>
                        
               
                    <?php echo $this->Form->create('Customer', array(
						'class' => 'form-horizontal'
					)); ?> 
					<!-- Links -->
					<?php echo $this->Form->input('id');?> 
					<div class="col-md-12">
						<h4>Kundendaten</h4>
						<div class="row">
							<div class="col-md-4">
	                            <div class="input-group">
	                                <span class="input-group-addon"><b data-toggle="popover" 
										 data-content=""
										 data-trigger="hover">#</b>
								</span>
	                                <?php echo $this->Form->input('id', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Customer',
										'placeholder' => 'Nummer',
										'data-field' => 'title', 
										'autoComplete' => true,
										'type' => 'text',
										'readonly' => 'readonly',
										'disabled' => 'disabled'
									));
									?>                                      
	                             </div>
	                         </div>
                        	<div class="col-md-8">
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	                                <?php echo $this->Form->input('organisation', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Customer',
										'placeholder' => 'Kundenname',
										'data-field' => 'title', 
										'autoComplete' => true,
										'type' => 'text'
									));
									?>                                      
	                             </div>
	                         </div>
                         </div>
                         <?php if($this->request->params['action'] == "admin_edit") { ?>
                         <div style="margin-top:10px" class="form-group">
	                        <!-- Button -->
	                        <div class="col-sm-12 controls">                         
	                        	<?php                    			
	                        			echo '<input type="submit" value="'.$primary_button.'" class="btn btn-success form-control">';
	                        	?>
	                    	</div>
	                    </div>
	                    <?php } ?>
                         </form>
                         <hr>
                         <?php if($this->request->params['action'] == "admin_view") { ?>
                         <div class="row">
		                 <h4>Auswertung</h4>   
		                 
		                 		<?php 
	                    
	                    	$chartSize = '110';
							$defaultColor = '#F7464A';
							$defaultHighlightColor = '#FF5A5E';
							$defaultTransparentColor = '#f5f5f5';
	                    	
	                   	?>
		                 
		                     <?php foreach($this->data['CustomerInformation'] as $info) { 
		                     	
		                     	?>
		                    
		                    <div class="chartEntry col-md-4">
		                    	<div class="title"><?php echo $info['title'] ?></div>
		                    	<div class="chart">
		                    		<div class="data"><?php echo $info['percent'] ?></div>
		                    		<div id="canvas-holder">
										<canvas id="chart-<?php echo $info['data'] ?>" width="<?php echo $chartSize ?>" height="<?php echo $chartSize ?>"/>
										<script>
											var data<?php echo $info['data'] ?> = [
												{
													value: <?php echo $info['ownCount'] ?>,
													color:'<?php echo $defaultColor ?>',
													highlight: '<?php echo $defaultHighlightColor ?>'
												}
												<?php if($info['percent'] != "100%" ) {?>
												,
												{
													value: <?php echo $info['allCount'] ?>,
													color: '<?php echo $defaultTransparentColor ?>',
													highlight: '<?php echo $defaultTransparentColor ?>'
													
												}
												<?php } ?>
											];
											var ctx<?php echo $info['data'] ?> = document.getElementById("chart-<?php echo $info['data'] ?>").getContext("2d");
											window.myPie = new Chart(ctx<?php echo $info['data'] ?>).Doughnut(data<?php echo $info['data'] ?>, {});
											
											</script> 
									</div>
								</div>
		                    </div>
		                    
		                    <?php } ?>
		                    
	                    </div>
	                  <?php } ?>
                         
                         					</div>
					<?php
					if(isset($this->data['Customer'])) {
					?>
					<script>

					$(document).ready(function() {
								
						$('.add_address').on('click', function(){
								
							var c = $('.address_dummy').length;
								
							$('#address_add .modal-content').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Addresses\/add\/'+c+'\/<?php echo $this->data['Customer']['id'];?>');
							$('#address_add').modal('show');
							
							return false;
						});														
					});
					
					</script>
					<div class="col-md-12">
						<hr>
						<h4 class="col-md-8">Adressen</h4> <button class="btn btn-success add_address pull-right">Adresse hinzufügen</button>
							
						<?php
						if(isset($this->data['Customer']['Addresses'])){
							foreach ($this->data['Customer']['Addresses'] as $address) {
								echo $this->element('backend/portlets/Address/addressMiniViewPortlet', array('address' => $address['Address'],)); 
							}
						}?>
						
						
					</div>
					
					<?php
					}
					?>
					
                    
                </div>
              	
            </div>                     
        </div>  
    </div>
</div>
