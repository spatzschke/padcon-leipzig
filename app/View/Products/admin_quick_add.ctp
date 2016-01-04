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
	
	$('#ProductCores').bind('click', function() {
		var list = $( this ).find('Option:selected')
		  .map( function() {
		    return this.text;
		  })
		  .get()
		  .join( " / " );
		$("#ProductCoreName").val(list)
		
		
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
	
?>
 
<div class="mainbox col-md-12 col-md-offset-0 col-sm-8 col-sm-offset-2">
	<div class="panel panel-info" >
	Es werden <?php echo count($this->data['Products']); ?> Produkte angelegt.
	</div>
</div>
 
 <?php
 echo $this->Form->create('Product', array(
					'class' => 'form-horizontal' ,
					'style' => 'width: 100%'
				));  
				
foreach($this->data['Products'] as $i => $product){
$product = $product;
	
?>

<?php echo $this->element('backend/portlets/Product/productDetailPortlet', array('data' => $product)); ?>    

    
<?php 
   }
?>

<div class="col-sm-12 controls">                          
		<?php 		
				echo '<input type="submit" value="'.$primary_button.'" class="btn btn-success form-control">';
		?>
	</div>
</form>
</div>
<?php 
}
?>

