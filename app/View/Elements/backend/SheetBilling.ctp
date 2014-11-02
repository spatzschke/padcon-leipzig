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
<?php 

	if(!empty($cart)) {
		
		if(empty($cart['CartProduct'])) {
			$cart['CartProduct'] = array('empty');	
		}
		
		foreach ($cart['CartProduct'] as $carti) {
				
			if(($i % $productsPerPage) == 0 || ($i % $productsPerPage) == 3 ) {	
				$page++;
				
		debug($cart['CartProduct']);
?>

<script>

	
</script>


	<article class="module width_full sheet business noInput<?php if((ceil($cart['count'] / $productsPerPage)) == $page) { echo ' last';}?>">		
		<?php 
			echo $this->element('backend/portlets/Billing/billingHeader', array('cart' => $cart, 'pdf' => $pdf, 'productsPerPage' => $productsPerPage, 'page' => $page, 'maxPage' => $maxPage)); 			
			if($this->data['Offer']['request_date'] != '0000-00-00') {
				echo '<p class="offerText"><input type="text" class="text" value="Bezug nehmend auf Ihre Anfrage vom '.$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y').' unterbreiten wir Ihnen folgendes Angebot:" /> </p>';
			}
			
			echo $this->element('backend/portlets/Offer/offerMiddle', array('carti' => $carti, 'cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
			
			if((ceil($cart['count'] / $productsPerPage)) == $page && $cartModulo != 0) { 
				echo $this->element('backend/portlets/Offer/offerCalc', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
				
				if(!empty($this->data['Offer']['additional_text']) && $cartModulo < $productsPerPage-1) { 
					echo $this->element('backend/portlets/Offer/offerAdditionalText', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
				}
			}
			
			//echo $this->element('backend/portlets/Offer/offerFooter', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
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
				echo $this->element('backend/portlets/Offer/offerHeader', array('cart' => $cart, 'pdf' => $pdf, 'productsPerPage' => $productsPerPage, 'page' => $page+1, 'maxPage' => $maxPage)); 
				
				if($cartModulo == 0) {
					echo $this->element('backend/portlets/Offer/offerCalc', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page));
				}
				if(!empty($this->data['Offer']['additional_text'])) { 
					echo $this->element('backend/portlets/Offer/offerAdditionalText', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page));
				}
		
				//echo $this->element('backend/portlets/Offer/offerFooter', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
			?>
		
	</article>

<?php
	}
}
?>
