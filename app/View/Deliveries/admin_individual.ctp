<?php 
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);
?>

<script>

$(document).ready(function() {
				
	
			
});

</script>

<div class="container"> 
	
	 <?php
	 
 echo $this->Form->create('Delivery', array(
					'class' => 'form-horizontal' ,
					'style' => 'width: 100%'
				));  	
?>  

<?php ?>

<script>
$(document).ready(function() {
})

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
                    
           		<?php echo $this->Form->input('id');?>   
                
				 
				<!-- Links -->
			
				<div class="col-md-4">
				<?php if($this->request->params['action'] == "admin_edit_individual") {
					$readonly = "readonly";
				} else {
					$readonly = "";
				} ?>
					<div class="input-group">
						<span class="input-group-addon"><b class="glyphicon" style="cursor: pointer" data-toggle="popover" data-trigger="hover" data-placement="left"
									 data-content="Lieferschein-Nummer">#</b>
						</span>
                        <?php  echo $this->Form->input('delivery_number', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Delivery',
							'placeholder' => 'Lieferschein-Nummer',
							'data-field' => 'delivery_number', 
							'autoComplete' => true,
  							'type' => 'text',
  							'readonly' => $readonly
						));
						?>                                      
                    </div> 
                    <?php 
                    
                    if($this->request->params['action'] == "admin_add_individual" && is_null($this->data['Delivery']['check'])) { ?>
                    <div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-check" style="cursor: pointer" data-toggle="popover" data-trigger="hover" data-placement="left"
									 data-content="Auftragsbestätigungs-Nummer"></i>
						</span>
                        <?php  echo $this->Form->input('confirmation_number', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Confirmation',
							'placeholder' => 'Auftragsbestätigungs-Nummer',
							'data-field' => 'confirmation_number', 
							'autoComplete' => true,
							'type'=>'text'
							//'type'=>'select','options'=>$this->data['Delivery']['confirmation_numbers']
						));
						?>                                      
                    </div> 
                  	<?php } else {                   		
                  		echo $this->Form->input('confirmation_number', array('type'=>'hidden'));
					}
                  	?> 
                    
                <?php if($this->request->params['action'] == "admin_edit_individual") { ?>   
                  
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user" style="cursor: pointer" data-toggle="popover" data-trigger="hover" data-placement="left"
									 data-content="Kundennummer"></i>
						</span>
                        <?php echo $this->Form->input('Confirmation.customer_id', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Confirmation',
							'placeholder' => 'Kunde',
							'data-field' => 'customer_id', 
							'autoComplete' => true,
							'type' => 'text',
							'readonly' => 'readonly'
						));
						?>              
                     </div>
                    
                   	<div class="input-group date">    
                   		<span class="input-group-addon"><i class="glyphicon glyphicon-calendar" style="cursor: pointer" data-toggle="popover" data-trigger="hover" data-placement="left"
									 data-content="Erstellt am"></i>
						</span>
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
					
					<div class="input-group date">    
                   		<span class="input-group-addon"><i class="glyphicon glyphicon-qrcode" style="cursor: pointer" data-toggle="popover" data-trigger="hover" data-placement="left"
									 data-content="DHL Trackingcode"></i>
						</span>
                        <?php echo $this->Form->input('trackingcode', array(
						    'label' => false,
						    'div' => false,
						    'type' => 'text',
						    'placeholder' => 'DHL Trackingcode',
							'class' => 'form-control span12'));
						
						?> 						 	
					</div>
									
				</div>
				
				 <!-- Mitte -->
				<div class="col-md-4">
					
					 
                     
                     
	          <?php } ?>   
                     
                </div>
                
                 <!-- Rechts -->
                 <div class="col-md-4">
                 	
                 </div>
          	</div>
          	
		</div> 
		                        
	</div> 
	<div class="col-sm-12 controls">                          
		<?php 		
				echo '<input type="submit" value="'.$primary_button.'" class="btn btn-success form-control">';
		?>
	</div>
</form>
</div>