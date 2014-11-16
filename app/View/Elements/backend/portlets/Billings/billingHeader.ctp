<?php

?>

<div class="sheetHeader module_content row">	
			
		</div>

		<div class="customerData module_content row-fluid">

			<div class="firstItem col-md-6">	
				<div class="addressHeader">padcon Leipzig • Holunderweg 4 • 04416 Markkleeberg</div>
				<?php 
				if(isset($this->data['Offer']['customer_id'])) 
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
				
					 echo $this->element('backend/portlets/Billing/billingInfoPortlet', array('page' => $page, 'maxPage' => $maxPage));
					
				?>
			</div>
		</div>
		<div class="module_content row-fluid">
		
			<div class="offerHeader">
				<div class="pos"><?php echo 'POS';?></div>
				<div class="amount"><?php echo 'STÜCK';?></div>	
				<div class="number"><?php echo 'BEST.NR.';?></div>	
				<div class="content"><?php echo 'ARTIKEL';?></div>	
				<div class="price"><?php echo 'PREIS';?></div>	
				<div class="sum_price"><?php echo 'GESAMTPREIS';?></div>	
			</div>
			