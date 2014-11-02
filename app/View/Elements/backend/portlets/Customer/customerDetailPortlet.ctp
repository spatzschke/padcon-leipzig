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
						
	$('.add_address').on('click', function(){
			
			var c = $('.address_dummy').length;
				
			$('#address_add .modal-content').load('<?php echo FULL_BASE_URL.$this->base;?>\/admin\/Addresses\/add\/'+c);
			$('#address_add').modal('show');
			
			return false;
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
					<div class="col-md-6">
						<h5>Direkter Ansprechpartner</h2>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-minus"></i></span>
	                                <?php echo $this->Form->select('salutation', array('Herr' => 'Herr', 'Frau' => 'Frau'), array(
										'class' => 'form-control',
										'label' => FALSE, 
										'div' => FALSE,
										'data-model' => 'Customer', 
										'data-field' => 'salutation', 
										'autoComplete' => true));
									?>   
								</div>                          
                        	</div>
                        	<div class="col-md-6">
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-minus"></i></span>
	                                <?php echo $this->Form->input('title', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Customer',
										'placeholder' => 'Titel',
										'data-field' => 'title', 
										'autoComplete' => true
									));
									?>                                      
	                             </div>
	                         </div>
                         </div>
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <?php echo $this->Form->input('first_name', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Customer',
								'placeholder' => 'Vorname',
								'data-field' => 'first_name', 
								'autoComplete' => true
							));
							?>                                      
                         </div>
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <?php echo $this->Form->input('last_name', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Customer',
								'placeholder' => 'Nachname',
								'data-field' => 'last_name', 
								'autoComplete' => true
							));
							?>                                      
                         </div>
                         
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                            <?php echo $this->Form->input('organisation', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Customer',
								'placeholder' => 'Organisation',
								'data-field' => 'organisation', 
								'autoComplete' => true,
								'type' => 'textarea'
							));
							?> 
						</div>
                         
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                            <?php echo $this->Form->input('department', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Customer',
								'placeholder' => 'Abteilung',
								'data-field' => 'department', 
								'autoComplete' => true,
								'type' => 'textarea',
								'rows' => '3'
							));
							?> 
						</div>
                         
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <?php echo $this->Form->input('email', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Customer',
								'placeholder' => 'Email',
								'data-field' => 'email', 
								'autoComplete' => true
							));
							?>                                      
                         </div>
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <?php echo $this->Form->input('phone', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Customer',
								'placeholder' => 'Telefon',
								'data-field' => 'phone', 
								'autoComplete' => true
							));
							?>                                      
                         </div>
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
                            <?php echo $this->Form->input('fax', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Customer',
								'placeholder' => 'Fax',
								'data-field' => 'fax', 
								'autoComplete' => true,
								'type' => 'text'
							));
							?>                                      
                         </div>
                         
                         
					</div>
					
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
