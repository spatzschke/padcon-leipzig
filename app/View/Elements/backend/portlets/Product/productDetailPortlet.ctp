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
                    
           		<?php echo $this->Form->input('id');?>   
                
				<?php 			
				if($this->request->params['action'] == "admin_edit") {
					$readonly = "readonly";
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
                        <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                        <?php  echo $this->Form->input('categories', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Kategorie',
							'data-field' => 'categories', 
							'autoComplete' => true,
							'multiple' => 'multiple',
  							'type' => 'select',
  							'style' => 'height: 185px',
  							'default' => $data['Product']['categories']
						));
						?>                                      
                     </div>
            
                    <div class="row">
                    	<div class="col-md-6">
                    	<div class="input-group">
                            <span class="input-group-addon"><b>€</b></span>
                            <?php echo $this->Form->input('price', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Product',
								'placeholder' => 'Einkaufspreis',
								'data-field' => 'price', 
								'autoComplete' => true,
								'min' => 0,
								'value' => $data['Product']['price'], 
							));
							?>                                    
                         </div>
                        </div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><b>€</b></span>
                                <?php echo $this->Form->input('retail_price', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Products',
									'placeholder' => 'Verkaufspreis',
									'data-field' => 'retail_price', 
									'autoComplete' => true,
									'min' => 0,
									'value' => $data['Product']['retail_price'], 
								));
								?>                                      
                             </div>
                         </div>
                     </div> 
                      
				</div>
				
				 <!-- Mitte -->
				<div class="col-md-4">
												
					<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <?php echo $this->Form->input('featurelist', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Product',
								'placeholder' => 'Featurliste',
								'data-field' => 'featurelist', 
								'autoComplete' => true,
								'type' => 'textarea',
								'rows' => '7',
								'value' => $data['Product']['featurelist'], 
								'style' => 'height: 141px',
							));
							?>                                      
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
                        <?php echo $this->Form->input('material_id', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Bezug',
							'data-field' => 'material_id', 
							'autoComplete' => true,
							'empty' => 'Bitte Bezug wählen',
							'value' => $data['Product']['material_id'], 
						));
						?> 
					</div>
					<div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-scale"></i></span>
                        <?php echo $this->Form->input('size', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Größe',
							'data-field' => 'size', 
							'autoComplete' => true, 
							'type' => 'text',
							'value' => $data['Product']['size'], 
						));
						?>                                      
                     </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon glyphicon-briefcase"></i></span>
                        <div class="row">
                        <?php echo $this->Form->input('producer_name', array(
							'label' => false,
							'class' => 'form-control',
							'type' => 'text',
							'data-model' => 'Product',
							'placeholder' => 'Herstellername',
							'data-field' => 'producerName', 
							'autoComplete' => true,
							'value' => $data['Product']['producer_name'],
							'div' => array(
						        'class' => 'col-md-6',
						    ), 
						));
						?>
						<?php echo $this->Form->input('producer_number', array(
							'label' => false,
							'class' => 'form-control',
							'type' => 'text',
							'data-model' => 'Product',
							'placeholder' => 'Herstellernummer',
							'data-field' => 'producerNumber', 
							'autoComplete' => true,
							'value' => $data['Product']['producer_number'],
							'div' => array(
						        'class' => 'col-md-6',
						    ), 
						));
						?>  </div>                                         
                     </div>
                     	
                    <div class="row">
                    	<div class="col-md-4">
                             <div class="input-group">
                                <span class="input-group-addon">
									<?php 
									$checked = "";
									if(isset($this->data['Product']['active'])) {
										$checked = "checked";
									}
									
									echo $this->Form->input('active', array(
										'label' => false,
										'type' => 'checkbox',
										'data-model' => 'Product',
										'placeholder' => 'Aktiv',
										'data-field' => 'active', 
										'autoComplete' => true,
										'div' => false,
										$data['Product']['active']
									));
									?>  
								</span>
                                <input type="text" class="form-control" value="Aktiv" readonly="readonly">                                    
                             </div>
						</div>
						<div class="col-md-3" style="width: 105px; padding-left: 0">
                             <div class="input-group">
                                <span class="input-group-addon">
									<?php echo $this->Form->input('new', array(
										'label' => false,
										'type' => 'checkbox',
										'data-model' => 'Product',
										'placeholder' => 'New',
										'data-field' => 'new', 
										'autoComplete' => true,
										'div' => false,
										$data['Product']['new'], 
									));
									?>  
								</span>
                                <input type="text" class="form-control" value="Neu" readonly="readonly">                                    
                             </div>
						</div>
						<div class="col-md-5" style="width: 134px; padding: 0">
                             <div class="input-group">
                                <span class="input-group-addon">
									<?php echo $this->Form->input('custom', array(
										'label' => false,
										'type' => 'checkbox',
										'data-model' => 'Product',
										'placeholder' => 'Sonder',
										'data-field' => 'custom', 
										'autoComplete' => true,
										'div' => false,
										$data['Product']['custom'], 
									));
									?>  
								</span>
                                <input type="text" class="form-control" value="Sonder" readonly="readonly">                                    
                             </div>
						</div>
					</div>
                </div>
                
                 <!-- Rechts -->
                 <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon  glyphicon-screenshot"></i></span>
                    <?php echo $this->Form->input('core_name', array(
						'label' => false,
						'class' => 'form-control',
						'data-model' => 'Product',
						'placeholder' => 'Kernbezeichnung',
						'data-field' => 'core_name', 
						'autoComplete' => true, 
						'type' => 'text',
						'value' => $data['Product']['core_name'], 
						'readonly' => 'readonly'
					));
					?>                                      
                 </div>
                <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-screenshot"></i></span>
                        <?php                         
                        
                        echo $this->Form->input('cores', array(
                        	'multiple' => 'multiple',
  							'type' => 'select',
  							'style' => 'height: 273px',
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Core',
							'placeholder' => 'Kern',
							'data-field' => 'cores', 
							'autoComplete' => true,
							'default' => $data['Product']['cores'],
						));
												
						?> 
					</div>  
          	</div>
          	
		</div> 
		                        
	</div> 
