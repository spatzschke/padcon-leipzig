<div class="products">
	<?php
		foreach ($products as $product):
		
			echo $this->element('productItem', array('product' => $product));
		
		endforeach; ?>
        <?php echo $this->Html->css('colorbox');?>
		<?php echo $this->Html->script('jquery.colorbox-min.js');?>
        
        <script>
		var src = $(".colorItem").find("img").attr("src");
		
			$(".mediaURL").colorbox({
				iframe:true, 
				width:"810", 
				height:"600", 
				overlayClose: true,
				onOpen: function () {
					$(this).parent().parent().find('.loader').hide();	
				},
				onLoad: function() {
    				//$('#cboxClose').remove();
				}

			});
			
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
							$.colorbox.close();
							$('#p'+response['data']['product_number']).find('.loader').hide();
					 }, 
					 
					
				 }); 
				 
			}

		</script>
</div>