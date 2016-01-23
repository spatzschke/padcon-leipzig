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
						<h5>Kundendaten</h2>
						<div class="row">
							<div class="col-md-4">
	                            <div class="input-group">
	                                <span class="input-group-addon"><b>#</b></span>
	                                <?php echo $this->Form->input('id', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Customer',
										'placeholder' => 'Nummer',
										'data-field' => 'title', 
										'autoComplete' => true,
										'type' => 'text'
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
					<!-- Rechts -->
					<div class="col-md-6">
						<h5>Adressen</h5>
						<?php
						if(isset($this->data['Customer']['Addresses'])){
							foreach ($this->data['Customer']['Addresses'] as $address) {
								echo $this->element('backend/portlets/Address/addressMiniViewPortlet', array('address' => $address,)); 
							}
						}?>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group">
									<button class="btn btn-success form-control add_address">Adresse hinzufügen</button>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group">
									
								</div>
							</div>
						</div>
						
					</div>
					
					<?php
					}
					?>
					
                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">                         
                            	<?php                    			
                            			echo '<input type="submit" value="'.$primary_button.'" class="btn btn-success form-control">';
                            	?>
                        	</div>
                        </div>
                    </div>
              	</form>
            </div>                     
        </div>  
    </div>
</div>
