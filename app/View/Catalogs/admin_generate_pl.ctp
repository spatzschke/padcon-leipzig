<?php 

	echo $this->Html->css('backend/page');
	echo $this->Html->css('catalog');
	echo $this->Html->css('catalogItem');

?>	

<script>

</script>
				
<?php 
if(empty($this->data['Catalogs'])) {
?>	

<div class="container">    
        <div style="margin-top:50px;" class="mainbox col-md-4  col-sm-3">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $title_for_panel; ?></div>  
                </div>

                <div class="panel-body" >

                   	<?php 

                   		
                   	echo $this->Session->flash(); ?>
                        
               
                    <?php echo $this->Form->create('Categories', array(
						'class' => 'form-horizontal'
					)); ?> 
					<!-- Links -->
				
					<div class="col-md-12">
                    	<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                            <?php echo $this->Form->input('id', array(
                            	'options' => $this->data['Categories'],
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Categories',
								'placeholder' => 'Material',
								'data-field' => 'category_id', 
								'autoComplete' => true,
								'empty' => 'Bitte Katalog wählen'
							));
							?> 
						</div>	
					</div> 
					<div class="col-md-12">
						<?php
							$months = array();
							setlocale(LC_ALL, 'de_DE', 'German_Germany.1252');
							for ($i = 0; $i < 12; $i++) {
							    $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
							    $months[date('n', $timestamp)] = utf8_encode(strftime('%B', $timestamp));
							}
						?>
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <?php echo $this->Form->input('month', array(
                            	'options' => $months,
								'label' => false,
								'class' => 'form-control',
								'data-model' => 'Categories',
								'placeholder' => 'Erstellungsdaten',
								'data-field' => 'category_id', 
								'autoComplete' => true
							));
							?> 
						</div>	
					</div>
					
					
                    
                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                      
                            	<?php 
                            			
                            			echo '<input type="submit" value="Anzeigen" class="btn btn-success form-control">';	
                            		
                            	
                            	?>
                    	</div>
                    </div>
                        
                  	</form>
                </div>                     
            </div>  
        </div>
    </div>

<?php 
} else {
?>

<div class="wood_bg">

	<div class="buttons">
		 <div id="printOffer" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-print"></i></span>
			<?php  echo $this->Html->link('Preisliste drucken', array('controller' => 'Catalogs', 'action' => 'createPdf_pl', $catalog_id, $this->data['month']), array('escape' => false, 'class' => 'btn btn-default', 'target' => '_blank')); ?>
		</div>
	</div>

	<div class="pages">
		<?php  
			if(isset($pdf)) {
				echo $this->element('backend/Catalog/priceList_cheet', array("pdf" => $pdf));
			} else {
				echo $this->element('backend/Catalog/priceList_cheet');
			}
			 ?>
	</div>
</div>
<?php 
}
?>
