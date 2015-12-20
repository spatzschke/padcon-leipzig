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
				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/Deliveries/convertPart/<?php echo $controller_id;?>/1',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	
					 	
					 	//obj.removeClass('loading');
					 	
						//$("#settings_modal .modal-body").html(data);
						//$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/<?php echo $controller_name;?>/reloadSheet/<?php echo $controller_id;?>');
						window.location = '<?php echo FULL_BASE_URL.$this->base;?>/admin/Deliveries/convert/<?php echo $controller_id;?>/'+data;
					 } 
				 }); 
				
			

			
			return false;
		});
		
		$('#add').on('click', function(){			
			$('#originalCart').find('p input:checked').each(function( index ) {
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
											
										$product = $this->requestAction('Products/getProduct/'.$value['product_id']);
											
										echo '<p>'.
												$this->Form->input('Product]['.$key.'][product_id]', array(
												'label' => false,
												'div' => false,
												'type' => 'checkbox',
												'value' => $value['product_id']
											)).
											$this->Form->input('Product]['.$key.'][amount]', array(
												'label' => false,
												'div' => false,
												'value' => $value['amount']
											)).
											$this->Form->input('Product]['.$key.'][color_id]', array(
												'label' => false,
												'div' => false,
												'value' => $value['color_id'],
												'style' => 'display: none;'
											)).
											$product['Product']['product_number'].' - '.$product['Product']['name'].'</p>';
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