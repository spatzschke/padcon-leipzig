<div class="products searchResult">

	<h1>Suchergebnis</h1>
	
	<?php
		if(!empty($products)) {
			if(count($products) > 50) {
				echo 'Es wurden zu viele Produkte gefunden. Bitte die Suche weiter einschränken.';
			} else {
				foreach ($products as $product):
			
					echo $this->element('productItem', array('product' => $product));
				
				endforeach;
			}
		} else {
			echo 'Keine Produkte gefunden.';
		}
	
	?>
        
        <script>
		
			$('.colorItem').bind({
			  mouseenter: function() {
				$(this).find('img').attr('src','<?php echo $html->url('/img/color_overlay_a.png')?>');
			  },
			  mouseleave: function() {
				if(!$(this).hasClass('active') ) {
					$(this).find('img').attr('src','<?php echo $html->url('/img/color_overlay.png')?>');
				}
			  }, 
			  click: function() {
				 
				$(this).parent().find('.active img').attr('src','<?php echo $html->url('/img/color_overlay.png')?>'); 
				$(this).parent().find('.active').removeClass('active');
				
				  
				var url = $(this).parent().parent().parent().find('.productItemImage a').attr('href');
				var rep = url.replace(url.substr(url.length - 4, 4), 'c='+$(this).attr('rel'));
				$(this).parent().parent().parent().find('.productItemImage a').attr('href', rep);
				
				$(this).addClass('active');
			  }
			});
			
			$(".mediaURL").colorbox({
				iframe:true, 
				width:"292", 
				height:"292", 
				overlayClose: false,
				onOpen: function () {
					$(this).parent().parent().find('.loader').toggle();	
				},
				onLoad: function() {
    				$('#cboxClose').remove();
				}

			});

			function saveImageInDb(response) {
				 
				 var data = {
					    data: {
							product_number : response['data']['product_number'],
							color : response['data']['color'],
							path : response['data']['path'],
							ext : response['data']['ext'],
						}
			     };
				 
				 $.ajax({
					 type: 'POST',
					 url:"\/Images\/add\/",
					 data: response,
					 success:function (data, textStatus) {
						 	$('#p'+response['data']['product_number']).find('.message').html();
							$('#p'+response['data']['product_number']+' .productItemImage').find('img').attr('src',response['data']['path']+'t.'+response['data']['ext']+'?'+new Date().getTime());
							$.colorbox.close(function() {
								$('#p'+response['data']['product_number']).find('.loader').toggle();
							});
					 }, 
					 
					
				 }); 
				 
			}

		</script>

</div>