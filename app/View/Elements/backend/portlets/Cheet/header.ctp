<?php

?>

<div class="sheetHeader module_content row" <?php if(!$logo) {echo 'style="visibility: hidden"';} ?>>	
			<div class="title col-md-8">	
				padcon Leipzig-Ralf Patzschke <br />
				<span class="small">Fachhandel und Service für medizinische Einrichtungen</span>
			</div>
			<div class="logo col-md-2">	
				<?php  echo $this->Html->image('backend/backend_logo.png', array('alt' => 'padcon Leipzig'))?>
			</div>
		</div>

		<div class="customerData module_content row-fluid">

			<div class="firstItem col-md-6">	
				<div class="addressHeader">padcon Leipzig • Holunderweg 4 • 04416 Markkleeberg</div>
				<?php 
				
				
				if(isset($this->data['Customer'])) 
				{
						if($pdf) {
							echo $this->element('backend/portlets/Customer/customerAdressPortlet', array('pdf' => $pdf));
						}else {
							echo $this->element('backend/portlets/Customer/customerSearchPortlet');
						}
				} 
					
				?>
			</div>
			<div class="col-md-6">	
				<?php 
					if($maxPage < 1) {$maxPage = 1;}
				
					 echo $this->element('backend/portlets/'.ucfirst($this->request->params['controller']).'/info', array('page' => $page, 'maxPage' => $maxPage));
					
				?>
			</div>
		</div>
		<div class="module_content row-fluid">
		
			<div class="offerHeader">
				<div class="pos"><?php echo 'POS';?></div>
				<div class="amount"><?php echo 'STÜCK';?></div>	
				<div class="number"><?php echo 'BEST.NR.';?></div>	
				<div class="content"><?php echo 'ARTIKEL';?></div>	
				<div class="price"><?php if($this->request->params['controller'] != "Deliveries") {echo 'PREIS';}?></div>	
				<div class="sum_price"><?php if($this->request->params['controller'] != "Deliveries") {echo 'GESAMTPREIS';}?></div>	
			</div>
			