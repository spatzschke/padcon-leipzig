<div class="container">    
        <div style="margin-top:50px;" class="mainbox col-md-12 col-md-offset-0 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                     <div class="panel-heading">
                        <div class="panel-title"><?php echo $title_for_panel; ?></div>
                        
                    </div>

                    <div class="panel-body" >

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
                            
                   
                        <?php echo $this->Form->create('Product', array(
							'class' => 'form-horizontal'
						)); ?> 
						
						<?php 						
						if($this->request->params['action'] == "admin_edit") {
							$readonly = "readonly";
						} else {
							$readonly = "";
						}
						?>  
						<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                            <?php echo $this->Form->input('category_id', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Product',
								'placeholder' => 'Kategorie',
								'data-field' => 'category_id', 
								'autoComplete' => true,
								'empty' => 'Bitte Kategorie wählen',
								'multiple' => 'multiple',
								'style' => 'height: 200px'
							));
							?>                                      
                         </div>
						
						<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-align-justify"></i></span>
                            <?php echo $this->Form->input('description_quick', array(
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Product',
								'placeholder' => 'Beschreibung',
								'data-field' => 'description', 
								'autoComplete' => true,
								'type' => 'textarea'
							));
							?> 
						</div> 
						
						<div class="col-sm-12 controls">                          
							<?php 		
									echo '<input type="submit" value="Übernehmen" class="btn btn-success form-control">';
							?>
						</div>
					</form>
                </div>                     
            </div>  
        </div>



<?php 
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);
?>

<script>

$(document).ready(function() {
			
	$(".module form").liveValidation({
						url: '<?php echo FULL_BASE_URL.$this->base;?>\/Products\/liveValidate\/',
						urlBase: '<?php echo FULL_BASE_URL.$this->base;?>',
						autoSave: false,});
						
	$("img.lazy").lazyload();
	
	$('#ProductCustom').bind('click', function() {
		
		if($(this).is(':checked')) {
			loadCustomProductNumber();
		} else {
			$('#ProductProductNumber').val('');
		}
		
		
	});
			
});

function loadCustomProductNumber() {
	var obj = $('this');
	
	 $.ajax({
		 type: 'POST',
		 url:'<?php echo FULL_BASE_URL.$this->base;?>\/Products\/getNextCustomProductNumber\/',
		 data: '',
		 success:function (data, textStatus) {
				$('#ProductProductNumber').val(data);
		 } 
		 
		
	 }); 

	
}
</script>
<?php 

if(!empty($this->data['Products'])) {
 
foreach($this->data['Products'] as $i => $product){
$product = $product['Product'];
?>
<div class="container">    
        <div style="margin-top:50px;" class="mainbox col-md-12 col-md-offset-0 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                     <div class="panel-heading">
                        <div class="panel-title"><?php echo $title_for_panel; ?></div>
                        
                    </div>

                    <div class="panel-body" >

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
                            
                   
                        <?php echo $this->Form->create('Product', array(
							'class' => 'form-horizontal'
						)); ?> 
						
						<?php 
						echo $this->Form->input('id');
						
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
									'value' => $product['number']
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
									'value' => $product['name']
								));
								?>                                      
                             </div>
                             <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                <?php echo $this->Form->input('category_id', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Kategorie',
									'data-field' => 'category_id', 
									'autoComplete' => true,
									'empty' => 'Bitte Kategorie wählen',
									'value' => $product['category_id']
								));
								?>                                      
                             </div>
                             
                             <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
                                <?php echo $this->Form->input('material_id', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Material',
									'data-field' => 'material_id', 
									'autoComplete' => true,
									'empty' => 'Bitte Material wählen',
									'value' => $product['material']
								));
								?> 
							</div>
							<div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-resize-vertical"></i></span>
                                <?php echo $this->Form->input('size', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Größe',
									'data-field' => 'size', 
									'autoComplete' => true, 
									'type' => 'text',
									'value' => $product['maße']
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
										'value' => $product['ek']
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
											'value' => $product['vk']
										));
										?>                                      
		                             </div>
		                         </div>
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
												'data-model' => 'Product',
												'placeholder' => 'Aktiv',
												'data-field' => 'active', 
												'autoComplete' => true,
												'div' => false,
												$product['active']
											));
											?>  
										</span>
		                                <input type="text" class="form-control" value="Aktiv" readonly="readonly">                                    
		                             </div>
								</div>
								<div class="col-md-4">
		                             <div class="input-group">
		                                <span class="input-group-addon">
											<?php echo $this->Form->input('new', array(
												'label' => false,
												'data-model' => 'Product',
												'placeholder' => 'New',
												'data-field' => 'new', 
												'autoComplete' => true,
												'div' => false,
												$product['new']
											));
											?>  
										</span>
		                                <input type="text" class="form-control" value="Neu" readonly="readonly">                                    
		                             </div>
								</div>
								<div class="col-md-4">
		                             <div class="input-group">
		                                <span class="input-group-addon">
		                                	<?php 
		                                	
		                                	if($this->request->params['action'] == "admin_edit") {
												$readonlyCustom = "disabled";
											} else {
												$readonlyCustom = "";
											}
		                                	
											echo $this->Form->input('custom', array(
												'label' => false,
												'data-model' => 'Product',
												'placeholder' => 'Sonderanfertigung',
												'data-field' => 'custom', 
												'autoComplete' => true,
												'div' => false,
												$readonlyCustom,
												$product['custom']
											));
											?>  
										</span>
		                                <input type="text" class="form-control" value="Sonder" readonly="readonly">                                    
		                             </div>
								</div>
							</div> 
						</div>
						
						 <!-- Mitte -->
						<div class="col-md-4">
							<div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-align-justify"></i></span>
                                <?php echo $this->Form->input('description', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Beschreibung',
									'data-field' => 'description', 
									'autoComplete' => true,
									'type' => 'textarea',
								));
								?> 
							</div>
							
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
										'value' => $product['feature']
									));
									?>                                      
	                        </div>
                        </div>
                        
                         <!-- Rechts -->
                        <div class="col-md-4">
				         	<?php echo $this->element('backend/portlets/Product/productImagePortlet'); ?>
                        </div>
                        
                  	</div>
                </div>                     
            </div>  
</div> </div> </div> 
    
<?php 
   }
?>
</form>
<div class="container"> 
	<div class="col-sm-12 controls">                          
		<?php 		
				echo '<input type="submit" value="'.$primary_button.'" class="btn btn-success form-control">';
		?>
	</div>
</div>
    </div>
<?php 
}
?>

