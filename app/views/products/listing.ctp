<div class="products">
	<?php
	
		foreach ($products as $product):
		
			echo $this->element('productItem', array('product' => $product));
		
		endforeach; ?>
        <?php echo $this->Html->css('colorbox');?>
		<?php echo $javascript->link('jquery.colorbox-min.js', false);?>
       
        <script>
        
        
		var src = $(".colorItem").find("img").attr("src");
				
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

		
				$('.mediaURL').bind({
				click: function() {
					
					
					var image = $(this).find('img').attr('image-rel');
					var box = '	<img id="image" src="'+image+'" width="768" height="557"/>';
					
					$.colorbox({
						html:box,
						width:'810', 
						height:'600', 
						overlayClose: true,
						onOpen: function () {
							$(this).parent().parent().find('.loader').hide();
								
						},
						onLoad: function() {
							//$('#cboxClose').remove();
						}
		
					});	
				}
			});
					
			
			$("img.lazy").lazyload();

		</script>
</div>