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
});

</script>

<div class="container">    
        <div style="margin-top:50px;" class="mainbox col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
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
					
						<div class="col-md-6">
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
											'autoComplete' => true,
											'readonly' => 'readonly'
										));
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
											'autoComplete' => true,
											'readonly' => 'readonly'
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
									'autoComplete' => true,
									'readonly' => 'readonly'
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
									'autoComplete' => true,
									'readonly' => 'readonly'
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
									'rows' => '3',
									'readonly' => 'readonly'
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
									'autoComplete' => true,
									'readonly' => 'readonly'
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
									'autoComplete' => true,
									'readonly' => 'readonly'
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
									'readonly' => 'readonly'
								));
								?>                                      
                             </div>
                             
                             
						</div>
						
						 <!-- Rechts -->
						<div class="col-md-6">
							<div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                <?php echo $this->Form->input('organisation', array(
									'label' => false,
									'class' => 'form-control',
									'data-model' => 'Customer',
									'placeholder' => 'Organisation',
									'data-field' => 'organisation', 
									'autoComplete' => true,
									'type' => 'textarea', 
									'readonly' => 'readonly'
								));
								?> 
							</div>
							
							<div class="input-group">
	                                <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
	                                <?php echo $this->Form->input('street', array(
										'label' => false,
										'class' => 'form-control',
										'data-model' => 'Customer',
										'placeholder' => 'Straße',
										'data-field' => 'street', 
										'autoComplete' => true, 
										'readonly' => 'readonly'
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
											'data-model' => 'Customer',
											'placeholder' => 'PLZ',
											'data-field' => 'postal_code', 
											'autoComplete' => true, 
											'readonly' => 'readonly'
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
											'data-model' => 'Customer',
											'placeholder' => 'Stadt',
											'data-field' => 'city', 
											'autoComplete' => true, 
											'readonly' => 'readonly'
										));
										?>                                      
		                             </div>
		                         </div>
							</div>
                    </div>
                    
                           <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                  
	                                    	
                                    	</div>
                                    </div>
                                </div>
 
                     </form>
                    
				</div>                     
            <div class="panel panel-info" >
	                     <div class="panel-heading">
	                        <div class="panel-title">Kundenauswertung</div>
	                        
	                    </div>
	                    
	                    <?php 
	                    
	                    	$chartSize = '110';
							$defaultColor = '#F7464A';
							$defaultHighlightColor = '#FF5A5E';
							$defaultTransparentColor = '#f5f5f5';
	                    	
	                   	?>
	
	                    <div class="panel-body" >
	                    	<div class="col-md-12">
	                    <div class="row">
		                    
		                     <?php foreach($this->data['CustomerInformation'] as $info) { ?>
		                    
		                    <div class="chartEntry col-md-4">
		                    	<div class="title"><?php echo $info['title'] ?></div>
		                    	<div class="chart">
		                    		<div class="data"><?php echo $info['percent'] ?>%</div>
		                    		<div id="canvas-holder">
										<canvas id="chart-<?php echo $info['title'] ?>" width="<?php echo $chartSize ?>" height="<?php echo $chartSize ?>"/>
										<script>
											var data<?php echo $info['title'] ?> = [
												{
													value: <?php echo $info['ownCount'] ?>,
													color:'<?php echo $defaultColor ?>',
													highlight: '<?php echo $defaultHighlightColor ?>'
												},
												{
													value: <?php echo $info['allCount'] ?>,
													color: '<?php echo $defaultTransparentColor ?>',
													highlight: '<?php echo $defaultTransparentColor ?>'
													
												}
											];
											var ctx<?php echo $info['title'] ?> = document.getElementById("chart-<?php echo $info['title'] ?>").getContext("2d");
											window.myPie = new Chart(ctx<?php echo $info['title'] ?>).Doughnut(data<?php echo $info['title'] ?>, {});
											
											</script> 
									</div>
								</div>
		                    </div>
		                    
		                    <?php } ?>
		                    
	                    </div>
                    </div>
	                    </div>
	                </div>
            
            </div>  
            
        </div>
    </div>
