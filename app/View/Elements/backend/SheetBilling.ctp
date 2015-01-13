<?php

	if(!empty($this->data['Cart'])) {
		$cart = $this->data['Cart'];
	
		$page = 0;
		$productsPerPage = 3;
		$cartModulo = $cart['count'] % $productsPerPage;
		
		$i = 0;
		
		$maxPage = round(ceil($cart['count'] / $productsPerPage),0,PHP_ROUND_HALF_UP);
		if($cartModulo == 3 || $cartModulo == 0) {
			$maxPage++;
		}
	}
	
?>

<script>

	
</script>

<?php 

	if(!empty($cart)) {
		
		if(empty($cart['CartProduct'])) {
			$cart['CartProduct'] = array('empty');	
		}
		
		foreach ($cart['CartProduct'] as $carti) {				
			if(($i % $productsPerPage) == 0 ) {	
				$page++;				

?>

<article class="module width_full sheet business noInput<?php if((ceil($cart['count'] / $productsPerPage)) == $page) { echo ' last';}?>">		
		<?php 
			echo $this->element('backend/portlets/Cheet/header', array('cart' => $cart, 'pdf' => $pdf, 'productsPerPage' => $productsPerPage, 'page' => $page, 'maxPage' => $maxPage, 'logo' => true)); 			
			
			if($this->data['Confirmation']['order_date']) {
				
				if($this->data['Confirmation']['order_number'] != '' || $this->data['Confirmation']['order_number'] != null) {
					echo '<p class="offerText">Ihre Bestellung Nr.: '.$this->data['Confirmation']['order_number'].' vom '.$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y').' lieferten wir mit dem Lieferschein Nr.: '.$this->data['Delivery']['delivery_number'].' vom '.$this->Time->format($this->data['Delivery']['delivery_date'], '%d.%m.%Y').'. Wir berechnen wie folgt:</p>';
				} else {
					echo '<p class="offerText">Ihre Bestellung vom '.$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y').' lieferten wir mit dem Lieferschein Nr.: '.$this->data['Delivery']['delivery_number'].' vom '.$this->Time->format($this->data['Delivery']['delivery_date'], '%d.%m.%Y').'. Wir berechnen wie folgt:</p>';
				}
			}
			
			
			echo $this->element('backend/portlets/Cheet/middle', array('carti' => $carti, 'cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page, 'pagePrice' => true)); 
			
			if((ceil($cart['count'] / $productsPerPage)) == $page && $cartModulo != 0) { 
				echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/calc', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
				
				if(!empty($this->data['Confirmation']['additional_text']) && $cartModulo < $productsPerPage-1) { 
					echo $this->element('backend/portlets/Billings/additionalText', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
				}
			}
			
			echo $this->element('backend/portlets/Cheet/footer', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
		?>
	</article>

<?php 
		}
		$i++;
	}
?>


<?php if(($cart['count'] % $productsPerPage == 0 && $cart['count'] > ($productsPerPage-1)) || $cart['count'] % $productsPerPage == $productsPerPage-1) {?>
	<article class="module width_full sheet business noInput<?php if((ceil($cart['count'] / $productsPerPage)) == $page) { echo ' last';}?>">
			
			<?php 
				echo $this->element('backend/portlets/Cheet/header', array('cart' => $cart, 'pdf' => $pdf, 'productsPerPage' => $productsPerPage, 'page' => $page+1, 'maxPage' => $maxPage, 'logo' => true)); 
				
				if($cartModulo == 0) {
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/calc', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page));
				}
				if(!empty($this->data['Confirmation']['additional_text'])) { 
					echo $this->element('backend/portlets/Billings/additionalText', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page));
				}
		
				echo $this->element('backend/portlets/Cheet/footer', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
			?>
		
	</article>

<?php
	}
}
?>
