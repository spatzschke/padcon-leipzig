<?php 
	echo $this->Html->script('jquery.caret.1.02.min', false);
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);

	$action = 'add';
	if($this->request->params['action'] == 'admin_edit') { $action = 'edit'; }

?>

<script>

$(document).ready(function() {
						
			
			$('.addAddressNow').on('click', function(){
					
				<?php
					$form = '#AddressAdminAddForm';
					if($this->request->params['action'] == 'admin_edit') { $form = '#AddressAdminEditForm'; }
				 
					$data = $this->Js->get($form)->serializeForm(array('isForm' => true, 'inline' => true)); 
				?>
								
				var xhr = null
				
				obj = $(this),
				

				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/Addresses/<?php echo $action;?>/<?php echo $this->data['Customer']['id'];?>/<?php echo (isset($this->data['Address']['id'])) ? $this->data['Address']['id']: '';?>',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 		
					 //	window.location = '<?php echo FULL_BASE_URL.$this->base;?>/admin/Customers/view/<?php echo $this->data['Customer']['id'];?>';
					 	//window.location = '';
					 	
					 }
				}); 
				return false;
			}); 
			
			
			
});



</script>
    <div class="mainbox col-md-10">                   
        <div class="panel panel-info" >
               <div class="panel-body" >
                      <?php
				
					//echo '<span>Addressen zu Kunde: '.$customer['Customer']['id'].' - '.$customer['Customer']['organisation'].'/span>';
					echo '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>';
					?>	 
               
                    <?php echo $this->Form->create('Address', array(
						'class' => 'form-horizontal'
					)); ?> 
					<!-- Links -->
					
					
					
					 <!-- Rechts -->
					<div class="col-md-12">
						
						<?php echo $this->Form->input('id');
						?> 
						
						<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin" data-toggle="popover" data-content="Adresstypen" data-trigger="hover" data-placement="left"></i></span>
                            <?php 
                                                       
                            echo $this->Form->input('addressTypes', array(
								'multiple' => 'multiple',
	  							'type' => 'select',
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Address',
								'placeholder' => 'Adresstypen',
								'data-field' => 'addressTypes', 
								'autoComplete' => true,
								'selected' => $this->data['Address']['addressType']));
							?>   
						</div>                          
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                            <?php echo $this->Form->input('organisation', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Address',
								'placeholder' => 'Organisation',
								'data-field' => 'organisation', 
								'autoComplete' => true,
								'type' => 'text',
							));
							?> 
						</div>
                         
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                            <?php echo $this->Form->input('department', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Address',
								'placeholder' => 'Abteilung',
								'data-field' => 'department', 
								'autoComplete' => true,
								'type' => 'text',
							));
							?> 
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-bullhorn"></i></span>
	                                <?php echo $this->Form->select('salutation', array('Herr' => 'Herr', 'Frau' => 'Frau'), array(
										'class' => 'form-control',
										'label' => FALSE, 
										'div' => FALSE,
										'placeholder' => 'Anrede',
										'data-model' => 'Address', 
										'data-field' => 'salutation', 
										'autoComplete' => true,));
									?>   
								</div>                          
                        	</div>
                        	<div class="col-md-6">
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
	                                <?php echo $this->Form->input('title', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Address',
										'placeholder' => 'Titel',
										'data-field' => 'title', 
										'autoComplete' => true,
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
								'data-model' => 'Address',
								'placeholder' => 'Vorname',
								'data-field' => 'first_name', 
								'autoComplete' => true,
							));
							?>                                      
                         </div>
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <?php echo $this->Form->input('last_name', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Address',
								'placeholder' => 'Nachname',
								'data-field' => 'last_name', 
								'autoComplete' => true,
							));
							?>                                      
                         </div>
                         
                        
						<div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                                <?php echo $this->Form->input('street', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Address',
									'placeholder' => 'Straße',
									'data-field' => 'street', 
									'autoComplete' => true
								));
								?>                                      
                        </div>
                    
                        <div class="row">
							<div class="col-md-4">
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-minus"></i></span>
	                                <?php echo $this->Form->input('postal_code', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Address',
										'placeholder' => 'PLZ',
										'data-field' => 'postal_code', 
										'autoComplete' => true,
										'type' => 'text'
									));
									?>                                      
	                             </div>
	                         </div>
                        	<div class="col-md-8">
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-tree-deciduous"></i></span>
	                                <?php echo $this->Form->input('city', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Address',
										'placeholder' => 'Stadt',
										'data-field' => 'city', 
										'autoComplete' => true
									));
									?>                                      
	                             </div>
	                        </div>
						</div> 
						<hr>
						<div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-send"></i></span>
                                <?php echo $this->Form->input('email', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Address',
									'placeholder' => 'eMail',
									'data-field' => 'email', 
									'autoComplete' => true
								));
								?>                                      
                        </div>
                        <div class="row">
							<div class="col-md-6">
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
	                                <?php echo $this->Form->input('phone', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Address',
										'placeholder' => 'Telefon',
										'data-field' => 'phone', 
										'autoComplete' => true,
										'type' => 'text'
									));
									?>                                      
	                             </div>
	                         </div>
                        	<div class="col-md-6">
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
	                                <?php echo $this->Form->input('fax', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Address',
										'placeholder' => 'Fax',
										'data-field' => 'fax', 
										'autoComplete' => true,
										'type' => 'text'
									));
									?>                                      
	                             </div>
	                        </div>
						</div>
                        
					</div>
                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">                         
                        	<?php                    			
                        			echo '<button class="btn btn-success form-control addAddressNow">Speichern</button>';
                        	?>
                    	</div>
                    </div>
                    </form>
          		</div>
            </div>                     
        </div> 
</div>
