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
	            url: "",
	            ajaxLoader: '.loader',
	            cancel: '.cancel',
	            content: '.productPortlet tbody'
            };
        var options = $.extend(defaults, options);
           
        var xhr = null;
			
			$(options.field).keyup(function() {
				
				
				if( xhr != null ) {
		                xhr.abort();
		                xhr = null;
		        }				
				var str = $(options.field).val();
			
				var data = {
						data: {str : str}
		};
				
				 xhr = $.ajax({
					 type: 'POST',
					 url:'\/padcon-leipzig\/Products\/validate\/',
					 data: data,
					 success:function (data, textStatus) {
							$(options.content).hide(500).html(data).show(500);							    		
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