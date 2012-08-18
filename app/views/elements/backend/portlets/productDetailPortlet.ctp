<?php 
	$products = $this->requestAction('Products/getProducts/');
	
	echo $this->Html->script('jquery.bootstrap.tooltip', false);
	echo $this->Html->script('jquery.bootstrap.popover', false);
	echo $this->Html->css('productItem');
?>




<article class="module width_full productPortlet">
		<header>
			<h3 class=""><?php __('Produkte bearbeiten');?></h3>
			
		</header>
		<div class="module_content row-fluid">
					<?php echo $this->Form->create('Product');?>
					
					<div class="span6">
					
					<?php
						
						echo $this->Form->input('id');
						echo $this->Form->input('product_number', array('data-model' => 'Product', 'data-field' => 'product_number'));
						echo $this->Form->input('name', array('data-model' => 'Product', 'data-field' => 'name'));
						echo $this->Form->input('category_id', array('data-model' => 'Product', 'data-field' => 'category_id'));
						echo $this->Form->input('material_id', array('data-model' => 'Product', 'data-field' => 'material_id'));
						echo $this->Form->input('price', array('data-model' => 'Product', 'data-field' => 'price'));
						echo $this->Form->input('size_id', array('data-model' => 'Product', 'data-field' => 'size_id'));
						
						
						
					?>
					</div>
					<div class="span5">
					<?php	
						echo $this->Form->input('description', array('data-model' => 'Product', 'data-field' => 'description'));
						echo $this->Form->input('featurelist', array('data-model' => 'Product', 'data-field' => 'featurelist'));
						
						
						echo $this->Form->input('active', array('data-model' => 'Product', 'data-field' => 'active'));
						echo $this->Form->input('new', array('data-model' => 'Product', 'data-field' => 'new'));
					?>
					
					</div>
					<div class="span12">
					
						<?php echo $this->Form->end(__('Submit', true));?>	
					
					</div>
					<div class="item">
						<?php echo $this->element('productItem', array('product' => $this->data)); ?>
					</div>

		</div><!-- end of .tab_container -->
	</article><!-- end of stats article -->

<script>

	$('.module form input').each(function() {
		buildData($(this));
		
	});
	
	$('.module form select').each(function() {
		buildData($(this));
		
	});
	
	$('.module form textarea').each(function() {
		buildData($(this));
		
	});
	
	function buildData(actField) {
		actField.data('oldVal', actField.val());

	
		 actField.bind("propertychange keyup input paste change", function(event){
		      // If value has changed...
		      if($(this).attr('type') == 'checkbox') {
			      
			      if(actField.attr('checked') == 'checked') {
				      actField.attr('checked','').val(0);
			      } else {
				      actField.attr('checked','checked').val(1);
			      }
			      
			      console.log(actField.val());
		      }
		      
		      if (actField.data('oldVal') != actField.val()) {
			       // Updated stored value
			       actField.data('oldVal', actField.val());
			
			       
			       
			       var data = 	'data['+actField.attr('data-model')+']['+actField.attr('data-field')+']='+actField.val()+
			       				'&data[Model]='+actField.attr('data-model')+
			       				'&data[Field]='+actField.attr('data-field')+
			       				'&data[Id]='+actField.parents('form:first').find('#'+actField.attr('data-model')+'Id').val();
	
			       valid(data, actField);	       
			  }

		});
	}
	
	function valid(data, actField) {
		xhr = $.ajax({
					 type: 'POST',
					 url: '\/padcon-leipzig\/Products\/liveValidate\/',
					 data: data,
					 success:function (data, textStatus) {
							console.log(data);
							actField.parent().find('.validationIcon').popover('hide').remove();
							
							var obj = jQuery.parseJSON(data);
							var icon = '<label class="validationIcon '+obj.status+'" data-content="'+obj.message+'"/>';
							actField.attr('class', '')
									.addClass(obj.status)
									.after(icon);
							
							if(obj.status === 'error')	{
							
								actField.parent().find('.validationIcon').popover();
								
							} else {
							
								 xhr = $.ajax({
									 type: 'POST',
									 url: '\/padcon-leipzig\/Products\/reloadProductItem\/'+obj.id,
									 data: data,
									 success:function (data, textStatus) {
											$('.item').html(data);
																					
											
																	    		
									 } 
								 }); 
								 
							}
								
							
							
													    		
					 } 
				 }); 
	}

</script>