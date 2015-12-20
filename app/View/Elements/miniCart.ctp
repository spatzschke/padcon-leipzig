<?php
	$cart = $this->requestAction('Carts/get_cart_by_cookie/');
	$this->requestAction('Carts/calcSumPriceByCartId/'.$cart['Cart']['id']);
	$sum = null;

	if(!empty($cart)){
?>
<div class="miniCartContent" style="display: none;">	
<div class="miniCartCount">
	
	<?php echo $cart['Cart']['count']; ?>
	
</div>
</div>
<?php } ?>