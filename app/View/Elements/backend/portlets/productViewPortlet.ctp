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
		
		if($(this).val() == 1) {
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

<div class="container">    
        <div style="margin-top:50px;" class="mainbox col-md-12 col-md-offset-0 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                     <div class="panel-heading">
                        <div class="panel-title"><?php echo $title_for_panel; ?></div>
                        
                    </div>

                    <div class="panel-body" >

                       	<?php echo $this->Session->flash(); ?>
                            
                   
                        <?php echo $this->Form->create('Product', array(
							'class' => 'form-horizontal'
						)); ?> 
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
									'autoComplete' => true
								));
								?>                                     
                             </div>
                             <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <?php echo $this->Form->input('name', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Produktname',
									'data-field' => 'name', 
									'autoComplete' => true
								));
								?>                                      
                             </div>
                             <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <?php echo $this->Form->input('category_id', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Kategorie',
									'data-field' => 'category_id', 
									'autoComplete' => true,
									'empty' => 'Bitte Kategorie wählen'
								));
								?>                                      
                             </div>
                             
                             <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                                <?php echo $this->Form->input('material_id', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Material',
									'data-field' => 'material_id', 
									'autoComplete' => true,
									'empty' => 'Bitte Material wählen'
								));
								?> 
							</div>
							<div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <?php echo $this->Form->input('size_id', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Product',
									'placeholder' => 'Größe',
									'data-field' => 'size_id', 
									'autoComplete' => true
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
										));
										?>                                      
		                             </div>
		                         </div>
                             </div> 
                             <div class="row">
                            	<div class="col-md-4">
		                             <div class="input-group">
		                                <span class="input-group-addon">
											<?php echo $this->Form->input('active', array(
												'label' => false,
												'data-model' => 'Product',
												'placeholder' => 'Aktiv',
												'data-field' => 'active', 
												'autoComplete' => true,
												'div' => false
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
												'div' => false
											));
											?>  
										</span>
		                                <input type="text" class="form-control" value="Neu" readonly="readonly">                                    
		                             </div>
								</div>
								<div class="col-md-4">
		                             <div class="input-group">
		                                <span class="input-group-addon">
											<?php echo $this->Form->input('custom', array(
												'label' => false,
												'data-model' => 'Product',
												'placeholder' => 'Sonderanfertigung',
												'data-field' => 'custom', 
												'autoComplete' => true,
												'div' => false
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
                                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                <?php echo $this->Form->input('description', array(
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
							
							<div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
	                                <?php echo $this->Form->input('featurelist', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Product',
										'placeholder' => 'Featurliste',
										'data-field' => 'featurelist', 
										'autoComplete' => true,
										'type' => 'textarea'
									));
									?>                                      
	                        </div>
                        </div>
                        
                         <!-- Rechts -->
                        <div class="col-md-4">
				         	<?php echo $this->element('backend/portlets/productImagePortlet'); ?>
                        </div>
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                          
                                	<?php 
                                		if($this->request->params['action'] == 'admin_view') {
                                			
                                			echo '<input type="submit" value="Spechern" class="btn btn-success form-control">';
                                		} else {
                                			
                                			echo '<input type="submit" value="Anlegen" class="btn btn-success form-control">';	
                                		}
                                	
                                	?>
                            	</div>
                            </div>
                        </div>
                  	</form>
                </div>                     
            </div>  
        </div>
    </div>



