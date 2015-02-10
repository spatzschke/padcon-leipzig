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
	$('#addToOffer a').addClass('disabled');
	$('#offerSettings a').addClass('disabled');
	$('#printOffer a').addClass('disabled');
	$('#createBilling').hide();
	$('#createDelivery a').addClass('disabled');
	
	<?php if(!is_null($this->data['Customer']['id'])) { ?>
		$('#addToCustomer a').removeClass('disabled');
		$('#offerSettings a').removeClass('disabled');
		
		$('#addToCustomer .input-group-addon').css('backgroundColor','lightgreen');		
	<?php } ?>
	
	<?php if(!empty($this->data['Cart']['CartProduct'])) { ?>	
		$('#addProduct .input-group-addon').css('backgroundColor','lightgreen');	
	<?php } ?>
	// <?php if(!empty($this->data['Confirmation']['additional_text'])) { 	?>	
		// $('#settings .input-group-addon').css('backgroundColor','lightgreen');
	// <?php } ?>
	<?php 
	if(((!empty($this->data['Confirmation']['additional_text'])) && (!empty($this->data['Cart']['CartProduct']))) || $this->request->params['action'] == 'admin_view') { ?>	
		$('#printOffer a').removeClass('disabled');
		$('#createDelivery a').removeClass('disabled');
	<?php } ?>
	<?php 
	if(!empty($this->data['Confirmation']['delivery_id'])) { ?>	
		$('#createBilling a').removeClass('disabled');
	<?php } ?>
	
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
				echo '<p class="offerText"><input type="text" class="text" value="Ihre Bestellung vom '.$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y').' bestätige ich wie folgt:" /> </p>';
				
				if($this->data['Confirmation']['order_number'] != '' || $this->data['Confirmation']['order_number'] != null) {
					echo '<p class="offerText"><input type="text" class="text" value="Ihre Bestellung Nr.: '.$this->data['Confirmation']['order_number'].' vom '.$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y').' bestätige ich wie folgt:" /> </p>';
				}
			}
			
			echo $this->element('backend/portlets/Cheet/middle', array('carti' => $carti, 'cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page, 'pagePrice' => true)); 
			
			if((ceil($cart['count'] / $productsPerPage)) == $page && $cartModulo != 0) { 
				echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/calc', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
				
				if(!empty($this->data['Confirmation']['additional_text']) && $cartModulo < $productsPerPage-1) { 
					echo $this->element('backend/portlets/Confirmations/additionalText', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
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
					echo $this->element('backend/portlets/Confirmations/additionalText', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page));
				}
		
				echo $this->element('backend/portlets/Cheet/footer', array('cart' => $cart, 'productsPerPage' => $productsPerPage, 'page' => $page)); 
			?>
		
	</article>

<?php
	}
}
?>
