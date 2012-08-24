 (function($){
        // add a new method to JQuery

        $.fn.liveValidation = function(options) {
           
           obj = $(this);
           
            var defaults = {
	            form: obj,
				fields: ['input', 'select', 'textarea'],
	            url: '\/Products\/liveValidate\/',
	            urlBase: '',
	            validationIcon: '.validationIcon',
	            validationIconLabel: 'validationIcon',
	            autoSave: true,
	            livePreview: true,
				
            };
	        var options = $.extend(defaults, options);
	        
	        if(options.autoSave) {
		       var submitButton = $(obj).find('input[type="submit"]');
		       submitButton.remove();
	        }
	        var id = null;
	        $(obj).find('input').each(function(){
		        if($(this).attr('data-field') == 'id')
		        	id = $(this).val();
	        });
	        	
	        if(options.autoSave) {	loadLivePreview('data[Id]='+id, obj, options); }	
	        	        
	        
	         
	
	        $.each(options.fields,function( intIndex, objValue ){
			 
				$(obj).find(objValue).each(function() {
					 
					showErrorMessage($(this), options);
					buildData($(this), options);
				});
			});
	
			
		}
})(jQuery);

	function showErrorMessage(obj, options) {
		if(obj.next().hasClass('error-message')) {
			var msg = obj.next().text();
		
			var icon = '<label class="'+options.validationIconLabel+' error" data-content="'+msg+'"/>';
					
					obj.attr('class', '')
							.addClass('error')
							.after(icon);	
					obj.parent().find(options.validationIcon).popover()
		}
	}

	
	function buildData(actField, options) {
		actField.data('oldVal', actField.val());
	
		 actField.bind("propertychange keyup input paste change", function(event){
		      // If value has changed...
		      if($(this).hasClass('noValid')) {
			      $(this).unbind("propertychange keyup input paste change");
			      return 0;
		      }
		      
		      
		      if($(this).attr('type') == 'checkbox') {
			      
			      if($(this).val() == 1) {
				      actField.val(0);
						
			      } else {
				      actField.val(1)
			      }
			      
		      }
		      
		      if (actField.data('oldVal') != actField.val()) {
			       // Updated stored value
			       actField.data('oldVal', actField.val());
			
			       var data = 	'data['+actField.attr('data-model')+']['+actField.attr('data-field')+']='+actField.val()+
			       				'&data[Model]='+actField.attr('data-model')+
			       				'&data[Field]='+actField.attr('data-field')+
			       				'&data[Id]='+actField.parents('form:first').find('#'+actField.attr('data-model')+'Id').val();
			       data += 		'&data[autoSave]='+options.autoSave;
	
			       valid(data, actField, options);	       
			  }

		});
	}
	
	function valid(data, actField, options) {
		xhr = $.ajax({
				type: 'POST',
				url: options.url,
				data: data,
				success:function (data, textStatus) {
					
					actField.parent()
							.find(options.validationIcon)
							.popover('hide')
							.remove();
				
					var obj = jQuery.parseJSON(data);
					
					var icon = '<label class="'+options.validationIconLabel+' '+obj.status+'" data-content="'+obj.message+'"/>';
					
					actField.attr('class', '')
							.addClass(obj.status)
							.after(icon);
					
					if(obj.status === 'error')	{
					
						actField.parent().find(options.validationIcon).popover();
						//actField.parents('form').find('input[type="submit"]').attr('disabled', 'true');
						
					} else {
						if(options.livePreview && options.autoSave) {
							loadLivePreview(data, obj, options); 
						}
						 
					}			
		 }
	 }); 
	}
	
	function loadLivePreview(data, obj, options) {
		xhr = $.ajax({
			 type: 'POST',
			 url: options.urlBase+'\/Products\/reloadProductItem\/'+obj.id,
			 data: data,
			 success:function (data, textStatus) {
					$('.livePreview').html(data);						    		
			 } 
		 }); 
	}
