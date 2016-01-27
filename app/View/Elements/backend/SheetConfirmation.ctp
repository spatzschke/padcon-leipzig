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
	
	$productCount = 0;
	foreach ($pages as $page => $carti) {
		
		
		$pageCur = $page;
		if(count($pages) > 1)
			$pageCur = $page + 1;	
		
?>

<article class="module width_full sheet business noInput">	
		<?php 
		
			echo $this->element('backend/portlets/Cheet/header', array('pdf' => $pdf, 'page' => $pageCur, 'maxPage' => count($pages), 'logo' => true)); 				
			
			if($this->data['Confirmation']['order_date']) {
				
				if($this->data['Confirmation']['order_number'] != '' || $this->data['Confirmation']['order_number'] != null) {
					echo '<p class="offerText">'.sprintf(Configure::read('padcon.Auftragsbestaetigung.header.Bestellnummer'),$this->data['Confirmation']['order_number'],$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y')).'</p>';
				} elseif($this->data['Confirmation']['pattern']) {
					echo '<p class="offerText">'.sprintf(Configure::read('padcon.Auftragsbestaetigung.header.pattern')).'</p>';	
				} else {
					echo '<p class="offerText">'.sprintf(Configure::read('padcon.Auftragsbestaetigung.header.default'),$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y')).'</p>';
				}
			}
			
			if(!empty($this->data['Pages'])) {
				$price = true;
				if($this->data['Confirmation']['pattern']) { $price = false;}
				
				echo $this->element('backend/portlets/Cheet/middle', array('carti' => $carti, 'page' => $page, 'pagePrice' => false, 'productCount' => $productCount)); 
			}
			
			if(!empty($this->data['Pages']) && in_array("C", $carti)){
				
				if(!$this->data['Confirmation']['pattern']) 
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/calc', array('page' => $page)); 
		
				if(in_array("T", $carti)) { 
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/additionalText', array('offer' => $this->data, 'page' => $page)); 
				}
			} else {
				if(!empty($this->data['Pages']) && in_array("T", $carti)) { 
					echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/additionalText', array('offer' => $this->data, 'page' => $page)); 
				}
			}
			
			echo $this->element('backend/portlets/Cheet/footer'); 
		?>
	</article>

<?php 
		
	$productCount += count($carti);	
}

?>

