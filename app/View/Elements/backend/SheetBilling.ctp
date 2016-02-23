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
		$pageCur = $page + 1;
		if(count($pages) > 1)
			$pageCur = $page + 1;	
?>

<article class="module width_full sheet business noInput">	
		<?php 
			echo $this->element('backend/portlets/Cheet/header', array('pdf' => $pdf, 'page' => $pageCur, 'maxPage' => count($pages), 'logo' => true)); 
			
			if($this->data['Confirmation']['order_date'] && $pageCur < 2) {
				
				if($this->data['Confirmation']['order_number'] != '' || $this->data['Confirmation']['order_number'] != null && isset($this->data['Delivery'])) {
					echo '<p class="offerText">'.sprintf(Configure::read('padcon.Rechnung.header.Bestellnummer'),$this->data['Confirmation']['order_number'],$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y'),$this->data['Delivery']['delivery_number'],$this->Time->format($this->data['Delivery']['created'], '%d.%m.%Y')).'</p>';
				} elseif(!isset($this->data['Delivery'])) {
					echo '<p class="offerText">'.Configure::read('padcon.Rechnung.header.default').'</p>';
				} else {
					echo '<p class="offerText">'.sprintf(Configure::read('padcon.Rechnung.header.Anfrage'),$this->Time->format($this->data['Confirmation']['order_date'], '%d.%m.%Y'),$this->data['Delivery']['delivery_number'],$this->Time->format($this->data['Delivery']['created'], '%d.%m.%Y')).'</p>';
				}
			}
			
			if(!empty($this->data['Pages'])) {
				echo $this->element('backend/portlets/Cheet/middle', array('carti' => $carti, 'page' => $page, 'pagePrice' => true, 'productCount' => $productCount)); 
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
			
			echo $this->element('backend/portlets/Cheet/footer'); 
		?>
	</article>

<?php 
		$productCount += count($carti);	
}

?>

