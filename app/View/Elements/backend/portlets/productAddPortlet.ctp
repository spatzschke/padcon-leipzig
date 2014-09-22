#<?php 
	echo $this->Html->script('jquery.bootstrap.tooltip', false);
	echo $this->Html->script('jquery.bootstrap.popover', false);
	echo $this->Html->css('productItem');
	
	echo $this->Html->script('jquery.liveValidation', false);
	echo $this->Html->script('jquery.lazyload.min', false);

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
			
					prod.addClass('loading');
					

				xhr = $.ajax({
					 type: 'POST',
					 url:'<?php echo FULL_BASE_URL.$this->base;?>/admin/Carts/addToCart',
					 data: <?php echo $data ?>,
					 success:function (data, textStatus) {
					 	
					 	
					 	
					 	$('#sidebar .miniCart').load('<?php echo FULL_BASE_URL.$this->base;?>/carts/reloadMiniCart');
					 
					 	$('.wood_bg .pages').load('<?php echo FULL_BASE_URL.$this->base;?>/Offers/reloadOfferSheetProducts');
					 	
					 	prod.removeClass('loading');
					 	$('#product_add').modal('hide');
					 	
					 }
				}); 
			}); 
			
			$('.productAddPortlet .close').on('click', function(){ $('#product_add').modal('hide');	});
			$('.productAddPortlet .btn-default').on('click', function(){ $('#product_add').modal('hide');	});
});



</script>

<article class="module width_full productAddPortlet">
		
			      <div class="modal-body span12">
			      	<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
			        <?php
						echo $this->Form->create('Product', array(
							'class' => 'form-horizontal'
						));
						
										
						echo $this->Form->input('id', array( 'data-field' => 'id'));
					?>	
						<div class="productInfo">
							<div>pd-<?php echo $this->data['Product']['product_number'];?></div>
							<div><?php echo $this->data['Product']['name'];?></div>
						</div>
					<?php	
						echo $this->Form->input('amount', array(
							'type' => 'number',
							'default' => 1,
							'class' => 'span8',
							'label' => array(
								'class' => 'span4',
								'text' => 'Anzahl'
							)
						));
						
						echo $this->Form->input('color', array(
						    'options' => $this->data['Color'],
						    'class' => 'span8',
						    'label' => array(
								'class' => 'span4',
								'text' => 'Farbe'
							)
						));				
						?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default">Abbrechen</button>
			        <button type="button" class="btn addToCartNow btn-primary">Hinzufügen</button>

			      </div>
					

		</div><!-- end of .tab_container -->
	</article><!-- end of stats article -->
	<script>





</script>


