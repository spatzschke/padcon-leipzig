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
			if($page == 1) {
				if($this->data['Offer']['request_date'] != '0000-00-00') {
					if($this->data['Offer']['request_number'] != '' || $this->data['Offer']['request_number'] != null) {
						echo '<p class="offerText">'.sprintf(Configure::read('padcon.Angebot.header.Anfragenummer'),$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y'), $this->data['Offer']['request_number']).'</p>';
					} else {
						echo '<p class="offerText">'.sprintf(Configure::read('padcon.Angebot.header.default'),$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y')).'</p>';
					}	
				} else {
					if(!empty($this->data['Pages'])) {
						echo '<p class="offerText">'.sprintf(Configure::read('padcon.Angebot.header.default'),$this->Time->format($this->data['Offer']['request_date'], '%d.%m.%Y')).'</p>';
					}
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
			
			echo $this->element('backend/portlets/Cheet/footer', array('page' => $page)); 
		?>
	</article>

<?php 
		
	$productCount += count($carti);	
}
?>
<?php
	
?>
