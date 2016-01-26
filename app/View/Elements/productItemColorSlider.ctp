<div id="colorCarousel<?php echo $product['Product']['product_number'];?>" data-interval="false" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner">
	    <?php 
		
			$colorsPerSlide = 5;
			$slide = 0;
			$colors = $this->requestAction('Products/getColors/'.$product['Material']['id']);
			
			for($i=0; $i < count($colors)/$colorsPerSlide; $i++) {
				
				if($i == 0) {
					echo '<div class="item active">';
				} else {
					echo '<div class="item">';
				}
					for($j = 0; $j < $colorsPerSlide; $j++) {
						
						if(isset($colors[$i * $colorsPerSlide + $j]))
							echo '<div class="colorItem" rel="'.$colors[$i * $colorsPerSlide + $j]['Color']['code'].'" style="background-color: #'.$colors[$i * $colorsPerSlide + $j]['Color']['rgb'].';" data-toggle="popover" 
								 data-content="'.$colors[$i * $colorsPerSlide + $j]['Color']['name'].'"
								 data-trigger="hover" data-placement="bottom"></div>';
						
					
					}
				echo '</div>';
				
			}
		
		?>	
	</div>
	<?php if(count($colors) > $colorsPerSlide) {?>
	<!-- Controls -->
	<a class="left carousel-control" href="#colorCarousel<?php echo $product['Product']['product_number'];?>" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
	</a>
	<a class="right carousel-control" href="#colorCarousel<?php echo $product['Product']['product_number'];?>" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
	</a>
	<?php }?>
</div>
<script type="text/javascript">
	$('#colorCarousel<?php echo $product['Product']['product_number'];?>').carousel();
</script>







	

