<?php if(!empty($this->data['Cart'])) { ?>
					
				<div class="offerFooter"> 
	
					<!-- Gesamtpreis -->
					<div>
						<label><?php echo 'Gesamtpreis:';?></label>
						<p class="sum_price"><?php echo $this->Number->currency($this->data['Cart']['sum_retail_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
					</div>
					
					<!-- Rabatt -->
					<?php if(isset($this->data['Offer']['discount']) && $this->data['Offer']['discount'] != 0) { ?>
						<div>
							<label><?php echo '-'.$this->data['Offer']['discount'].'% Rabatt:';?></label>
							<p class="discount"><?php echo $this->Number->currency($this->data['Offer']['discount_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
						</div>
					<?php } ?>
					
					<!-- Versandkostenanteil -->
					<div>
						<label><?php echo 'Versandkostenanteil:';?></label>
						<p class="delivery_cost"><?php echo $this->Number->currency($this->data['Offer']['delivery_cost'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
					</div>
					
					<!-- Zwischensumme -->
					<div>
						<label><?php echo 'Zwischensumme:';?></label>
						<p class="part_price"><?php echo $this->Number->currency($this->data['Offer']['part_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
					</div>
					
					<!-- Zwischensumme -->
					<div>
						<label><?php echo '+'.$this->data['Offer']['vat'].'% Mehrwertsteuer:';?></label>
						<p class="vat"><?php echo $this->Number->currency($this->data['Offer']['vat_price'],'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></p>
					</div>
					
					<!-- Zwischensumme -->
					<div>
						<label><?php echo 'Angebotswert:';?></label>
						<p class="sum_price"><span class="double"><?php echo $this->Number->currency(floatval($this->data['Offer']['offer_price']),'EUR', array('wholePosition' => 'after', 'before' => ' €', 'thousands' => '.', 'decimals' => ','));?></span></p>
					</div>
					
				</div>
	<?php } ?>