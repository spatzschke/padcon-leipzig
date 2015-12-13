// JavaScript Document

$(document).ready(function() {

	$('.addToCart').bind('click', function() {
		
		console.log("test");
		
		addToCart($(this));
		return false;
	})
	
	reloadMiniCart();
		
			
});

function addToCart(obj) {
				
	var xhr = null

	
	obj.addClass('loading');
	console.log(obj.attr('href'))

		
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

function reloadMiniCart() {
	
	$('#miniCart').load('Carts/reloadFrontendMiniCart', function() {
		$('#miniCart .miniCartContent').show();
	});
	
	
}