<?php

	$cart = $this->requestAction('Carts/get_active_cart/');
	$this->requestAction('Carts/calcSumPrice/');
	
	$sum = null;

	if(!empty($cart)){
?>

<div class="miniCartContent well">
	
	<h2>Aktiver Warenkorb</h2>
	ID: <?php echo $cart['Cart']['id']; ?> 
	<br />
	Anzahl: <?php echo $cart['Cart']['count']; ?> 
	<br />
	Verkaufssumme: <?php echo $cart['Cart']['sum_retail_price']; ?> €
	<br />
	Einkaufssumme: <?php echo $cart['Cart']['sum_base_price']; ?> €

</div>

<?php } else {
	?>

<div class="miniCartContent well">
	
	Warenkorb ist lerr

</div>

<?php } ?>