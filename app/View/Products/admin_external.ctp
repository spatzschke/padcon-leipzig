<div class="container" style="padding-top: 50px">
	
	<?php echo $this->Form->create('Product', array(
		'class' => 'form-horizontal'
	)); ?> 
	
		<?php ?>

<script>


</script>

<div class="mainbox col-md-12 col-md-offset-0 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title"><?php echo $title_for_panel; ?></div>
                
            </div>

            <div class="panel-body form-horizontal" >

               	<?php 
               		if(isset($errors)) {
               			echo '
               				<div class="row alert-row">
								<div class="alert alert-danger col-md-12" role="alert" style="margin-bottom: 0;">
								  Folgende Fehler sind aufgetreten
								  <br /><br />
								  <ul>
								  ';
								  foreach($errors as $error) {
								  	echo '<li>'.$error[0].'</li>';
								  }
						echo '
								</ul>
								</div>
							</div>
               			';
               		} else {
               			echo $this->Session->flash();
               		}
               		 ?>
               		 
               		 
                    
           		<?php echo $this->Form->input('id', array('hidden' => true, 'label' => false));?>   
                
				<?php 			
				if($this->request->params['action'] == "admin_edit_external") {
					$readonly = "";
				} else {
					$readonly = "";
				}

				?>   
				<!-- Links -->
			
				<div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon"><b>#</b></span>
                        <?php echo $this->Form->input('product_number', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Produktnummer',
							'data-field' => 'product_number', 
							'autoComplete' => true,
							'value' => $data['Product']['product_number'], 
							'readonly' => $readonly
						));
						?>                                     
                     </div>
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <?php echo $this->Form->input('name', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Produktname',
							'data-field' => 'name', 
							'autoComplete' => true,
							'value' => $data['Product']['name'], 
							
						));
						?>                                      
                     </div>
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
                        <?php echo $this->Form->input('company', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Firma',
							'data-field' => 'company', 
							'autoComplete' => true, 
							'type' => 'text',
							'value' => $data['Product']['company'], 
						));
						?>                                      
                     </div>
            		
                    <div class="row">
                    	<div class="col-md-6">
                    	<div class="input-group">
                            <span class="input-group-addon"><i 
                            	data-content="Einkaufspreis" 
                            	data-placement="left" 
                            	data-trigger="hover" 
                            	data-toggle="popover" 
                            	style="cursor: pointer" 
                            	class="glyphicon glyphicon-shopping-cart" 
                            	data-original-title="" 
                            	title=""></i></span>
                            <?php echo $this->Form->input('price', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Product',
								'placeholder' => 'Einkaufspreis',
								'data-field' => 'price', 
								'autoComplete' => true,
								'min' => 0,
								'type' => 'text',
								'value' => $this->Number->currency($data['Product']['price'],'EUR', array('before' => false)), 
							));
							?> 
							<span class="input-group-addon"><b>€</b></span>                                   
                         </div>
                        </div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i 
                                	data-content="Verkaufsspreis" 
                                	data-placement="left" 
                                	data-trigger="hover" 
                                	data-toggle="popover" 
                                	style="cursor: pointer" 
                                	class="glyphicon glyphicon-piggy-bank" 
                                	data-original-title="" 
                                	title=""></i></span>
                                <?php echo $this->Form->input('retail_price', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Products',
									'placeholder' => 'Verkaufspreis',
									'data-field' => 'retail_price', 
									'autoComplete' => true,
									'min' => 0,
									'type' => 'text',
									'value' => $this->Number->currency($data['Product']['retail_price'],'EUR', array('before' => false)),
								));
								?>      
								<span class="input-group-addon"><b>€</b></span>                                
                             </div>
                         </div>
                	</div> 
                 </div>  
				
				 <!-- Mitte -->
				<div class="col-md-8">
												
					<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <?php echo $this->Form->input('featurelist', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Product',
								'placeholder' => 'Produktbeschreibung',
								'data-field' => 'featurelist', 
								'autoComplete' => true,
								'type' => 'textarea',
								'rows' => '7',
								'value' => $data['Product']['featurelist'], 
								'style' => 'height: 166px',
							));
							?>                                      
                    </div>
                    
                      
                    
                </div>
          	
          	
		</div> 
		                        
	</div> 

		
		<div class="col-sm-12 controls">                          
			<?php 		
					echo '<input type="submit" value="Anlegen" class="btn btn-success form-control">';
			?>
		</div>
	</form>
	
	
</div>