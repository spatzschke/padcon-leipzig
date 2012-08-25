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
	            renderTemplate: '/elements/backend/portlets/productPortletTableContent',
	            showAnimation: true
            };
        var options = $.extend(defaults, options);
           
        var xhr = null;
			
			$(options.field).keyup(function() {
				
				
				if( xhr != null ) {
		                xhr.abort();
		                xhr = null;
		        }				
				var str = $(options.field).val();
			
				var data = 'data[str]='+str+
			       				'&data[template]='+options.renderTemplate;
				
								
				 xhr = $.ajax({
					 type: 'POST',
					 url:options.url,
					 data: data,
					 success:function (data, textStatus) {
					 	if(options.showAnimation) {
							$(options.content).hide(500).html(data).show(500);							    		
						}
					 } 
				 }); 
			});
        }
    })(jQuery);
			
	function cleanSearch() {
		$('#filter .search input').val('');
		$('#filter .search .cancel').hide(100, function() {
						$('#filter .search input').animate({
							paddingLeft: 15
						}, 250)
					  });

		$.ajax({
			 url:window.location.pathname,
			 success:function (data, textStatus) {
					$('.productPortlet').html('');
					$('.productPortlet').html(data);
			 } 
		 });
}