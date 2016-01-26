<?php 
	echo $this->Html->script('jquery.dynamicSearch', false);
?>

<script>
$(document).ready(function() {
	
		$('#ConfirmationConfirmationNumber').dynamicSearch({
			url: "<?php echo FULL_BASE_URL.$this->base;?>\/Confirmations\/search\/",
			renderTemplate: '/Elements/backend/portlets/Billings/convertSearchTableContent',
			cancel: '',
			content: '.searchResult',
			loadingClass: 'loadingSpinner',
			loadingElement: '.input-group-addon i',
			admin: true
		});	
});

</script>


<div class="container">    
        <div style="margin-top:50px;" class="mainbox col-md-4  col-sm-3">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $title_for_panel; ?></div>  
                </div>

                <div class="panel-body" >

                   	<?php 

                   		
                   	echo $this->Session->flash(); ?>
                        
               
                    <?php echo $this->Form->create('Confirmation', array(
						'class' => 'form-horizontal'
					)); ?> 
					<!-- Links -->
				
					<div class="col-md-12">
                    	<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                            <?php echo $this->Form->input('confirmation_number', array(                            	
								'label' => false,
								'class' => 'form-control span12',
								'data-model' => 'Confirmation',
								'placeholder' => 'Auftragsbestätigungsnummer',
								'data-field' => 'confirmation_number', 
								'autoComplete' => true,
								'empty' => 'Bitte Auftragsbestätigungsnummer eingeben'
							));
							?> 
						</div>	
					</div> 
					                    
                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                      
                            	<?php 
                            			
                            			echo '<input type="submit" value="Erstellen" class="btn btn-success form-control">';	
                            		
                            	
                            	?>
                    	</div>
                    </div>
                        
                  	</form>
                  	
                  	<div class="searchResult">
                  		   
                  	</div>
                  	
                </div>                     
            </div>  
        </div>
    </div>


