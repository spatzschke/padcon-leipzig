 (function($){
        // add a new method to JQueryg


        $.fn.liveValidation = function(options) {
           
           obj = $(this);
           
            var defaults = {
	            form: obj,
				fields: {'input', 'select', 'textarea'}
	            url: "",
	            validationIcon: 'validationIcon',
	            autoSubmit: true,
				
            };
        var options = $.extend(defaults, options);

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
			      
			      if($(this).val() == 1) {
				      actField.val(0);
						
			      } else {
				      actField.val(1)
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
});