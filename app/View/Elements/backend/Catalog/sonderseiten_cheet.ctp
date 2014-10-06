<?php
	//debug($this->data);
	
	$catalog = $this->data['Catalog'];
	
	if($type == 'agb') {
		
		$final = array();
	
		$agb = $this->data['SiteContent']['agb']['content_paragraph'];
		$agb = str_replace('</div>', '', $agb);
		$agbString = explode("</h2>", $agb);
		
		$agbStrings = explode("3. Sind Teillieferungen", $agbString[1]);
		$agbStrings[1] = '3. Sind Teillieferungen'.$agbStrings[1];
		$last = explode("VII. Gewährleistung", $agbStrings[1]);
		
		$final[0] = $agbStrings[0];
		$final[1] = $last[0];
		$final[2] = 'VII. Gewährleistung'.$last[1];
	}
	
			
?>


<?php 
	if($type == 'agb'){
		
		foreach ($final as $a) { ?>
			<article class="module width_full sheet sonderseite">
				<div class="sheetHeader <?php if($type == "waschanleitung") { ?>style="top: 60px;<?php } ?>">	
						<div class="content"><?php echo $this->data['SiteContent'][$type]['headline']; ?></div>
						<div class="bandage"></div>
					</div>
					<div class="sheetContent agb">
						<?php echo $a; ?>
					</div>
					<div class="sheetFooter">	
						<div class="bandage">
							<?php echo $page; ?>
						</div>
					</div>		
			</article>
<?php		
	}} else {
 ?>
			<article class="module width_full sheet sonderseite">
				<div class="sheetHeader <?php if($type == "waschanleitung") { ?>style="top: 60px;<?php } ?>">	
						<div class="content"><?php echo $this->data['SiteContent'][$type]['headline']; ?></div>
						<div class="bandage"></div>
					</div>
					<div class="sheetContent agb">
						<?php echo $this->data['SiteContent'][$type]['content_paragraph']; ?>
					</div>
					<div class="sheetFooter">	
						<div class="bandage">
							<span><?php echo $page; ?></span>
						</div>
					</div>		
			</article>
<?php		
	

} ?>
