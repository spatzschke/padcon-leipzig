<?php
	
	
	if(!empty($this->data['Cart'])) {
		$cart = $this->data['Cart'];
	
		$page = 0;
		$productsPerPage = 3;
		$cartModulo = $cart['count'] % $productsPerPage;
		
		$i = 0;
		
		$maxPage = round(ceil($cart['count'] / $productsPerPage),0,PHP_ROUND_HALF_UP);
		$maxPage = 1;
		if($cartModulo == $productsPerPage-1) {
			$maxPage++;
		}
	}

?>

<script>
	
	$(".maxPage").html($(".sheet ").length)
	
</script>

<?php 
	if(!empty($cart)) {
		
		$cartTemp = $this->data;
		if(empty($this->data['CartProduct'])) {
			$cartTemp['CartProduct'] = array('empty');	
		}
		
		foreach ($cartTemp['CartProduct'] as $carti) {				
			if(($i % $productsPerPage) == 0 ) {	
				$page++;
				
?>

<article class="module width_full sheet business noInput<?php if((ceil($cart['count'] / $productsPerPage)) == $page) { echo ' last';}?>">		
		<?php 
			echo $this->element('backend/portlets/Cheet/header', array('cart' => $cart, 'pdf' => $pdf, 'productsPerPage' => $productsPerPage, 'page' => $page, 'maxPage' => $maxPage, 'logo' => true)); 			
			if($this->data['Offer']['request_date'] != '0000-00-00') {
				echo '<p class="offerText"><input type="text" class="text" value="Bezug nehmend auf Ihre Anfrage vom '.$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y').' unterbreiten wir Ihnen folgendes Angebot:" /> </p>';
			}
			
			echo $this->element('backend/portlets/Cheet/middle', array('carti' => $carti, 'cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page, 'pagePrice' => true)); 
								
			if((ceil($cart['count'] / $productsPerPage)) == $page && $cartModulo != 0 ) { 
				echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/calc', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
		
				if(!empty($this->data['Offer']['additional_text']) && $cartModulo < $productsPerPage-1) { 
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/additionalText', array('offer' => $this->data, 'cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
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

	

				if(!empty($this->data['Offer']['additional_text'])) { 
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/additionalText', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page));
				}
		
				echo $this->element('backend/portlets/Cheet/footer', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
			?>
		
	</article>

<?php
	}
}
?>
