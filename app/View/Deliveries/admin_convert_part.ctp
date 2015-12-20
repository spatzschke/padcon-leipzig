 <?php 


?>	

<script>
	$(document).ready(function() {
	
		$('#saveCart').on('click', function(){
			
			<?php 
			
				$data = $this->Js->get('#DeliveryAdminConvertPartForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
			?>
			
			var xhr = null,
			obj = $(this);			
			obj.addClass('loading');
			console.log("load");
				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/Deliveries/convertPart/<?php echo $controller_id;?>/1',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	//obj.removeClass('loading');
					 	
						//$("#settings_modal .modal-body").html(data);
						//$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/<?php echo $controller_name;?>/reloadSheet/<?php echo $controller_id;?>');
					 } 
				 }); 
				
			

			
			return false;
		});
		
		$('#add').on('click', function(){
			
			console.log('add');
			
			$('#originalCart').find('p input:checked').each(function( index ) {
				
					console.log( index + ": " + $( this ).parent().text() );
					$('#partCart').append($(this).parent());
 				
			})
			
		return false;
		})
		
		 
		
	});

</script>

<div class="offer form">

<article class="module width_full convertPartPortlet">
		
		<?php echo $this->Session->flash(); ?>
		
		<div class="module_content row-fluid">
					
					
	
					<div class="col-md-12">
						<div class="panel panel-info" >
                    		<div class="panel-body" >
								<div id="originalCart" class="col-md-5"  style="height: 100px">
									<?php 
									
									foreach($this->data['CartProduct'] as $key => $value) {
										echo '<p>'.$this->Form->input('Product'.$key, array(
												'label' => false,
												'div' => false,
												'type' => 'checkbox',
												'value' => $value['id']
											)).$value['id'].'</p>';
									}
									
									?>
								</div>
							
	                            <div class="col-md-1">
	                             <button id="add" class="btn btn-default" type="button">></button>
	                            </div> 
	                            <?php echo $this->Form->create('Delivery', array('class' => 'col-md-5'));?>
								<div id="partCart" class="col-md-5"  style="height: 100px">
									
								</div>
								</form>
							</div>
						</div>					
					</div>
				
					
					<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
				        <button type="button" id="saveCart" class="btn btn-primary">Teillieferschein erstellen</button>
				      </div>
					

		</div><!-- end of .tab_container --> 
	</article><!-- end of stats article -->



</div>