<div class="products">
	<?php
	
		foreach ($products as $product):
		
			echo $this->element('productItem', array('product' => $product));
		
		endforeach; ?>
       
        <script>
        
			$("img.lazy").lazyload();

		</script>
</div>