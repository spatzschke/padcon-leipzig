<?php 

?>

<script>
$(document).ready(function() {
	
			
			
			$('.addToCartNow').on('click', function(){
					
				<?php 
					$data = $this->Js->get('#ProductAdminLoadProductAddPopupForm')->serializeForm(array('isForm' => true, 'inline' => true)); 
				?>
								
				var xhr = null
					prodID = $('#ProductId').val(),
					obj = $(this),
					prod = $("div").find("[pdid='" + prodID + "']");
			
					prod.find('i').addClass('loadingSpinner');
					

				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/Carts/addToCart',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	
					 	
					 	$('#sidebar .miniCart').load('<?php echo FULL_BASE_URL.$this->base;?>/carts/reloadMiniCart');
					 
					 	$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/Offers/reloadOfferSheetProducts');
					 	
					 	
					 	$('#product_add').css('zIndex','-1')
					 	$('#product_add').css('display','none')
					 	
					 	prod.find('i').removeClass('loadingSpinner');
					 	
					 	
					 }
				}); 
				return false;
			}); 
			
			$('.productAddPortlet .close').on('click', function(){ 
					$('#product_add').css('zIndex','-1')	
					$('#product_add').css('display','none')
			});
			$('.btn-close').on('click', function(){ 
				$('#product_add').css('zIndex','-1')
				$('#product_add').css('display','none')
			});
});



</script>


		
			      <div class="modal-body productAddPortlet">
			      	<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
			        <?php
						echo $this->Form->create('Product', array(
							'class' => 'form-horizontal'
						));
						
										
						echo $this->Form->input('id', array( 'data-field' => 'id'));
					?>	
						<div class="productInfo">
							<div>pd-<?php echo $this->data['Product']['product_number'];?></div>
							<div><b><?php echo $this->data['Product']['name'];?></b></div>
						</div>
				
			       <div class="input-group">
	                    <span class="input-group-addon"><i>Anzahl</i></span>
	                    <?php echo $this->Form->input('amount', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Anzahl', 
							'autoComplete' => true,
							'type' => 'number',
							'default' => 1,
						));
						?>                                      
	                 </div>
	                 <div class="input-group">
	                    <span class="input-group-addon"><i>Farbe</i></span>
	                    <?php echo $this->Form->input('color', array(
							'label' => false,
							'class' => 'form-control',
							'data-model' => 'Product',
							'placeholder' => 'Farbe',
							'options' => $this->data['Color'], 
							'autoComplete' => true
						));
						?>                                      
	                 </div>
			      
			      
			      </div>
			      		      
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default btn-close">Abbrechen</button>
			        <button type="button" class="btn addToCartNow btn-primary">Hinzufügen</button>

			      </div>
					

		</div><!-- end of .tab_container -->
	<script>





</script>


