
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
      	  
      	  
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});

function reloadMiniCart() {
	
	$('#sidebar .miniCart').load('<?php echo FULL_BASE_URL.$this->base;?>/carts/reloadMiniCart');
	
	
}

function reloadCartCheet(url) {
	
	$('wood_bg').load(url, function(data) {
	  console.log(data)
	});

	
}

function addToCart() {
				
	var xhr = null,
	obj = $(this);
	
	obj.addClass('loading');
	console.log('addToCart')
	
		
		xhr = $.ajax({
			 type: 'POST',
			 url:obj.attr('href'),
			 data: '',
			 success:function (data, textStatus) {
			 	
			 	obj.removeClass('loading');
			 	obj.addClass('added').attr('data-amount',1);
			 	
			 	reloadMiniCart();
			 	
			 } 
		 }); 

	return false;
};

