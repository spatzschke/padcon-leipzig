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
	            renderTemplate: '/elements/backend/portlets/productPortletTableContent',
	            showAnimation: true
            };
        var options = $.extend(defaults, options);
           
        var xhr = null;
			
			$(options.field).val('');
			
			$(options.cancel).bind('click', function() {
				cleanSearch(options);
			});
			
			$(options.field).bind("propertychange keyup input paste", function(event) {
				
				
				if( xhr != null ) {
		                xhr.abort();
		                $(options.ajaxLoader).hide();
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
						
						$("img.lazy").lazyload();
					 } 
				 }); 
			});
        }
    })(jQuery);
			
	function cleanSearch(options) {
		$(options.field).val('');
		$(options.cancel).hide(100);
		$(options.ajaxLoader).hide();
		$(options.content).hide();
		
		$(options.content).html('');
		$(options.originContent).show();

		
}