/*$('#filter .search').focusout( function() {
				$('#filter .search .cancel').hide(100, function() {
						$('#filter .search input').animate({
							paddingLeft: 15
						}, 250)
					  });
			});*/
			
 (function($){
        // add a new method to JQuery

        $.fn.dynamicSearch = function(options) {
           
           obj = $(this);
           
            var defaults = {
	            field: obj,
	            url: "\/Products\/search\/",
	            ajaxLoader: '.loader',
	            cancel: '.cancel',
	            content: '.productPortlet tbody',
	            originContent: '',
	            renderTemplate: '',
	            showAnimation: true,
	            addToCartUrl: '',
	            loadingElement: '',
	            loadingClass: 'loadingSpinner',
	            admin: false, 
	            reloadUrl: ''
            };
        var options = $.extend(defaults, options);
           
        var xhr = null;
			
			$(options.field).val('');
			
			$(options.cancel).bind('click', function() {
				cleanSearch(options);
			});
			
			$(options.field).on("propertychange keyup input paste", function(event) {
				
				
				if( xhr != null ) {
		                xhr.abort();
		                $(options.ajaxLoader).hide();
		                $(options.loadingElement).removeClass(options.loadingClass);
		                xhr = null;
		        }	
		        $(options.cancel).show(100);
		        
		        if($(options.originContent).is(':hidden')){
			        $(options.content).css('opacity', '0.3');
			        
		        }else{
			        $(options.originContent).css('opacity', '0.3');
			        $(options.content).parent().show();
		        }
		        
		       $(options.ajaxLoader).show();
		       $(options.loadingElement).addClass(options.loadingClass);
		        
		        			
				var str = $(options.field).val();
			
				var data = 'data[str]='+str;
				
				if(options.renderTemplate != ''){
			    	data += '&data[template]='+options.renderTemplate;
				}
								
				 xhr = $.ajax({
					 type: 'POST',
					 url:options.url,
					 data: data,
					 success:function (data, textStatus) {
					 	if(options.showAnimation) {
							$(options.content).hide(500).html(data).show(500);							    		
						} else {
							$(options.content).html(data);
							
						}
						$(options.content).css('opacity', '1');
						$(options.originContent).hide().css('opacity','1');
						$(options.ajaxLoader).hide();
						$(options.loadingElement).removeClass(options.loadingClass);
						
						$("img.lazy").lazyload();
						
						$('.addToCart').on('click', function(){
							
							console.log("click3");
				
							$('#product_add .modal-content').load(options.addToCartUrl+$(this).attr('pdid'));
							$('#product_add').modal('show');
							$('#product_add').css('zIndex','1000')
							$('#product_add').css('display','block')
							
							return false;
						});
						
						$(document).on('click','.addCustomer', function(){
							return false;
						});
	
					 } 
				 }); 
			});
        }
    })(jQuery);
			
	function cleanSearch(options) {
		if(options.admin) {
			
			$(options.cancel).hide(100);
			
			var data = 'data[str]=';
			
			if(options.renderTemplate != ''){
		    	data += '&data[template]='+options.renderTemplate;
			}
			
			$(options.ajaxLoader).show();
		    $(options.loadingElement).addClass(options.loadingClass);
			
			xhr = $.ajax({
					 type: 'POST',
					 url:options.url,
					 data: data,
					 success:function (data, textStatus) {
					 	if(options.showAnimation) {
							$(options.content).hide(500).html(data).show(500);							    		
						} else {
							$(options.content).html(data);
							
						}
						$(options.content).css('opacity', '1');
						$(options.originContent).hide().css('opacity','1');
						$(options.ajaxLoader).hide();
						$(options.loadingElement).removeClass(options.loadingClass);
						$(options.field).val('');
						
						$("img.lazy").lazyload();
						
						$('.addToCart').on('click', function(){
				
							$('#product_add .modal-content').load(options.addToCartUrl+$(this).attr('pdid'));
							$('#product_add').modal('show');
							$('#product_add').css('zIndex','1000')
							$('#product_add').css('display','block')
							
							return false;
						});
					 } 
				 }); 
		} else {
			
			$(options.field).val('');
			$(options.cancel).hide(100);
			$(options.ajaxLoader).hide();
			$(options.content).hide();
			
			$(options.content).html('');
			$(options.originContent).show();

		}
}