<?php 
if(empty($this->data['Pages'])) {
	$pages = array('0');
} else {
	$pages = $this->data['Pages'];
}	
		$cartTemp = $this->data;
		if(empty($this->data['CartProduct'])) {
			$cartTemp['CartProduct'] = array('empty');	
		}
		
		foreach ($pages as $page => $carti) {	
				
?>

<article class="module width_full sheet business noInput">		
		<?php 
			echo $this->element('backend/portlets/Cheet/header', array('pdf' => $pdf, 'page' => $page+1, 'maxPage' => count($pages), 'logo' => true)); 			
			if($this->data['Offer']['request_date'] != '0000-00-00') {
				if($this->data['Offer']['request_number'] != '' || $this->data['Offer']['request_number'] != null) {
					echo '<p class="offerText">Bezug nehmend auf Ihre Anfrage vom '.$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y').' mit der Nummer '.$this->data['Offer']['request_number'].' unterbreiten wir Ihnen folgendes Angebot:</p>';
				} else {
					echo '<p class="offerText">Bezug nehmend auf Ihre Anfrage vom '.$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y').' unterbreiten wir Ihnen folgendes Angebot:</p>';
				}	
				} else {
				if(!empty($this->data['Pages'])) {
					echo '<p class="offerText"><input type="text" class="text" value="Bezug nehmend auf Ihre Anfrage vom '.$this->Time->format(time(), '%d.%m.%Y').' unterbreiten wir Ihnen folgendes Angebot:" /> </p>';
				}
			}
			
			if(!empty($this->data['Pages'])) {
				echo $this->element('backend/portlets/Cheet/middle', array('carti' => $carti, 'page' => $page, 'pagePrice' => true)); 
			}
								
			if(!empty($this->data['Pages']) && in_array("C", $carti)){ 
				echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/calc', array('page' => $page)); 
		
				if(in_array("T", $carti)) { 
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/additionalText', array('offer' => $this->data, 'page' => $page)); 
				}
			} else {
				if(!empty($this->data['Pages']) && in_array("T", $carti)) { 
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/additionalText', array('offer' => $this->data, 'page' => $page)); 
				}
			}
			
			echo $this->element('backend/portlets/Cheet/footer', array('page' => $page)); 
		?>
	</article>

<?php 
		
	}
?>
<?php
	
?>
